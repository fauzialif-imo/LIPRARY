@extends('layouts.admin')
@section('title','Tambah Buku')
@section('page-title','Tambah Buku')
@section('content')
<div class="dl-card-p" style="max-width:820px">
  <form method="POST" action="{{ route('admin.books.store') }}" enctype="multipart/form-data">
    @csrf
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:18px">
      <div style="grid-column:1/-1">
        <label class="field-label">Judul *</label>
        <input class="field-input" name="title" value="{{ old('title') }}" required placeholder="Judul buku">
      </div>
      <div>
        <label class="field-label">Penulis *</label>
        <input class="field-input" name="author" value="{{ old('author') }}" required>
      </div>
      <div>
        <label class="field-label">Penerbit *</label>
        <input class="field-input" name="publisher" value="{{ old('publisher') }}" required>
      </div>
      <div>
        <label class="field-label">Kategori *</label>
        <select class="field-select" name="category_id" required>
          <option value="">-- Pilih --</option>
          @foreach($categories as $c)<option value="{{ $c->id }}" {{ old('category_id')==$c->id?'selected':'' }}>{{ $c->name }}</option>@endforeach
        </select>
      </div>
      <div>
        <label class="field-label">Tahun Terbit</label>
        <input class="field-input" name="publish_date" type="number" min="1900" max="{{ date('Y')+1 }}" value="{{ old('publish_date') }}" placeholder="{{ date('Y') }}">
      </div>
      <div>
        <label class="field-label">ISBN</label>
        <input class="field-input" name="isbn" value="{{ old('isbn') }}" placeholder="978-...">
      </div>
      <div>
        <label class="field-label">Jumlah Halaman</label>
        <input class="field-input" name="pages" type="number" min="1" value="{{ old('pages') }}">
      </div>
      <div>
        <label class="field-label">Stok *</label>
        <input class="field-input" name="stock" type="number" min="0" value="{{ old('stock',1) }}" required>
      </div>
      <div style="grid-column:1/-1">
        <label class="field-label">Sinopsis</label>
        <textarea class="field-textarea" name="synopsis" rows="4" placeholder="Ringkasan cerita buku…">{{ old('synopsis') }}</textarea>
      </div>
      <div>
        <label class="field-label">Cover Buku</label>
        <input type="file" class="field-input" name="cover" accept="image/*" style="padding-top:8px">
      </div>
    </div>
    <div style="display:flex;gap:10px;margin-top:24px;justify-content:flex-end">
      <a href="{{ route('admin.books.index') }}" class="btn-dl-secondary"><i class="fas fa-times"></i>Batal</a>
      <button type="submit" class="btn-dl-primary"><i class="fas fa-save"></i>Simpan Buku</button>
    </div>
    @if($errors->any())<div class="dl-alert dl-alert-error" style="margin-top:12px"><i class="fas fa-exclamation-circle"></i>{{ $errors->first() }}</div>@endif
  </form>
</div>
@endsection
