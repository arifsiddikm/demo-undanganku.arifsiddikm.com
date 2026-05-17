@extends('layouts.app')
@section('title', 'Template Undangan - UndanganKu')
@section('meta_description', 'Pilih dari 100+ template undangan digital pernikahan yang cantik dan modern.')

@section('content')
{{-- HERO --}}
<div style="padding:7rem 1.5rem 4rem;text-align:center;background:linear-gradient(160deg,#FDF2F8 0%,#EFF6FF 100%);">
    <div style="font-size:0.72rem;font-weight:700;letter-spacing:0.2em;text-transform:uppercase;color:var(--color-pink);margin-bottom:0.75rem;">Koleksi Template</div>
    <h1 style="font-family:var(--font-display);font-size:clamp(2rem,5vw,3rem);font-weight:500;margin-bottom:1rem;line-height:1.2;">{{ $templateCount }}+ Template Undangan<br>Pilihan Pasangan Indonesia</h1>
    <p style="font-size:0.95rem;color:var(--color-muted);max-width:500px;margin:0 auto 1.5rem;">Temukan template yang mencerminkan kepribadian kalian. Setiap template bisa dikustomisasi sepenuhnya.</p>
    <a href="{{ route('register') }}" class="btn-primary" style="padding:0.7rem 1.75rem;">Mulai Buat Undangan ✨</a>
</div>

{{-- FILTER TABS --}}
<div style="max-width:1100px;margin:0 auto;padding:2rem 1.5rem 0;">
    <div style="display:flex;gap:0.5rem;flex-wrap:wrap;margin-bottom:2rem;">
        <button onclick="filterTemplates('all')" id="btn-all" class="filter-btn active" style="padding:0.45rem 1.1rem;border-radius:9999px;font-size:0.82rem;font-weight:500;border:1.5px solid var(--color-pink);background:var(--color-pink);color:white;cursor:pointer;transition:all 0.2s;">Semua</button>
        <button onclick="filterTemplates('basic')" id="btn-basic" class="filter-btn" style="padding:0.45rem 1.1rem;border-radius:9999px;font-size:0.82rem;font-weight:500;border:1.5px solid #E5E7EB;background:white;color:var(--color-muted);cursor:pointer;transition:all 0.2s;">Basic</button>
        <button onclick="filterTemplates('premium')" id="btn-premium" class="filter-btn" style="padding:0.45rem 1.1rem;border-radius:9999px;font-size:0.82rem;font-weight:500;border:1.5px solid #E5E7EB;background:white;color:var(--color-muted);cursor:pointer;transition:all 0.2s;">Premium</button>
        <button onclick="filterTemplates('luxury')" id="btn-luxury" class="filter-btn" style="padding:0.45rem 1.1rem;border-radius:9999px;font-size:0.82rem;font-weight:500;border:1.5px solid #E5E7EB;background:white;color:var(--color-muted);cursor:pointer;transition:all 0.2s;">Luxury</button>
    </div>

    {{-- TEMPLATE GRID --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1.5rem;" id="templateGrid">
        @forelse($templates as $tpl)
        <div class="tpl-item" data-category="{{ $tpl->category }}" style="border-radius:16px;overflow:hidden;background:white;box-shadow:0 2px 16px rgba(0,0,0,0.06);transition:all 0.2s;" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 8px 32px rgba(0,0,0,0.12)'" onmouseout="this.style.transform='';this.style.boxShadow='0 2px 16px rgba(0,0,0,0.06)'">
            <div style="aspect-ratio:3/4;background:linear-gradient(135deg,#FDF2F8,#EFF6FF);overflow:hidden;position:relative;">
                @if($tpl->thumbnail)
                <img src="{{ $tpl->thumbnail }}" alt="{{ $tpl->name }}" style="width:100%;height:100%;object-fit:cover;">
                @else
                {{-- Color preview from template palette --}}
                <div style="width:100%;height:100%;background:{{ $tpl->primary_color ?? '#C1826A' }};position:relative;overflow:hidden;">
                    <div style="position:absolute;inset:0;background:linear-gradient(160deg,{{ $tpl->color_secondary ?? $tpl->secondary_color ?? '#F5EDE8' }}55,{{ $tpl->primary_color ?? '#C1826A' }}cc)"></div>
                    <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;color:white;text-align:center;padding:1.5rem;">
                        <div style="font-size:2rem;margin-bottom:0.75rem;opacity:.8">💍</div>
                        <div style="font-family:'Georgia',serif;font-style:italic;font-size:1.15rem;line-height:1.3;text-shadow:0 1px 8px rgba(0,0,0,.3);">Pengantin<br>& Pasangan</div>
                        <div style="width:30px;height:1px;background:rgba(255,255,255,.5);margin:.75rem auto"></div>
                        <div style="font-size:.7rem;letter-spacing:.15em;text-transform:uppercase;opacity:.75">{{ $tpl->category }}</div>
                    </div>
                </div>
                @endif
                <div style="position:absolute;top:0.75rem;left:0.75rem;">
                    <span class="badge badge-{{ $tpl->category }}">{{ ucfirst($tpl->category) }}</span>
                </div>
            </div>
            <div style="padding:1.1rem;">
                <div style="font-weight:600;font-size:0.95rem;margin-bottom:0.2rem;">{{ $tpl->name }}</div>
                <div style="font-size:0.8rem;color:var(--color-muted);margin-bottom:1rem;line-height:1.5;">{{ $tpl->description ?: 'Template ' . ucfirst($tpl->category) . ' yang elegan' }}</div>
                <div style="display:flex;align-items:center;justify-content:space-between;gap:0.5rem;">
                    @if($tpl->preview_url || $tpl->file_path)
                    <a href="{{ route('templates.preview', $tpl->slug) }}" target="_blank" class="btn-outline btn-sm" style="flex:1;justify-content:center;">Preview</a>
                    @endif
                    <a href="{{ route('register') }}" class="btn-primary btn-sm" style="flex:1;justify-content:center;">Pakai Template</a>
                </div>
            </div>
        </div>
        @empty
        <div style="grid-column:1/-1;text-align:center;padding:4rem;">
            <div style="font-size:3rem;margin-bottom:1rem;">🎨</div>
            <h3 style="font-family:var(--font-display);font-size:1.5rem;font-weight:500;margin-bottom:0.5rem;">Template Segera Tersedia</h3>
            <p style="color:var(--color-muted);">Kami sedang menyiapkan koleksi template terbaik untuk Anda.</p>
        </div>
        @endforelse
    </div>
</div>

{{-- PRICING CTA --}}
<div style="padding:4rem 1.5rem;margin-top:3rem;">
    <div style="max-width:900px;margin:0 auto;">
        <div style="text-align:center;margin-bottom:2.5rem;">
            <div style="font-size:0.72rem;font-weight:700;letter-spacing:0.2em;text-transform:uppercase;color:var(--color-pink);margin-bottom:0.5rem;">Harga</div>
            <h2 style="font-family:var(--font-display);font-size:2rem;font-weight:500;">Pilih Paket yang Tepat</h2>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:1.25rem;">
            @foreach($packages as $pkg)
            <div style="border-radius:16px;border:1.5px solid {{ $pkg->slug==='premium'?'var(--color-pink)':'#E5E7EB' }};padding:1.75rem;background:{{ $pkg->slug==='premium'?'#FDF2F8':'white' }};position:relative;">
                @if($pkg->slug === 'premium')
                <div style="position:absolute;top:-12px;left:50%;transform:translateX(-50%);background:linear-gradient(135deg,#F472B6,#EC4899);color:white;font-size:0.7rem;font-weight:700;padding:0.2rem 0.85rem;border-radius:9999px;white-space:nowrap;">⭐ TERPOPULER</div>
                @endif
                <div class="badge badge-{{ $pkg->slug }}" style="margin-bottom:0.75rem;">{{ $pkg->name }}</div>
                <div style="font-family:var(--font-display);font-size:2rem;font-weight:600;margin-bottom:0.25rem;">Rp {{ number_format($pkg->price,0,',','.') }}</div>
                <div style="font-size:0.78rem;color:var(--color-muted);margin-bottom:1.25rem;">Bayar sekali, aktif selamanya</div>
                <div style="margin-bottom:1.25rem;">
                    @foreach((is_array($pkg->features) ? $pkg->features : json_decode($pkg->features,true)) ?? [] as $feat)
                    <div style="display:flex;align-items:center;gap:0.5rem;font-size:0.82rem;margin-bottom:0.4rem;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#F472B6" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        {{ $feat }}
                    </div>
                    @endforeach
                </div>
                <a href="{{ route('register') }}" class="{{ $pkg->slug==='premium'?'btn-primary':'btn-outline' }}" style="width:100%;justify-content:center;padding:0.65rem;">Pilih Paket</a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function filterTemplates(cat) {
    document.querySelectorAll('.filter-btn').forEach(b => {
        b.style.background = 'white';
        b.style.borderColor = '#E5E7EB';
        b.style.color = '#6B7280';
    });
    const activeBtn = document.getElementById('btn-' + cat);
    activeBtn.style.background = 'var(--color-pink)';
    activeBtn.style.borderColor = 'var(--color-pink)';
    activeBtn.style.color = 'white';

    document.querySelectorAll('.tpl-item').forEach(item => {
        if (cat === 'all' || item.dataset.category === cat) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    });
}
</script>
@endpush
