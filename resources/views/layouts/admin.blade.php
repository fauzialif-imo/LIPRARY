<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<title>@yield('title','Admin') — {{ \App\Models\Setting::get('navbar_site_name','YomuLib') }}</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
:root{
  --navy:#0d1b3e;--navy-dark:#0b1622;--navy-light:#1a2d5a;
  --gold:#c9a84c;--gold-light:#e8c97a;--gold-pale:rgba(201,168,76,.12);
  --white:#fff;--bg:#f0f2f7;--surface:#e8eaf0;
  --border:#dde0ea;--border-2:#c4c8d8;
  --ink:#1a1a2e;--ink-2:#2d3055;--muted:#6b7280;--muted-2:#9ca3af;
  --red:#c0392b;--red-pale:#fef2f2;
  --amber:#b8760a;--amber-pale:#fef8ed;
  --green:#1c6b46;--green-pale:#eaf3ee;
  --blue:#1a5280;--blue-pale:#ebf2f8;
  --sidebar-w:236px;--header-h:62px;
}
*,*::before,*::after{margin:0;padding:0;box-sizing:border-box}
html{height:100%;-webkit-font-smoothing:antialiased}
body{height:100%;font-family:'DM Sans',system-ui,sans-serif;background:var(--bg);color:var(--ink);overflow:hidden}
a{text-decoration:none;color:inherit}
button{font-family:inherit;cursor:pointer;border:none;background:none}
input,select,textarea{font-family:inherit}
::-webkit-scrollbar{width:4px;height:4px}
::-webkit-scrollbar-thumb{background:var(--border-2);border-radius:99px}

.app{display:grid;grid-template-columns:var(--sidebar-w) 1fr;grid-template-rows:var(--header-h) 1fr;height:100vh;overflow:hidden}

/* SIDEBAR */
.sidebar{grid-row:1/-1;background:var(--navy-dark);display:flex;flex-direction:column;overflow:hidden;z-index:200}
.sidebar-logo{height:var(--header-h);display:flex;align-items:center;padding:0 20px;border-bottom:1px solid rgba(201,168,76,.15);flex-shrink:0}
.logo-mark{width:34px;height:34px;background:var(--gold);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.logo-name{font-family:'Playfair Display',serif;font-size:1.1rem;color:var(--gold);letter-spacing:-.01em;margin-left:10px}
.logo-badge{margin-left:auto;font-size:.6rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;background:rgba(201,168,76,.15);color:var(--gold);padding:2px 8px;border-radius:99px;flex-shrink:0}

.sidebar-nav{flex:1;padding:14px 10px;overflow-y:auto;scroll-behavior:auto}
.nav-section-label{font-size:.6rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:rgba(255,255,255,.2);padding:0 10px;margin:16px 0 6px}
.nav-item{display:flex;align-items:center;gap:10px;padding:9px 12px;border-radius:8px;font-size:.83rem;font-weight:500;color:rgba(255,255,255,.45);cursor:pointer;transition:all .15s;margin-bottom:2px}
.nav-item:hover{background:rgba(201,168,76,.08);color:rgba(255,255,255,.8)}
.nav-item.active{background:rgba(201,168,76,.18);color:var(--gold);font-weight:600}
.nav-item i{width:18px;text-align:center;flex-shrink:0;font-size:.9rem}
.nav-badge{margin-left:auto;font-size:.6rem;font-weight:700;padding:2px 7px;border-radius:99px;background:var(--gold);color:var(--navy-dark)}
.nav-badge.warn{background:#e74c3c;color:#fff}
.sidebar-div{height:1px;background:rgba(255,255,255,.06);margin:6px 10px}

.sidebar-footer{padding:12px 10px;border-top:1px solid rgba(201,168,76,.1);flex-shrink:0}
.user-card{display:flex;align-items:center;gap:9px;padding:8px 10px;border-radius:8px}
.user-av{width:34px;height:34px;border-radius:50%;background:var(--gold);display:flex;align-items:center;justify-content:center;font-size:.78rem;font-weight:700;color:var(--navy-dark);flex-shrink:0}
.user-name{font-size:.8rem;font-weight:600;color:#fff}
.user-role{font-size:.6rem;font-weight:600;letter-spacing:.05em;text-transform:uppercase;color:rgba(255,255,255,.3);margin-top:1px}

/* HEADER */
.header{grid-column:2;background:rgba(240,242,247,.96);backdrop-filter:blur(20px);border-bottom:1px solid var(--border);display:flex;align-items:center;padding:0 32px;gap:12px;z-index:9;position:sticky;top:0}
.header-title{font-family:'Playfair Display',serif;font-size:1.05rem;color:var(--ink)}
.header-sub{font-size:.72rem;color:var(--muted);margin-left:4px}
.header-spacer{flex:1}

.page-body{grid-column:2;overflow-y:auto;height:calc(100vh - var(--header-h));padding:28px 32px 48px}

/* TYPOGRAPHY */
.section-title{font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--muted-2);margin-bottom:14px}

/* CARDS */
.dl-card{background:var(--white);border:1px solid var(--border);border-radius:12px;overflow:hidden}
.dl-card-p{background:var(--white);border:1px solid var(--border);border-radius:12px;padding:22px}

/* BUTTONS */
.btn-dl-primary{height:36px;padding:0 18px;background:var(--gold);color:var(--navy-dark) !important;border-radius:9px;font-size:.72rem;font-weight:700;letter-spacing:.04em;text-transform:uppercase;display:inline-flex;align-items:center;gap:6px;cursor:pointer;transition:all .15s;white-space:nowrap;border:none}
.btn-dl-primary:hover{background:var(--gold-light);transform:translateY(-1px)}
.btn-dl-secondary{height:36px;padding:0 16px;background:var(--white);color:var(--ink-2) !important;border-radius:9px;font-size:.68rem;font-weight:700;letter-spacing:.04em;border:1.5px solid var(--border);display:inline-flex;align-items:center;gap:6px;cursor:pointer;transition:all .15s}
.btn-dl-secondary:hover{border-color:var(--border-2);background:var(--surface)}
.btn-dl-danger{height:36px;padding:0 16px;background:var(--red-pale);color:var(--red) !important;border-radius:9px;font-size:.68rem;font-weight:700;border:1.5px solid transparent;display:inline-flex;align-items:center;gap:6px;cursor:pointer;transition:all .15s}
.btn-dl-danger:hover{background:var(--red);color:#fff !important}

/* TABLE */
.table-toolbar{display:flex;align-items:center;gap:10px;margin-bottom:16px;flex-wrap:wrap}
.tb-search{display:flex;align-items:center;gap:8px;background:var(--white);border:1.5px solid var(--border);border-radius:10px;padding:0 14px 0 10px;height:36px;flex:1;max-width:300px;transition:all .2s}
.tb-search:focus-within{border-color:var(--gold);box-shadow:0 0 0 3px var(--gold-pale)}
.tb-search input{flex:1;border:none;outline:none;font-size:.82rem;color:var(--ink);background:transparent}
.tb-select{height:36px;padding:0 10px;border:1.5px solid var(--border);border-radius:10px;font-size:.78rem;font-weight:500;color:var(--ink-2);background:var(--white);outline:none;cursor:pointer}
.tb-select:focus{border-color:var(--gold)}
.tb-spacer{flex:1}
.data-table-wrap{overflow-x:auto;border-radius:12px;border:1px solid var(--border)}
.data-table-wrap table{width:100%;border-collapse:collapse;background:var(--white)}
.data-table-wrap thead th{background:var(--bg);padding:11px 14px;text-align:left;font-size:.62rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--muted-2);border-bottom:1px solid var(--border);white-space:nowrap}
.data-table-wrap thead th:first-child{padding-left:18px}
.data-table-wrap thead th:last-child{padding-right:18px;text-align:center}
.data-table-wrap tbody tr{border-bottom:1px solid var(--border);transition:background .12s}
.data-table-wrap tbody tr:last-child{border-bottom:none}
.data-table-wrap tbody tr:hover{background:var(--bg)}
.data-table-wrap tbody td{padding:12px 14px;font-size:.82rem;color:var(--ink-2);vertical-align:middle}
.data-table-wrap tbody td:first-child{padding-left:18px;font-weight:500;color:var(--ink)}
.data-table-wrap tbody td:last-child{padding-right:18px;text-align:center}
.dl-pagination{display:flex;align-items:center;justify-content:space-between;padding:12px 18px;border-top:1px solid var(--border);background:var(--bg);border-radius:0 0 12px 12px}
.dl-pagination .page-info{font-size:.62rem;font-weight:600;letter-spacing:.04em;color:var(--muted-2)}

/* BADGES */
.dl-badge{display:inline-flex;align-items:center;gap:5px;font-size:.6rem;font-weight:700;padding:3px 9px;border-radius:99px;letter-spacing:.04em;text-transform:uppercase;white-space:nowrap}
.dl-badge::before{content:'';width:5px;height:5px;border-radius:50%;background:currentColor;flex-shrink:0}
.dl-badge-gold{background:rgba(201,168,76,.12);color:var(--gold)}
.dl-badge-green{background:var(--green-pale);color:var(--green)}
.dl-badge-blue{background:var(--blue-pale);color:var(--blue)}
.dl-badge-red{background:var(--red-pale);color:var(--red)}
.dl-badge-amber{background:var(--amber-pale);color:var(--amber)}
.dl-badge-muted{background:var(--surface);color:var(--muted)}

/* ROW ACTIONS */
.row-actions{display:flex;align-items:center;justify-content:center;gap:4px}
.action-btn{width:28px;height:28px;border-radius:7px;display:inline-flex;align-items:center;justify-content:center;font-size:.75rem;cursor:pointer;transition:all .15s;color:var(--muted);background:none;border:none}
.action-btn:hover{background:var(--surface);color:var(--ink)}
.action-btn.danger:hover{background:var(--red-pale);color:var(--red)}
.action-btn.edit:hover{background:var(--amber-pale);color:var(--amber)}
.action-btn.view:hover{background:var(--blue-pale);color:var(--blue)}
.action-btn.approve:hover{background:var(--green-pale);color:var(--green)}

/* FORM */
.field-label{font-size:.65rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:var(--muted);margin-bottom:6px;display:block}
.field-input{width:100%;height:40px;padding:0 12px;border:1.5px solid var(--border);border-radius:10px;font-size:.85rem;color:var(--ink);outline:none;transition:border-color .2s;background:var(--white)}
.field-input:focus{border-color:var(--gold);box-shadow:0 0 0 3px var(--gold-pale)}
.field-select{width:100%;height:40px;padding:0 12px;border:1.5px solid var(--border);border-radius:10px;font-size:.85rem;color:var(--ink);outline:none;background:var(--white);cursor:pointer}
.field-select:focus{border-color:var(--gold)}
.field-textarea{width:100%;padding:10px 12px;border:1.5px solid var(--border);border-radius:10px;font-size:.85rem;color:var(--ink);outline:none;resize:vertical}
.field-textarea:focus{border-color:var(--gold)}
.form-control,.form-select{border:1.5px solid var(--border) !important;border-radius:10px !important;font-size:.85rem !important;color:var(--ink) !important;background:var(--white) !important}
.form-control:focus,.form-select:focus{border-color:var(--gold) !important;box-shadow:0 0 0 3px var(--gold-pale) !important}

/* MODAL */
.modal-content{border:1px solid var(--border);border-radius:16px;background:var(--white)}
.modal-header{border-bottom:1px solid var(--border);padding:20px 24px}
.modal-title{font-family:'Playfair Display',serif;font-size:1.1rem;color:var(--ink);font-weight:400}
.modal-body{padding:20px 24px}
.modal-footer{border-top:1px solid var(--border);padding:16px 24px}

/* TABS */
.dl-tabs{display:flex;gap:2px;border-bottom:1px solid var(--border);margin-bottom:24px;padding:0}
.dl-tab{padding:10px 18px;font-size:.72rem;font-weight:700;letter-spacing:.04em;text-transform:uppercase;color:var(--muted);cursor:pointer;border-bottom:2.5px solid transparent;transition:all .2s;display:flex;align-items:center;gap:7px;margin-bottom:-1px;text-decoration:none}
.dl-tab:hover{color:var(--ink-2)}
.dl-tab.active{color:var(--gold);border-bottom-color:var(--gold)}
.tab-cnt{font-size:.58rem;font-weight:700;padding:2px 6px;border-radius:99px}
.tab-cnt.red{background:var(--red-pale);color:var(--red)}
.tab-cnt.normal{background:var(--surface);color:var(--muted)}
.tab-cnt.green{background:var(--green-pale);color:var(--green)}

/* ALERT */
.dl-alert{display:flex;align-items:center;gap:10px;padding:12px 16px;border-radius:10px;font-size:.82rem;margin-bottom:16px}
.dl-alert-success{background:var(--green-pale);color:var(--green);border:1px solid #a7d3b9}
.dl-alert-error{background:var(--red-pale);color:var(--red);border:1px solid #fca5a5}
.dl-alert-gold{background:rgba(201,168,76,.1);color:var(--gold);border:1px solid rgba(201,168,76,.3)}

/* MINI COVER */
.mini-cover{width:32px;height:44px;border-radius:3px;flex-shrink:0;box-shadow:1px 2px 6px rgba(0,0,0,.15);object-fit:cover}
.book-col{display:flex;align-items:center;gap:10px}

/* TOAST */
#dl-toast{position:fixed;bottom:24px;left:50%;transform:translateX(-50%) translateY(20px);background:var(--navy-dark);color:var(--gold);font-size:.68rem;font-weight:700;letter-spacing:.04em;text-transform:uppercase;padding:12px 22px;border-radius:8px;border:1px solid rgba(201,168,76,.3);white-space:nowrap;box-shadow:0 8px 28px rgba(0,0,0,.3);z-index:9999;opacity:0;transition:all .3s cubic-bezier(.34,1.56,.64,1);pointer-events:none}

@media(max-width:768px){
  .app{grid-template-columns:0 1fr}
  .sidebar{position:fixed;left:0;top:0;bottom:0;transform:translateX(-100%);transition:transform .3s;z-index:500}
  .sidebar.mobile-open{transform:translateX(0)}
  .page-body{padding:16px}
  .header{padding:0 16px}
}
@stack('styles')
</style>
@stack('styles')
</head>
<body>
<div class="app">

<aside class="sidebar" id="sidebar">
  <div class="sidebar-logo">
    <div class="logo-mark">
      <i class="fas fa-book-open" style="color:var(--navy-dark);font-size:16px;"></i>
    </div>
    <span class="logo-name">{{ \App\Models\Setting::get('navbar_site_name','YOMULIB') }}</span>
    <span class="logo-badge">{{ auth()->user()->role === 'admin' ? 'Admin' : 'Petugas' }}</span>
  </div>

  <nav class="sidebar-nav">
    <div class="nav-section-label">Overview</div>
    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <i class="fas fa-chart-bar"></i>Dashboard
    </a>

    <div class="sidebar-div"></div>
    <div class="nav-section-label">Kelola</div>

    @if(auth()->user()->role === 'admin')
    <a href="{{ route('admin.books.index') }}" class="nav-item {{ request()->routeIs('admin.books.*') && !request()->routeIs('admin.books.proposals.*') ? 'active' : '' }}">
      <i class="fas fa-book"></i>Kelola Buku
    </a>
    @endif

    <a href="{{ route('admin.books.proposals.index') }}" class="nav-item {{ request()->routeIs('admin.books.proposals.*') ? 'active' : '' }}">
      <i class="fas fa-file-plus"></i>Usulan Buku
      @if($proposalPending > 0 && auth()->user()->role === 'admin')
        <span class="nav-badge warn">{{ $proposalPending }}</span>
      @elseif(auth()->user()->role === 'petugas' && $myProposalPending > 0)
        <span class="nav-badge">{{ $myProposalPending }}</span>
      @endif
    </a>

    @if(auth()->user()->role === 'admin')
    <a href="{{ route('admin.categories.index') }}" class="nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
      <i class="fas fa-tags"></i>Kategori
    </a>
    <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
      <i class="fas fa-users"></i>Kelola User
    </a>
    @endif

    <div class="sidebar-div"></div>
    <div class="nav-section-label">Transaksi</div>

    <a href="{{ route('admin.borrowings.index') }}" class="nav-item {{ request()->routeIs('admin.borrowings.*') ? 'active' : '' }}">
      <i class="fas fa-exchange-alt"></i>Peminjaman
      @if($pendingBorrowCount > 0)
        <span class="nav-badge warn">{{ $pendingBorrowCount }}</span>
      @endif
    </a>
    <a href="{{ route('admin.reviews.index') }}" class="nav-item {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
      <i class="fas fa-star"></i>Ulasan
    </a>

    @if(auth()->user()->isPetugas())
    <div class="sidebar-div"></div>
    <div class="nav-section-label">Laporan</div>
    <a href="{{ route('admin.reports.index') }}" class="nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
      <i class="fas fa-file-alt"></i>Generate Laporan
    </a>
    @endif

    @if(auth()->user()->role === 'admin')
    <div class="sidebar-div"></div>
    <div class="nav-section-label">Sistem</div>

    {{-- Pengaturan dropdown --}}
    @php
      $settingActive = request()->routeIs('admin.settings.*');
    @endphp
    <div class="nav-item {{ $settingActive ? 'active' : '' }}"
         onclick="toggleSettingMenu()"
         style="cursor:pointer;justify-content:space-between"
         id="navSettingParent">
      <span style="display:flex;align-items:center;gap:10px">
        <i class="fas fa-sliders-h"></i>Pengaturan Situs
      </span>
      <i class="fas fa-chevron-down" id="settingChevron"
         style="font-size:.6rem;transition:transform .2s;{{ $settingActive ? 'transform:rotate(180deg)' : '' }}"></i>
    </div>

    <div id="settingSubmenu" style="{{ $settingActive ? '' : 'display:none' }}">
      <a href="{{ route('admin.settings.hero') }}"
         class="nav-item {{ request()->routeIs('admin.settings.hero') ? 'active' : '' }}"
         style="padding-left:36px;font-size:.78rem">
        <i class="fas fa-home" style="font-size:.75rem"></i>Hero
      </a>
      <a href="{{ route('admin.settings.tentang') }}"
         class="nav-item {{ request()->routeIs('admin.settings.tentang') ? 'active' : '' }}"
         style="padding-left:36px;font-size:.78rem">
        <i class="fas fa-info-circle" style="font-size:.75rem"></i>Tentang
      </a>
      <a href="{{ route('admin.settings.fitur') }}"
         class="nav-item {{ request()->routeIs('admin.settings.fitur') ? 'active' : '' }}"
         style="padding-left:36px;font-size:.78rem">
        <i class="fas fa-th-large" style="font-size:.75rem"></i>Fitur Unggulan
      </a>
      <a href="{{ route('admin.settings.kategori') }}"
         class="nav-item {{ request()->routeIs('admin.settings.kategori') ? 'active' : '' }}"
         style="padding-left:36px;font-size:.78rem">
        <i class="fas fa-images" style="font-size:.75rem"></i>Kategori
      </a>
    </div>
    @endif
  </nav>

  <div class="sidebar-footer">
    <div style="margin-bottom:6px">
      <a href="{{ route('dashboard') }}" style="display:flex;align-items:center;gap:8px;padding:7px 12px;border-radius:8px;font-size:.72rem;font-weight:600;color:rgba(255,255,255,.3);transition:all .15s" onmouseover="this.style.background='rgba(201,168,76,.1)';this.style.color='var(--gold)'" onmouseout="this.style.background='';this.style.color='rgba(255,255,255,.3)'">
        <i class="fas fa-home" style="width:16px;text-align:center"></i>Lihat Situs
      </a>
    </div>
    <form method="POST" action="{{ route('logout') }}">@csrf
      <button type="submit" style="width:100%;display:flex;align-items:center;gap:8px;padding:7px 12px;border-radius:8px;font-size:.72rem;font-weight:600;color:rgba(255,255,255,.3);transition:all .15s;background:none;border:none;cursor:pointer" onmouseover="this.style.background='rgba(192,57,43,.15)';this.style.color='#e57373'" onmouseout="this.style.background='';this.style.color='rgba(255,255,255,.3)'">
        <i class="fas fa-sign-out-alt" style="width:16px;text-align:center"></i>Logout
      </button>
    </form>
    <div class="user-card" style="margin-top:4px">
      @php $initial = strtoupper(substr(auth()->user()->username, 0, 1)); @endphp
      @if(auth()->user()->profile_photo)
        <img src="{{ asset('storage/'.auth()->user()->profile_photo) }}" class="user-av" style="object-fit:cover">
      @else
        <div class="user-av">{{ $initial }}</div>
      @endif
      <div>
        <div class="user-name">{{ auth()->user()->username }}</div>
        <div class="user-role">{{ ucfirst(auth()->user()->role) }}</div>
      </div>
    </div>
  </div>
</aside>

<header class="header">
  <button class="action-btn d-md-none" onclick="document.getElementById('sidebar').classList.toggle('mobile-open')">
    <i class="fas fa-bars"></i>
  </button>
  <div>
    <span class="header-title">@yield('page-title','Dashboard')</span>
    @hasSection('page-subtitle')<span class="header-sub">@yield('page-subtitle')</span>@endif
  </div>
  <div class="header-spacer"></div>
</header>

<div class="page-body">
  @if(session('success'))
    <div class="dl-alert dl-alert-success"><i class="fas fa-check-circle"></i>{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="dl-alert dl-alert-error"><i class="fas fa-exclamation-circle"></i>{{ session('error') }}</div>
  @endif
  @yield('content')
</div>

</div>
<div id="dl-toast"></div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function showToast(msg){const t=document.getElementById('dl-toast');t.textContent=msg;t.style.opacity=1;t.style.transform='translateX(-50%) translateY(0)';setTimeout(()=>{t.style.opacity=0;t.style.transform='translateX(-50%) translateY(20px)'},2500);}

function toggleSettingMenu(){
    const menu    = document.getElementById('settingSubmenu');
    const chevron = document.getElementById('settingChevron');
    const parent  = document.getElementById('navSettingParent');
    const open    = menu.style.display === 'none' || menu.style.display === '';
    menu.style.display = open ? 'block' : 'none';
    chevron.style.transform = open ? 'rotate(180deg)' : '';
    parent.classList.toggle('active', open);
}

// ── Persist sidebar scroll position across navigation ──
(function () {
    const KEY = 'sidebarScroll';

    function restoreScroll() {
        const nav   = document.querySelector('.sidebar-nav');
        const saved = sessionStorage.getItem(KEY);
        if (nav && saved) nav.scrollTop = parseInt(saved, 10);
    }

    // Try immediately (script runs after sidebar HTML is parsed)
    restoreScroll();

    document.addEventListener('DOMContentLoaded', function () {
        // Try again after full DOM ready in case first attempt was too early
        restoreScroll();

        const nav = document.querySelector('.sidebar-nav');
        if (!nav) return;

        // Save on every scroll
        nav.addEventListener('scroll', function () {
            sessionStorage.setItem(KEY, nav.scrollTop);
        }, { passive: true });

        // Save before leaving the page
        document.querySelectorAll('.sidebar-nav a').forEach(el => {
            el.addEventListener('click', function () {
                sessionStorage.setItem(KEY, nav.scrollTop);
            });
        });
    });
})();
</script>
@stack('scripts')
</body>
</html>
