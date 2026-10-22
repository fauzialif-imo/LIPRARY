@extends('layouts.admin')
@section('title','Pengaturan Kategori')
@section('page-title','Pengaturan Kategori Utama')
@section('page-subtitle','Background kartu kategori di landing page')
@include('admin.settings._styles')

@section('content')
@php
$categoryDefs=[1=>['label'=>'Fiksi Novel','icon'=>'fas fa-book','cls'=>'ck1'],2=>['label'=>'Fiksi Komik','icon'=>'fas fa-images','cls'=>'ck2'],3=>['label'=>'Pemrograman','icon'=>'fas fa-code','cls'=>'ck3'],4=>['label'=>'Non Fiksi Sejarah','icon'=>'fas fa-landmark','cls'=>'ck4']];
@endphp
<form method="POST" action="{{ route('admin.settings.kategori.update') }}" enctype="multipart/form-data">
@csrf @method('PUT')
<div class="set-grid">
  <div style="display:flex;flex-direction:column;gap:20px">
    @foreach($categoryDefs as $n=>$cat)
    <div class="dl-card-p">
      <div class="section-title" style="margin-bottom:6px"><i class="{{ $cat['icon'] }}" style="color:var(--gold);margin-right:6px"></i>Kategori {{ $n }} — {{ $cat['label'] }}</div>
      <p style="font-size:.78rem;color:var(--muted);margin-bottom:14px">Background kartu. Kosong = gradient default.</p>
      @include('admin.settings._upload',['name'=>"category_{$n}_image",'current'=>$s["category_{$n}_image"],'label'=>'Upload Gambar','rec'=>'Rekomendasi: 800×400 px','previewId'=>"catCard{$n}"])
    </div>
    @endforeach
    <div style="display:flex;gap:10px">
      <button type="submit" class="btn-dl-primary"><i class="fas fa-save"></i> Simpan Semua</button>
      <a href="{{ url('/') }}" target="_blank" class="btn-dl-secondary"><i class="fas fa-external-link-alt"></i> Lihat Situs</a>
    </div>
  </div>
  <div class="preview-panel">
    <div class="section-title" style="margin-bottom:12px"><i class="fas fa-eye" style="color:var(--gold);margin-right:6px"></i>Preview</div>
    <div class="cat-prev-grid">
      @foreach($categoryDefs as $n=>$cat)
      <div class="cat-prev-card {{ $cat['cls'] }}" id="catCard{{ $n }}"
           @if($s["category_{$n}_image"]) style="background-image:url('{{ asset('storage/'.$s["category_{$n}_image"]) }}');background-size:cover;background-position:center" @endif>
        <div class="cat-prev-label"><i class="{{ $cat['icon'] }}" style="margin-right:4px"></i>{{ $cat['label'] }}</div>
      </div>
      @endforeach
    </div>
    <div class="preview-info"><ul><li>Tiap kartu punya background sendiri</li><li>Kosong = gradient warna default</li><li>Format: JPG, PNG, WebP — maks. 4 MB</li></ul></div>
  </div>
</div>
</form>
@endsection
