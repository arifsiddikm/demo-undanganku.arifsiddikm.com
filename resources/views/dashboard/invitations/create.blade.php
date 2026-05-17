@extends('layouts.dashboard')
@section('title', 'Buat Undangan Baru')
@section('page_title', 'Buat Undangan Baru')

@section('content')
<div style="max-width:700px;">
    <div class="dash-card">
        <div style="font-weight:600;font-size:0.95rem;margin-bottom:1.25rem;">Pilih Template & Mulai</div>

        <form action="{{ route('invitations.store') }}" method="POST">
            @csrf
            <div class="form-group" style="margin-bottom:1.5rem;">
                <label class="form-label">Judul Undangan (Nama Pasangan)</label>
                <input type="text" name="title" class="form-input" placeholder="Cth: Reza & Vina" value="{{ old('title') }}" required style="font-size:1rem;padding:0.7rem 1rem;">
            </div>

            <div style="font-size:0.78rem;font-weight:600;color:var(--color-muted);text-transform:uppercase;letter-spacing:0.07em;margin-bottom:0.75rem;">Pilih Template</div>
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:1rem;margin-bottom:1.5rem;">
                @foreach($templates as $tpl)
                <label style="cursor:pointer;">
                    <input type="radio" name="template_id" value="{{ $tpl->id }}" {{ $loop->first ? 'checked' : '' }} style="display:none;" class="tpl-radio">
                    <div class="tpl-card" data-id="{{ $tpl->id }}" style="border:2px solid {{ $loop->first ? '#F472B6' : '#E5E7EB' }};border-radius:12px;overflow:hidden;transition:all 0.2s;">
                        <div style="aspect-ratio:4/3;background:linear-gradient(135deg,#FDF2F8,#EFF6FF);position:relative;overflow:hidden;">
                            @if($tpl->thumbnail)
                            <img src="{{ $tpl->thumbnail }}" style="width:100%;height:100%;object-fit:cover;">
                            @else
                            <div style="display:flex;align-items:center;justify-content:center;height:100%;font-size:2.5rem;">💍</div>
                            @endif
                            <span style="position:absolute;top:6px;right:6px;background:{{ $tpl->category==='luxury'?'#F59E0B':($tpl->category==='premium'?'#3B82F6':'#9CA3AF') }};color:white;font-size:0.65rem;font-weight:700;padding:2px 8px;border-radius:99px;text-transform:uppercase;">{{ $tpl->category }}</span>
                        </div>
                        <div style="padding:0.65rem;">
                            <div style="font-weight:600;font-size:0.82rem;">{{ $tpl->name }}</div>
                            <div style="font-size:0.72rem;color:var(--color-muted);">{{ $tpl->description ?? 'Template ' . ucfirst($tpl->category) }}</div>
                        </div>
                    </div>
                </label>
                @endforeach
            </div>

            <div style="display:flex;gap:0.75rem;">
                <button type="submit" class="btn-primary" style="padding:0.75rem 2rem;font-size:0.9rem;">
                    ✨ Buat & Mulai Edit
                </button>
                <a href="{{ route('dashboard') }}" class="btn-outline" style="padding:0.75rem 1.5rem;">Batal</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.querySelectorAll('.tpl-radio').forEach(radio => {
    radio.addEventListener('change', function() {
        document.querySelectorAll('.tpl-card').forEach(card => {
            card.style.borderColor = '#E5E7EB';
        });
        this.nextElementSibling.style.borderColor = '#F472B6';
    });
});
</script>
@endpush
@endsection
