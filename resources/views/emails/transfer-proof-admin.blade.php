@extends('emails.layout')
@section('body')
<div style="text-align:center;margin-bottom:24px">
  <div style="font-size:36px;margin-bottom:8px">💳</div>
  <h1 style="margin:0 0 6px;font-size:22px;font-weight:700;color:#111827">Bukti Transfer Diterima</h1>
  <p style="margin:0;color:#6B7280;font-size:14px">User telah mengunggah bukti pembayaran.</p>
</div>

<div style="background:#EFF6FF;border:1px solid #BFDBFE;border-radius:12px;padding:18px 22px;margin-bottom:22px">
  <table width="100%" cellpadding="0" cellspacing="0">
    @foreach([['No. Pesanan',$order->order_number],['Nama User',$order->user->name ?? '-'],['Total','Rp '.number_format($order->amount,0,',','.')]] as [$l,$v])
    <tr>
      <td style="padding:6px 0;color:#1E40AF;font-size:13px;width:42%">{{ $l }}</td>
      <td style="padding:6px 0;color:#1F2937;font-size:13px;font-weight:600">{{ $v }}</td>
    </tr>
    @endforeach
  </table>
</div>

@if(isset($proofUrl))
<div style="text-align:center;margin-bottom:22px">
  <img src="{{ $proofUrl }}" alt="Bukti Transfer" style="max-width:100%;border-radius:12px;border:2px solid #E5E7EB">
</div>
@endif

<div style="text-align:center">
  <a href="{{ url('/webmin/orders/'.$order->id) }}" style="display:inline-block;background:linear-gradient(135deg,#3B82F6,#6366F1);color:white;padding:13px 32px;border-radius:50px;text-decoration:none;font-weight:700;font-size:14px">
    Konfirmasi Sekarang →
  </a>
</div>
@endsection
