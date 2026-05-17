@extends('layouts.admin')
@section('title', 'Template')
@section('page_title', 'Manajemen Template')

@section('content')
<div class="page-header">
    <div></div>
    <a href="{{ route('admin.templates.create') }}" class="btn-primary">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Template
    </a>
</div>

<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:1rem;">
    @forelse($templates as $tpl)
    <div class="card" style="overflow:hidden;">
        <div style="aspect-ratio:4/3;background:linear-gradient(135deg,#FDF2F8,#EFF6FF);position:relative;overflow:hidden;">
            @if($tpl->thumbnail)
            <img src="{{ $tpl->thumbnail }}" alt="{{ $tpl->name }}" style="width:100%;height:100%;object-fit:cover;">
            @elseif($tpl->preview_url)
            <img src="{{ $tpl->preview_url }}" alt="{{ $tpl->name }}" style="width:100%;height:100%;object-fit:cover;" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
            <div style="display:none;align-items:center;justify-content:center;height:100%;font-size:3rem;">💍</div>
            @else
            <div style="display:flex;align-items:center;justify-content:center;height:100%;font-size:3rem;">💍</div>
            @endif
            <span class="badge {{ $tpl->category==='luxury'?'badge-warning':($tpl->category==='premium'?'badge-info':'badge-gray') }}" style="position:absolute;top:0.5rem;right:0.5rem;">
                {{ ucfirst($tpl->category) }}
            </span>
            @if(!$tpl->is_active)
            <div style="position:absolute;inset:0;background:rgba(0,0,0,0.4);display:flex;align-items:center;justify-content:center;">
                <span style="color:white;font-weight:600;font-size:0.8rem;">NONAKTIF</span>
            </div>
            @endif
        </div>
        <div style="padding:0.85rem;">
            <div style="font-weight:600;font-size:0.88rem;margin-bottom:0.2rem;">{{ $tpl->name }}</div>
            <div style="font-size:0.72rem;color:#9CA3AF;margin-bottom:0.75rem;">{{ $tpl->file_path }}</div>
            <div style="display:flex;gap:0.4rem;">
                <a href="{{ route('admin.templates.edit', $tpl->id) }}" class="btn-outline btn-sm" style="flex:1;justify-content:center;">Edit</a>
                <form id="del-tpl-{{ $tpl->id }}" action="{{ route('admin.templates.delete', $tpl->id) }}" method="POST" style="flex:1;">
                    @csrf @method('DELETE')
                    <button type="button" onclick="confirmDelete('del-tpl-{{ $tpl->id }}')" class="btn-danger btn-sm" style="width:100%;justify-content:center;">Hapus</button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div style="grid-column:1/-1;text-align:center;padding:3rem;color:#9CA3AF;">
        <div style="font-size:3rem;margin-bottom:1rem;">🎨</div>
        <div>Belum ada template. <a href="{{ route('admin.templates.create') }}" style="color:#F472B6;">Tambahkan sekarang →</a></div>
    </div>
    @endforelse
</div>
@endsection
