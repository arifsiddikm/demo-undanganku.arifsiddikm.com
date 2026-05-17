@extends('emails.layout')
@section('body')
<div style="text-align:center;margin-bottom:24px">
  <div style="font-size:36px;margin-bottom:8px">🔔</div>
  <h1 style="margin:0 0 6px;font-size:22px;font-weight:700;color:#111827">Pesanan Baru Masuk!</h1>
  <p style="margin:0;color:#6B7280;font-size:14px">Ada pesanan baru yang perlu diproses.</p>
</div>

<div style="background:#FFF7ED;border:1px solid #FED7AA;border-radius:12px;padding:18px 22px;margin-bottom:22px">
  <table width="100%" cellpadding="0" cellspacing="0">
    @foreach([['No. Pesanan',$order->order_number],['Nama User',$order->user->name ?? '-'],['Email',$order->user->email ?? '-'],['Paket',$order->package->name ?? '-'],['Total','Rp '.number_format($order->amount,0,',','.')],['Metode Bayar',ucfirst(str_replace('_',' ',$order->payment_method))],['Waktu',now()->format('d M Y H:i').' WIB']] as [$l,$v])
    <tr>
      <td style="padding:6px 0;color:#92400E;font-size:13px;width:42%">{{ $l }}</td>
      <td style="padding:6px 0;color:#1F2937;font-size:13px;font-weight:600">{{ $v }}</td>
    </tr>
    @endforeach
  </table>
</div>

<div style="text-align:center;margin:24px 0">
  <a href="{{ url('/webmin/orders/'.$order->id) }}" style="display:inline-block;background:linear-gradient(135deg,#F59E0B,#EF4444);color:white;padding:13px 32px;border-radius:50px;text-decoration:none;font-weight:700;font-size:14px">
    Lihat & Konfirmasi Pesanan →
  </a>
</div>
@endsection
