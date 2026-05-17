@extends('layouts.admin')
@section('title', 'FAQ')
@section('page_title', 'Manajemen FAQ')

@section('content')
<div style="display:grid;grid-template-columns:1fr 380px;gap:1.25rem;align-items:start;">

    <div class="card">
        <div style="padding:1rem 1.25rem;border-bottom:1px solid #F3F4F6;font-weight:600;">Daftar FAQ ({{ $faqs->count() }})</div>
        @forelse($faqs as $faq)
        <div style="padding:1rem 1.25rem;border-bottom:1px solid #F3F4F6;">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:0.75rem;">
                <div style="flex:1;">
                    <div style="font-weight:600;font-size:0.88rem;margin-bottom:0.35rem;">{{ $faq->question }}</div>
                    <div style="font-size:0.82rem;color:#6B7280;line-height:1.6;">{{ Str::limit($faq->answer, 120) }}</div>
                    <div style="font-size:0.7rem;color:#9CA3AF;margin-top:0.35rem;">Urutan: {{ $faq->sort_order }}</div>
                </div>
                <div style="display:flex;gap:0.35rem;flex-shrink:0;">
                    <span class="badge {{ $faq->is_visible ? 'badge-success' : 'badge-gray' }}">{{ $faq->is_visible ? 'Visible' : 'Hidden' }}</span>
                    <form id="del-faq-{{ $faq->id }}" action="{{ route('admin.faqs.delete', $faq->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="button" onclick="confirmDelete('del-faq-{{ $faq->id }}')" class="btn-danger btn-sm">×</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div style="text-align:center;padding:2.5rem;color:#9CA3AF;">Belum ada FAQ</div>
        @endforelse
    </div>

    <div class="card">
        <div style="padding:1rem 1.25rem;border-bottom:1px solid #F3F4F6;font-weight:600;">Tambah FAQ Baru</div>
        <div class="card-body">
            <form action="{{ route('admin.faqs.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Pertanyaan</label>
                    <input type="text" name="question" class="form-input" placeholder="Pertanyaan yang sering diajukan..." required>
                </div>
                <div class="form-group">
                    <label class="form-label">Jawaban</label>
                    <textarea name="answer" class="form-textarea" rows="4" placeholder="Jawaban lengkap..." required></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Urutan</label>
                    <input type="number" name="sort_order" class="form-input" value="{{ $faqs->count() + 1 }}" min="1" style="width:100px;">
                </div>
                <button type="submit" class="btn-primary" style="width:100%;">Tambah FAQ</button>
            </form>
        </div>
    </div>
</div>
@endsection
