@extends('layouts.admin')
@section('title', $template ? 'Edit Template' : 'Tambah Template')
@section('page_title', $template ? 'Edit Template: ' . $template->name : 'Tambah Template Baru')

@section('content')
<div style="max-width:700px;">
    <div class="card">
        <div class="card-body">
            <form action="{{ $template ? route('admin.templates.update', $template->id) : route('admin.templates.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if($template) @method('PUT') @endif

                @if($errors->any())
                <div class="alert alert-danger" style="margin-bottom:1rem;">
                    @foreach($errors->all() as $e)<div>• {{ $e }}</div>@endforeach
                </div>
                @endif

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                    <div class="form-group">
                        <label class="form-label">Nama Template <span style="color:#EF4444;">*</span></label>
                        <input type="text" name="name" class="form-input" value="{{ old('name', $template?->name) }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kategori <span style="color:#EF4444;">*</span></label>
                        <select name="category" class="form-select" required>
                            <option value="">Pilih Kategori</option>
                            @foreach(['basic','premium','luxury'] as $cat)
                            <option value="{{ $cat }}" {{ old('category', $template?->category) === $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Nama File View <span style="color:#EF4444;">*</span></label>
                    <div style="position:relative;">
                        <span style="position:absolute;left:0.75rem;top:50%;transform:translateY(-50%);font-size:0.78rem;color:#9CA3AF;">resources/views/templates/</span>
                        <input type="text" name="file_path" class="form-input" value="{{ old('file_path', $template?->file_path) }}" placeholder="sakura-bloom" required style="padding-left:220px;">
                    </div>
                    <div style="font-size:0.72rem;color:#9CA3AF;margin-top:0.2rem;">Contoh: sakura-bloom (tanpa .blade.php)</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-textarea" rows="2" placeholder="Deskripsi singkat template...">{{ old('description', $template?->description) }}</textarea>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                    <div class="form-group">
                        <label class="form-label">Warna Primer</label>
                        <div style="display:flex;gap:0.5rem;align-items:center;">
                            <input type="color" name="primary_color" value="{{ old('primary_color', $template?->primary_color ?? '#F472B6') }}" style="width:40px;height:36px;border:1.5px solid #E5E7EB;border-radius:8px;cursor:pointer;padding:2px;">
                            <input type="text" id="primary_color_text" value="{{ old('primary_color', $template?->primary_color ?? '#F472B6') }}" class="form-input" style="flex:1;" oninput="document.querySelector('[name=primary_color]').value=this.value">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Warna Sekunder</label>
                        <div style="display:flex;gap:0.5rem;align-items:center;">
                            <input type="color" name="secondary_color" value="{{ old('secondary_color', $template?->secondary_color ?? '#93C5FD') }}" style="width:40px;height:36px;border:1.5px solid #E5E7EB;border-radius:8px;cursor:pointer;padding:2px;">
                            <input type="text" id="secondary_color_text" value="{{ old('secondary_color', $template?->secondary_color ?? '#93C5FD') }}" class="form-input" style="flex:1;" oninput="document.querySelector('[name=secondary_color]').value=this.value">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Thumbnail</label>
                    <div style="border:2px dashed #E5E7EB;border-radius:10px;padding:1.25rem;text-align:center;cursor:pointer;background:#FAFAFA;" onclick="document.getElementById('thumbnailInput').click()">
                        @if($template?->thumbnail)
                        <img src="{{ $template->thumbnail }}" style="max-height:120px;border-radius:8px;margin-bottom:0.5rem;object-fit:cover;">
                        @endif
                        <div style="font-size:0.8rem;color:#9CA3AF;">Klik untuk upload thumbnail (JPG/PNG, maks. 2MB)</div>
                    </div>
                    <input type="file" id="thumbnailInput" name="thumbnail" accept="image/*" style="display:none;" onchange="previewThumb(this)">
                </div>

                <div class="form-group">
                    <label class="form-label">URL Preview <span style="color:#9CA3AF;font-weight:400;">(opsional)</span></label>
                    <input type="url" name="preview_url" class="form-input" value="{{ old('preview_url', $template?->preview_url) }}" placeholder="https://...">
                </div>

                <div class="form-group">
                    <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer;font-size:0.85rem;">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $template?->is_active ?? true) ? 'checked' : '' }} style="width:16px;height:16px;accent-color:#F472B6;">
                        Template aktif (ditampilkan di website)
                    </label>
                </div>

                <div class="form-group">
                    <label class="form-label">Urutan Tampil</label>
                    <input type="number" name="sort_order" class="form-input" value="{{ old('sort_order', $template?->sort_order ?? 1) }}" min="1" style="width:120px;">
                </div>

                <div style="display:flex;gap:0.75rem;margin-top:0.5rem;">
                    <button type="submit" class="btn-primary" style="padding:0.65rem 1.5rem;">
                        {{ $template ? 'Perbarui Template' : 'Tambah Template' }}
                    </button>
                    <a href="{{ route('admin.templates') }}" class="btn-outline" style="padding:0.65rem 1.5rem;">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function previewThumb(input) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const zone = input.previousElementSibling;
        zone.innerHTML = `<img src="${e.target.result}" style="max-height:120px;border-radius:8px;margin-bottom:0.5rem;object-fit:cover;"><div style="font-size:0.8rem;color:#9CA3AF;">${file.name}</div>`;
    };
    reader.readAsDataURL(file);
}
</script>
@endpush
@endsection
