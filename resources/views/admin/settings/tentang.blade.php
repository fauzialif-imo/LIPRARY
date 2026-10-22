@extends('layouts.admin')
@section('title','Pengaturan Tentang')
@section('page-title','Pengaturan Tentang')
@section('page-subtitle','Gambar di section "Apa Itu YomuLib?"')
@include('admin.settings._styles')

@section('content')
<form method="POST" action="{{ route('admin.settings.tentang.update') }}" enctype="multipart/form-data">
@csrf @method('PUT')
<div class="set-grid">
  <div style="display:flex;flex-direction:column;gap:20px">
    <div class="dl-card-p">
      <div class="section-title" style="margin-bottom:6px"><i class="fas fa-info-circle" style="color:var(--gold);margin-right:6px"></i>Gambar Tentang</div>
      <p style="font-size:.78rem;color:var(--muted);margin-bottom:14px">Tampil di sisi kiri teks tentang. Kosong = ilustrasi rak buku SVG default.</p>
      @include('admin.settings._upload',['name'=>'about_image','current'=>$s['about_image'],'label'=>'Upload Gambar','rec'=>'Rekomendasi: 600×700 px (portrait)','previewId'=>'aboutPrev'])
    </div>
    <div style="display:flex;gap:10px">
      <button type="submit" class="btn-dl-primary"><i class="fas fa-save"></i> Simpan</button>
      <a href="{{ url('/') }}" target="_blank" class="btn-dl-secondary"><i class="fas fa-external-link-alt"></i> Lihat Situs</a>
    </div>
  </div>
  <div class="preview-panel">
    <div class="section-title" style="margin-bottom:12px"><i class="fas fa-eye" style="color:var(--gold);margin-right:6px"></i>Preview</div>
    <div style="background:var(--navy);border-radius:12px;padding:20px;display:flex;gap:14px;align-items:center;border:1.5px solid var(--border)">
      @if($s['about_image'])
        <img id="aboutPrev" src="{{ asset('storage/'.$s['about_image']) }}" style="width:100px;height:120px;object-fit:cover;border-radius:8px;flex-shrink:0">
      @else
        <div id="aboutPrev" style="width:100px;height:120px;background:rgba(255,255,255,.06);border-radius:8px;flex-shrink:0;display:flex;align-items:center;justify-content:center;color:rgba(201,168,76,.4);font-size:1.8rem"><i class="fas fa-book-open"></i></div>
      @endif
      <div>
        <div style="font-family:'Playfair Display',serif;color:var(--gold);font-size:.9rem;font-weight:700;margin-bottom:6px">Apa Itu YomuLib?</div>
        <div style="font-size:.7rem;color:rgba(255,255,255,.5);line-height:1.6">Platform perpustakaan digital modern untuk SMK...</div>
      </div>
    </div>
    <div class="preview-info"><ul><li>Kosong → ilustrasi SVG rak buku</li><li>Format: JPG, PNG, WebP — maks. 4 MB</li></ul></div>
  </div>
</div>
</form>
@endsection
