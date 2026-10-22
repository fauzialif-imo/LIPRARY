<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $navbarSiteName }} - Perpustakaan Digital SMK</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/landingpage.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
@php
    $heroBg         = $heroBg         ?? null;
    $heroTitle      = $heroTitle      ?? 'Pintu Gerbang Digital Anda ke Ilmu Pengetahuan';
    $heroSub        = $heroSub        ?? 'Akses Buku dan Modul SMK di sini';
    $aboutImage     = $aboutImage     ?? null;
    $navbarLogo     = $navbarLogo     ?? null;
    $navbarSiteName = $navbarSiteName ?? 'YOMULIB';
@endphp
<style>
  @if($heroBg)
  .hero {
    background-image: url('{{ asset('storage/'.$heroBg) }}') !important;
    background-size: cover !important;
    background-position: center !important;
    background-blend-mode: normal !important;
    position: relative;
  }
  .hero::before {
    content: '' !important;
    position: absolute !important;
    inset: 0 !important;
    background: rgba(10, 20, 50, 0.62) !important;
  }
  @endif

  /* ── NAVBAR animate in ── */
  nav {
    animation: navSlideDown .6s cubic-bezier(.25,.8,.25,1) both;
  }
  @keyframes navSlideDown {
    from { transform: translateY(-100%); opacity: 0; }
    to   { transform: translateY(0);     opacity: 1; }
  }

  /* ── HERO animations ── */
  .hero-content h1 {
    animation: heroTitle .9s cubic-bezier(.25,.8,.25,1) .3s both;
  }
  .hero-content p {
    animation: heroTitle .9s cubic-bezier(.25,.8,.25,1) .55s both;
  }
  .hero-btn {
    animation: heroTitle .9s cubic-bezier(.25,.8,.25,1) .75s both;
  }
  @keyframes heroTitle {
    from { opacity: 0; transform: translateY(32px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  /* Hero floating particle effect */
  .hero-particles {
    position: absolute;
    inset: 0;
    overflow: hidden;
    pointer-events: none;
    z-index: 0;
  }
  .hero-particles span {
    position: absolute;
    border-radius: 50%;
    background: rgba(201,168,76,.15);
    animation: floatParticle linear infinite;
  }
  @keyframes floatParticle {
    0%   { transform: translateY(0) rotate(0deg);   opacity: 0; }
    10%  { opacity: 1; }
    90%  { opacity: .6; }
    100% { transform: translateY(-110vh) rotate(720deg); opacity: 0; }
  }

  /* ── SCROLL REVEAL ── */
  .reveal {
    opacity: 0;
    transform: translateY(40px);
    transition: opacity .7s cubic-bezier(.25,.8,.25,1),
                transform .7s cubic-bezier(.25,.8,.25,1);
  }
  .reveal.visible {
    opacity: 1;
    transform: translateY(0);
  }
  /* Reset smooth saat scroll ke atas */
  .reveal:not(.visible) {
    opacity: 0;
    transform: translateY(40px);
    transition: opacity .35s ease, transform .35s ease;
  }
  /* Stagger children */
  .reveal-stagger > * {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity .6s cubic-bezier(.25,.8,.25,1),
                transform .6s cubic-bezier(.25,.8,.25,1);
  }
  .reveal-stagger.visible > *:nth-child(1)  { transition-delay: .05s; opacity:1; transform:none; }
  .reveal-stagger.visible > *:nth-child(2)  { transition-delay: .12s; opacity:1; transform:none; }
  .reveal-stagger.visible > *:nth-child(3)  { transition-delay: .19s; opacity:1; transform:none; }
  .reveal-stagger.visible > *:nth-child(4)  { transition-delay: .26s; opacity:1; transform:none; }
  .reveal-stagger.visible > *:nth-child(5)  { transition-delay: .33s; opacity:1; transform:none; }
  .reveal-stagger.visible > *:nth-child(6)  { transition-delay: .40s; opacity:1; transform:none; }
  .reveal-stagger.visible > *:nth-child(7)  { transition-delay: .47s; opacity:1; transform:none; }
  .reveal-stagger.visible > *:nth-child(8)  { transition-delay: .54s; opacity:1; transform:none; }
  /* Reset: saat visible dihapus, anak kembali tersembunyi */
  .reveal-stagger:not(.visible) > * {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity .3s ease, transform .3s ease;
  }

  /* ── SECTION TITLE animated underline ── */
  .section-title h2 {
    position: relative;
    display: inline-block;
  }
  .section-title h2::after {
    content: '';
    position: absolute;
    bottom: -6px;
    left: 50%;
    transform: translateX(-50%) scaleX(0);
    width: 60px;
    height: 3px;
    background: var(--gold);
    border-radius: 99px;
    transition: transform .6s cubic-bezier(.25,.8,.25,1);
    transform-origin: center;
  }
  .reveal.visible .section-title h2::after,
  .section-title.visible h2::after {
    transform: translateX(-50%) scaleX(1);
  }

  /* ── BOOK CARDS ── */
  .book-card {
    transition: transform .35s cubic-bezier(.25,.8,.25,1),
                box-shadow .35s,
                border-color .35s !important;
  }
  .book-card:hover {
    transform: translateY(-8px) scale(1.015) !important;
    box-shadow: 0 16px 48px rgba(13,27,62,.18) !important;
    border-color: rgba(201,168,76,.5) !important;
  }
  .book-card img {
    transition: transform .5s cubic-bezier(.25,.8,.25,1);
  }
  .book-card:hover img {
    transform: scale(1.06);
  }
  .book-cover { overflow: hidden; }

  /* ── TESTI CARDS ── */
  .testi-card {
    transition: transform .3s cubic-bezier(.25,.8,.25,1), box-shadow .3s !important;
  }
  .testi-card:hover {
    transform: translateY(-6px) !important;
    box-shadow: 0 12px 40px rgba(0,0,0,.25) !important;
  }

  /* ── ABOUT SECTION text shimmer on icon ── */
  .about-icon {
    animation: iconFloat 4s ease-in-out infinite;
  }
  @keyframes iconFloat {
    0%, 100% { transform: translateY(0); }
    50%       { transform: translateY(-10px); }
  }

  /* ── NAV LINKS hover underline effect ── */
  .nav-links a {
    position: relative;
  }
  .nav-links a::after {
    content: '';
    position: absolute;
    bottom: -3px;
    left: 0;
    width: 0;
    height: 2px;
    background: var(--gold);
    border-radius: 99px;
    transition: width .25s ease;
  }
  .nav-links a:hover::after { width: 100%; }

  /* ── HERO BOOKS icon subtle spin ── */
  .hero-books {
    animation: heroBookPulse 6s ease-in-out infinite;
  }
  @keyframes heroBookPulse {
    0%, 100% { opacity: .08; transform: translateY(-50%) scale(1); }
    50%       { opacity: .12; transform: translateY(-52%) scale(1.04); }
  }

  /* ── CTA button pulse glow ── */
  .hero-btn {
    position: relative;
    overflow: hidden;
  }
  .hero-btn::after {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(255,255,255,.2);
    transform: translateX(-100%) skewX(-15deg);
    transition: transform .5s;
  }
  .hero-btn:hover::after {
    transform: translateX(150%) skewX(-15deg);
  }

  /* ── SPOTLIGHT — cahaya warna ikut cursor di background ── */
  .section-spotlight {
    position: relative;
    overflow: hidden;
  }

  /* Layer 1: spotlight bulat ikut cursor */
  .section-spotlight::before {
    content: '';
    position: absolute;
    inset: 0;
    pointer-events: none;
    z-index: 0;
    background: radial-gradient(
      700px circle at var(--mx, -200px) var(--my, -200px),
      var(--spot-color, rgba(201,168,76,.13)) 0%,
      transparent 65%
    );
    opacity: 0;
    transition: opacity .5s ease;
  }

  /* Layer 2: shimmer warna bergerak otomatis (tidak tergantung cursor) */
  .section-spotlight::after {
    content: '';
    position: absolute;
    inset: -100%;
    pointer-events: none;
    z-index: 0;
    background: conic-gradient(
      from var(--angle, 0deg) at 50% 50%,
      transparent 0deg,
      var(--shimmer-color, rgba(201,168,76,.04)) 60deg,
      transparent 120deg
    );
    animation: shimmerRotate 8s linear infinite;
    opacity: 0;
    transition: opacity .5s ease;
  }

  .section-spotlight.spot-active::before { opacity: 1; }
  .section-spotlight.spot-active::after  { opacity: 1; }

  @keyframes shimmerRotate {
    from { transform: rotate(0deg); }
    to   { transform: rotate(360deg); }
  }

  /* Children sit above both layers */
  .section-spotlight > * { position: relative; z-index: 1; }

  /* ── Per-section spot colors ── */
  /* koleksi: gold warm */
  #koleksi   { --spot-color: rgba(201,168,76,.14); --shimmer-color: rgba(201,168,76,.05); }
  /* tentang: gold bright (dark bg) */
  #tentang   { --spot-color: rgba(201,168,76,.22); --shimmer-color: rgba(201,168,76,.07); }
  /* fitur: teal-blue */
  .fitur-sec { --spot-color: rgba(56,139,184,.12); --shimmer-color: rgba(56,139,184,.04); }
  /* testimoni: soft purple-gold */
  .testi-sec { --spot-color: rgba(180,140,210,.12); --shimmer-color: rgba(201,168,76,.04); }

  /* ── MAGNETIC hero button ── */
  .hero-btn {
    transition: transform .2s cubic-bezier(.25,.8,.25,1),
                background .2s, box-shadow .2s !important;
  }

  @keyframes countUp {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
  }
</style>
</head>
<body>

<nav>
  <a href="{{ url('/') }}" class="nav-logo">
    @if($navbarLogo)
      <img src="{{ asset('storage/'.$navbarLogo) }}"
           style="height:36px;width:auto;object-fit:contain;display:block;flex-shrink:0" alt="{{ $navbarSiteName }}">
    @else
      <i class="fas fa-book-open" style="color:var(--gold);font-size:26px;flex-shrink:0"></i>
    @endif
    <span>{{ $navbarSiteName }}</span>
  </a>
  <ul class="nav-links">
    <li><a href="#beranda">Beranda</a></li>
    <li><a href="{{ route('buku') }}">Buku</a></li>
    <li><a href="#koleksi">Koleksi</a></li>
    <li><a href="#tentang">Tentang</a></li>
    <li><a href="#kontak">Kontak</a></li>
  </ul>
  <a href="{{ route('login') }}" class="nav-btn">Masuk</a>
</nav>

<!-- HERO -->
<section class="hero" id="beranda">
  {{-- Floating particles --}}
  <div class="hero-particles" id="heroParticles"></div>

  <div class="hero-content">
    <h1>{{ $heroTitle }}</h1>
    <p>{{ $heroSub }}</p>
    <a href="{{ route('register') }}" class="hero-btn">Mulai Sekarang</a>
  </div>
  <div class="hero-books"><i class="fas fa-books"></i></div>
</section>

<!-- KOLEKSI POPULER -->
<section id="koleksi" class="section-spotlight" style="background:#fff;--spot-color:rgba(201,168,76,.07)">
  <div class="section-title reveal">
    <h2>Koleksi Populer</h2>
    <p>Buku-buku paling banyak dipinjam di {{ $navbarSiteName }}</p>
  </div>
  <div class="book-grid reveal-stagger">
    @forelse($popularBooks as $book)
    <a href="{{ auth()->check() ? route('buku.show', $book) : route('login') }}"
       class="book-card" style="text-decoration:none;color:inherit">
      <div class="book-cover" style="height:200px;padding:0;overflow:hidden;background:#f3f4f6">
        @if($book->cover)
          <img src="{{ asset('storage/'.$book->cover) }}"
               alt="{{ $book->title }}"
               style="width:100%;height:100%;object-fit:cover;display:block">
        @else
          {{-- Fallback: gradient + inisial judul --}}
          @php
            $colors = [
              ['#1a3a6e','#2d5a9e'],['#c9a84c','#8a6a1a'],['#1a6e4a','#2da05a'],
              ['#2d4a7a','#4a6fa5'],['#7a2a2a','#c04040'],['#1a4a6e','#3a8aba'],
              ['#4a3a1a','#7a6a3a'],['#2a1a4a','#5a3a8a'],
            ];
            $ci = $loop->index % count($colors);
          @endphp
          <div style="width:100%;height:100%;background:linear-gradient(135deg,{{ $colors[$ci][0] }},{{ $colors[$ci][1] }});display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;padding:16px">
            <i class="fas fa-book-open" style="font-size:40px;color:rgba(255,255,255,.5)"></i>
            <span style="color:rgba(255,255,255,.7);font-size:11px;font-weight:600;text-align:center;line-height:1.3;max-width:90%">{{ Str::limit($book->title, 30) }}</span>
          </div>
        @endif
      </div>
      <div class="book-info">
        <h4 style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis" title="{{ $book->title }}">{{ $book->title }}</h4>
        <div style="font-size:.75rem;color:#6b7280;margin-bottom:6px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $book->author }}</div>
        <div style="display:flex;align-items:center;justify-content:space-between">
          <div class="stars">
            @php $avg = $book->avgRating(); @endphp
            @for($s=1;$s<=5;$s++)
              @if($s <= $avg)★@elseif($s - $avg < 1)✦@else☆@endif
            @endfor
          </div>
          @if($book->borrowed_count > 0)
            <span style="font-size:.68rem;color:#c9a84c;font-weight:700">{{ $book->borrowed_count }}× dipinjam</span>
          @endif
        </div>
      </div>
    </a>
    @empty
    {{-- Fallback kalau belum ada buku --}}
    <div style="grid-column:1/-1;text-align:center;padding:60px 20px;color:#6b7280">
      <i class="fas fa-books" style="font-size:48px;opacity:.3;margin-bottom:16px;display:block"></i>
      <p>Belum ada buku tersedia. Tambahkan buku melalui panel admin.</p>
    </div>
    @endforelse
  </div>
</section>

<!-- APA ITU SITE -->
<section class="about-section section-spotlight" id="tentang" style="--spot-color:rgba(201,168,76,.12)">
  <div class="section-title reveal">
    <h2>Apa Itu {{ $navbarSiteName }}?</h2>
  </div>
  <div class="about-grid reveal">
    <div class="about-icon">
      @if($aboutImage)
        <img src="{{ asset('storage/'.$aboutImage) }}"
             alt="Tentang {{ $navbarSiteName }}"
             style="width:100%;max-width:360px;height:auto;border-radius:16px;object-fit:cover;box-shadow:0 8px 40px rgba(0,0,0,.4)">
      @else xmlns="http://www.w3.org/2000/svg" style="width:100%;max-width:320px;height:auto;filter:drop-shadow(0 8px 32px rgba(0,0,0,.35))">
        <!-- Shelf background -->
        <rect x="10" y="10" width="320" height="360" rx="18" fill="#0d1b3e" stroke="rgba(201,168,76,.25)" stroke-width="1.5"/>

        <!-- Shelf plank 1 -->
        <rect x="20" y="120" width="300" height="10" rx="3" fill="#c9a84c" opacity=".35"/>
        <!-- Shelf plank 2 -->
        <rect x="20" y="240" width="300" height="10" rx="3" fill="#c9a84c" opacity=".35"/>
        <!-- Bottom base -->
        <rect x="20" y="348" width="300" height="10" rx="3" fill="#c9a84c" opacity=".5"/>

        <!-- ── ROW 1 books (y base = 120) ── -->
        <!-- Book 1: tall navy -->
        <rect x="32"  y="34" width="28" height="86" rx="3" fill="#1a3a6e"/>
        <rect x="32"  y="34" width="5"  height="86" rx="2" fill="#2d5a9e"/>
        <text x="52"  y="85" font-size="9" fill="rgba(255,255,255,.6)" text-anchor="middle" transform="rotate(-90,52,85)" font-family="serif">NOVEL</text>

        <!-- Book 2: gold spine -->
        <rect x="64"  y="44" width="22" height="76" rx="3" fill="#8a6a1a"/>
        <rect x="64"  y="44" width="4"  height="76" rx="2" fill="#c9a84c"/>
        <line x1="70" y1="58" x2="82" y2="58" stroke="rgba(255,255,255,.3)" stroke-width="1"/>
        <line x1="70" y1="64" x2="82" y2="64" stroke="rgba(255,255,255,.2)" stroke-width="1"/>

        <!-- Book 3: slim red -->
        <rect x="90"  y="50" width="16" height="70" rx="3" fill="#7a2a2a"/>
        <rect x="90"  y="50" width="4"  height="70" rx="2" fill="#c04040"/>

        <!-- Book 4: teal wide -->
        <rect x="110" y="38" width="32" height="82" rx="3" fill="#1a6e4a"/>
        <rect x="110" y="38" width="5"  height="82" rx="2" fill="#2da05a"/>
        <text x="130" y="88" font-size="8" fill="rgba(255,255,255,.5)" text-anchor="middle" transform="rotate(-90,130,88)" font-family="sans-serif">SAINS</text>

        <!-- Book 5: purple -->
        <rect x="146" y="55" width="20" height="65" rx="3" fill="#3a2a6e"/>
        <rect x="146" y="55" width="4"  height="65" rx="2" fill="#6a4ab8"/>

        <!-- Book 6: amber medium -->
        <rect x="170" y="42" width="26" height="78" rx="3" fill="#7a5c1a"/>
        <rect x="170" y="42" width="5"  height="78" rx="2" fill="#e8c97a"/>
        <line x1="178" y1="58" x2="192" y2="58" stroke="rgba(255,255,255,.25)" stroke-width="1"/>

        <!-- Book 7: dark blue slim -->
        <rect x="200" y="52" width="18" height="68" rx="3" fill="#0d2a4e"/>
        <rect x="200" y="52" width="4"  height="68" rx="2" fill="#1a5280"/>

        <!-- Book 8: coral -->
        <rect x="222" y="36" width="24" height="84" rx="3" fill="#6e2a1a"/>
        <rect x="222" y="36" width="5"  height="84" rx="2" fill="#c0603a"/>
        <text x="237" y="88" font-size="8" fill="rgba(255,255,255,.5)" text-anchor="middle" transform="rotate(-90,237,88)" font-family="sans-serif">FIKSI</text>

        <!-- Book 9: olive -->
        <rect x="250" y="48" width="20" height="72" rx="3" fill="#3a4a1a"/>
        <rect x="250" y="48" width="4"  height="72" rx="2" fill="#6a8a2a"/>

        <!-- Book 10: wide maroon -->
        <rect x="274" y="34" width="34" height="86" rx="3" fill="#4a1a2a"/>
        <rect x="274" y="34" width="6"  height="86" rx="2" fill="#8a3a5a"/>
        <line x1="282" y1="52" x2="304" y2="52" stroke="rgba(255,255,255,.2)" stroke-width="1"/>
        <line x1="282" y1="60" x2="304" y2="60" stroke="rgba(255,255,255,.15)" stroke-width="1"/>

        <!-- ── ROW 2 books (y base = 240) ── -->
        <!-- Book 1 -->
        <rect x="28"  y="154" width="30" height="86" rx="3" fill="#2a4a7a"/>
        <rect x="28"  y="154" width="5"  height="86" rx="2" fill="#4a7ab8"/>
        <text x="48"  y="205" font-size="8" fill="rgba(255,255,255,.5)" text-anchor="middle" transform="rotate(-90,48,205)" font-family="sans-serif">MANGA</text>

        <!-- Book 2 -->
        <rect x="62"  y="162" width="18" height="78" rx="3" fill="#1a4a3a"/>
        <rect x="62"  y="162" width="4"  height="78" rx="2" fill="#2a8a6a"/>

        <!-- Book 3 wide -->
        <rect x="84"  y="150" width="36" height="90" rx="3" fill="#5a3a0a"/>
        <rect x="84"  y="150" width="6"  height="90" rx="2" fill="#c9a84c"/>
        <line x1="93" y1="168" x2="116" y2="168" stroke="rgba(255,255,255,.25)" stroke-width="1.5"/>
        <line x1="93" y1="176" x2="116" y2="176" stroke="rgba(255,255,255,.15)" stroke-width="1"/>
        <text x="105" y="215" font-size="8" fill="rgba(255,255,255,.45)" text-anchor="middle" transform="rotate(-90,105,215)" font-family="serif">SEJARAH</text>

        <!-- Book 4 slim -->
        <rect x="124" y="165" width="16" height="75" rx="3" fill="#6a1a1a"/>
        <rect x="124" y="165" width="4"  height="75" rx="2" fill="#b03030"/>

        <!-- Book 5 -->
        <rect x="144" y="155" width="24" height="85" rx="3" fill="#1a3a5a"/>
        <rect x="144" y="155" width="5"  height="85" rx="2" fill="#3a6a9a"/>

        <!-- Book 6 tall -->
        <rect x="172" y="148" width="22" height="92" rx="3" fill="#3a1a5a"/>
        <rect x="172" y="148" width="4"  height="92" rx="2" fill="#7a4ab0"/>
        <text x="186" y="205" font-size="8" fill="rgba(255,255,255,.45)" text-anchor="middle" transform="rotate(-90,186,205)" font-family="sans-serif">TEKNIK</text>

        <!-- Book 7 -->
        <rect x="198" y="160" width="20" height="80" rx="3" fill="#1a4a2a"/>
        <rect x="198" y="160" width="4"  height="80" rx="2" fill="#2a8a4a"/>

        <!-- Book 8 wide -->
        <rect x="222" y="152" width="34" height="88" rx="3" fill="#4a3a0a"/>
        <rect x="222" y="152" width="6"  height="88" rx="2" fill="#d4a844"/>
        <line x1="231" y1="170" x2="252" y2="170" stroke="rgba(255,255,255,.2)" stroke-width="1.5"/>

        <!-- Book 9 -->
        <rect x="260" y="158" width="18" height="82" rx="3" fill="#3a1a1a"/>
        <rect x="260" y="158" width="4"  height="82" rx="2" fill="#8a3a2a"/>

        <!-- Book 10 -->
        <rect x="282" y="150" width="28" height="90" rx="3" fill="#0a2a4a"/>
        <rect x="282" y="150" width="5"  height="90" rx="2" fill="#1a5a8a"/>
        <text x="298" y="208" font-size="8" fill="rgba(255,255,255,.45)" text-anchor="middle" transform="rotate(-90,298,208)" font-family="sans-serif">BISNIS</text>

        <!-- ── ROW 3 books (y base = 348) ── -->
        <rect x="30"  y="274" width="22" height="74" rx="3" fill="#2a5a3a"/>
        <rect x="30"  y="274" width="4"  height="74" rx="2" fill="#4aa06a"/>
        <rect x="56"  y="280" width="18" height="68" rx="3" fill="#5a2a3a"/>
        <rect x="56"  y="280" width="4"  height="68" rx="2" fill="#a04a6a"/>
        <rect x="78"  y="270" width="30" height="78" rx="3" fill="#1a2a5a"/>
        <rect x="78"  y="270" width="5"  height="78" rx="2" fill="#3a5aaa"/>
        <rect x="112" y="276" width="16" height="72" rx="3" fill="#5a4a1a"/>
        <rect x="112" y="276" width="4"  height="72" rx="2" fill="#aa8a3a"/>
        <rect x="132" y="268" width="28" height="80" rx="3" fill="#3a1a4a"/>
        <rect x="132" y="268" width="5"  height="80" rx="2" fill="#7a3a9a"/>
        <rect x="164" y="274" width="20" height="74" rx="3" fill="#1a4a4a"/>
        <rect x="164" y="274" width="4"  height="74" rx="2" fill="#3a8a8a"/>
        <rect x="188" y="266" width="26" height="82" rx="3" fill="#4a2a1a"/>
        <rect x="188" y="266" width="5"  height="82" rx="2" fill="#8a5a3a"/>
        <rect x="218" y="272" width="18" height="76" rx="3" fill="#1a3a2a"/>
        <rect x="218" y="272" width="4"  height="76" rx="2" fill="#3a7a5a"/>
        <rect x="240" y="268" width="32" height="80" rx="3" fill="#4a1a1a"/>
        <rect x="240" y="268" width="6"  height="80" rx="2" fill="#aa3a3a"/>
        <rect x="276" y="274" width="20" height="74" rx="3" fill="#1a1a4a"/>
        <rect x="276" y="274" width="4"  height="74" rx="2" fill="#3a3a8a"/>

        <!-- Gold accent dots on shelves -->
        <circle cx="25" cy="125" r="4" fill="#c9a84c" opacity=".6"/>
        <circle cx="315" cy="125" r="4" fill="#c9a84c" opacity=".6"/>
        <circle cx="25" cy="245" r="4" fill="#c9a84c" opacity=".6"/>
        <circle cx="315" cy="245" r="4" fill="#c9a84c" opacity=".6"/>

        <!-- YOMULIB text at bottom -->
        <text x="170" y="368" font-size="11" fill="#c9a84c" text-anchor="middle" font-family="serif" font-weight="bold" letter-spacing="3" opacity=".8">{{ strtoupper($navbarSiteName) }}</text>
      </svg>
      @endif
    </div>
    <div>
      <div class="about-card">
        <p>{{ $navbarSiteName }} adalah platform perpustakaan digital modern yang dirancang sebagai ruang baca tanpa batas di era inklusivitas digital. Nama {{ $navbarSiteName }} sendiri merupakan representasi dari visi kami: "Your Modern Ultimate Library"—sebuah perpustakaan utama yang hadir untuk memenuhi gaya hidup modern Anda.</p>
      </div>
      <div class="about-card">
        <p>Platform ini memberikan kenyamanan tanpa batasan geografis. Dengan fokus pada aksesibilitas yang lebih mudah, Perpustakaan Platform {{ $navbarSiteName }} membebaskan penggunanya dari keharusan menginstal aplikasi tambahan.</p>
      </div>
    </div>
  </div>
</section>

<!-- FITUR UNGGULAN -->
<section class="section-spotlight fitur-sec" style="background:#f8f9fc;">
  <div class="section-title reveal">
    <h2>Fitur Unggulan</h2>
    <p>Perpustakaan Digital SMK {{ $navbarSiteName }}</p>
  </div>
  <div class="features-grid reveal-stagger">
    @php
    $featureItems = [
      1 => ['icon'=>'fas fa-globe',      'title'=>'Berbasis WEB',    'desc'=>'Perpustakaan yang berbasis digital melalui website'],
      2 => ['icon'=>'fas fa-book-open',  'title'=>'Katalog Luas',    'desc'=>'Memberikan informasi buku secara detail dan lengkap'],
      3 => ['icon'=>'fas fa-puzzle-piece','title'=>'Modul Praktik',  'desc'=>'Sebagai bahan ajar sistematis untuk SMK'],
    ];
    $featureImages = $featureImages ?? [];
    @endphp
    @foreach($featureItems as $idx => $item)
    @php $img = $featureImages[$idx] ?? null; @endphp
    <div class="feature-card {{ $img ? 'has-img' : '' }}"
         @if($img) style="background-image:url('{{ asset('storage/'.$img) }}')" @endif>
      <div class="feature-overlay"></div>
      <div class="feature-body">
        <div class="feature-icon"><i class="{{ $item['icon'] }}"></i></div>
        <h3>{{ $item['title'] }}</h3>
        <p>{{ $item['desc'] }}</p>
      </div>
    </div>
    @endforeach
  </div>
</section>

<!-- KATEGORI UTAMA -->
<section class="kategori-section" id="kategori">
  <div class="section-title reveal">
    <h2>Kategori Utama</h2>
    <p>Menyampaikan Kategori – Kategori Unggulan</p>
  </div>
  @php
  $kategoriItems = [
    1 => ['icon'=>'fas fa-book',      'label'=>'Buku Fiksi Novel',           'cls'=>'k1'],
    2 => ['icon'=>'fas fa-images',    'label'=>'Buku Fiksi Komik',           'cls'=>'k2'],
    3 => ['icon'=>'fas fa-code',      'label'=>'Buku Non Fiksi Pemrograman', 'cls'=>'k3'],
    4 => ['icon'=>'fas fa-landmark',  'label'=>'Buku Non Fiksi Sejarah',     'cls'=>'k4'],
  ];
  $categoryImages = $categoryImages ?? [];
  @endphp
  <div class="kategori-grid reveal-stagger">
    @foreach($kategoriItems as $idx => $kat)
    @php $img = $categoryImages[$idx] ?? null; @endphp
    <div class="kategori-card {{ $kat['cls'] }} {{ $img ? 'has-img' : '' }}"
         @if($img) style="background-image:url('{{ asset('storage/'.$img) }}');background-size:cover;background-position:center" @endif>
      <div class="kategori-overlay"></div>
      <div class="kategori-name"><i class="{{ $kat['icon'] }}"></i> {{ $kat['label'] }}</div>
    </div>
    @endforeach
  </div>
</section>

<!-- TESTIMONI -->
<section class="section-spotlight testi-sec" style="background:#fff;">
  <div class="section-title reveal">
    <h2>Testimoni Pelanggan</h2>
    <p>Ulasan nyata dari peminjam buku {{ $navbarSiteName }}</p>
  </div>

  @if($testimonials->count())
  <div class="testimoni-grid reveal-stagger">
    @foreach($testimonials as $review)
    @php
      $initial = strtoupper(substr($review->user->username ?? 'U', 0, 1));
      $photo   = $review->user->profile_photo ?? null;
    @endphp
    <div class="testi-card">
      {{-- Avatar --}}
      <div class="testi-avatar">
        @if($photo)
          <img src="{{ asset('storage/'.$photo) }}"
               style="width:50px;height:50px;border-radius:50%;object-fit:cover;border:2px solid rgba(201,168,76,.4)">
        @else
          <div style="width:50px;height:50px;border-radius:50%;background:rgba(201,168,76,.2);border:2px solid rgba(201,168,76,.35);display:flex;align-items:center;justify-content:center;font-size:1.1rem;font-weight:700;color:#c9a84c">
            {{ $initial }}
          </div>
        @endif
      </div>

      {{-- Rating bintang --}}
      <div style="margin:10px 0 6px;display:flex;justify-content:center;gap:2px">
        @for($i = 1; $i <= 5; $i++)
          <span style="color:{{ $i <= $review->rating ? '#c9a84c' : 'rgba(255,255,255,.2)' }};font-size:.85rem">★</span>
        @endfor
      </div>

      {{-- Komentar --}}
      <p class="testi-text">"{{ Str::limit($review->comment, 120) }}"</p>

      {{-- Nama + judul buku --}}
      <div class="testi-name">{{ $review->user->username ?? 'Pengguna' }}</div>
      @if($review->book)
        <div style="font-size:.68rem;color:rgba(255,255,255,.35);margin-top:4px">
          <i class="fas fa-book" style="margin-right:4px"></i>{{ Str::limit($review->book->title, 30) }}
        </div>
      @endif
    </div>
    @endforeach
  </div>

  @else
  {{-- Fallback: belum ada ulasan --}}
  <div class="testimoni-grid reveal-stagger">
    @foreach([
      ['Grace Syanatanugsih', 'Sangat puas dengan buku yang disediakan dan selalu lengkap, menarik untuk dibaca.', 5],
      ['Fauzian Prasetiyan',  'Isi bukunya sangat bagus untuk dibaca dan bisa menenangkan pikiran.', 5],
      ['Angelina Matangsyih', 'Sangat membantu untuk belajar, adanya perpustakaan ini memudahkan akses buku.', 5],
    ] as [$nama, $komentar, $rating])
    <div class="testi-card">
      <div class="testi-avatar">
        <div style="width:50px;height:50px;border-radius:50%;background:rgba(201,168,76,.2);border:2px solid rgba(201,168,76,.35);display:flex;align-items:center;justify-content:center;font-size:1.1rem;font-weight:700;color:#c9a84c;margin:0 auto">
          {{ strtoupper(substr($nama,0,1)) }}
        </div>
      </div>
      <div style="margin:10px 0 6px;display:flex;justify-content:center;gap:2px">
        @for($i=1;$i<=5;$i++)<span style="color:{{ $i<=$rating?'#c9a84c':'rgba(255,255,255,.2)' }};font-size:.85rem">★</span>@endfor
      </div>
      <p class="testi-text">"{{ $komentar }}"</p>
      <div class="testi-name">{{ $nama }}</div>
    </div>
    @endforeach
  </div>
  @endif
</section>

<!-- FOOTER -->
<footer id="kontak">
  <div class="footer-grid">
    <div class="footer-brand">
      <div class="logo">
        @if($navbarLogo)
          <img src="{{ asset('storage/'.$navbarLogo) }}" style="height:32px;width:auto;object-fit:contain">
        @else
          <i class="fas fa-book-open" style="color:var(--gold);font-size:28px;"></i>
        @endif
        <span>{{ $navbarSiteName }}</span>
      </div>
      <p style="font-size:0.75rem;color:rgba(255,255,255,0.4);">PERPUSTAKAAN DIGITAL SMK</p>
    </div>
    <div class="footer-col">
      <h4>Kontak</h4>
      <p><i class="fas fa-phone" style="color:var(--gold);margin-right:8px;"></i>+62 812 3456 7890</p>
      <p><i class="fas fa-globe" style="color:var(--gold);margin-right:8px;"></i>www.yomulib.co.id</p>
    </div>
    <div class="footer-col">
      <h4>Alamat</h4>
      <p><i class="fas fa-map-marker-alt" style="color:var(--gold);margin-right:8px;"></i>Tajung Utik, Kec. Gb, Putri, Kabupaten Bogor, Jawa Barat 16862</p>
    </div>
    <div class="footer-col">
      <h4>Social Media</h4>
      <a href="#"><i class="fab fa-instagram" style="margin-right:8px;"></i>@yomulib.id</a>
      <a href="#"><i class="fab fa-youtube" style="margin-right:8px;"></i>yomulib49</a>
    </div>
  </div>
  <div class="footer-bottom">© {{ date('Y') }} {{ $navbarSiteName }}. All rights reserved.</div>
</footer>

<script>
// ── 1. Floating particles di hero ──────────────────────────────
(function () {
  const container = document.getElementById('heroParticles');
  if (!container) return;
  const count = 18;
  for (let i = 0; i < count; i++) {
    const span = document.createElement('span');
    const size = Math.random() * 18 + 6;       // 6–24 px
    const left = Math.random() * 100;           // 0–100%
    const delay = Math.random() * 12;           // 0–12s
    const dur   = Math.random() * 10 + 10;     // 10–20s
    span.style.cssText = `
      width:${size}px; height:${size}px;
      left:${left}%;  bottom:-${size}px;
      animation-delay:${delay}s;
      animation-duration:${dur}s;
      opacity:0;
    `;
    container.appendChild(span);
  }
})();

// ── 2. Intersection Observer — scroll reveal (repeatable) ────
(function () {
  const io = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
      } else {
        // Reset saat keluar viewport → animasi ulang saat masuk lagi
        entry.target.classList.remove('visible');
      }
    });
  }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

  document.querySelectorAll('.reveal, .reveal-stagger').forEach(el => io.observe(el));
})();

// ── 3. Smooth scroll untuk nav links ─────────────────────────
document.querySelectorAll('a[href^="#"]').forEach(link => {
  link.addEventListener('click', function (e) {
    const target = document.querySelector(this.getAttribute('href'));
    if (!target) return;
    e.preventDefault();
    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
  });
});

// ── 4. Navbar background on scroll ───────────────────────────
(function () {
  const nav = document.querySelector('nav');
  if (!nav) return;
  window.addEventListener('scroll', () => {
    if (window.scrollY > 60) {
      nav.style.background = 'rgba(11,22,34,.98)';
      nav.style.boxShadow  = '0 2px 20px rgba(0,0,0,.3)';
    } else {
      nav.style.background = 'rgba(13,27,62,0.97)';
      nav.style.boxShadow  = 'none';
    }
  }, { passive: true });
})();

// ── 5. Book cards tilt on hover (subtle 3D) ───────────────────
document.querySelectorAll('.book-card').forEach(card => {
  card.addEventListener('mousemove', function (e) {
    const rect = this.getBoundingClientRect();
    const x = (e.clientX - rect.left) / rect.width  - 0.5;  // -0.5 to 0.5
    const y = (e.clientY - rect.top)  / rect.height - 0.5;
    this.style.transform = `translateY(-8px) scale(1.015) rotateY(${x * 6}deg) rotateX(${-y * 4}deg)`;
  });
  card.addEventListener('mouseleave', function () {
    this.style.transform = '';
    this.style.transition = 'transform .4s cubic-bezier(.25,.8,.25,1), box-shadow .35s, border-color .35s';
  });
});

// ── 6. Typing effect on hero title ───────────────────────────
(function () {
  const h1 = document.querySelector('.hero-content h1');
  if (!h1) return;
  const original = h1.textContent.trim();
  // Only run if text is short enough
  if (original.length > 60) return;
  h1.textContent = '';
  h1.style.opacity = '1';
  h1.style.animation = 'none';
  let i = 0;
  const cursor = document.createElement('span');
  cursor.textContent = '|';
  cursor.style.cssText = 'color:var(--gold);animation:blink .7s step-end infinite;font-weight:300';
  h1.appendChild(cursor);

  const style = document.createElement('style');
  style.textContent = '@keyframes blink{0%,100%{opacity:1}50%{opacity:0}}';
  document.head.appendChild(style);

  // Start after hero animation delay
  setTimeout(() => {
    const interval = setInterval(() => {
      cursor.before(original[i]);
      i++;
      if (i >= original.length) {
        clearInterval(interval);
        setTimeout(() => cursor.remove(), 1200);
      }
    }, 45);
  }, 400);
})();

// ── 7. Counter animation for stats (if ever added) ────────────
function animateCounter(el, target, duration = 1500) {
  const start = performance.now();
  const update = (now) => {
    const progress = Math.min((now - start) / duration, 1);
    const ease = 1 - Math.pow(1 - progress, 3);
    el.textContent = Math.floor(ease * target).toLocaleString('id-ID');
    if (progress < 1) requestAnimationFrame(update);
  };
  requestAnimationFrame(update);
}

// ── 8. Spotlight — cahaya warna ikut cursor di background ────
(function () {
  const sections = document.querySelectorAll('.section-spotlight');
  sections.forEach(sec => {
    sec.addEventListener('mouseenter', () => sec.classList.add('spot-active'));
    sec.addEventListener('mouseleave', () => {
      sec.classList.remove('spot-active');
      // Reset posisi agar saat masuk lagi tidak lompat
      sec.style.setProperty('--mx', '-200px');
      sec.style.setProperty('--my', '-200px');
    });
    sec.addEventListener('mousemove', e => {
      const rect = sec.getBoundingClientRect();
      // Pakai px bukan % supaya gradient radius tetap konsisten
      sec.style.setProperty('--mx', (e.clientX - rect.left) + 'px');
      sec.style.setProperty('--my', (e.clientY - rect.top)  + 'px');
    });
  });
})();

// ── 9. Magnetic hero button ──────────────────────────────────
(function () {
  const btn = document.querySelector('.hero-btn');
  if (!btn) return;
  btn.addEventListener('mousemove', e => {
    const rect = btn.getBoundingClientRect();
    const dx = (e.clientX - rect.left - rect.width  / 2) * 0.3;
    const dy = (e.clientY - rect.top  - rect.height / 2) * 0.3;
    btn.style.transform = `translate(${dx}px,${dy}px)`;
  });
  btn.addEventListener('mouseleave', () => btn.style.transform = '');
})();
</script>
</body>
</html>