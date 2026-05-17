<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Template;
use App\Models\BankAccount;
use App\Models\Package;
use App\Models\Portfolio;
use App\Models\Testimonial;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users'   => User::where('role','user')->count(),
            'total_orders'  => Order::count(),
            'paid_orders'   => Order::where('payment_status','paid')->count(),
            'pending_orders'=> Order::where('payment_status','pending')->count(),
            'total_revenue' => Order::where('payment_status','paid')->sum('amount'),
        ];
        $recentOrders = Order::with(['user','package'])->latest()->take(10)->get();
        return view('admin.dashboard', compact('stats','recentOrders'));
    }

    // ==================== USERS ====================
    public function users(Request $request)
    {
        $users = User::where('role','user')
            ->withCount([
                'invitations as invitations_count',
                'orders as orders_count'
            ])
            ->when($request->search, function($q) use ($request) {
                $q->where('name','like','%'.$request->search.'%')
                  ->orWhere('email','like','%'.$request->search.'%');
            })
            ->latest()->paginate(15)->withQueryString();
        return view('admin.users', compact('users'));
    }

    public function toggleUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_active' => !$user->is_active]);
        return back()->with('success', 'Status user diperbarui.');
    }

    // ==================== ORDERS ====================
    public function orders(Request $request)
    {
        $orders = Order::with(['user','package','bankAccount'])
            ->when($request->status, fn($q) => $q->where('payment_status', $request->status))
            ->when($request->method, fn($q) => $q->where('payment_method', $request->method))
            ->when($request->search, fn($q) => $q->where('order_number','like','%'.$request->search.'%'))
            ->latest()->paginate(15)->withQueryString();
        return view('admin.orders', compact('orders'));
    }

    public function confirmOrder(Request $request, $id)
    {
        $order = Order::with(['user','package'])->findOrFail($id);

        if ($order->payment_status === 'paid') return back()->with('error', 'Pesanan sudah dikonfirmasi.');

        $updateData = [
            'payment_status' => 'paid',
            'paid_at'        => now(),
        ];

        // Admin can upload transfer proof
        if ($request->hasFile('transfer_proof')) {
            $path = $request->file('transfer_proof')->store('transfer-proofs', 'public');
            $updateData['transfer_proof'] = $path;
        }

        if ($request->notes) {
            $updateData['notes'] = $request->notes;
        }

        $order->update($updateData);

        // Activate invitation
        $this->activateUserInvitation($order);

        // Notify user
        try {
            Mail::to($order->user->email)->send(new \App\Mail\OrderConfirmedUser($order));
        } catch (\Throwable $e) {
            Log::error('Confirm order mail: ' . $e->getMessage());
        }

        return back()->with('success', 'Pesanan #' . $order->order_number . ' berhasil dikonfirmasi dan notifikasi telah dikirim ke pembeli.');
    }

    public function showOrder($id)
    {
        $order = Order::with(['user','package','bankAccount'])->findOrFail($id);
        return view('admin.order-detail', compact('order'));
    }

    // ==================== TEMPLATES ====================
    public function templates()
    {
        $templates = Template::orderBy('category')->orderBy('sort_order')->get();
        return view('admin.templates', compact('templates'));
    }

    public function createTemplate()
    {
        return view('admin.template-form', ['template' => null]);
    }

    public function storeTemplate(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'category'  => 'required|in:basic,premium,luxury',
            'thumbnail' => 'nullable|image|max:2048',
            'file_path' => 'required|string',
        ]);

        $data = $request->except(['thumbnail','_token']);
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = '/storage/' . $request->file('thumbnail')->store('templates', 'public');
        }
        $data['slug'] = \Illuminate\Support\Str::slug($request->name);

        Template::create($data);
        return redirect()->route('admin.templates')->with('success', 'Template berhasil ditambahkan.');
    }

    public function editTemplate($id)
    {
        $template = Template::findOrFail($id);
        return view('admin.template-form', compact('template'));
    }

    public function updateTemplate(Request $request, $id)
    {
        $template = Template::findOrFail($id);
        $data = $request->except(['thumbnail','_token','_method']);
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = '/storage/' . $request->file('thumbnail')->store('templates','public');
        }
        $template->update($data);
        return redirect()->route('admin.templates')->with('success', 'Template diperbarui.');
    }

    public function deleteTemplate($id)
    {
        Template::findOrFail($id)->delete();
        return back()->with('success', 'Template dihapus.');
    }

    // ==================== BANK ACCOUNTS ====================
    public function bankAccounts()
    {
        $bankAccounts = BankAccount::all();
        return view('admin.bank-accounts', compact('bankAccounts'));
    }

    public function storeBankAccount(Request $request)
    {
        $request->validate(['bank_name'=>'required','account_number'=>'required','account_name'=>'required']);
        BankAccount::create($request->only(['bank_name','account_number','account_name']));
        return back()->with('success', 'Rekening ditambahkan.');
    }

    public function updateBankAccount(Request $request, $id)
    {
        BankAccount::findOrFail($id)->update($request->only(['bank_name','account_number','account_name','is_active']));
        return back()->with('success', 'Rekening diperbarui.');
    }

    public function deleteBankAccount($id)
    {
        BankAccount::findOrFail($id)->delete();
        return back()->with('success', 'Rekening dihapus.');
    }

    // ==================== PORTFOLIOS ====================
    public function portfolios()
    {
        $portfolios = Portfolio::latest()->paginate(15);
        return view('admin.portfolios', compact('portfolios'));
    }

        public function storePortfolio(Request $request)
    {
        $request->validate(['couple_name' => 'required|string|max:255']);

        $data = [
            'couple_name'  => $request->couple_name,
            'package_name' => $request->package_name,
            'rating'       => $request->rating ?? 5,
            'testimonial'  => $request->testimonial,
            'demo_url'     => $request->demo_url ?: null,
            'is_visible'   => $request->has('is_visible') ? 1 : 0,
        ];

        if ($request->hasFile('photo_file')) {
            $dir = storage_path('app/public/portfolio');
            if (!is_dir($dir)) mkdir($dir, 0755, true);
            $data['photo'] = $request->file('photo_file')->store('portfolio', 'public');
        } elseif ($request->filled('photo_url')) {
            $data['photo'] = $request->photo_url;
        }

        Portfolio::create($data);
        return back()->with('success', 'Portfolio berhasil ditambahkan!');
    }

    public function updatePortfolioUrl(Request $request, $id)
    {
        \App\Models\Portfolio::findOrFail($id)->update(['demo_url' => $request->demo_url]);
        return response()->json(['success' => true]);
    }

    public function updatePortfolioFull(Request $request, $id)
    {
        $portfolio = \App\Models\Portfolio::findOrFail($id);

        $data = [
            'couple_name'  => $request->couple_name,
            'package_name' => $request->package_name,
            'rating'       => $request->rating ?? 5,
            'testimonial'  => $request->testimonial,
            'demo_url'     => $request->demo_url ?: null,
            'is_visible'   => $request->has('is_visible') ? 1 : 0,
        ];

        // Handle photo - file upload takes priority over URL
        if ($request->hasFile('photo_file')) {
            if ($portfolio->photo && !str_starts_with($portfolio->photo,'http')) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($portfolio->photo);
            }
            $data['photo'] = $request->file('photo_file')->store('portfolio', 'public');
        } elseif ($request->filled('photo_url')) {
            $data['photo'] = $request->photo_url;
        }

        $portfolio->update($data);
        return back()->with('success', 'Portfolio berhasil diupdate!');
    }

    public function deletePortfolio($id)
    {
        Portfolio::findOrFail($id)->delete();
        return back()->with('success', 'Portfolio dihapus.');
    }

    // ==================== FAQs ====================
    public function faqs()
    {
        $faqs = Faq::orderBy('sort_order')->get();
        return view('admin.faqs', compact('faqs'));
    }

    public function storeFaq(Request $request)
    {
        $request->validate(['question'=>'required','answer'=>'required']);
        Faq::create($request->only(['question','answer','sort_order']));
        return back()->with('success', 'FAQ ditambahkan.');
    }

    public function updateFaq(Request $request, $id)
    {
        Faq::findOrFail($id)->update($request->only(['question','answer','sort_order','is_visible']));
        return back()->with('success', 'FAQ diperbarui.');
    }

    public function deleteFaq($id)
    {
        Faq::findOrFail($id)->delete();
        return back()->with('success', 'FAQ dihapus.');
    }

    // ==================== TESTIMONIALS ====================
    public function testimonials()
    {
        $testimonials = Testimonial::orderBy('sort_order')->get();
        return view('admin.testimonials', compact('testimonials'));
    }

    public function storeTestimonial(Request $request)
    {
        $request->validate(['name'=>'required','content'=>'required']);
        Testimonial::create($request->only(['name','couple','content','rating','sort_order']));
        return back()->with('success', 'Testimoni ditambahkan.');
    }

    public function deleteTestimonial($id)
    {
        Testimonial::findOrFail($id)->delete();
        return back()->with('success', 'Testimoni dihapus.');
    }

    // ==================== INVITATIONS (monitoring) ====================
    public function invitations(Request $request)
    {
        $invitations = \App\Models\Invitation::with(['user','template','order'])
            ->when($request->search, fn($q) => $q->where('title','like','%'.$request->search.'%')->orWhere('slug','like','%'.$request->search.'%'))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()->paginate(15)->withQueryString();
        return view('admin.invitations', compact('invitations'));
    }

    public function showInvitation($id)
    {
        $invitation = \App\Models\Invitation::with(['user','template','order','guests','wishes','rsvps','gifts','photos'])->findOrFail($id);
        return view('admin.invitation-detail', compact('invitation'));
    }

    // ==================== PRESET MUSIC ====================
    public function presetMusics()
    {
        $musics = \App\Models\PresetMusic::orderBy('sort_order')->get();
        return view('admin.music', compact('musics'));
    }

    public function storePresetMusic(Request $request)
    {
        $request->validate(['title' => 'required']);
        
        $fileUrl = $request->file_url;
        
        // Handle file upload
        if ($request->hasFile('music_file')) {
            $path = $request->file('music_file')->store('preset-musics', 'public');
            $fileUrl = asset('storage/' . $path);
        }
        
        if (!$fileUrl) {
            return back()->withErrors(['file_url' => 'URL atau file musik diperlukan.']);
        }
        
        \App\Models\PresetMusic::create([
            'title'     => $request->title,
            'artist'    => $request->artist,
            'file_url'  => $fileUrl,
            'sort_order'=> $request->sort_order ?? \App\Models\PresetMusic::count() + 1,
            'is_active' => $request->boolean('is_active', true),
        ]);
        return back()->with('success', 'Musik ditambahkan.');
    }

    public function deletePresetMusic($id)
    {
        \App\Models\PresetMusic::findOrFail($id)->delete();
        return back()->with('success', 'Musik dihapus.');
    }

    public function uploadMusic(Request $request)
    {
        $request->validate(['title' => 'required|string|max:255', 'music_file' => 'required|file|max:10240']);
        $dir = storage_path('app/public/preset-music');
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        $path = $request->file('music_file')->store('preset-music', 'public');
        \App\Models\PresetMusic::create([
            'title'      => $request->title,
            'artist'     => $request->artist,
            'file_url'   => $path,
            'is_active'  => $request->has('is_active') ? 1 : 0,
            'sort_order' => (int)($request->sort_order ?? 0),
        ]);
        return back()->with('success', 'Musik berhasil diupload!');
    }

    // ==================== USER TESTIMONIALS (approve/reject) ====================
    public function approveUserTestimonial($id)
    {
        $ut = \App\Models\UserTestimonial::with(['user','order'])->findOrFail($id);
        $ut->update(['status' => 'approved']);

        // Add to main testimonials
        \App\Models\Testimonial::create([
            'name'       => $ut->user->name,
            'content'    => $ut->content,
            'rating'     => $ut->rating,
            'is_visible' => true,
            'sort_order' => \App\Models\Testimonial::count() + 1,
        ]);

        // If allowed portfolio, add to portfolio
        if ($ut->allow_portfolio) {
            $inv = \App\Models\Invitation::where('order_id', $ut->order_id)->where('status','active')->first();
            if ($inv) {
                \App\Models\Portfolio::create([
                    'couple_name'  => $inv->title,
                    'demo_url'     => url('/' . $inv->slug),
                    'package_name' => $ut->order->package->name ?? null,
                    'rating'       => $ut->rating,
                    'testimonial'  => $ut->content,
                    'is_visible'   => true,
                ]);
            }
        }

        return back()->with('success', 'Testimoni disetujui dan ditampilkan.');
    }

    public function rejectUserTestimonial($id)
    {
        \App\Models\UserTestimonial::findOrFail($id)->update(['status' => 'rejected']);
        return back()->with('success', 'Testimoni ditolak.');
    }

    private function activateUserInvitation(Order $order): void
    {
        $inv = \App\Models\Invitation::where('order_id', $order->id)->first()
            ?? \App\Models\Invitation::where('user_id', $order->user_id)->where('status','draft')->latest()->first();
        if ($inv) $inv->update(['status'=>'active','order_id'=>$order->id]);
    }
}
