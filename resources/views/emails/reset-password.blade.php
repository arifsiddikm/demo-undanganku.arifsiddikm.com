@extends('emails.layout')

@section('body')
<div style="text-align:center;margin-bottom:28px">
    <div style="font-size:48px;margin-bottom:12px">🔐</div>
    <h1 style="margin:0 0 8px;font-size:22px;font-weight:700;color:#1F2937;font-family:Georgia,serif">Reset Password</h1>
    <p style="margin:0;font-size:14px;color:#6B7280">Halo, <strong>{{ $userName }}</strong>!</p>
</div>

<p style="font-size:14px;color:#374151;line-height:1.7;margin:0 0 20px">
    Kami menerima permintaan untuk mereset password akun UndanganKu kamu.
    Klik tombol di bawah ini untuk membuat password baru.
</p>

<div style="text-align:center;margin:28px 0">
    <a href="{{ $resetUrl }}"
       style="display:inline-block;background:linear-gradient(135deg,#BE185D,#F472B6);color:white;text-decoration:none;
              font-weight:700;font-size:15px;padding:14px 36px;border-radius:12px;letter-spacing:0.3px;
              box-shadow:0 4px 16px rgba(244,114,182,0.4)">
        🔑 &nbsp; Reset Password Sekarang
    </a>
</div>

<div style="background:#FFF7ED;border:1px solid #FED7AA;border-radius:12px;padding:16px 20px;margin:20px 0">
    <p style="margin:0;font-size:13px;color:#92400E;line-height:1.6">
        ⏱️ <strong>Link ini hanya berlaku selama 60 menit.</strong><br>
        Jika kamu tidak merasa meminta reset password, abaikan email ini — akunmu tetap aman.
    </p>
</div>

<p style="font-size:13px;color:#9CA3AF;line-height:1.6;margin:16px 0 0">
    Jika tombol di atas tidak berfungsi, copy link berikut ke browser kamu:<br>
    <a href="{{ $resetUrl }}" style="color:#F472B6;word-break:break-all;font-size:12px">{{ $resetUrl }}</a>
</p>

<hr style="border:none;border-top:1px solid #F3F4F6;margin:24px 0">

<p style="font-size:12px;color:#9CA3AF;text-align:center;margin:0">
    Butuh bantuan? Hubungi kami via
    <a href="https://wa.me/{{ env('ADMIN_WHATSAPP') }}" style="color:#F472B6;text-decoration:none;font-weight:600">WhatsApp Admin</a>
</p>
@endsection
