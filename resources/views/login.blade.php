<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - {{ \App\Models\Setting::get('navbar_site_name','YomuLib') }}</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <style>
        /* Tab switcher */
        .login-tabs {
            display: flex;
            background: #f0f2f5;
            border-radius: 12px;
            padding: 4px;
            margin-bottom: 32px;
            gap: 4px;
        }
        .login-tab {
            flex: 1;
            padding: 10px 12px;
            border: none;
            background: transparent;
            border-radius: 9px;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            font-weight: 600;
            color: #6b7280;
            cursor: pointer;
            transition: all .2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
        }
        .login-tab.active {
            background: #fff;
            color: #0d1b3e;
            box-shadow: 0 1px 6px rgba(0,0,0,.1);
        }
        .login-tab.active.admin-tab {
            color: #c9a84c;
        }
        .login-tab i { font-size: 13px; }

        /* Role badge */
        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 99px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .04em;
            margin-bottom: 20px;
        }
        .role-badge.user-badge {
            background: #ebf2f8;
            color: #1a5280;
        }
        .role-badge.admin-badge {
            background: rgba(201,168,76,.15);
            color: #8a6a1a;
        }

        /* Panel */
        .tab-panel { display: none; }
        .tab-panel.active { display: block; }

        /* Admin left side */
        .left-side.admin-mode {
            background: linear-gradient(135deg, #0d1b3e 0%, #1a2d5a 60%, #0a1628 100%);
        }
        .left-side .brand-area,
        .left-side .brand-icon,
        .left-side .brand-title,
        .left-side .brand-sub,
        .left-side .brand-features { display: none; }

        .main-logo {
            width: 70%;
            max-width: 480px;
            height: auto;
            object-fit: contain;
        }

        .brand-features {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .brand-features li {
            font-size: 13px;
            color: rgba(255,255,255,.65);
            padding: 6px 0;
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: 'DM Sans', sans-serif;
        }
        .brand-features li i {
            color: #c9a84c;
            width: 14px;
            flex-shrink: 0;
        }

        /* Transition on left side */
        .left-side { transition: background .4s; }

        .error-msg {
            background: #fef2f2;
            color: #c0392b;
            border: 1px solid #fca5a5;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 13px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .success-msg {
            background: #eaf3ee;
            color: #1c6b46;
            border: 1px solid #a7d3b9;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 13px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Better input icons using FA */
        .input-group { position: relative; width: 100%; margin-bottom: 14px; }
        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 14px;
            pointer-events: none;
            z-index: 2;
        }
        .form-input {
            width: 100%;
            height: 46px;
            background-color: #f3f4f6;
            border: 1.5px solid transparent;
            border-radius: 10px;
            padding: 0 44px;
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            color: #1a1a2e;
            outline: none;
            transition: all .2s;
        }
        .form-input:focus {
            background: #fff;
            border-color: #1b344a;
            box-shadow: 0 0 0 3px rgba(27,52,74,.08);
        }
        body.admin-active .form-input:focus {
            border-color: #c9a84c;
            box-shadow: 0 0 0 3px rgba(201,168,76,.12);
        }
        .password-container { position: relative; }
        .icon-eye {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            cursor: pointer;
            font-size: 14px;
            z-index: 3;
            transition: color .15s;
        }
        .icon-eye:hover { color: #374151; }

        .btn-login {
            width: 100%;
            height: 46px;
            border: none;
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 8px;
        }
        .btn-login.btn-user {
            background: #1b344a;
            color: #fff;
        }
        .btn-login.btn-user:hover { background: #091a2e; transform: translateY(-1px); }
        .btn-login.btn-admin {
            background: linear-gradient(135deg, #c9a84c, #e8c97a);
            color: #0d1b3e;
        }
        .btn-login.btn-admin:hover { transform: translateY(-1px); box-shadow: 0 4px 16px rgba(201,168,76,.4); }

        .footer-text { margin-top: 20px; font-size: 13px; color: #6b7280; }
        .link-daftar { color: #1b344a; font-weight: 700; text-decoration: none; }
        .link-daftar:hover { text-decoration: underline; }

        /* Divider between forms */
        .form-divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 18px 0;
            color: #d1d5db;
            font-size: 11px;
        }
        .form-divider::before, .form-divider::after {
            content: ''; flex: 1; height: 1px; background: #e5e7eb;
        }

        @media (max-width: 640px) {
            .left-side { display: none; }
            .right-side { flex: 1; }
        }
    </style>
</head>
<body id="loginBody">
<div class="login-container">

    {{-- Left decorative side --}}
    <div class="left-side" id="leftSide">
        <div style="display:flex;flex-direction:column;align-items:center;gap:0">
            <img src="{{ asset('asset/loginback.png') }}" class="main-logo" alt="{{ \App\Models\Setting::get('navbar_site_name','YomuLib') }}">
            <ul class="brand-features">
                <li><i class="fas fa-check"></i> Akses ribuan buku &amp; modul</li>
                <li><i class="fas fa-check"></i> Pinjam buku kapan saja</li>
                <li><i class="fas fa-check"></i> Koleksi pribadi digital</li>
                <li><i class="fas fa-check"></i> Gratis untuk semua siswa</li>
            </ul>
        </div>
    </div>

    {{-- Right form side --}}
    <div class="right-side">
        <div class="form-wrapper">

            {{-- Success flash --}}
            @if(session('success'))
                <div class="success-msg"><i class="fas fa-check-circle"></i>{{ session('success') }}</div>
            @endif

            {{-- Error flash --}}
            @if($errors->has('loginError'))
                <div class="error-msg"><i class="fas fa-exclamation-circle"></i>{{ $errors->first('loginError') }}</div>
            @endif

            {{-- Tab switcher --}}
            <div class="login-tabs">
                <button type="button" class="login-tab active" id="tabUser" onclick="switchTab('user')">
                    <i class="fas fa-user"></i> Login Member
                </button>
                <button type="button" class="login-tab admin-tab" id="tabAdmin" onclick="switchTab('admin')">
                    <i class="fas fa-shield-alt"></i> Login Admin
                </button>
            </div>

            {{-- ====== USER LOGIN PANEL ====== --}}
            <div class="tab-panel active" id="panelUser">
                <span class="role-badge user-badge">
                    <i class="fas fa-user-circle"></i> Portal Member
                </span>
                <h1 class="title" style="margin-bottom:24px">Selamat Datang</h1>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <input type="hidden" name="login_type" value="user">

                    <div class="input-group">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" name="email" class="form-input"
                               placeholder="Alamat email"
                               value="{{ old('email') }}" required autocomplete="email">
                    </div>

                    <div class="input-group">
                        <i class="fas fa-lock input-icon"></i>
                        <div class="password-container">
                            <input type="password" name="password" id="passUser" class="form-input"
                                   placeholder="Password" required autocomplete="current-password">
                            <i class="fas fa-eye icon-eye" onclick="togglePass('passUser', this)"></i>
                        </div>
                    </div>

                    <button type="submit" class="btn-login btn-user">
                        <i class="fas fa-sign-in-alt"></i> Masuk
                    </button>
                </form>

                <div class="form-divider">atau</div>
                <p class="footer-text">
                    Belum punya akun? <a href="{{ route('register') }}" class="link-daftar">Daftar sekarang</a>
                </p>
            </div>

            {{-- ====== ADMIN LOGIN PANEL ====== --}}
            <div class="tab-panel" id="panelAdmin">
                <span class="role-badge admin-badge">
                    <i class="fas fa-shield-alt"></i> Portal Admin & Petugas
                </span>
                <h1 class="title" style="margin-bottom:24px;font-family:'Playfair Display',serif;color:#0d1b3e">Dashboard Access</h1>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <input type="hidden" name="login_type" value="admin">

                    <div class="input-group">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" name="email" class="form-input"
                               placeholder="Email admin / petugas"
                               value="{{ old('email') }}" required autocomplete="email">
                    </div>

                    <div class="input-group">
                        <i class="fas fa-lock input-icon"></i>
                        <div class="password-container">
                            <input type="password" name="password" id="passAdmin" class="form-input"
                                   placeholder="Password" required autocomplete="current-password">
                            <i class="fas fa-eye icon-eye" onclick="togglePass('passAdmin', this)"></i>
                        </div>
                    </div>

                    <button type="submit" class="btn-login btn-admin">
                        <i class="fas fa-lock-open"></i> Masuk ke Dashboard
                    </button>
                </form>

                <p class="footer-text" style="margin-top:16px">
                    <a href="{{ url('/') }}" style="color:#6b7280;font-size:12px">
                        <i class="fas fa-arrow-left" style="font-size:10px;margin-right:4px"></i>Kembali ke halaman utama
                    </a>
                </p>
            </div>

        </div>
    </div>
</div>

<script>
const leftSide = document.getElementById('leftSide');
const body     = document.getElementById('loginBody');

// On load: restore last active tab, or switch to admin if error on admin form
document.addEventListener('DOMContentLoaded', function () {
    const stored = sessionStorage.getItem('loginTab');
    const loginType = document.querySelector('input[name="login_type"]');

    // If there's a validation error and we know which form was submitted,
    // keep that tab active. We store it via hidden field value fallback.
    @if($errors->has('loginError'))
        const lastType = sessionStorage.getItem('lastLoginType') || 'user';
        switchTab(lastType);
    @else
        if (stored) switchTab(stored);
    @endif
});

function switchTab(type) {
    sessionStorage.setItem('loginTab', type);

    document.getElementById('tabUser').classList.toggle('active', type === 'user');
    document.getElementById('tabAdmin').classList.toggle('active', type === 'admin');
    document.getElementById('panelUser').classList.toggle('active', type === 'user');
    document.getElementById('panelAdmin').classList.toggle('active', type === 'admin');

    if (type === 'admin') {
        leftSide.style.background = 'linear-gradient(135deg, #0d1b3e 0%, #1a2d5a 60%, #0a1628 100%)';
        body.classList.add('admin-active');
    } else {
        leftSide.style.background = '#091a2e';
        body.classList.remove('admin-active');
    }
}

// Store which form is being submitted so on error we reopen correct tab
document.querySelectorAll('form').forEach(function(form) {
    form.addEventListener('submit', function () {
        const typeInput = form.querySelector('input[name="login_type"]');
        if (typeInput) sessionStorage.setItem('lastLoginType', typeInput.value);
    });
});

function togglePass(inputId, icon) {
    const input = document.getElementById(inputId);
    const isHidden = input.type === 'password';
    input.type = isHidden ? 'text' : 'password';
    icon.className = isHidden ? 'fas fa-eye-slash icon-eye' : 'fas fa-eye icon-eye';
}
</script>
</body>
</html>
