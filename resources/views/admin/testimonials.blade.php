@extends('layouts.admin')
@section('title', 'Testimoni')
@section('page_title', 'Manajemen Testimoni')

@section('content')
<div style="display:grid;grid-template-columns:1fr 380px;gap:1.25rem;align-items:start;">

    <div class="card">
        <div style="padding:1rem 1.25rem;border-bottom:1px solid #F3F4F6;font-weight:600;">Daftar Testimoni</div>
        @forelse($testimonials as $t)
        <div style="padding:1rem 1.25rem;border-bottom:1px solid #F3F4F6;display:flex;gap:0.75rem;align-items:flex-start;">
            <div style="width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,#F472B6,#93C5FD);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:0.9rem;flex-shrink:0;">{{ strtoupper(substr($t->name,0,1)) }}</div>
            <div style="flex:1;">
                <div style="font-weight:600;font-size:0.88rem;">{{ $t->name }}</div>
                @if($t->couple)<div style="font-size:0.75rem;color:#F472B6;">{{ $t->couple }}</div>@endif
                <div style="font-size:0.82rem;color:#6B7280;margin-top:0.25rem;line-height:1.5;">{{ Str::limit($t->content, 100) }}</div>
                <div style="margin-top:0.2rem;">@for($i=1;$i<=5;$i++)<span style="color:{{ $i<=$t->rating?'#F59E0B':'#E5E7EB' }};font-size:0.85rem;">★</span>@endfor</div>
            </div>
            <form id="del-t-{{ $t->id }}" action="{{ route('admin.testimonials.delete', $t->id) }}" method="POST">
                @csrf @method('DELETE')
                <button type="button" onclick="confirmDelete('del-t-{{ $t->id }}')" class="btn-danger btn-sm">×</button>
            </form>
        </div>
        @empty
        <div style="text-align:center;padding:2.5rem;color:#9CA3AF;">Belum ada testimoni</div>
        @endforelse
    </div>

    <div class="card">
        <div style="padding:1rem 1.25rem;border-bottom:1px solid #F3F4F6;font-weight:600;">Tambah Testimoni</div>
        <div class="card-body">
            <form action="{{ route('admin.testimonials.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Nama</label>
                    <input type="text" name="name" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Pasangan <span style="color:#9CA3AF;">(opsional)</span></label>
                    <input type="text" name="couple" class="form-input" placeholder="Cth: Reza & Vina">
                </div>
                <div class="form-group">
                    <label class="form-label">Isi Testimoni</label>
                    <textarea name="content" class="form-textarea" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Rating</label>
                    <select name="rating" class="form-select">
                        @foreach([5,4,3,2,1] as $r)
                        <option value="{{ $r }}" {{ $r===5?'selected':'' }}>{{ $r }} Bintang</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Urutan</label>
                    <input type="number" name="sort_order" class="form-input" value="{{ $testimonials->count()+1 }}" style="width:100px;">
                </div>
                <button type="submit" class="btn-primary" style="width:100%;">Tambah Testimoni</button>
            </form>
        </div>
    </div>
</div>
@endsection
