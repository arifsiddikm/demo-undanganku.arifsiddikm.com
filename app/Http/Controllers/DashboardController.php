<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Invitation;
use App\Models\Order;
use App\Models\Guest;
use App\Models\Wish;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Redirect admin to admin panel
        if ($user->role === 'admin') return redirect()->route('admin.dashboard');

        $invitations = Invitation::where('user_id', $user->id)
            ->with('template')
            ->latest()
            ->take(5)
            ->get();

        $orders = Order::where('user_id', $user->id)
            ->with('package')
            ->latest()
            ->take(5)
            ->get();

        $stats = [
            'total_invitations' => Invitation::where('user_id', $user->id)->count(),
            'active_invitations' => Invitation::where('user_id', $user->id)->where('status', 'active')->count(),
            'total_guests' => Guest::whereHas('invitation', fn($q) => $q->where('user_id', $user->id))->count(),
            'total_wishes' => Wish::whereHas('invitation', fn($q) => $q->where('user_id', $user->id))->count(),
        ];

        return view('dashboard.index', compact('invitations', 'orders', 'stats'));
    }

    public function profile()
    {
        return view('dashboard.profile', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'     => 'required|string|max:255',
            'phone'    => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6',
        ]);

        $data = ['name' => $request->name, 'phone' => $request->phone];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('avatars', 'public');
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
