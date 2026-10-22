@extends('layouts.admin')
@section('title','Pengaturan Fitur')
@section('page-title','Pengaturan Fitur Unggulan')
@section('page-subtitle','Background kartu fitur di landing page')
@include('admin.settings._styles')

@section('content')
@php
$featureDefs=[1=>['label'=>'Berbasis WEB','icon'=>'fas fa-globe'],2=>['label'=>'Katalog Luas','icon'=>'fas fa-book-open'],3=>['label'=>'Modul Praktik','icon'=>'fas fa-puzzle-piece']];
@endphp
<form method="POST" action="{{ route('admin.settings.fitur.update') }}" enctype="multipart/form-data">
@csrf @method('PUT')
<div class="set-grid">
  <div style="display:flex;flex-direction:column;gap:20px">
    @foreach($featureDefs as $n=>$feat)
    <div class="dl-card-p">
      <div class="section-title" style="margin-bottom:6px"><i class="{{ $feat['icon'] }}" style="color:var(--gold);margin-right:6px"></i>Fitur {{ $n }} — {{ $feat['label'] }}</div>
      <p style="font-size:.78rem;color:var(--muted);margin-bottom:14px">Background kartu. Kosong = navy gelap default.</p>
      @include('admin.settings._upload',['name'=>"feature_{$n}_image",'current'=>$s["feature_{$n}_image"],'label'=>'Upload Gambar','rec'=>'Rekomendasi: 600×400 px','previewId'=>"featCard{$n}"])
    </div>
    @endforeach
    <div style="display:flex;gap:10px">
      <button type="submit" class="btn-dl-primary"><i class="fas fa-save"></i> Simpan Semua</button>
      <a href="{{ url('/') }}" target="_blank" class="btn-dl-secondary"><i class="fas fa-external-link-alt"></i> Lihat Situs</a>
    </div>
  </div>
  <div class="preview-panel">
    <div class="section-title" style="margin-bottom:12px"><i class="fas fa-eye" style="color:var(--gold);margin-right:6px"></i>Preview</div>
    <div class="feat-prev-grid">
      @foreach($featureDefs as $n=>$feat)
      <div class="feat-prev-card" id="featCard{{ $n }}"
           @if($s["feature_{$n}_image"]) style="background-image:url('{{ asset('storage/'.$s["feature_{$n}_image"]) }}')" @endif>
        <div class="feat-prev-label"><i class="{{ $feat['icon'] }}" style="display:block;margin-bottom:3px"></i>{{ $feat['label'] }}</div>
      </div>
      @endforeach
    </div>
    <div class="preview-info"><ul><li>Tiap kartu punya background sendiri</li><li>Kosong = navy gelap</li><li>Format: JPG, PNG, WebP — maks. 4 MB</li></ul></div>
  </div>
</div>
</form>
@endsection
