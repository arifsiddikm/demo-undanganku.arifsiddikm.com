@extends('layouts.admin')
@section('title', 'Portfolio')
@section('page_title', 'Manajemen Portfolio')
@section('content')
@if(session('success'))<div class="alert-success" style="margin-bottom:1rem">✅ {{ session('success') }}</div>@endif
@if(session('error'))<div class="alert-danger" style="margin-bottom:1rem">❌ {{ session('error') }}</div>@endif

<div style="display:grid;grid-template-columns:1fr 420px;gap:1.25rem;align-items:start">
  {{-- LIST --}}
  <div class="card">
    <div style="padding:1rem 1.25rem;border-bottom:1px solid #F3F4F6;font-weight:600">Portfolio ({{ $portfolios->count() }})</div>
    @forelse($portfolios as $p)
    <div style="padding:1rem 1.25rem;border-bottom:1px solid #F3F4F6;display:flex;gap:1rem;align-items:flex-start">
      {{-- Thumbnail --}}
      <div style="width:80px;height:60px;border-radius:8px;overflow:hidden;flex-shrink:0;background:#F3F4F6">
        @if($p->photo)
        <img src="{{ str_starts_with($p->photo,'http') ? $p->photo : asset('storage/'.$p->photo) }}"
             style="width:100%;height:100%;object-fit:cover" onerror="this.parentElement.innerHTML='💍'">
        @else
        <div style="display:flex;align-items:center;justify-content:center;height:100%;font-size:1.5rem">💍</div>
        @endif
      </div>
      {{-- Info --}}
      <div style="flex:1;min-width:0">
        <div style="font-weight:600;font-size:.88rem">{{ $p->couple_name }}</div>
        <div style="font-size:.75rem;color:#9CA3AF">{{ $p->package_name }} · ⭐ {{ $p->rating }}/5</div>
        @if($p->testimonial)<div style="font-size:.75rem;color:#6B7280;margin-top:.2rem;line-height:1.4">{{ Str::limit($p->testimonial,80) }}</div>@endif
        <div style="margin-top:.4rem;display:flex;gap:.4rem;flex-wrap:wrap">
          <span class="badge {{ $p->is_visible?'badge-success':'badge-gray' }}">{{ $p->is_visible?'✅ Tampil':'⏸ Tersembunyi' }}</span>
          @if($p->demo_url)<a href="{{ $p->demo_url }}" target="_blank" style="font-size:.7rem;color:var(--color-pink)">Lihat Demo →</a>@endif
        </div>
      </div>
      {{-- Actions --}}
      <div style="display:flex;flex-direction:column;gap:.35rem;flex-shrink:0">
        <button onclick="editPortfolio({{ $p->id }},'{{ addslashes($p->couple_name) }}','{{ addslashes($p->photo ?? '') }}','{{ addslashes($p->package_name ?? '') }}','{{ $p->rating }}','{{ addslashes($p->testimonial ?? '') }}','{{ addslashes($p->demo_url ?? '') }}',{{ $p->is_visible ? 1 : 0 }})" class="btn-outline btn-sm">✏️ Edit</button>
        <form id="del-p-{{ $p->id }}" action="{{ route('admin.portfolios.delete', $p->id) }}" method="POST">@csrf @method('DELETE')
          <button type="button" onclick="confirmDeletePortfolio({{ $p->id }})" class="btn-danger btn-sm">× Hapus</button>
        </form>
      </div>
    </div>
    @empty
    <div style="text-align:center;padding:3rem;color:#9CA3AF"><div style="font-size:3rem;margin-bottom:.75rem">📸</div>Belum ada portfolio</div>
    @endforelse
  </div>

  {{-- ADD/EDIT FORM --}}
  <div class="card card-body" id="portfolioForm">
    <div style="font-weight:600;margin-bottom:1rem" id="formTitle">Tambah Portfolio</div>
    <form id="mainPortfolioForm" action="{{ route('admin.portfolios.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="_method" id="formMethod" value="POST">
      <input type="hidden" name="_id" id="formId">

      <div class="form-group">
        <label class="form-label">Nama Pasangan *</label>
        <input type="text" name="couple_name" id="fCoupleName" class="form-input" placeholder="Cth: Reza & Vina" required>
      </div>

      {{-- Photo options --}}
      <div class="form-group">
        <label class="form-label">Foto Portfolio</label>
        <div style="display:flex;gap:.4rem;margin-bottom:.5rem;background:#F9FAFB;border-radius:8px;padding:.25rem">
          <button type="button" id="photoTabUrl" onclick="switchPhotoTab('url')" style="flex:1;padding:.35rem;border-radius:6px;font-size:.75rem;font-weight:500;border:none;cursor:pointer;background:white;box-shadow:0 1px 3px rgba(0,0,0,.08)">🔗 URL</button>
          <button type="button" id="photoTabFile" onclick="switchPhotoTab('file')" style="flex:1;padding:.35rem;border-radius:6px;font-size:.75rem;font-weight:500;border:none;cursor:pointer;background:transparent;color:#9CA3AF">📁 Upload</button>
        </div>
        <div id="photoUrlDiv">
          <input type="url" name="photo_url" id="fPhotoUrl" class="form-input" placeholder="https://images.unsplash.com/...">
          <div style="font-size:.7rem;color:#9CA3AF;margin-top:.2rem">URL foto langsung (Unsplash, CDN, dll)</div>
        </div>
        <div id="photoFileDiv" style="display:none">
          <div onclick="document.getElementById('portfolioPhotoFile').click()" style="border:2px dashed #E5E7EB;border-radius:8px;padding:1rem;text-align:center;cursor:pointer;transition:border-color .2s" onmouseover="this.style.borderColor='#F472B6'" onmouseout="this.style.borderColor='#E5E7EB'">
            <div style="font-size:1.3rem;margin-bottom:.3rem">📸</div>
            <div id="portfolioPhotoName" style="font-size:.78rem;color:#6B7280">Klik untuk pilih foto</div>
            <div style="font-size:.7rem;color:#9CA3AF;margin-top:.15rem">JPG, PNG · Maks 5MB</div>
          </div>
          <input type="file" id="portfolioPhotoFile" name="photo_file" accept="image/*" style="display:none" onchange="document.getElementById('portfolioPhotoName').textContent=this.files[0]?.name||'Pilih foto'">
        </div>
        {{-- Current photo preview --}}
        <div id="currentPhotoWrap" style="margin-top:.5rem;display:none">
          <div style="font-size:.7rem;color:#9CA3AF;margin-bottom:.25rem">Foto saat ini:</div>
          <img id="currentPhotoPreview" src="" style="height:60px;border-radius:6px;object-fit:cover">
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Nama Paket</label>
        <select name="package_name" id="fPackageName" class="form-input">
          <option value="">Pilih paket</option>
          <option value="Basic">Basic</option>
          <option value="Premium">Premium</option>
          <option value="Luxury">Luxury</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Rating</label>
        <select name="rating" id="fRating" class="form-input" style="width:100px">
          @for($i=5;$i>=1;$i--)<option value="{{ $i }}">⭐ {{ $i }}</option>@endfor
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Testimoni</label>
        <textarea name="testimonial" id="fTestimonial" class="form-input" rows="3" placeholder="Testimoni dari pasangan..."></textarea>
      </div>
      <div class="form-group">
        <label class="form-label">URL Demo Undangan</label>
        <input type="url" name="demo_url" id="fDemoUrl" class="form-input" placeholder="https://...">
      </div>
      <div class="form-group">
        <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer;font-size:.84rem">
          <input type="checkbox" name="is_visible" id="fIsVisible" value="1" checked style="accent-color:#F472B6;width:15px;height:15px"> Tampilkan di website
        </label>
      </div>
      <div style="display:flex;gap:.5rem">
        <button type="submit" class="btn-primary" style="flex:1" id="submitBtn">Simpan Portfolio</button>
        <button type="button" onclick="resetPortfolioForm()" class="btn-outline">Reset</button>
      </div>
    </form>
  </div>
</div>

<script>
function switchPhotoTab(tab) {
    document.getElementById('photoUrlDiv').style.display = tab === 'url' ? 'block' : 'none';
    document.getElementById('photoFileDiv').style.display = tab === 'file' ? 'block' : 'none';
    var urlBtn = document.getElementById('photoTabUrl'), fileBtn = document.getElementById('photoTabFile');
    if (tab === 'url') {
        urlBtn.style.cssText += ';background:white;color:#374151;box-shadow:0 1px 3px rgba(0,0,0,.08)';
        fileBtn.style.cssText += ';background:transparent;color:#9CA3AF;box-shadow:none';
    } else {
        fileBtn.style.cssText += ';background:white;color:#374151;box-shadow:0 1px 3px rgba(0,0,0,.08)';
        urlBtn.style.cssText += ';background:transparent;color:#9CA3AF;box-shadow:none';
    }
}

function editPortfolio(id, name, photo, pkg, rating, testimonial, demoUrl, visible) {
    document.getElementById('formTitle').textContent = 'Edit Portfolio';
    document.getElementById('formMethod').value = 'PUT';
    document.getElementById('formId').value = id;
    document.getElementById('mainPortfolioForm').action = '/webmin/portfolios/' + id;
    document.getElementById('fCoupleName').value = name;
    document.getElementById('fPhotoUrl').value = photo;
    document.getElementById('fPackageName').value = pkg;
    document.getElementById('fRating').value = rating;
    document.getElementById('fTestimonial').value = testimonial;
    document.getElementById('fDemoUrl').value = demoUrl;
    document.getElementById('fIsVisible').checked = visible == 1;
    document.getElementById('submitBtn').textContent = 'Update Portfolio';

    if (photo) {
        var w = document.getElementById('currentPhotoWrap');
        var i = document.getElementById('currentPhotoPreview');
        i.src = photo.startsWith('http') ? photo : '/storage/' + photo;
        w.style.display = 'block';
    }
    // Scroll to form
    document.getElementById('portfolioForm').scrollIntoView({ behavior: 'smooth' });
}

function resetPortfolioForm() {
    document.getElementById('formTitle').textContent = 'Tambah Portfolio';
    document.getElementById('formMethod').value = 'POST';
    document.getElementById('formId').value = '';
    document.getElementById('mainPortfolioForm').action = '{{ route('admin.portfolios.store') }}';
    document.getElementById('mainPortfolioForm').reset();
    document.getElementById('submitBtn').textContent = 'Simpan Portfolio';
    document.getElementById('currentPhotoWrap').style.display = 'none';
}

function confirmDeletePortfolio(id) {
    if (confirm('Hapus portfolio ini? Tindakan ini tidak bisa dibatalkan.')) {
        document.getElementById('del-p-' + id).submit();
    }
}
</script>
@endsection
