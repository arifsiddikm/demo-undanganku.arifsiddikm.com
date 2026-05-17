@extends('emails.layout')
@section('body')
<div style="text-align:center;margin-bottom:28px">
  <div style="width:72px;height:72px;background:linear-gradient(135deg,#D1FAE5,#A7F3D0);border-radius:50%;margin:0 auto 16px;display:flex;align-items:center;justify-content:center;font-size:32px">✅</div>
  <h1 style="margin:0 0 8px;font-size:24px;font-weight:700;color:#111827;font-family:Georgia,serif">Pembayaran Dikonfirmasi!</h1>
  <p style="margin:0;color:#6B7280;font-size:15px">Hore! Undangan digital kamu sudah aktif dan siap diedit.</p>
</div>

<div style="background:linear-gradient(135deg,#FDF2F8,#EFF6FF);border-radius:14px;padding:20px 24px;margin-bottom:24px">
  <table width="100%" cellpadding="0" cellspacing="0">
    @foreach([['No. Pesanan', $order->order_number],['Paket', $order->package->name ?? '-'],['Total Pembayaran', 'Rp '.number_format($order->amount,0,',','.')],['Dikonfirmasi', now()->format('d M Y H:i').' WIB']] as [$label,$val])
    <tr>
      <td style="padding:7px 0;color:#6B7280;font-size:14px;width:45%">{{ $label }}</td>
      <td style="padding:7px 0;color:#111827;font-size:14px;font-weight:600">{{ $val }}</td>
    </tr>
    @endforeach
  </table>
</div>

<div style="background:#F0FDF4;border:1px solid #BBF7D0;border-radius:12px;padding:16px 20px;margin-bottom:24px">
  <div style="color:#065F46;font-weight:600;font-size:14px;margin-bottom:6px">🎉 Langkah Selanjutnya:</div>
  <ol style="margin:0;padding-left:20px;color:#047857;font-size:13px;line-height:2">
    <li>Masuk ke dashboard kamu</li>
    <li>Pilih undangan yang dibuat</li>
    <li>Isi data pengantin, detail acara, dan foto</li>
    <li>Bagikan link ke tamu undangan kamu 🎊</li>
  </ol>
</div>

<div style="text-align:center;margin:28px 0">
  <a href="{{ url('/dashboard') }}" style="display:inline-block;background:linear-gradient(135deg,#F472B6,#A78BFA);color:white;padding:14px 36px;border-radius:50px;text-decoration:none;font-weight:700;font-size:15px;letter-spacing:0.3px;box-shadow:0 4px 15px rgba(244,114,182,0.4)">
    Mulai Edit Undanganmu →
  </a>
</div>

<p style="color:#9CA3AF;font-size:13px;text-align:center;margin:0">Terima kasih telah mempercayakan undangan spesialmu kepada kami 💝</p>
@endsection
