@extends('layouts.dashboard')
@section('title', 'Checkout - ' . ($package->name ?? 'Paket'))
@section('page_title', 'Checkout Paket')

@push('styles')
<style>
.checkout-grid { display: grid; grid-template-columns: 1fr 360px; gap: 1.5rem; }
@media (max-width: 900px) { .checkout-grid { grid-template-columns: 1fr; } }

.payment-tab { padding: 0.75rem 1.25rem; border-radius: 10px; border: 1.5px solid #E5E7EB; cursor: pointer; font-size: 0.85rem; font-weight: 500; transition: all 0.2s; display: flex; align-items: center; gap: 0.6rem; background: white; }
.payment-tab.active { border-color: var(--color-pink); background: #FDF2F8; color: var(--color-pink); }
.payment-tab:hover:not(.active) { border-color: rgba(244,114,182,0.4); }

.bank-option { display: flex; align-items: center; gap: 0.75rem; padding: 0.85rem 1rem; border-radius: 10px; border: 1.5px solid #E5E7EB; cursor: pointer; transition: all 0.2s; margin-bottom: 0.6rem; }
.bank-option.selected { border-color: var(--color-pink); background: #FDF2F8; }
.bank-option:hover:not(.selected) { border-color: rgba(244,114,182,0.3); }
.bank-option input[type=radio] { display: none; }

@keyframes spin { to { transform: rotate(360deg); } }
.spin { animation: spin 0.8s linear infinite; display: inline-block; }
</style>
@endpush

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Checkout Paket {{ $package->name }}</div>
        <p style="font-size:0.8rem;color:var(--color-muted);margin-top:0.2rem;">Selesaikan pembayaran untuk mengaktifkan undangan digitalmu</p>
    </div>
    <a href="{{ url()->previous() }}" class="btn-outline btn-sm">← Kembali</a>
</div>

<div class="checkout-grid">
    {{-- LEFT: Payment Form --}}
    <div>
        <div class="dash-card" style="margin-bottom:1.25rem;">
            <div style="font-weight:600;font-size:0.9rem;margin-bottom:1rem;">Metode Pembayaran</div>
            <div style="display:flex;gap:0.75rem;margin-bottom:1.25rem;flex-wrap:wrap;">
                <button type="button" class="payment-tab active" id="tab-midtrans" onclick="switchPayment('midtrans')">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                    Payment Gateway
                    <span style="font-size:0.68rem;background:#FDF2F8;color:var(--color-pink);padding:0.15rem 0.4rem;border-radius:4px;font-weight:600;">QRIS, GoPay, dll</span>
                </button>
                <button type="button" class="payment-tab" id="tab-transfer" onclick="switchPayment('transfer')">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    Transfer Manual
                </button>
            </div>

            {{-- Midtrans Panel --}}
            <div id="midtrans-panel">
                <div style="background:#EFF6FF;border:1px solid #BFDBFE;border-radius:10px;padding:1rem;margin-bottom:1rem;">
                    <div style="font-size:0.8rem;color:#1E40AF;font-weight:500;margin-bottom:0.4rem;">💳 Metode Pembayaran Tersedia:</div>
                    <div style="font-size:0.78rem;color:#3B82F6;line-height:1.7;">QRIS · GoPay · OVO · Dana · ShopeePay · BCA · BNI · BRI · Mandiri · Permata · Kartu Kredit/Debit</div>
                </div>
                <input type="hidden" id="packageId" value="{{ $package->id }}">
                @if(isset($invitation) && $invitation)
                <input type="hidden" id="invitationId" value="{{ $invitation->id }}">
                @endif
                <button type="button" onclick="processPayment()" id="payBtn" class="btn-primary" style="width:100%;padding:0.8rem;font-size:0.9rem;border-radius:10px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                    Bayar Rp {{ number_format($package->price, 0, ',', '.') }}
                </button>
            </div>

            {{-- Transfer Manual Panel --}}
            <div id="transfer-panel" style="display:none;">
                <form action="{{ route('orders.store') }}" method="POST" enctype="multipart/form-data" id="transferForm">
                    @csrf
                    <input type="hidden" name="package_id" value="{{ $package->id }}">
                    @if(isset($invitation) && $invitation)
                    <input type="hidden" name="invitation_id" value="{{ $invitation->id }}">
                    @endif
                    <input type="hidden" name="payment_method" value="bank_transfer">

                    <div style="font-size:0.85rem;font-weight:500;margin-bottom:0.75rem;">Pilih Bank Tujuan Transfer:</div>
                    @foreach($bankAccounts as $bank)
                    <label class="bank-option {{ $loop->first ? 'selected' : '' }}" onclick="selectBank(this)">
                        <input type="radio" name="bank_account_id" value="{{ $bank->id }}" {{ $loop->first ? 'checked' : '' }}>
                        <div style="width:48px;height:32px;background:#F3F4F6;border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:0.72rem;font-weight:700;color:var(--color-muted);flex-shrink:0;">{{ strtoupper(substr($bank->bank_name,0,3)) }}</div>
                        <div style="flex:1;">
                            <div style="font-weight:600;font-size:0.85rem;">{{ $bank->bank_name }}</div>
                            <div style="font-size:0.8rem;color:var(--color-muted);">{{ $bank->account_number }} · a.n. {{ $bank->account_name }}</div>
                        </div>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                    </label>
                    @endforeach

                    <div style="background:#FFF9F0;border:1px solid #FDE68A;border-radius:10px;padding:1rem;margin:1rem 0;">
                        <div style="font-size:0.8rem;font-weight:600;color:#92400E;margin-bottom:0.4rem;">⚠️ Jumlah Transfer</div>
                        <div style="font-size:1.1rem;font-weight:700;color:var(--color-text);">Rp {{ number_format($package->price, 0, ',', '.') }}</div>
                        <div style="font-size:0.72rem;color:#92400E;margin-top:0.25rem;">Transfer tepat sesuai nominal di atas untuk memudahkan verifikasi</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" style="font-weight:600;margin-bottom:.5rem">📤 Upload Bukti Transfer <span style="color:var(--color-pink)">*</span></label>
                        <div id="proofZone" onclick="document.getElementById('proofInput').click()"
                            style="border:2px dashed #E5E7EB;border-radius:14px;padding:1.5rem;text-align:center;cursor:pointer;transition:all .2s;background:#FAFAFA;"
                            onmouseover="this.style.borderColor='var(--color-pink)';this.style.background='#FDF2F8'"
                            onmouseout="this.style.borderColor='#E5E7EB';this.style.background='#FAFAFA'">
                            <div id="proofEmptyState">
                                <div style="font-size:2rem;margin-bottom:.5rem">📸</div>
                                <div style="font-weight:600;font-size:.85rem;color:#374151;margin-bottom:.2rem">Klik untuk pilih foto bukti transfer</div>
                                <div style="font-size:.75rem;color:#9CA3AF">JPG, PNG, WebP · Maks 5MB</div>
                            </div>
                            <div id="proofPreviewState" style="display:none">
                                <img id="proofPreviewImg" src="" alt="" style="max-height:160px;max-width:100%;border-radius:10px;object-fit:contain;margin-bottom:.75rem">
                                <div id="proofFileName" style="font-size:.78rem;color:#374151;font-weight:500"></div>
                                <div style="font-size:.72rem;color:var(--color-pink);margin-top:.3rem">Klik untuk ganti foto</div>
                            </div>
                        </div>
                        <input type="file" id="proofInput" name="transfer_proof" accept="image/*" style="display:none;" onchange="previewProof(this)">
                        <div id="proofError" style="display:none;color:#EF4444;font-size:.75rem;margin-top:.35rem"></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Catatan <span style="color:#9CA3AF;">(opsional)</span></label>
                        <textarea name="notes" class="form-textarea" rows="2" placeholder="Cth: Transfer dari BCA ke BRI atas nama..."></textarea>
                    </div>

                    <button type="submit" id="transferBtn" class="btn-primary" style="width:100%;padding:0.8rem;font-size:0.9rem;border-radius:10px;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                        Kirim Bukti Transfer
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- RIGHT: Order Summary --}}
    <div>
        <div class="dash-card" style="position:sticky;top:80px;">
            <div style="font-weight:600;font-size:0.9rem;margin-bottom:1rem;">Ringkasan Pesanan</div>

            <div style="background:linear-gradient(135deg, {{ $package->slug==='luxury'?'#FFF9F0':($package->slug==='premium'?'#EFF6FF':'#FDF2F8') }}, white);border-radius:12px;padding:1.25rem;margin-bottom:1rem;border:1.5px solid rgba(244,114,182,0.15);">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;">
                    <div>
                        <div style="font-weight:600;font-size:0.9rem;">Paket {{ $package->name }}</div>
                        <div style="font-size:0.78rem;color:var(--color-muted);margin-top:0.2rem;">{{ $package->description }}</div>
                    </div>
                    <div style="font-family:var(--font-display);font-size:1.3rem;font-weight:600;white-space:nowrap;">
                        Rp {{ number_format($package->price, 0, ',', '.') }}
                    </div>
                </div>
            </div>

            <div style="margin-bottom:1rem;">
                <div style="font-size:0.78rem;font-weight:600;color:var(--color-muted);margin-bottom:0.6rem;text-transform:uppercase;letter-spacing:0.06em;">Fitur Paket</div>
                @foreach((is_array($package->features) ? $package->features : json_decode($package->features, true)) ?? [] as $feat)
                <div style="display:flex;align-items:center;gap:0.5rem;font-size:0.8rem;margin-bottom:0.35rem;">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#F472B6" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    {{ $feat }}
                </div>
                @endforeach
            </div>

            <div style="border-top:1px solid #F3F4F6;padding-top:0.85rem;">
                <div style="display:flex;justify-content:space-between;align-items:center;font-weight:700;font-size:1rem;">
                    <span>Total</span>
                    <span style="color:var(--color-pink);">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                </div>
            </div>

            <div style="background:#F0FDF4;border:1px solid #BBF7D0;border-radius:8px;padding:0.75rem;margin-top:1rem;font-size:0.75rem;color:#15803D;">
                🔒 Pembayaran aman. Data kamu terenkripsi dan dilindungi.
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ env('MIDTRANS_SNAP_JS_URL', 'https://app.sandbox.midtrans.com/snap/snap.js') }}" data-client-key="{{ env('MIDTRANS_CLIENT_KEY', '') }}"></script>
<script>
// ── Tab switch ──────────────────────────────────────────────
function switchPayment(method) {
    document.getElementById('midtrans-panel').style.display = method === 'midtrans' ? 'block' : 'none';
    document.getElementById('transfer-panel').style.display  = method === 'transfer'  ? 'block' : 'none';
    document.getElementById('tab-midtrans').classList.toggle('active', method === 'midtrans');
    document.getElementById('tab-transfer').classList.toggle('active', method === 'transfer');
}

// ── Bank select ─────────────────────────────────────────────
function selectBank(label) {
    document.querySelectorAll('.bank-option').forEach(el => el.classList.remove('selected'));
    label.classList.add('selected');
    label.querySelector('input[type=radio]').checked = true;
}

// ── Bukti transfer preview ──────────────────────────────────
function previewProof(input) {
    const file = input.files[0];
    if (!file) return;
    if (file.size > 5 * 1024 * 1024) {
        document.getElementById('proofError').style.display = 'block';
        document.getElementById('proofError').textContent = 'File terlalu besar! Maks 5MB.';
        input.value = '';
        return;
    }
    document.getElementById('proofError').style.display = 'none';
    const reader = new FileReader();
    reader.onload = (e) => {
        document.getElementById('proofPreviewImg').src = e.target.result;
        document.getElementById('proofFileName').textContent = file.name;
        document.getElementById('proofEmptyState').style.display = 'none';
        document.getElementById('proofPreviewState').style.display = 'block';
        document.getElementById('proofZone').style.borderColor = 'var(--color-pink)';
        document.getElementById('proofZone').style.background  = '#FDF2F8';
    };
    reader.readAsDataURL(file);
}

// ── Transfer form submit guard ──────────────────────────────
document.getElementById('transferForm').addEventListener('submit', function(e) {
    const proof = document.getElementById('proofInput').files[0];
    if (!proof) {
        e.preventDefault();
        document.getElementById('proofError').style.display = 'block';
        document.getElementById('proofError').textContent = 'Wajib upload bukti transfer terlebih dahulu.';
        document.getElementById('proofZone').style.borderColor = '#EF4444';
        return;
    }
    const btn = document.getElementById('transferBtn');
    btn.disabled = true;
    btn.innerHTML = '<svg class="spin" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 11-6.219-8.56"/></svg> &nbsp; Mengirim...';
});

// ── Midtrans payment — HARUS async ─────────────────────────
async function processPayment() {
    const btn = document.getElementById('payBtn');
    const origHTML = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<svg class="spin" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 11-6.219-8.56"/></svg> &nbsp; Memproses...';

    const packageId    = document.getElementById('packageId').value;
    const invEl        = document.getElementById('invitationId');
    const invitationId = invEl ? invEl.value : null;

    try {
        const res = await fetch('{{ route("payment.getSnapToken") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ package_id: packageId, invitation_id: invitationId })
        });

        const data = await res.json();

        if (!data.snap_token) throw new Error(data.message || 'Gagal mendapatkan token pembayaran.');

        window.snap.pay(data.snap_token, {
            onSuccess: function(result) {
                Swal.fire({ icon: 'success', title: 'Pembayaran Berhasil! 🎉', text: 'Undanganmu sudah aktif.', confirmButtonColor: '#F472B6' })
                    .then(() => { window.location.href = '{{ route("dashboard") }}'; });
            },
            onPending: function(result) {
                window.location.href = '{{ route("orders.index") }}';
            },
            onError: function(result) {
                Swal.fire({ icon: 'error', title: 'Pembayaran Gagal', text: 'Terjadi kesalahan. Silakan coba lagi.' });
                btn.disabled = false;
                btn.innerHTML = origHTML;
            },
            onClose: function() {
                btn.disabled = false;
                btn.innerHTML = origHTML;
            }
        });

    } catch (e) {
        Swal.fire({ icon: 'error', title: 'Error', text: e.message });
        btn.disabled = false;
        btn.innerHTML = origHTML;
    }
}
</script>
@endpush
