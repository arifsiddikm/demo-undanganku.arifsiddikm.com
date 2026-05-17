@extends('layouts.admin')
@section('title','Preset Musik')
@section('page_title','Manajemen Musik Latar')
@section('content')
@if(session('success'))<div class="alert-success" style="margin-bottom:1rem">✅ {{ session('success') }}</div>@endif

<div style="display:grid;grid-template-columns:1fr 400px;gap:1.25rem;align-items:start">

  {{-- LIST --}}
  <div class="card">
    <div style="padding:1rem 1.25rem;border-bottom:1px solid #F3F4F6;font-weight:600;display:flex;align-items:center;justify-content:space-between">
      <span>Daftar Musik Preset ({{ $musics->count() }})</span>
      <span style="font-size:.75rem;color:#9CA3AF">Digunakan di editor undangan</span>
    </div>
    @forelse($musics->sortBy('sort_order') as $m)
    <div style="padding:1rem 1.25rem;border-bottom:1px solid #F3F4F6;display:flex;align-items:flex-start;gap:.85rem">
      <div style="width:42px;height:42px;background:#FDF2F8;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0">🎵</div>
      <div style="flex:1;min-width:0">
        <div style="font-weight:600;font-size:.88rem">{{ $m->title }}</div>
        @if($m->artist)<div style="font-size:.75rem;color:#9CA3AF">{{ $m->artist }}</div>@endif
        <div style="font-size:.7rem;color:#C4B8B0;margin-top:.1rem;overflow:hidden;text-overflow:ellipsis;white-space:nowrap" title="{{ $m->file_url }}">
          {{ Str::limit($m->file_url, 55) }}
        </div>
        <div style="margin-top:.4rem">
          <audio controls style="height:28px;width:100%;max-width:280px" preload="none">
            <source src="{{ str_starts_with($m->file_url,'http') ? $m->file_url : asset('storage/'.$m->file_url) }}">
          </audio>
        </div>
      </div>
      <div style="display:flex;flex-direction:column;align-items:flex-end;gap:.4rem;flex-shrink:0">
        <span class="badge {{ $m->is_active ? 'badge-success' : 'badge-gray' }}">{{ $m->is_active ? 'Aktif' : 'Off' }}</span>
        <span style="font-size:.68rem;color:#9CA3AF">#{{ $m->sort_order }}</span>
        <form id="del-m-{{ $m->id }}" action="{{ route('admin.music.delete', $m->id) }}" method="POST" style="display:inline">
          @csrf @method('DELETE')
          <button type="button" onclick="confirmDeleteMusic('del-m-{{ $m->id }}')" class="btn-danger btn-sm">× Hapus</button>
        </form>
      </div>
    </div>
    @empty
    <div style="text-align:center;padding:3rem;color:#9CA3AF">
      <div style="font-size:2.5rem;margin-bottom:.75rem">🎵</div>
      Belum ada musik preset
    </div>
    @endforelse
  </div>

  {{-- ADD FORM --}}
  <div class="card card-body">
    <div style="font-weight:700;margin-bottom:1rem">Tambah Musik</div>

    {{-- Tab Switch --}}
    <div style="display:flex;background:#F3F4F6;border-radius:8px;padding:.25rem;margin-bottom:1.25rem" id="musicTabBar">
      <button type="button" id="tab-url" onclick="switchMusicTab('url')"
        style="flex:1;padding:.45rem;border-radius:6px;font-size:.78rem;font-weight:600;border:none;cursor:pointer;background:white;color:#374151;box-shadow:0 1px 4px rgba(0,0,0,.08);transition:all .2s">
        🔗 URL Link
      </button>
      <button type="button" id="tab-file" onclick="switchMusicTab('file')"
        style="flex:1;padding:.45rem;border-radius:6px;font-size:.78rem;font-weight:600;border:none;cursor:pointer;background:transparent;color:#9CA3AF;transition:all .2s">
        📁 Upload File
      </button>
    </div>

    {{-- URL FORM --}}
    <form id="form-url" action="{{ route('admin.music.store') }}" method="POST">
      @csrf
      <div class="form-group"><label class="form-label">Judul Lagu *</label><input type="text" name="title" class="form-input" placeholder="A Thousand Years" required></div>
      <div class="form-group"><label class="form-label">Artis</label><input type="text" name="artist" class="form-input" placeholder="Christina Perri"></div>
      <div class="form-group">
        <label class="form-label">URL File Audio *</label>
        <input type="url" name="file_url" class="form-input" placeholder="https://example.com/song.mp3" required>
        <div style="font-size:.7rem;color:#9CA3AF;margin-top:.25rem">Link MP3/OGG publik yang bisa diakses langsung</div>
      </div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem">
        <div class="form-group"><label class="form-label">Urutan</label><input type="number" name="sort_order" class="form-input" value="{{ $musics->count() + 1 }}"></div>
        <div class="form-group" style="display:flex;align-items:flex-end;padding-bottom:.3rem">
          <label style="display:flex;align-items:center;gap:.4rem;cursor:pointer;font-size:.83rem">
            <input type="checkbox" name="is_active" value="1" checked style="accent-color:#F472B6;width:15px;height:15px"> Aktif
          </label>
        </div>
      </div>
      <button type="submit" class="btn-primary" style="width:100%;margin-top:.25rem">+ Tambah dari URL</button>
    </form>

    {{-- FILE UPLOAD FORM --}}
    <form id="form-file" action="{{ route('admin.music.upload') }}" method="POST" enctype="multipart/form-data" style="display:none">
      @csrf
      <div class="form-group"><label class="form-label">Judul Lagu *</label><input type="text" name="title" class="form-input" placeholder="A Thousand Years" required></div>
      <div class="form-group"><label class="form-label">Artis</label><input type="text" name="artist" class="form-input" placeholder="Christina Perri"></div>
      <div class="form-group">
        <label class="form-label">File Audio *</label>
        <div id="musicDropZone" onclick="document.getElementById('musicFileInput').click()"
          style="border:2px dashed #E5E7EB;border-radius:10px;padding:1.5rem;text-align:center;cursor:pointer;background:#FAFAFA;transition:all .2s"
          onmouseover="this.style.borderColor='#F472B6';this.style.background='#FDF2F8'"
          onmouseout="this.style.borderColor='#E5E7EB';this.style.background='#FAFAFA'">
          <div style="font-size:1.75rem;margin-bottom:.4rem">🎵</div>
          <div id="musicFileName" style="font-size:.8rem;color:#6B7280;font-weight:500">Klik untuk pilih file audio</div>
          <div style="font-size:.7rem;color:#9CA3AF;margin-top:.2rem">MP3, WAV, OGG · Maks 10MB</div>
        </div>
        <input type="file" id="musicFileInput" name="music_file" accept="audio/mpeg,audio/wav,audio/ogg,audio/*" style="display:none" onchange="onMusicFileSelected(this)">
      </div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem">
        <div class="form-group"><label class="form-label">Urutan</label><input type="number" name="sort_order" class="form-input" value="{{ $musics->count() + 1 }}"></div>
        <div class="form-group" style="display:flex;align-items:flex-end;padding-bottom:.3rem">
          <label style="display:flex;align-items:center;gap:.4rem;cursor:pointer;font-size:.83rem">
            <input type="checkbox" name="is_active" value="1" checked style="accent-color:#F472B6;width:15px;height:15px"> Aktif
          </label>
        </div>
      </div>
      <button type="submit" class="btn-primary" style="width:100%;margin-top:.25rem" id="uploadMusicBtn">📤 Upload Musik</button>
    </form>

    <div style="margin-top:1rem;padding:.75rem;background:#FFFBEB;border-radius:8px;border:1px solid #FDE68A;font-size:.75rem;color:#92400E">
      <strong>💡 Tips:</strong> Gunakan URL SoundHelix, Pixabay, atau upload dari komputer kamu. File disimpan di <code>storage/app/public/preset-music/</code>
    </div>
  </div>
</div>

<script>
function switchMusicTab(tab) {
    var formUrl  = document.getElementById('form-url');
    var formFile = document.getElementById('form-file');
    var tabUrl   = document.getElementById('tab-url');
    var tabFile  = document.getElementById('tab-file');

    if (tab === 'url') {
        formUrl.style.display  = 'block';
        formFile.style.display = 'none';
        tabUrl.style.background  = 'white'; tabUrl.style.color  = '#374151'; tabUrl.style.boxShadow  = '0 1px 4px rgba(0,0,0,.08)';
        tabFile.style.background = 'transparent'; tabFile.style.color = '#9CA3AF'; tabFile.style.boxShadow = 'none';
    } else {
        formUrl.style.display  = 'none';
        formFile.style.display = 'block';
        tabFile.style.background = 'white'; tabFile.style.color  = '#374151'; tabFile.style.boxShadow  = '0 1px 4px rgba(0,0,0,.08)';
        tabUrl.style.background  = 'transparent'; tabUrl.style.color = '#9CA3AF'; tabUrl.style.boxShadow = 'none';
    }
}

function onMusicFileSelected(input) {
    var file = input.files[0];
    if (!file) return;
    var zone = document.getElementById('musicDropZone');
    document.getElementById('musicFileName').textContent = '✅ ' + file.name;
    zone.style.borderColor = '#10B981';
    zone.style.background  = '#F0FDF4';
}

function confirmDeleteMusic(formId) {
    if (confirm('Hapus musik ini? Undangan yang menggunakan musik ini tidak akan terpengaruh.')) {
        document.getElementById(formId).submit();
    }
}
</script>
@endsection
