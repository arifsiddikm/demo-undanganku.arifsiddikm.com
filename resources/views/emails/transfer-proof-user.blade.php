@extends('emails.layout')
@section('body')
<div style="text-align:center;margin-bottom:24px">
  <div style="font-size:36px;margin-bottom:8px">⏳</div>
  <h1 style="margin:0 0 6px;font-size:22px;font-weight:700;color:#111827">Bukti Transfer Diterima!</h1>
  <p style="margin:0;color:#6B7280;font-size:14px">Kami sedang memverifikasi pembayaranmu. Mohon tunggu ya!</p>
</div>

<div style="background:#F0F9FF;border:1px solid #BAE6FD;border-radius:12px;padding:18px 22px;margin-bottom:22px">
  <table width="100%" cellpadding="0" cellspacing="0">
    @foreach([['No. Pesanan',$order->order_number],['Paket',$order->package->name ?? '-'],['Total','Rp '.number_format($order->amount,0,',','.')]] as [$l,$v])
    <tr>
      <td style="padding:6px 0;color:#0369A1;font-size:13px;width:42%">{{ $l }}</td>
      <td style="padding:6px 0;color:#1F2937;font-size:13px;font-weight:600">{{ $v }}</td>
    </tr>
    @endforeach
  </table>
</div>

<div style="background:#FFFBEB;border:1px solid #FDE68A;border-radius:12px;padding:14px 18px;font-size:13px;color:#92400E;margin-bottom:22px">
  ⏱️ Verifikasi biasanya selesai dalam <strong>1×24 jam</strong>. Kamu akan mendapat email konfirmasi setelah pembayaran diverifikasi admin.
</div>

<p style="color:#9CA3AF;font-size:13px;text-align:center">Ada pertanyaan? Hubungi kami via
  <a href="https://wa.me/6289514392694" style="color:#F472B6;text-decoration:none">WhatsApp</a>
</p>
@endsection
