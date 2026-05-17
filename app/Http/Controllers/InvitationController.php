<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Template;
use App\Models\Package;
use App\Models\InvitationPhoto;
use App\Models\Guest;
use App\Models\InvitationGift;
use App\Models\Rsvp;
use App\Models\Wish;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InvitationController extends Controller
{
    /**
     * List user's invitations
     */
    public function index()
    {
        $invitations = Invitation::where('user_id', Auth::id())
            ->with(['template','order.package'])
            ->latest()
            ->paginate(10);
        $packages = \App\Models\Package::where('is_active', true)->orderBy('price')->get();
        return view('dashboard.invitations.index', compact('invitations', 'packages'));
    }

    /**
     * Show create form (template selection)
     */
    public function create()
    {
        $templates = Template::where('is_active', true)->orderBy('sort_order')->get();
        $packages  = Package::where('is_active', true)->orderBy('sort_order')->get();
        return view('dashboard.invitations.create', compact('templates', 'packages'));
    }

    /**
     * Store new invitation
     */
    public function store(Request $request)
    {
        $request->validate([
            'template_id' => 'required|exists:templates,id',
            'title'       => 'required|string|max:255',
        ]);

        $template = Template::findOrFail($request->template_id);
        $slug = Str::slug($request->title) . '-' . Str::random(6);

        $invitation = Invitation::create([
            'user_id'     => Auth::id(),
            'template_id' => $request->template_id,
            'title'       => $request->title,
            'slug'        => $slug,
            'status'      => 'draft',
            'color_primary'   => $template->primary_color,
            'color_secondary' => $template->secondary_color,
        ]);

        return redirect()->route('editor.show', $invitation->id)
            ->with('success', 'Undangan berhasil dibuat! Silakan mulai mengisi data. ✨');
    }

    /**
     * Show invitation editor
     */
    public function edit($id)
    {
        $invitation = Invitation::where('user_id', Auth::id())
            ->with(['template', 'photos', 'guests', 'rsvps', 'wishes', 'gifts'])
            ->findOrFail($id);

        $templates = Template::where('is_active', true)->get();

        // Determine features based on order/package
        $order = Order::where('user_id', Auth::id())->where('payment_status', 'paid')
            ->whereHas('package', fn($q) => $q->whereIn('slug', ['premium','luxury']))
            ->latest()->first();
        $hasGallery = $order && in_array($order->package->slug, ['premium','luxury']);
        $hasMusic   = $hasGallery;

        $stats = [
            'total_rsvp'   => $invitation->rsvps->count(),
            'hadir'        => $invitation->rsvps->where('attendance','hadir')->count(),
            'tidak_hadir'  => $invitation->rsvps->where('attendance','tidak_hadir')->count(),
            'total_wishes' => $invitation->wishes->count(),
        ];

        $recentWishes  = $invitation->wishes()->where('is_visible', true)->latest()->take(5)->get();
        $photos        = $invitation->photos;
        $guests        = $invitation->guests;
        $rsvps         = $invitation->rsvps()->latest()->take(20)->get();
        $wishes        = $invitation->wishes()->where('is_visible', true)->latest()->take(20)->get();
        $gifts         = $invitation->gifts;
        $presetMusics  = \App\Models\PresetMusic::where('is_active', true)->orderBy('sort_order')->get();

        return view('editor.show', compact('invitation','templates','hasGallery','hasMusic','stats','recentWishes','photos','guests','rsvps','wishes','gifts','presetMusics'));
    }

    /**
     * AJAX save all invitation fields
     */
    public function save(Request $request, $id)
    {
        set_time_limit(120); // prevent timeout on large saves
        $invitation = Invitation::where('user_id', Auth::id())->findOrFail($id);

        $allowed = [
            'title','status','slug',
            'groom_name','groom_nickname','groom_father','groom_mother','groom_bio','groom_instagram',
            'bride_name','bride_nickname','bride_father','bride_mother','bride_bio','bride_instagram',
            'akad_date','akad_time_start','akad_time_end','akad_venue','akad_address','akad_maps_url',
            'resepsi_date','resepsi_time_start','resepsi_time_end','resepsi_venue','resepsi_address','resepsi_maps_url',
            'resepsi_same_as_akad',
            'opening_text','closing_text','love_story','love_story_items','music_autoplay',
            'color_primary','color_secondary','template_id',
            'font_family','invitation_message','selected_music_key','livestream_url','couple_order',
        ];

        $data = array_intersect_key($request->only($allowed), array_flip($allowed));

        // love_story_items dikirim sebagai JSON string dari frontend, decode ke array
        if (isset($data['love_story_items']) && is_string($data['love_story_items'])) {
            $decoded = json_decode($data['love_story_items'], true);
            $data['love_story_items'] = is_array($decoded) ? $decoded : [];
        }

        // Ensure slug uniqueness
        if (isset($data['slug'])) {
            $data['slug'] = Str::slug($data['slug']);
            $existing = Invitation::where('slug', $data['slug'])->where('id', '!=', $id)->first();
            if ($existing) $data['slug'] .= '-' . Str::random(4);
        }

        $invitation->update($data);
        return response()->json(['success' => true]);
    }

    /**
     * Upload image (cover, groom, bride photo)
     */
    public function uploadImage(Request $request, $id)
    {
        $invitation = Invitation::where('user_id', Auth::id())->findOrFail($id);
        $request->validate(['file' => 'required|image|max:5120', 'field' => 'required|string']);

        $path = $request->file('file')->store('invitations/' . $id, 'public');
        $field = $request->field;

        if (in_array($field, ['cover_photo','groom_photo','bride_photo'])) {
            // Delete old
            if ($invitation->$field) Storage::disk('public')->delete($invitation->$field);
            $invitation->update([$field => $path]);
        }

        return response()->json(['success' => true, 'path' => $path]);
    }

    /**
     * Upload gallery photo
     */
    public function uploadGallery(Request $request, $id)
    {
        $invitation = Invitation::where('user_id', Auth::id())->findOrFail($id);
        $request->validate(['photo' => 'required|image|max:5120']);

        $path = $request->file('photo')->store('invitations/' . $id . '/gallery', 'public');
        $photo = InvitationPhoto::create([
            'invitation_id' => $id,
            'photo'         => $path,
            'sort_order'    => $invitation->photos()->count() + 1,
        ]);

        return response()->json(['success' => true, 'id' => $photo->id, 'path' => Storage::url($path)]);
    }

    /**
     * Delete gallery photo
     */
    public function deletePhoto($photoId)
    {
        $photo = InvitationPhoto::findOrFail($photoId);
        $invitation = Invitation::where('user_id', Auth::id())->findOrFail($photo->invitation_id);
        Storage::disk('public')->delete($photo->photo);
        $photo->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Upload music
     */
    public function uploadMusic(Request $request, $id)
    {
        $invitation = Invitation::where('user_id', Auth::id())->findOrFail($id);
        $request->validate(['music' => 'required|mimes:mp3,ogg,wav|max:10240']);

        if ($invitation->music_file) Storage::disk('public')->delete($invitation->music_file);
        $path = $request->file('music')->store('invitations/' . $id . '/music', 'public');
        $invitation->update(['music_file' => $path]);

        return response()->json(['success' => true]);
    }

    /**
     * Add guest
     */
    public function upgrade($id)
    {
        $invitation = Invitation::where('user_id', Auth::id())->findOrFail($id);
        $packages = \App\Models\Package::where('is_active', true)->orderBy('price')->get();
        $bankAccounts = \App\Models\BankAccount::where('is_active', true)->get();
        return view('dashboard.invitations.upgrade', compact('invitation', 'packages', 'bankAccounts'));
    }

    public function addGuest(Request $request)
    {
        $request->validate([
            'invitation_id' => 'required|exists:invitations,id',
            'name'          => 'required|string|max:255',
            'phone'         => 'nullable|string|max:20',
            'pax'           => 'integer|min:1|max:50',
        ]);

        $invitation = Invitation::where('user_id', Auth::id())->findOrFail($request->invitation_id);

        $guest = Guest::create([
            'invitation_id' => $invitation->id,
            'name'          => $request->name,
            'phone'         => $request->phone,
            'pax'           => $request->pax ?? 1,
            'status'        => 'pending',
        ]);

        return response()->json(['success' => true, 'guest' => $guest]);
    }

    /**
     * Add gift bank account
     */
    public function addGift(Request $request)
    {
        $request->validate([
            'invitation_id'  => 'required|exists:invitations,id',
            'bank_name'      => 'required|string|max:100',
            'account_number' => 'required|string|max:50',
            'account_name'   => 'required|string|max:255',
        ]);

        $invitation = Invitation::where('user_id', Auth::id())->findOrFail($request->invitation_id);

        $gift = InvitationGift::create([
            'invitation_id'  => $invitation->id,
            'bank_name'      => $request->bank_name,
            'account_number' => $request->account_number,
            'account_name'   => $request->account_name,
            'is_active'      => true,
        ]);

        return response()->json(['success' => true, 'gift' => $gift]);
    }

    /**
     * Preview (for iframe in editor)
     */
    public function preview($id)
    {
        $invitation = Invitation::with(['template','photos','gifts'])->findOrFail($id);
        $fp = $invitation->template->file_path ?? 'sakura-bloom';
        // Strip 'templates/' prefix if stored wrongly
        $fp = ltrim(str_replace('templates/', '', $fp), '/');
        $viewName = 'templates.' . $fp;
        if (!view()->exists($viewName)) $viewName = 'templates.sakura-bloom';
        return view($viewName, ['invitation' => $invitation, 'isPreview' => true, 'guestName' => '']);
    }

    /**
     * Public invitation view - slug directly without /i/
     */
    public function show($slug, Request $request)
    {
        $invitation = Invitation::where('slug', $slug)
            ->where('status', 'active')
            ->with(['template','photos','gifts'])
            ->firstOrFail();

        // Support both ?untuk= and ?to= for backward compat
        $guestName = $request->query('untuk', $request->query('to', ''));
        $fp = $invitation->template->file_path ?? 'sakura-bloom';
        $fp = ltrim(str_replace('templates/', '', $fp), '/');
        $viewName = 'templates.' . $fp;
        if (!view()->exists($viewName)) $viewName = 'templates.sakura-bloom';

        return view($viewName, compact('invitation','guestName'));
    }

    /**
     * Submit RSVP (public)
     */
    public function submitRsvp(Request $request, $slug)
    {
        $invitation = Invitation::where('slug', $slug)->where('status', 'active')->firstOrFail();
        $request->validate([
            'name'       => 'required|string|max:255',
            'phone'      => 'nullable|string|max:20',
            'pax'        => 'integer|min:1|max:20',
            'attendance' => 'required|in:hadir,tidak_hadir',
            'message'    => 'nullable|string|max:1000',
        ]);

        Rsvp::create([
            'invitation_id' => $invitation->id,
            'name'          => $request->name,
            'phone'         => $request->phone,
            'pax'           => $request->pax ?? 1,
            'attendance'    => $request->attendance,
            'message'       => $request->message,
            'ip_address'    => $request->ip(),
        ]);

        return response()->json(['success' => true, 'message' => 'Konfirmasi kehadiran berhasil dikirim! 💌']);
    }

    /**
     * Submit wish (public)
     */
    public function submitWish(Request $request, $slug)
    {
        $invitation = Invitation::where('slug', $slug)->where('status', 'active')->firstOrFail();
        $request->validate([
            'name'    => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // Simple spam check: same IP max 3 wishes per invitation
        $wishCount = Wish::where('invitation_id', $invitation->id)
            ->where('ip_address', $request->ip())
            ->whereDate('created_at', today())->count();
        if ($wishCount >= 3) {
            return response()->json(['success' => false, 'message' => 'Terlalu banyak ucapan dari IP ini.'], 429);
        }

        Wish::create([
            'invitation_id' => $invitation->id,
            'name'          => $request->name,
            'message'       => $request->message,
            'ip_address'    => $request->ip(),
        ]);

        return response()->json(['success' => true, 'message' => 'Ucapan berhasil dikirim! 🙏']);
    }

    /**
     * Check slug availability (AJAX)
     */
    public function checkSlug(Request $request)
    {
        $slug       = Str::slug($request->query('slug', ''));
        $excludeId  = $request->query('exclude_id');
        $exists = Invitation::where('slug', $slug)
            ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
            ->exists();
        // Also check reserved words
        $reserved = ['dashboard','login','register','logout','profile','checkout','payment','preset','portfolio','webmin','favicon','storage','api'];
        $reserved_hit = in_array($slug, $reserved);
        return response()->json([
            'available' => !$exists && !$reserved_hit && strlen($slug) >= 3,
            'slug'      => $slug,
        ]);
    }

    /**
     * Delete guest
     */
    public function deleteGuest($guestId)
    {
        $guest = \App\Models\Guest::findOrFail($guestId);
        Invitation::where('user_id', Auth::id())->findOrFail($guest->invitation_id);
        $guest->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Delete gift
     */
    public function deleteGift($giftId)
    {
        $gift = \App\Models\InvitationGift::findOrFail($giftId);
        Invitation::where('user_id', Auth::id())->findOrFail($gift->invitation_id);
        $gift->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Delete invitation
     */
    public function destroy($id)
    {
        $invitation = Invitation::where('user_id', Auth::id())->findOrFail($id);
        // Delete storage files
        Storage::disk('public')->deleteDirectory('invitations/' . $id);
        $invitation->delete();
        return redirect()->route('invitations.index')->with('success', 'Undangan berhasil dihapus.');
    }
}
