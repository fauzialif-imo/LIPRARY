<!-- Navbar fonts & styles (kept here so partial renders consistently across pages) -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
    :root {
        --navy: #0d1b3e;
        --navy-light: #1a2d5a;
        --gold: #c9a84c;
        --gold-light: #e8c97a;
        --bg: #f0f2f7;
    }
    nav {
        position: fixed; top: 0; width: 100%; z-index: 1000;
        background: var(--navy); padding: 14px 40px;
        display: flex; align-items: center; justify-content: space-between;
        box-shadow: 0 2px 10px rgba(0,0,0,0.3);
    }
    .nav-logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
    .nav-logo i { font-size: 26px; color: var(--gold); }
    .nav-logo span { color: var(--gold); font-family: 'Playfair Display', serif; font-size: 1.2rem; font-weight: 700; }
    .nav-logo small { display: block; color: rgba(255,255,255,0.4); font-size: 0.6rem; letter-spacing: 2px; }

    .nav-center { display: flex; gap: 8px; }
    .nav-center a {
        color: rgba(255,255,255,0.7); text-decoration: none; padding: 8px 16px;
        border-radius: 6px; font-size: 0.88rem; font-weight: 500; transition: all 0.2s;
    }
    .nav-center a:hover { background: rgba(201,168,76,0.15); color: var(--gold); }

    .nav-right { display: flex; align-items: center; gap: 12px; }
    .user-menu { position: relative; cursor: pointer; }
    .user-avatar {
        width: 38px; height: 38px; border-radius: 50%; background: var(--gold);
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; color: var(--navy); border: 2px solid var(--gold-light);
    }
    .user-avatar-img {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        object-fit: cover;
        display: block;
        border: 2px solid var(--gold-light);
    }

    .dropdown {
        position: absolute; right: 0; top: 50px; background: white;
        border-radius: 10px; box-shadow: 0 8px 32px rgba(0,0,0,0.15);
        width: 200px; display: none; overflow: hidden; z-index: 999;
    }
    .dropdown.show { display: block; }
    .dropdown-header {
        padding: 14px 16px;
        border-bottom: 1px solid #eee;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }
    .dropdown-avatar {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #f3f3f3;
        display: block;
    }
    .dropdown-avatar-initial {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: var(--gold);
        color: var(--navy);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.25rem;
        border: 2px solid #f3f3f3;
    }
    .dropdown-username { color: var(--navy); font-weight: 700; }
    .dropdown-role { font-size: 0.75rem; color: #999; margin-top: -2px; }
    .dropdown a, .dropdown button {
        display: flex; align-items: center; gap: 10px; padding: 12px 16px;
        text-decoration: none; color: #374151; font-size: 0.88rem; 
        width: 100%; border: none; background: none; cursor: pointer; text-align: left;
    }
    .dropdown a:hover, .dropdown button:hover { background: #f9fafb; color: var(--gold); }

    /* Logout modal theme (match site colors) */
    .modal-theme .modal-content {
        background: var(--navy-dark);
        color: #fff;
        border-radius: 12px;
        border: none;
    }
    .modal-theme .modal-body { padding: 1.25rem 1.5rem; text-align: center; }
    .modal-theme .btn-close { filter: none; opacity: 0.9; }
    .modal-theme .btn-outline-light { color: #fff; border-color: rgba(255,255,255,0.12); }
    .btn-gold {
        background: linear-gradient(90deg, var(--gold), var(--gold-light));
        color: var(--navy); border: none; padding: 8px 18px; border-radius: 8px; font-weight:700;
    }
    .btn-gold:hover { opacity: .95; transform: translateY(-1px); }
</style>

<nav>
    <a href="{{ route('dashboard') }}" class="nav-logo">
        <i class="fas fa-book-open"></i>
        <div>
            <span>YOMULIB</span>
            <small>PERPUSTAKAAN DIGITAL SMK</small>
        </div>
    </a>
    <div class="nav-center">
        <a href="{{ route('dashboard') }}">Beranda</a>
        <a href="{{ route('buku') }}">Koleksi</a>
        <a href="#">Pinjaman</a>
    </div>
    <div class="nav-right">
        @auth
            <div class="user-menu" onclick="toggleDropdown()">
                <div class="user-avatar">
                    @if(Auth::user()->profile_photo)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="avatar" class="user-avatar-img">
                    @else
                        {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
                    @endif
                </div>
                <div class="dropdown" id="userDropdown">
                    <div class="dropdown-header">
                        @if(Auth::user()->profile_photo)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="avatar" class="dropdown-avatar">
                        @else
                            <div class="dropdown-avatar-initial">{{ strtoupper(substr(Auth::user()->username, 0, 1)) }}</div>
                        @endif
                        <strong class="dropdown-username">{{ Auth::user()->username }}</strong>
                        <div class="dropdown-role">{{ Auth::user()->role }}</div>
                    </div>
                    <a href="{{ route('profile') }}"><i class="fas fa-user"></i> Profil</a>
                    <button type="button" onclick="openLogoutModal()"><i class="fas fa-sign-out-alt"></i> Keluar</button>
                </div>
            </div>
        @else
            <a href="{{ route('login') }}" class="nav-btn">Masuk/Daftar</a>
        @endauth
    </div>
</nav>

<script>
    function toggleDropdown() {
        var el = document.getElementById('userDropdown');
        if (el) el.classList.toggle('show');
    }

    // Menutup dropdown jika klik di luar
    window.addEventListener('click', function(event) {
        if (!event.target.closest('.user-menu')) {
            var dropdowns = document.getElementsByClassName('dropdown');
            for (var i = 0; i < dropdowns.length; i++) {
                if (dropdowns[i].classList.contains('show')) {
                    dropdowns[i].classList.remove('show');
                }
            }
        }
    });

    function openLogoutModal(){
        // close dropdown if open
        var dd = document.getElementById('userDropdown');
        if(dd && dd.classList.contains('show')) dd.classList.remove('show');

        // show bootstrap modal if available
        var modalEl = document.getElementById('logoutModal');
        if(typeof bootstrap !== 'undefined' && modalEl){
            var m = new bootstrap.Modal(modalEl);
            m.show();
            return false;
        }

        // fallback: simple confirm and submit logout
        if(confirm('Yakin ingin keluar?')){
            var f = document.createElement('form');
            f.method = 'POST';
            f.action = '{{ route('logout') }}';
            var token = document.createElement('input'); token.type='hidden'; token.name='_token'; token.value='{{ csrf_token() }}';
            f.appendChild(token);
            document.body.appendChild(f);
            f.submit();
        }
        return false;
    }
</script>
