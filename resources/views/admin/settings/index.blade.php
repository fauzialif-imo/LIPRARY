@extends('layouts.admin')
@section('title','Pengaturan Situs')
@section('page-title','Pengaturan Situs')
@section('page-subtitle','Kustomisasi tampilan landing page')

@push('styles')
<style>
/* ── Tab Nav ── */
.set-tabs {
    display: flex;
    gap: 4px;
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 5px;
    margin-bottom: 28px;
    flex-wrap: wrap;
}
.set-tab {
    flex: 1;
    min-width: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 10px 14px;
    border-radius: 10px;
    font-size: .75rem;
    font-weight: 700;
    letter-spacing: .04em;
    text-transform: uppercase;
    color: var(--muted);
    cursor: pointer;
    border: none;
    background: transparent;
    transition: all .18s;
}
.set-tab:hover { color: var(--ink-2); background: var(--surface); }
.set-tab.active { background: var(--white); color: var(--gold); box-shadow: 0 1px 6px rgba(0,0,0,.08); }
.set-tab i { font-size: .85rem; }

/* ── Panel ── */
.set-panel { display: none; }
.set-panel.active { display: block; }

/* ── 2-col layout ── */
.set-grid { display: grid; grid-template-columns: 1fr 360px; gap: 24px; align-items: start; }

/* ── Upload zone ── */
.upload-zone {
    border: 2px dashed var(--border-2);
    border-radius: 12px;
    padding: 28px 20px;
    text-align: center;
    cursor: pointer;
    transition: all .2s;
    background: var(--bg);
    position: relative;
}
.upload-zone:hover, .upload-zone.drag-over {
    border-color: var(--gold);
    background: rgba(201,168,76,.05);
}
.upload-zone input[type=file] {
    position: absolute; inset: 0;
    opacity: 0; cursor: pointer;
    width: 100%; height: 100%;
}
.upload-icon {
    width: 48px; height: 48px;
    border-radius: 12px;
    background: var(--gold-pale);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 10px;
    font-size: 1.3rem;
    color: var(--gold);
}
.mini-zone {
    padding: 16px 12px;
    min-height: 88px;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    border-radius: 10px;
}

/* ── Current thumb ── */
.thumb {
    width: 100%; object-fit: cover;
    border-radius: 10px;
    border: 1.5px solid var(--border);
    display: block;
}
.thumb-tall  { height: 120px; }
.thumb-wide  { height: 90px; }
.thumb-sq    { height: 100px; }

/* ── Remove btn ── */
.remove-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 5px 12px; font-size: .72rem; font-weight: 700;
    color: var(--red); background: var(--red-pale);
    border: 1px solid transparent; border-radius: 8px;
    cursor: pointer; transition: all .15s; margin-top: 8px;
}
.remove-btn:hover { background: var(--red); color: #fff; }
.remove-btn.full { width: 100%; justify-content: center; margin-top: 6px; }

/* ── Hero preview ── */
.hero-preview {
    width: 100%; height: 200px;
    border-radius: 12px; overflow: hidden;
    position: relative;
    display: flex; align-items: center;
    padding: 28px 32px;
    background: linear-gradient(135deg, #0d1b3e 0%, #1a2d5a 60%, #0a1628 100%);
    border: 1.5px solid var(--border);
}
.hero-preview::before {
    content: ''; position: absolute; inset: 0;
    background: radial-gradient(ellipse at 70% 50%, rgba(201,168,76,.08) 0%, transparent 60%);
}
.hero-preview.has-bg { background-size: cover; background-position: center; }
.hero-preview.has-bg::after {
    content: ''; position: absolute; inset: 0;
    background: rgba(10,20,50,.58);
}
.hp-text { position: relative; z-index: 2; }
.hp-text h3 {
    font-family: 'Playfair Display', serif;
    color: #fff; font-size: 1.1rem; font-weight: 700;
    line-height: 1.3; margin-bottom: 6px;
    text-shadow: 0 2px 8px rgba(0,0,0,.4);
}
.hp-text p { color: rgba(255,255,255,.7); font-size: .8rem; }

/* ── Feature preview cards ── */
.feat-prev-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 10px; }
.feat-prev-card {
    border-radius: 10px; overflow: hidden; height: 90px;
    position: relative; display: flex; align-items: flex-end;
    background: var(--navy); background-size: cover; background-position: center;
}
.feat-prev-card::after {
    content: ''; position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(10,18,50,.85), rgba(10,18,50,.25));
}
.feat-prev-label {
    position: relative; z-index: 1;
    padding: 8px; font-size: .65rem; font-weight: 700;
    color: var(--gold); line-height: 1.2;
}

/* ── Category preview cards ── */
.cat-prev-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
.cat-prev-card {
    border-radius: 10px; overflow: hidden; height: 72px;
    position: relative; display: flex; align-items: flex-end;
    background-size: cover; background-position: center;
}
.cat-prev-card::after {
    content: ''; position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(13,27,62,.85), transparent 60%);
}
.cat-prev-label {
    position: relative; z-index: 1;
    padding: 7px 10px; font-size: .65rem; font-weight: 700; color: #fff;
}
.ck1 { background: linear-gradient(135deg,#4a6fa5,#2d4a7a); }
.ck2 { background: linear-gradient(135deg,#7a5c2a,#c9a84c); }
.ck3 { background: linear-gradient(135deg,#2a5a4a,#48a07a); }
.ck4 { background: linear-gradient(135deg,#5a2a4a,#a04878); }

/* ── Sticky preview panel ── */
.preview-panel { position: sticky; top: 20px; }
.preview-panel .section-title { margin-bottom: 12px; }
.preview-info {
    margin-top: 12px; padding: 12px 16px;
    background: var(--bg); border-radius: 10px;
    border: 1px solid var(--border);
}
.preview-info ul { font-size: .76rem; color: var(--muted); padding-left: 16px; line-height: 1.9; }
</style>
@endpush

@section('content')

{{-- Tab nav --}}
<div class="set-tabs">
    <button type="button" class="set-tab active" onclick="switchTab('hero')" id="tab-hero">
        <i class="fas fa-home"></i> Hero
    </button>
    <button type="button" class="set-tab" onclick="switchTab('tentang')" id="tab-tentang">
        <i class="fas fa-info-circle"></i> Tentang
    </button>
    <button type="button" class="set-tab" onclick="switchTab('fitur')" id="tab-fitur">
        <i class="fas fa-th-large"></i> Fitur
    </button>
    <button type="button" class="set-tab" onclick="switchTab('kategori')" id="tab-kategori">
        <i class="fas fa-images"></i> Kategori
    </button>
</div>

{{-- ══════════════════════════════════════════
     TAB 1 — HERO
════════════════════════════════════════════ --}}
<div class="set-panel active" id="panel-hero">
<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
@csrf @method('PUT')
<input type="hidden" name="_tab" value="hero">

<div class="set-grid">
  <div style="display:flex;flex-direction:column;gap:20px">

    {{-- Background image --}}
    <div class="dl-card-p">
      <div class="section-title" style="margin-bottom:14px">
        <i class="fas fa-image" style="color:var(--gold);margin-right:6px"></i>Background Hero
      </div>
      @if($settings['hero_bg_image'])
        <label class="field-label">Gambar Saat Ini</label>
        <img src="{{ asset('storage/'.$settings['hero_bg_image']) }}" class="thumb thumb-wide" style="margin-bottom:8px">
        <input type="hidden" name="remove_hero_bg_image" id="removeBgFlag" value="0">
        <button type="button" class="remove-btn" onclick="flagRemove('removeBgFlag', this.closest('form'))">
          <i class="fas fa-trash-alt"></i> Hapus Background
        </button>
        <div style="margin-top:14px">
          <label class="field-label">Ganti Gambar</label>
      @else
        <label class="field-label">Upload Background</label>
        <input type="hidden" name="remove_hero_bg_image" value="0">
      @endif
          <div class="upload-zone" id="bgZone">
            <input type="file" name="hero_bg_image" id="bgFile" accept="image/jpeg,image/png,image/webp">
            <div class="upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
            <div id="bgLabel">
              <div style="font-size:.85rem;font-weight:600;color:var(--ink-2);margin-bottom:4px">Klik atau drag & drop</div>
              <div style="font-size:.72rem;color:var(--muted)">JPG, PNG, WebP — Maks. 4 MB</div>
              <div style="font-size:.72rem;color:var(--muted);margin-top:3px">Rekomendasi: 1440 × 600 px</div>
            </div>
          </div>
      @if($settings['hero_bg_image'])
        </div>
      @endif
    </div>

    {{-- Teks Hero --}}
    <div class="dl-card-p">
      <div class="section-title" style="margin-bottom:14px">
        <i class="fas fa-font" style="color:var(--gold);margin-right:6px"></i>Teks Hero
      </div>
      <div style="margin-bottom:14px">
        <label class="field-label" for="hero_title">Judul Utama</label>
        <input class="field-input" id="hero_title" name="hero_title"
               value="{{ old('hero_title', $settings['hero_title']) }}"
               placeholder="Pintu Gerbang Digital..." maxlength="200" oninput="updateHeroPreview()">
      </div>
      <div>
        <label class="field-label" for="hero_subtitle">Subjudul</label>
        <input class="field-input" id="hero_subtitle" name="hero_subtitle"
               value="{{ old('hero_subtitle', $settings['hero_subtitle']) }}"
               placeholder="Akses Buku dan Modul SMK di sini" maxlength="300" oninput="updateHeroPreview()">
      </div>
    </div>

    <div style="display:flex;gap:10px">
      <button type="submit" class="btn-dl-primary"><i class="fas fa-save"></i> Simpan</button>
      <a href="{{ url('/') }}" target="_blank" class="btn-dl-secondary"><i class="fas fa-external-link-alt"></i> Lihat Situs</a>
    </div>
  </div>

  {{-- Preview --}}
  <div class="preview-panel">
    <div class="section-title"><i class="fas fa-eye" style="color:var(--gold);margin-right:6px"></i>Preview Hero</div>
    <div class="hero-preview {{ $settings['hero_bg_image'] ? 'has-bg' : '' }}" id="heroPreview"
         @if($settings['hero_bg_image']) style="background-image:url('{{ asset('storage/'.$settings['hero_bg_image']) }}')" @endif>
      <div class="hp-text">
        <h3 id="prevTitle">{{ $settings['hero_title'] }}</h3>
        <p id="prevSub">{{ $settings['hero_subtitle'] }}</p>
      </div>
    </div>
    <div class="preview-info">
      <ul>
        <li>Tampil sebagai background bagian atas landing page</li>
        <li>Format: JPG, PNG, WebP — maks. 4 MB</li>
        <li>Tanpa gambar → gradient biru default</li>
      </ul>
    </div>
  </div>
</div>
</form>
</div>

{{-- ══════════════════════════════════════════
     TAB 2 — TENTANG
════════════════════════════════════════════ --}}
<div class="set-panel" id="panel-tentang">
<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
@csrf @method('PUT')
<input type="hidden" name="_tab" value="tentang">

<div class="set-grid">
  <div style="display:flex;flex-direction:column;gap:20px">
    <div class="dl-card-p">
      <div class="section-title" style="margin-bottom:6px">
        <i class="fas fa-info-circle" style="color:var(--gold);margin-right:6px"></i>Gambar Seksi "Apa Itu YomuLib?"
      </div>
      <p style="font-size:.78rem;color:var(--muted);margin-bottom:16px">Tampil di sisi kiri teks tentang. Kosong = ilustrasi rak buku default.</p>

      @if($settings['about_image'])
        <label class="field-label">Gambar Saat Ini</label>
        <img src="{{ asset('storage/'.$settings['about_image']) }}" class="thumb" style="height:160px;margin-bottom:8px">
        <input type="hidden" name="remove_about_image" id="removeAboutFlag" value="0">
        <button type="button" class="remove-btn" onclick="flagRemove('removeAboutFlag', this.closest('form'))">
          <i class="fas fa-trash-alt"></i> Hapus Gambar
        </button>
        <div style="margin-top:14px">
          <label class="field-label">Ganti Gambar</label>
      @else
        <label class="field-label">Upload Gambar</label>
        <input type="hidden" name="remove_about_image" value="0">
      @endif
          <div class="upload-zone" id="aboutZone">
            <input type="file" name="about_image" id="aboutFile" accept="image/jpeg,image/png,image/webp">
            <div class="upload-icon"><i class="fas fa-image"></i></div>
            <div id="aboutLabel">
              <div style="font-size:.85rem;font-weight:600;color:var(--ink-2);margin-bottom:4px">Klik atau drag & drop</div>
              <div style="font-size:.72rem;color:var(--muted)">JPG, PNG, WebP — Maks. 4 MB</div>
              <div style="font-size:.72rem;color:var(--muted);margin-top:3px">Rekomendasi: 600 × 700 px</div>
            </div>
          </div>
      @if($settings['about_image'])
        </div>
      @endif
    </div>

    <div style="display:flex;gap:10px">
      <button type="submit" class="btn-dl-primary"><i class="fas fa-save"></i> Simpan</button>
      <a href="{{ url('/') }}" target="_blank" class="btn-dl-secondary"><i class="fas fa-external-link-alt"></i> Lihat Situs</a>
    </div>
  </div>

  {{-- Preview --}}
  <div class="preview-panel">
    <div class="section-title"><i class="fas fa-eye" style="color:var(--gold);margin-right:6px"></i>Preview Tentang</div>
    <div style="background:var(--navy);border-radius:12px;overflow:hidden;border:1.5px solid var(--border);padding:20px;display:flex;gap:16px;align-items:center">
      @if($settings['about_image'])
        <img src="{{ asset('storage/'.$settings['about_image']) }}" id="aboutPreviewImg"
             style="width:110px;height:130px;object-fit:cover;border-radius:8px;flex-shrink:0">
      @else
        <div id="aboutPreviewImg" style="width:110px;height:130px;background:rgba(255,255,255,.06);border-radius:8px;flex-shrink:0;display:flex;align-items:center;justify-content:center;color:rgba(201,168,76,.5);font-size:2rem">
          <i class="fas fa-book-open"></i>
        </div>
      @endif
      <div>
        <div style="font-family:'Playfair Display',serif;color:var(--gold);font-size:.95rem;font-weight:700;margin-bottom:8px">Apa Itu YomuLib?</div>
        <div style="font-size:.72rem;color:rgba(255,255,255,.55);line-height:1.6">Platform perpustakaan digital modern untuk SMK...</div>
      </div>
    </div>
    <div class="preview-info">
      <ul>
        <li>Tampil di section "Apa Itu YomuLib?"</li>
        <li>Kosong → ilustrasi SVG rak buku default</li>
        <li>Format: JPG, PNG, WebP — maks. 4 MB</li>
      </ul>
    </div>
  </div>
</div>
</form>
</div>

{{-- ══════════════════════════════════════════
     TAB 3 — FITUR UNGGULAN
════════════════════════════════════════════ --}}
<div class="set-panel" id="panel-fitur">
<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
@csrf @method('PUT')
<input type="hidden" name="_tab" value="fitur">

@php
$featureDefs = [
  1 => ['label'=>'Berbasis WEB',  'icon'=>'fas fa-globe',      'desc'=>'Perpustakaan digital via website'],
  2 => ['label'=>'Katalog Luas',  'icon'=>'fas fa-book-open',   'desc'=>'Informasi buku secara lengkap'],
  3 => ['label'=>'Modul Praktik', 'icon'=>'fas fa-puzzle-piece','desc'=>'Bahan ajar sistematis SMK'],
];
@endphp

<div class="set-grid">
  <div style="display:flex;flex-direction:column;gap:20px">
    @foreach($featureDefs as $n => $feat)
    <div class="dl-card-p">
      <div class="section-title" style="margin-bottom:6px">
        <i class="{{ $feat['icon'] }}" style="color:var(--gold);margin-right:6px"></i>Fitur {{ $n }} — {{ $feat['label'] }}
      </div>
      <p style="font-size:.78rem;color:var(--muted);margin-bottom:14px">Background kartu fitur. Kosong = background navy gelap default.</p>

      @if($settings["feature_{$n}_image"])
        <label class="field-label">Gambar Saat Ini</label>
        <img src="{{ asset('storage/'.$settings["feature_{$n}_image"]) }}"
             class="thumb thumb-wide" style="margin-bottom:8px" id="featPrev{{ $n }}">
        <input type="hidden" name="remove_feature_{{ $n }}_image" id="removeFeat{{ $n }}" value="0">
        <button type="button" class="remove-btn" onclick="flagRemove('removeFeat{{ $n }}', this.closest('form'))">
          <i class="fas fa-trash-alt"></i> Hapus
        </button>
        <div style="margin-top:12px">
          <label class="field-label">Ganti Gambar</label>
      @else
        <label class="field-label">Upload Gambar</label>
        <input type="hidden" name="remove_feature_{{ $n }}_image" value="0">
      @endif
          <div class="upload-zone mini-zone" id="featZone{{ $n }}">
            <input type="file" name="feature_{{ $n }}_image" accept="image/jpeg,image/png,image/webp"
                   onchange="miniPreview(this, 'featCard{{ $n }}')">
            <i class="fas fa-cloud-upload-alt" style="color:var(--gold);font-size:1.2rem;display:block;margin-bottom:6px"></i>
            <div style="font-size:.72rem;color:var(--muted)">Klik atau drag & drop — Maks. 4 MB</div>
          </div>
      @if($settings["feature_{$n}_image"])
        </div>
      @endif
    </div>
    @endforeach

    <div style="display:flex;gap:10px">
      <button type="submit" class="btn-dl-primary"><i class="fas fa-save"></i> Simpan</button>
      <a href="{{ url('/') }}" target="_blank" class="btn-dl-secondary"><i class="fas fa-external-link-alt"></i> Lihat Situs</a>
    </div>
  </div>

  {{-- Preview --}}
  <div class="preview-panel">
    <div class="section-title"><i class="fas fa-eye" style="color:var(--gold);margin-right:6px"></i>Preview Fitur</div>
    <div class="feat-prev-grid">
      @foreach($featureDefs as $n => $feat)
      <div class="feat-prev-card" id="featCard{{ $n }}"
           @if($settings["feature_{$n}_image"]) style="background-image:url('{{ asset('storage/'.$settings["feature_{$n}_image"]) }}')" @endif>
        <div class="feat-prev-label">
          <i class="{{ $feat['icon'] }}" style="display:block;margin-bottom:3px"></i>
          {{ $feat['label'] }}
        </div>
      </div>
      @endforeach
    </div>
    <div class="preview-info" style="margin-top:12px">
      <ul>
        <li>Tiap kartu punya background sendiri</li>
        <li>Kosong = background navy gelap</li>
        <li>Format: JPG, PNG, WebP — maks. 4 MB</li>
        <li>Rekomendasi: landscape, min. 600 × 400 px</li>
      </ul>
    </div>
  </div>
</div>
</form>
</div>

{{-- ══════════════════════════════════════════
     TAB 4 — KATEGORI UTAMA
════════════════════════════════════════════ --}}
<div class="set-panel" id="panel-kategori">
<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
@csrf @method('PUT')
<input type="hidden" name="_tab" value="kategori">

@php
$categoryDefs = [
  1 => ['label'=>'Fiksi Novel',    'icon'=>'fas fa-book',     'cls'=>'ck1'],
  2 => ['label'=>'Fiksi Komik',    'icon'=>'fas fa-images',   'cls'=>'ck2'],
  3 => ['label'=>'Pemrograman',    'icon'=>'fas fa-code',     'cls'=>'ck3'],
  4 => ['label'=>'Non Fiksi Sejarah','icon'=>'fas fa-landmark','cls'=>'ck4'],
];
@endphp

<div class="set-grid">
  <div style="display:flex;flex-direction:column;gap:20px">
    @foreach($categoryDefs as $n => $cat)
    <div class="dl-card-p">
      <div class="section-title" style="margin-bottom:6px">
        <i class="{{ $cat['icon'] }}" style="color:var(--gold);margin-right:6px"></i>Kategori {{ $n }} — {{ $cat['label'] }}
      </div>
      <p style="font-size:.78rem;color:var(--muted);margin-bottom:14px">Background kartu kategori. Kosong = warna gradient default.</p>

      @if($settings["category_{$n}_image"])
        <label class="field-label">Gambar Saat Ini</label>
        <img src="{{ asset('storage/'.$settings["category_{$n}_image"]) }}"
             class="thumb thumb-wide" style="margin-bottom:8px">
        <input type="hidden" name="remove_category_{{ $n }}_image" id="removeCat{{ $n }}" value="0">
        <button type="button" class="remove-btn" onclick="flagRemove('removeCat{{ $n }}', this.closest('form'))">
          <i class="fas fa-trash-alt"></i> Hapus
        </button>
        <div style="margin-top:12px">
          <label class="field-label">Ganti Gambar</label>
      @else
        <label class="field-label">Upload Gambar</label>
        <input type="hidden" name="remove_category_{{ $n }}_image" value="0">
      @endif
          <div class="upload-zone mini-zone">
            <input type="file" name="category_{{ $n }}_image" accept="image/jpeg,image/png,image/webp"
                   onchange="miniPreview(this, 'catCard{{ $n }}')">
            <i class="fas fa-cloud-upload-alt" style="color:var(--gold);font-size:1.2rem;display:block;margin-bottom:6px"></i>
            <div style="font-size:.72rem;color:var(--muted)">Klik atau drag & drop — Maks. 4 MB</div>
          </div>
      @if($settings["category_{$n}_image"])
        </div>
      @endif
    </div>
    @endforeach

    <div style="display:flex;gap:10px">
      <button type="submit" class="btn-dl-primary"><i class="fas fa-save"></i> Simpan</button>
      <a href="{{ url('/') }}" target="_blank" class="btn-dl-secondary"><i class="fas fa-external-link-alt"></i> Lihat Situs</a>
    </div>
  </div>

  {{-- Preview --}}
  <div class="preview-panel">
    <div class="section-title"><i class="fas fa-eye" style="color:var(--gold);margin-right:6px"></i>Preview Kategori</div>
    <div class="cat-prev-grid">
      @foreach($categoryDefs as $n => $cat)
      <div class="cat-prev-card {{ $cat['cls'] }}" id="catCard{{ $n }}"
           @if($settings["category_{$n}_image"]) style="background-image:url('{{ asset('storage/'.$settings["category_{$n}_image"]) }}');background-size:cover;background-position:center" @endif>
        <div class="cat-prev-label"><i class="{{ $cat['icon'] }}" style="margin-right:5px"></i>{{ $cat['label'] }}</div>
      </div>
      @endforeach
    </div>
    <div class="preview-info" style="margin-top:12px">
      <ul>
        <li>Tiap kartu kategori punya background sendiri</li>
        <li>Kosong = gradient warna default</li>
        <li>Format: JPG, PNG, WebP — maks. 4 MB</li>
        <li>Rekomendasi: landscape, min. 800 × 400 px</li>
      </ul>
    </div>
  </div>
</div>
</form>
</div>

@endsection

@push('scripts')
<script>
// ── Tab switching ──
function switchTab(name) {
    document.querySelectorAll('.set-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.set-panel').forEach(p => p.classList.remove('active'));
    document.getElementById('tab-' + name).classList.add('active');
    document.getElementById('panel-' + name).classList.add('active');
    sessionStorage.setItem('settingTab', name);
}

// Restore tab on load
document.addEventListener('DOMContentLoaded', () => {
    const saved = sessionStorage.getItem('settingTab');
    if (saved) switchTab(saved);

    // Hero background file input live preview
    const bgFile = document.getElementById('bgFile');
    if (bgFile) {
        bgFile.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
            const url = URL.createObjectURL(file);
            const hp  = document.getElementById('heroPreview');
            hp.style.backgroundImage = `url('${url}')`;
            hp.classList.add('has-bg');
            const lbl = document.getElementById('bgLabel');
            if (lbl) lbl.innerHTML = `<div style="font-size:.82rem;font-weight:600"><i class="fas fa-check-circle" style="color:var(--green)"></i> ${file.name}</div>
                                       <div style="font-size:.7rem;color:var(--muted);margin-top:3px">${(file.size/1024/1024).toFixed(2)} MB</div>`;
        });
        // drag & drop
        const bgZone = document.getElementById('bgZone');
        if (bgZone) {
            bgZone.addEventListener('dragover', e => { e.preventDefault(); bgZone.classList.add('drag-over'); });
            bgZone.addEventListener('dragleave', () => bgZone.classList.remove('drag-over'));
            bgZone.addEventListener('drop', e => {
                e.preventDefault(); bgZone.classList.remove('drag-over');
                if (e.dataTransfer.files.length) { bgFile.files = e.dataTransfer.files; bgFile.dispatchEvent(new Event('change')); }
            });
        }
    }

    // About file live preview
    const aboutFile = document.getElementById('aboutFile');
    if (aboutFile) {
        aboutFile.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
            const url = URL.createObjectURL(file);
            const img = document.getElementById('aboutPreviewImg');
            if (img.tagName === 'IMG') { img.src = url; }
            else {
                const newImg = document.createElement('img');
                newImg.id = 'aboutPreviewImg';
                newImg.src = url;
                newImg.style.cssText = 'width:110px;height:130px;object-fit:cover;border-radius:8px;flex-shrink:0';
                img.replaceWith(newImg);
            }
            const lbl = document.getElementById('aboutLabel');
            if (lbl) lbl.innerHTML = `<div style="font-size:.82rem;font-weight:600"><i class="fas fa-check-circle" style="color:var(--green)"></i> ${file.name}</div>`;
        });
    }
});

// ── Hero text live preview ──
function updateHeroPreview() {
    const t = document.getElementById('hero_title')?.value;
    const s = document.getElementById('hero_subtitle')?.value;
    const pt = document.getElementById('prevTitle');
    const ps = document.getElementById('prevSub');
    if (pt) pt.textContent = t || 'Judul Hero';
    if (ps) ps.textContent = s || 'Deskripsi...';
}

// ── Flag remove + submit immediately ──
function flagRemove(flagId, form) {
    const flag = document.getElementById(flagId);
    if (flag) flag.value = '1';
    form.submit();
}

// ── Mini zone preview (update preview card) ──
function miniPreview(input, previewCardId) {
    const file = input.files[0];
    if (!file) return;
    const url  = URL.createObjectURL(file);
    // Update preview card if exists
    if (previewCardId) {
        const card = document.getElementById(previewCardId);
        if (card) {
            card.style.backgroundImage = `url('${url}')`;
            card.style.backgroundSize  = 'cover';
            card.style.backgroundPosition = 'center';
        }
    }
    // Update zone label
    const zone = input.closest('.mini-zone, .upload-zone');
    if (zone) {
        const icon = zone.querySelector('i:not([class*="fa-cloud"])') || zone.querySelector('i');
        const txt  = zone.querySelector('div');
        if (icon) { icon.className = 'fas fa-check-circle'; icon.style.color = 'var(--green)'; }
        if (txt)  { txt.textContent = file.name.length > 22 ? file.name.slice(0,20) + '…' : file.name; }
    }
}
</script>
@endpush
