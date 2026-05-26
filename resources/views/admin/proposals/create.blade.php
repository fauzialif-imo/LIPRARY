@extends('layouts.admin')
@section('title','Buat Usulan')
@section('page-title','Buat Usulan Buku')
@section('content')
<div class="dl-card-p" style="max-width:760px">
  <form method="POST" action="{{ route('admin.books.proposals.store') }}" enctype="multipart/form-data">
    @csrf
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
      <div style="grid-column:1/-1"><label class="field-label">Judul Buku *</label><input class="field-input" name="title" value="{{ old('title') }}" required></div>
      <div><label class="field-label">Penulis *</label><input class="field-input" name="author" value="{{ old('author') }}" required></div>
      <div><label class="field-label">Penerbit</label><input class="field-input" name="publisher" value="{{ old('publisher') }}"></div>
      <div><label class="field-label">Kategori *</label>
        <select class="field-select" name="category_id" required>
          <option value="">-- Pilih --</option>
          @foreach($categories as $c)<option value="{{ $c->id }}" {{ old('category_id')==$c->id?'selected':'' }}>{{ $c->name }}</option>@endforeach
        </select>
      </div>
      <div><label class="field-label">Tahun Terbit</label><input class="field-input" name="publish_year" type="number" min="1900" max="{{ date('Y')+1 }}" value="{{ old('publish_year') }}"></div>
      <div><label class="field-label">ISBN</label><input class="field-input" name="isbn" value="{{ old('isbn') }}"></div>
      <div style="grid-column:1/-1"><label class="field-label">Sinopsis</label><textarea class="field-textarea" name="synopsis" rows="3">{{ old('synopsis') }}</textarea></div>
      <div style="grid-column:1/-1"><label class="field-label">Alasan Mengusulkan *</label><textarea class="field-textarea" name="reason" rows="3" required placeholder="Kenapa buku ini perlu ditambahkan ke koleksi?">{{ old('reason') }}</textarea></div>
      <div><label class="field-label">Gambar Cover</label><input type="file" class="field-input" name="cover" accept="image/*" style="padding-top:8px"></div>
    </div>
    <div style="display:flex;gap:10px;margin-top:20px;justify-content:flex-end">
      <a href="{{ route('admin.books.proposals.index') }}" class="btn-dl-secondary"><i class="fas fa-times"></i>Batal</a>
      <button type="submit" class="btn-dl-primary"><i class="fas fa-paper-plane"></i>Kirim Usulan</button>
    </div>
    @if($errors->any())<div class="dl-alert dl-alert-error" style="margin-top:12px"><i class="fas fa-exclamation-circle"></i>{{ $errors->first() }}</div>@endif
  </form>
</div>
@endsection
