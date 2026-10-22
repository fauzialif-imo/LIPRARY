@extends('layouts.admin')
@section('title','Pengaturan Hero')
@section('page-title','Pengaturan Hero')
@section('page-subtitle','Background, teks, dan logo navbar')
@include('admin.settings._styles')

@section('content')
<form method="POST" action="{{ route('admin.settings.hero.update') }}" enctype="multipart/form-data">
@csrf @method('PUT')
<div class="set-grid">
  <div style="display:flex;flex-direction:column;gap:20px">

    <div class="dl-card-p">
      <div class="section-title" style="margin-bottom:14px"><i class="fas fa-image" style="color:var(--gold);margin-right:6px"></i>Background Hero</div>
      @include('admin.settings._upload',['name'=>'hero_bg_image','current'=>$s['hero_bg_image'],'label'=>'Upload Background','rec'=>'Rekomendasi: 1440×600 px','previewId'=>'heroPreview'])
    </div>

    <div class="dl-card-p">
      <div class="section-title" style="margin-bottom:6px"><i class="fas fa-star" style="color:var(--gold);margin-right:6px"></i>Logo & Nama Navbar</div>
      <p style="font-size:.78rem;color:var(--muted);margin-bottom:14px">Logo tampil di kiri, nama situs di kanannya.</p>
      <div style="margin-bottom:14px">
        <label class="field-label">Nama Situs</label>
        <input class="field-input" name="navbar_site_name" id="navSiteName"
               value="{{ old('navbar_site_name',$s['navbar_site_name']) }}" placeholder="YOMULIB" maxlength="60"
               oninput="document.getElementById('navNamePreview').textContent=this.value||'YOMULIB'">
      </div>
      <label class="field-label">Logo (opsional)</label>
      @include('admin.settings._upload',['name'=>'navbar_logo','current'=>$s['navbar_logo'],'label'=>'Upload Logo','rec'=>'PNG transparan, tinggi 40–60 px','previewId'=>'navLogoImg'])
    </div>

    <div class="dl-card-p">
      <div class="section-title" style="margin-bottom:14px"><i class="fas fa-font" style="color:var(--gold);margin-right:6px"></i>Teks Hero</div>
      <div style="margin-bottom:14px">
        <label class="field-label">Judul Utama</label>
        <input class="field-input" name="hero_title" value="{{ old('hero_title',$s['hero_title']) }}" maxlength="200"
               oninput="document.getElementById('prevTitle').textContent=this.value||'Judul Hero'">
      </div>
      <div>
        <label class="field-label">Subjudul</label>
        <input class="field-input" name="hero_subtitle" value="{{ old('hero_subtitle',$s['hero_subtitle']) }}" maxlength="300"
               oninput="document.getElementById('prevSub').textContent=this.value||'Deskripsi...'">
      </div>
    </div>

    <div style="display:flex;gap:10px">
      <button type="submit" class="btn-dl-primary"><i class="fas fa-save"></i> Simpan</button>
      <a href="{{ url('/') }}" target="_blank" class="btn-dl-secondary"><i class="fas fa-external-link-alt"></i> Lihat Situs</a>
    </div>
  </div>

  <div class="preview-panel">
    <div class="section-title" style="margin-bottom:12px"><i class="fas fa-eye" style="color:var(--gold);margin-right:6px"></i>Preview</div>
    <div class="hero-preview {{ $s['hero_bg_image'] ? 'has-bg' : '' }}" id="heroPreview"
         @if($s['hero_bg_image']) style="background-image:url('{{ asset('storage/'.$s['hero_bg_image']) }}')" @endif>
      <div class="hp-text">
        <h3 id="prevTitle">{{ $s['hero_title'] }}</h3>
        <p id="prevSub">{{ $s['hero_subtitle'] }}</p>
      </div>
    </div>
    <div style="margin-top:16px">
      <div class="section-title" style="margin-bottom:10px"><i class="fas fa-eye" style="color:var(--gold);margin-right:6px"></i>Preview Navbar</div>
      <div style="background:rgba(13,27,62,.97);border-radius:10px;padding:10px 18px;display:flex;align-items:center;gap:10px;border:1.5px solid var(--border)">
        @if($s['navbar_logo'])
          <img id="navLogoImg" src="{{ asset('storage/'.$s['navbar_logo']) }}" style="height:32px;width:auto;object-fit:contain;flex-shrink:0">
        @else
          <i id="navLogoImg" class="fas fa-book-open" style="color:#c9a84c;font-size:20px;flex-shrink:0"></i>
        @endif
        <span id="navNamePreview" style="color:#c9a84c;font-family:'Playfair Display',serif;font-size:.95rem;font-weight:700">{{ $s['navbar_site_name'] }}</span>
      </div>
    </div>
    <div class="preview-info">
      <ul>
        <li>Tanpa gambar → gradient biru default</li>
        <li>Format: JPG, PNG, WebP — maks. 4 MB</li>
      </ul>
    </div>
  </div>
</div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded',function(){
    const logoInput=document.getElementById('file_navbar_logo');
    if(!logoInput)return;
    logoInput.addEventListener('change',function(){
        const file=this.files[0];if(!file)return;
        const url=URL.createObjectURL(file);
        const el=document.getElementById('navLogoImg');
        if(!el)return;
        if(el.tagName==='IMG'){el.src=url;}
        else{const img=document.createElement('img');img.id='navLogoImg';img.src=url;img.style.cssText='height:32px;width:auto;object-fit:contain;flex-shrink:0';el.replaceWith(img);}
    });
    const bgFile=document.getElementById('file_hero_bg_image');
    if(bgFile)bgFile.addEventListener('change',function(){
        const file=this.files[0];if(!file)return;
        const hp=document.getElementById('heroPreview');
        hp.style.backgroundImage=`url('${URL.createObjectURL(file)}')`;hp.classList.add('has-bg');
    });
});
</script>
@endpush
