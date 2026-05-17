@extends('layouts.dashboard')
@section('title', 'Detail Pesanan #' . $order->order_number)
@section('page_title', 'Detail Pesanan')

@section('content')
<div style="max-width:700px;">

  {{-- ORDER CARD --}}
  <div class="dash-card" style="margin-bottom:1rem;">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;">
      <div style="font-weight:700;font-family:monospace;font-size:0.9rem;">{{ $order->order_number }}</div>
      <span class="badge {{ $order->payment_status==='paid'?'badge-success':($order->payment_status==='pending'?'badge-warning':'badge-danger') }}">
        {{ $order->payment_status==='paid'?'✅ Lunas':($order->payment_status==='pending'?'⏳ Pending':'❌ Gagal') }}
      </span>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.25rem;">
      <div><div style="font-size:0.72rem;color:var(--color-muted);margin-bottom:0.2rem;">Paket</div><div style="font-weight:600;">{{ $order->package->name ?? '-' }}</div></div>
      <div><div style="font-size:0.72rem;color:var(--color-muted);margin-bottom:0.2rem;">Total</div><div style="font-weight:700;color:var(--color-pink);font-size:1.1rem;">Rp {{ number_format($order->amount,0,',','.') }}</div></div>
      <div><div style="font-size:0.72rem;color:var(--color-muted);margin-bottom:0.2rem;">Metode</div><div style="font-weight:500;">{{ $order->payment_method==='midtrans'?'🔗 Payment Gateway':'🏦 Transfer Manual' }}</div></div>
      <div><div style="font-size:0.72rem;color:var(--color-muted);margin-bottom:0.2rem;">Tanggal</div><div style="font-weight:500;font-size:0.85rem;">{{ $order->created_at->format('d M Y H:i') }}</div></div>
    </div>

    {{-- STATUS BANNER --}}
    @if($order->payment_status === 'paid')
    <div style="background:#F0FDF4;border:1px solid #BBF7D0;border-radius:10px;padding:1rem;margin-bottom:1rem;">
      <div style="font-size:0.82rem;color:#15803D;font-weight:600;">✅ Pembayaran dikonfirmasi</div>
      <div style="font-size:0.78rem;color:#16A34A;margin-top:0.2rem;">{{ $order->paid_at?->format('d M Y H:i') }} WIB · Undangan sudah diaktifkan.</div>
    </div>
    @elseif($order->payment_status === 'pending')
    <div style="background:#FFFBEB;border:1px solid #FDE68A;border-radius:10px;padding:1rem;margin-bottom:1rem;">
      <div style="font-size:0.82rem;color:#92400E;font-weight:600;">⏳ Menunggu konfirmasi pembayaran</div>
      <div style="font-size:0.78rem;color:#78350F;margin-top:0.2rem;">
        @if($order->payment_method === 'bank_transfer')
          Bukti transfer kamu sedang diverifikasi admin (maks. 1×24 jam).
        @else
          Selesaikan pembayaran sesuai instruksi yang diberikan.
        @endif
      </div>
    </div>
    @endif

    {{-- BANK INFO --}}
    @if($order->bankAccount)
    <div style="background:#F9FAFB;border-radius:10px;padding:1rem;margin-bottom:1rem;">
      <div style="font-size:0.72rem;font-weight:600;color:var(--color-muted);margin-bottom:0.4rem;">💳 Transfer ke:</div>
      <div style="font-weight:700;font-size:1rem;">{{ $order->bankAccount->bank_name }}</div>
      <div style="font-size:0.88rem;color:var(--color-muted);margin-top:0.15rem;">{{ $order->bankAccount->account_number }}</div>
      <div style="font-size:0.82rem;color:var(--color-muted);">a.n. {{ $order->bankAccount->account_name }}</div>
      <div style="font-size:0.78rem;font-weight:600;margin-top:0.35rem;">
        Jumlah: <span style="color:var(--color-pink)">Rp {{ number_format($order->amount,0,',','.') }}</span>
      </div>
    </div>
    @endif

    {{-- EXISTING TRANSFER PROOF --}}
    @if($order->transfer_proof)
    <div style="margin-bottom:1rem;">
      <div style="font-size:0.78rem;font-weight:600;color:var(--color-muted);margin-bottom:0.5rem;">Bukti Transfer yang Dikirim:</div>
      <img src="{{ asset('storage/' . $order->transfer_proof) }}" style="max-width:320px;border-radius:10px;border:1px solid #E5E7EB;display:block;">
    </div>
    @endif

    {{-- UPLOAD TRANSFER PROOF FORM --}}
    @if($order->payment_status === 'pending' && $order->payment_method === 'bank_transfer')
    <div style="background:white;border:2px solid #FDE68A;border-radius:14px;padding:1.25rem;margin-bottom:1rem;">
      <div style="font-weight:700;font-size:0.88rem;margin-bottom:0.25rem;">📤 Upload Bukti Transfer</div>
      <div style="font-size:0.78rem;color:var(--color-muted);margin-bottom:1rem;line-height:1.5;">
        Upload foto/screenshot bukti transfer kamu agar admin dapat segera mengkonfirmasi pembayaran.
      </div>

      <form id="proofForm" enctype="multipart/form-data">
        @csrf
        <div style="margin-bottom:0.85rem;">
          <label style="display:block;font-size:0.74rem;font-weight:500;margin-bottom:0.3rem;">Foto Bukti Transfer</label>
          {{-- Upload drop zone --}}
          <div id="proofDropZone" onclick="document.getElementById('proofInput').click()"
            style="border:2px dashed #E5E7EB;border-radius:10px;padding:1.5rem;text-align:center;cursor:pointer;transition:border-color .2s;background:#FAFAFA;"
            onmouseover="this.style.borderColor='var(--color-pink)'"
            onmouseout="this.style.borderColor='#E5E7EB'">
            <div id="proofPreviewWrap" style="display:none;margin-bottom:0.75rem;">
              <img id="proofPreview" style="max-width:100%;max-height:200px;border-radius:8px;object-fit:contain;">
            </div>
            <svg id="proofIcon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="1.5" style="margin:0 auto 0.5rem;display:block;">
              <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>
            </svg>
            <div id="proofText" style="font-size:0.8rem;color:var(--color-muted);">Klik atau drag foto bukti transfer</div>
            <div style="font-size:0.7rem;color:#9CA3AF;margin-top:0.2rem;">JPG, PNG, maks. 5MB</div>
          </div>
          <input type="file" id="proofInput" name="transfer_proof" accept="image/*" style="display:none;" onchange="previewProof(this)">
        </div>

        <button type="button" id="proofSubmitBtn" onclick="submitProof()" class="btn-primary" style="width:100%;padding:0.75rem;font-size:0.88rem;" disabled>
          📤 Kirim Bukti Transfer
        </button>
      </form>

      <div id="proofSuccess" style="display:none;background:#F0FDF4;border:1px solid #BBF7D0;border-radius:10px;padding:1rem;margin-top:0.75rem;">
        <div style="font-size:0.82rem;color:#15803D;font-weight:600;">✅ Bukti transfer berhasil dikirim!</div>
        <div style="font-size:0.78rem;color:#16A34A;margin-top:0.2rem;">Admin akan mengkonfirmasi dalam 1×24 jam. Kamu akan mendapat notifikasi email.</div>
      </div>
    </div>
    @endif

  </div>

  <div style="display:flex;gap:0.75rem;">
    <a href="{{ route('orders.index') }}" class="btn-outline">← Kembali</a>
    @if($order->payment_status === 'paid')
    <a href="{{ route('dashboard') }}" class="btn-primary">Edit Undangan →</a>
    @endif
  </div>
</div>

<script>
function previewProof(input) {
    var file = input.files[0];
    if (!file) return;
    var reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('proofPreview').src = e.target.result;
        document.getElementById('proofPreviewWrap').style.display = 'block';
        document.getElementById('proofIcon').style.display = 'none';
        document.getElementById('proofText').textContent = file.name;
        document.getElementById('proofSubmitBtn').disabled = false;
        document.getElementById('proofSubmitBtn').style.opacity = '1';
    };
    reader.readAsDataURL(file);
}

async function submitProof() {
    var input = document.getElementById('proofInput');
    if (!input.files[0]) return;
    var btn = document.getElementById('proofSubmitBtn');
    btn.disabled = true; btn.textContent = 'Mengirim...';
    var fd = new FormData(document.getElementById('proofForm'));
    try {
        var res = await fetch('/dashboard/orders/{{ $order->id }}/upload-proof', {
            method: 'POST', body: fd
        });
        var d = await res.json();
        if (d.success) {
            document.getElementById('proofSuccess').style.display = 'block';
            document.getElementById('proofForm').style.display = 'none';
        } else { throw new Error(d.message || 'Gagal'); }
    } catch(e) {
        btn.disabled = false; btn.textContent = '📤 Kirim Bukti Transfer';
        alert('Gagal mengirim. ' + e.message);
    }
}
</script>
@endsection
