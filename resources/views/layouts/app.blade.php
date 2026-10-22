<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<title>@yield('title', \App\Models\Setting::get('navbar_site_name','YomuLib')) — Perpustakaan Digital</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
:root{
  --navy:#0d1b3e;--navy-dark:#0b1622;--navy-light:#1a2d5a;
  --gold:#c9a84c;--gold-light:#e8c97a;--gold-pale:rgba(201,168,76,.12);
  --bg:#f0f2f7;--border:#dde0ea;--ink:#1a1a2e;--muted:#6b7280;
  --white:#fff;--surface:#e8eaf0;
}
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'DM Sans',sans-serif;background:var(--bg);color:var(--ink);-webkit-font-smoothing:antialiased}
a{text-decoration:none;color:inherit}

.site-nav{background:var(--navy-dark);padding:0 40px;height:62px;display:flex;align-items:center;gap:28px;position:sticky;top:0;z-index:100}
.site-nav .logo{font-family:'Playfair Display',serif;color:var(--gold);font-size:1.15rem;letter-spacing:-.01em;display:flex;align-items:center;gap:8px}
.site-nav .logo-mark{width:30px;height:30px;background:var(--gold);border-radius:7px;display:flex;align-items:center;justify-content:center}
.site-nav .logo-mark i{color:var(--navy-dark);font-size:.85rem}
.nav-links{display:flex;align-items:center;gap:4px;margin-left:24px}
.nav-link{padding:6px 14px;border-radius:8px;font-size:.8rem;font-weight:500;color:rgba(255,255,255,.55);transition:all .15s}
.nav-link:hover,.nav-link.active{background:rgba(201,168,76,.12);color:var(--gold)}
.nav-spacer{flex:1}
.nav-user{display:flex;align-items:center;gap:8px;cursor:pointer}
.nav-avatar{width:32px;height:32px;border-radius:50%;background:var(--gold);display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:700;color:var(--navy-dark);flex-shrink:0}
.nav-username{font-size:.78rem;font-weight:600;color:rgba(255,255,255,.8)}
.nav-btn{height:34px;padding:0 16px;border-radius:8px;font-size:.75rem;font-weight:600;border:none;cursor:pointer;transition:all .15s}
.nav-btn-gold{background:var(--gold);color:var(--navy-dark)}
.nav-btn-gold:hover{background:var(--gold-light)}
.nav-btn-outline{background:rgba(255,255,255,.08);color:rgba(255,255,255,.7);border:1px solid rgba(255,255,255,.15)}
.nav-btn-outline:hover{background:rgba(255,255,255,.14);color:#fff}

.page-wrap{max-width:1180px;margin:0 auto;padding:32px 20px 64px}

.dl-badge{display:inline-flex;align-items:center;gap:5px;font-size:.6rem;font-weight:700;padding:3px 9px;border-radius:99px;letter-spacing:.04em;text-transform:uppercase}
.dl-badge::before{content:'';width:5px;height:5px;border-radius:50%;background:currentColor;flex-shrink:0}
.dl-badge-gold{background:rgba(201,168,76,.12);color:var(--gold)}
.dl-badge-green{background:#eaf3ee;color:#1c6b46}
.dl-badge-blue{background:#ebf2f8;color:#1a5280}
.dl-badge-red{background:#fef2f2;color:#c0392b}
.dl-badge-amber{background:#fef8ed;color:#b8760a}
.dl-badge-muted{background:var(--surface);color:var(--muted)}

.dl-card{background:var(--white);border:1px solid var(--border);border-radius:12px;overflow:hidden}
.dl-card-p{background:var(--white);border:1px solid var(--border);border-radius:12px;padding:22px}

.btn-primary-gold{height:40px;padding:0 22px;background:var(--gold);color:var(--navy-dark);border-radius:10px;font-size:.8rem;font-weight:700;border:none;cursor:pointer;transition:all .15s;display:inline-flex;align-items:center;gap:7px}
.btn-primary-gold:hover{background:var(--gold-light);transform:translateY(-1px)}
.btn-outline-navy{height:40px;padding:0 20px;background:transparent;color:var(--navy);border:1.5px solid var(--navy);border-radius:10px;font-size:.8rem;font-weight:600;cursor:pointer;transition:all .15s;display:inline-flex;align-items:center;gap:7px}
.btn-outline-navy:hover{background:var(--navy);color:#fff}

.field-label{font-size:.65rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:var(--muted);margin-bottom:6px;display:block}
.field-input{width:100%;height:42px;padding:0 14px;border:1.5px solid var(--border);border-radius:10px;font-size:.85rem;outline:none;transition:border-color .2s;background:var(--white)}
.field-input:focus{border-color:var(--gold);box-shadow:0 0 0 3px var(--gold-pale)}
.field-textarea{width:100%;padding:10px 14px;border:1.5px solid var(--border);border-radius:10px;font-size:.85rem;outline:none;resize:vertical;background:var(--white)}
.field-textarea:focus{border-color:var(--gold)}
.field-select{width:100%;height:42px;padding:0 14px;border:1.5px solid var(--border);border-radius:10px;font-size:.85rem;outline:none;background:var(--white)}

.alert-success{background:#eaf3ee;color:#1c6b46;border:1px solid #a7d3b9;border-radius:10px;padding:12px 16px;font-size:.82rem;display:flex;align-items:center;gap:8px;margin-bottom:16px}
.alert-error{background:#fef2f2;color:#c0392b;border:1px solid #fca5a5;border-radius:10px;padding:12px 16px;font-size:.82rem;display:flex;align-items:center;gap:8px;margin-bottom:16px}

.book-card{background:var(--white);border:1px solid var(--border);border-radius:14px;overflow:hidden;transition:all .2s;cursor:pointer}
.book-card:hover{transform:translateY(-4px);box-shadow:0 12px 32px rgba(13,27,62,.12);border-color:rgba(201,168,76,.3)}
.book-cover{width:100%;aspect-ratio:2/3;object-fit:cover;display:block}
.book-cover-placeholder{width:100%;aspect-ratio:2/3;background:var(--navy);display:flex;align-items:center;justify-content:center;font-size:2rem}
.book-meta{padding:12px}
.book-title{font-weight:600;font-size:.84rem;color:var(--ink);line-height:1.3;margin-bottom:2px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
.book-author{font-size:.72rem;color:var(--muted)}
.book-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(155px,1fr));gap:16px}

@media(max-width:768px){.site-nav{padding:0 16px}.page-wrap{padding:20px 14px 48px}.book-grid{grid-template-columns:repeat(auto-fill,minmax(130px,1fr));gap:12px}}
</style>
@stack('styles')
</head>
<body>
<nav class="site-nav">
  @php $__siteName = \App\Models\Setting::get('navbar_site_name','YomuLib'); $__navLogo = \App\Models\Setting::get('navbar_logo'); @endphp
  <a href="{{ route('dashboard') }}" class="logo">
    <div class="logo-mark">
      @if($__navLogo)
        <img src="{{ asset('storage/'.$__navLogo) }}" style="height:22px;width:auto;object-fit:contain">
      @else
        <i class="fas fa-book-open"></i>
      @endif
    </div>{{ $__siteName }}
  </a>
  <div class="nav-links">
    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard')?'active':'' }}">Beranda</a>
    <a href="{{ route('buku') }}" class="nav-link {{ request()->routeIs('buku*')?'active':'' }}">Koleksi</a>
    <a href="{{ route('profile') }}" class="nav-link {{ request()->routeIs('profile*')?'active':'' }}">Profil</a>
  </div>
  <div class="nav-spacer"></div>
  @if(auth()->check() && auth()->user()->isPetugas())
    <a href="{{ route('admin.dashboard') }}" class="nav-btn nav-btn-outline" style="margin-right:8px"><i class="fas fa-tachometer-alt"></i> Admin</a>
  @endif
  @auth
  {{-- Notification Bell --}}
  <div style="position:relative;margin-right:4px">
    <button id="notif-btn" onclick="toggleNotif(event)"
      style="width:38px;height:38px;border-radius:10px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);color:rgba(255,255,255,.7);font-size:.9rem;cursor:pointer;display:flex;align-items:center;justify-content:center;position:relative;transition:all .15s"
      onmouseover="this.style.background='rgba(201,168,76,.15)';this.style.color='#c9a84c'"
      onmouseout="if(!document.getElementById('notif-dropdown').classList.contains('open')){this.style.background='rgba(255,255,255,.08)';this.style.color='rgba(255,255,255,.7)'}">
      <i class="fas fa-bell"></i>
      <span id="notif-badge"
        style="display:none;position:absolute;top:4px;right:4px;width:16px;height:16px;background:#e74c3c;border-radius:50%;font-size:.55rem;font-weight:700;color:#fff;line-height:16px;text-align:center;border:2px solid var(--navy-dark)"></span>
    </button>

    {{-- Dropdown --}}
    <div id="notif-dropdown"
      style="display:none;position:absolute;top:calc(100% + 10px);right:0;width:320px;background:#fff;border-radius:14px;box-shadow:0 8px 40px rgba(13,27,62,.2);border:1px solid #dde0ea;overflow:hidden;z-index:500">
      <div style="padding:14px 16px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid #dde0ea">
        <span style="font-weight:700;font-size:.88rem;color:#1a1a2e">Notifikasi</span>
        <button onclick="markAllRead()" style="font-size:.7rem;color:#c9a84c;background:none;border:none;cursor:pointer;font-weight:600">Tandai semua dibaca</button>
      </div>
      <div id="notif-list" style="max-height:380px;overflow-y:auto">
        <div style="padding:32px 16px;text-align:center;color:#9ca3af;font-size:.82rem">
          <i class="fas fa-bell" style="font-size:1.5rem;margin-bottom:8px;display:block;opacity:.3"></i>
          Memuat notifikasi...
        </div>
      </div>
      <div style="padding:10px 16px;border-top:1px solid #dde0ea;text-align:center">
        <a href="{{ route('dashboard') }}" style="font-size:.75rem;color:#c9a84c;font-weight:600">Lihat semua aktivitas →</a>
      </div>
    </div>
  </div>
  <div class="nav-user dropdown">
    <div data-bs-toggle="dropdown" style="display:flex;align-items:center;gap:8px;cursor:pointer">
      @if(auth()->user()->profile_photo)
        <img src="{{ asset('storage/'.auth()->user()->profile_photo) }}" class="nav-avatar" style="object-fit:cover">
      @else
        <div class="nav-avatar">{{ strtoupper(substr(auth()->user()->username,0,1)) }}</div>
      @endif
      <span class="nav-username d-none d-md-inline">{{ auth()->user()->username }}</span>
      <i class="fas fa-chevron-down" style="font-size:.6rem;color:rgba(255,255,255,.4)"></i>
    </div>
    <ul class="dropdown-menu dropdown-menu-end" style="min-width:160px;font-size:.82rem">
      <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-user me-2"></i>Profil</a></li>
      <li><hr class="dropdown-divider"></li>
      <li><form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="dropdown-item text-danger"><i class="fas fa-sign-out-alt me-2"></i>Logout</button></form></li>
    </ul>
  </div>
  @else
    <a href="{{ route('login') }}" class="nav-btn nav-btn-outline" style="margin-right:8px">Masuk</a>
    <a href="{{ route('register') }}" class="nav-btn nav-btn-gold">Daftar</a>
  @endauth
</nav>

<div class="page-wrap">
  @if(session('success') && session('success') !== true)
    <div class="alert-success"><i class="fas fa-check-circle"></i>{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert-error"><i class="fas fa-exclamation-circle"></i>{{ session('error') }}</div>
  @endif
  @if(session('info'))
    <div style="background:#ebf2f8;color:#1a5280;border:1px solid #90b8d4;border-radius:10px;padding:12px 16px;font-size:.82rem;display:flex;align-items:center;gap:8px;margin-bottom:16px"><i class="fas fa-info-circle"></i>{{ session('info') }}</div>
  @endif
  @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
@include('partials.chatbot')
</body>
</html>
