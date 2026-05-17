<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\ResetPasswordMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) return redirect()->route('dashboard');
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    }

    public function showRegister()
    {
        if (Auth::check()) return redirect()->route('dashboard');
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::min(8)],
            'phone'    => 'nullable|string|max:20',
            'agree'    => 'required|accepted',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'phone'    => $request->phone,
        ]);

        Auth::login($user);
        return redirect()->route('dashboard')->with('success', 'Selamat datang di UndanganKu! 🎉');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle forgot password — generate token & kirim email LANGSUNG (sync, bukan queue)
     */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        // Tampilkan error jika email tidak terdaftar
        if (!$user) {
            return back()
                ->withInput()
                ->withErrors(["email" => "Email ini belum terdaftar di UndanganKu. Coba email lain atau daftar dulu."]);
        }

        // Hapus token lama jika ada
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // Buat token baru
        $token = Str::random(64);
        DB::table('password_reset_tokens')->insert([
            'email'      => $request->email,
            'token'      => Hash::make($token),
            'created_at' => now(),
        ]);

        // Build reset URL manual (tidak pakai route() agar tidak tergantung queue)
        $resetUrl = url('/reset-password/' . $token . '?email=' . urlencode($request->email));

        try {
            // Kirim LANGSUNG — bypass queue dengan mailer() eksplisit
            Mail::mailer(config('mail.default'))
                ->to($user->email)
                ->send(new ResetPasswordMail($resetUrl, $user->name));

        } catch (\Throwable $e) {
            Log::error('[ResetPassword] Gagal kirim email ke ' . $user->email . ' — ' . $e->getMessage());

            // Hapus token agar user bisa retry
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();

            return back()
                ->withInput()
                ->withErrors(['email' => 'Gagal mengirim email. Coba beberapa saat lagi atau hubungi admin via WhatsApp.']);
        }

        return back()->with('status',
            'Link reset password sudah dikirim ke ' . $request->email . '. Berlaku 60 menit. Cek folder Spam jika tidak muncul di inbox.'
        );
    }

    /**
     * Tampilkan form buat password baru
     */
    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email', ''),
        ]);
    }

    /**
     * Proses password baru & auto-login
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => ['required', 'confirmed', Rules\Password::min(8)],
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$record) {
            return back()->withErrors(['email' => 'Link reset password tidak valid atau sudah kadaluarsa.']);
        }

        // Cek expiry 60 menit
        if (now()->diffInMinutes($record->created_at) > 60) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withErrors(['email' => 'Link reset password sudah kadaluarsa. Silakan minta link baru.']);
        }

        // Verifikasi token
        if (!Hash::check($request->token, $record->token)) {
            return back()->withErrors(['email' => 'Link reset password tidak valid.']);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Akun tidak ditemukan.']);
        }

        $user->update([
            'password'       => Hash::make($request->password),
            'remember_token' => Str::random(60),
        ]);

        // Hapus token yang sudah dipakai
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // Auto-login langsung
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')
            ->with('success', 'Password berhasil diperbarui! Selamat datang kembali 🎉');
    }
}
