<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - {{ \App\Models\Setting::get('navbar_site_name','YomuLib') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            height: 100vh;
            overflow: hidden;
            display: flex;
        }

        /* ── LEFT SIDE ── */
        .brand-side {
            flex: 1.1;
            background: #091a2e;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 0;
            padding: 40px;
        }

        .brand-side img {
            width: 70%;
            max-width: 420px;
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
        }
        .brand-features li i {
            color: #c9a84c;
            width: 14px;
            flex-shrink: 0;
        }

        /* ── RIGHT SIDE ── */
        .form-side {
            flex: 1;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 32px;
            overflow-y: auto;
        }

        .form-box {
            width: 100%;
            max-width: 400px;
        }

        /* Header */
        .form-header {
            margin-bottom: 28px;
        }
        .form-header .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 13px;
            border-radius: 99px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .04em;
            background: #ebf2f8;
            color: #1a5280;
            margin-bottom: 12px;
        }
        .form-header h1 {
            font-size: 28px;
            font-weight: 700;
            color: #111827;
            line-height: 1.2;
            margin-bottom: 6px;
        }
        .form-header p {
            font-size: 13px;
            color: #6b7280;
        }

        /* Input group */
        .input-group {
            position: relative;
            margin-bottom: 14px;
        }

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
            background: #f3f4f6;
            border: 1.5px solid transparent;
            border-radius: 10px;
            padding: 0 44px;
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            color: #1a1a2e;
            outline: none;
            transition: all .2s;
            appearance: none;
        }
        .form-input:focus {
            background: #fff;
            border-color: #1b344a;
            box-shadow: 0 0 0 3px rgba(27,52,74,.08);
        }
        select.form-input {
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236b7280' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 36px;
        }
        select.form-input option[value=""] { color: #9ca3af; }

        /* Password toggle */
        .password-container { position: relative; }
        .password-toggle {
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
        .password-toggle:hover { color: #374151; }

        /* Error */
        .error-msg {
            display: flex;
            align-items: center;
            gap: 7px;
            background: #fef2f2;
            color: #c0392b;
            border: 1px solid #fca5a5;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 13px;
            margin-bottom: 14px;
        }
        .error-msg.hidden { display: none; }

        /* Button */
        .btn-register {
            width: 100%;
            height: 46px;
            background: #1b344a;
            color: #fff;
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
            margin-top: 4px;
        }
        .btn-register:hover {
            background: #091a2e;
            transform: translateY(-1px);
        }

        /* Footer */
        .footer-text {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #6b7280;
        }
        .footer-text a {
            color: #1b344a;
            font-weight: 700;
            text-decoration: none;
        }
        .footer-text a:hover { text-decoration: underline; }

        /* Divider */
        .form-divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 18px 0 0;
            color: #d1d5db;
            font-size: 11px;
        }
        .form-divider::before, .form-divider::after {
            content: ''; flex: 1; height: 1px; background: #e5e7eb;
        }

        /* Field label */
        .field-label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: #6b7280;
            margin-bottom: 6px;
            padding-left: 2px;
        }

        @media (max-width: 640px) {
            .brand-side { display: none; }
            .form-side { padding: 32px 24px; }
        }
    </style>
</head>
<body>

{{-- Left side --}}
<div class="brand-side">
    <img src="{{ asset('asset/loginback.png') }}" alt="{{ \App\Models\Setting::get('navbar_site_name','YomuLib') }}">
    <ul class="brand-features">
        <li><i class="fas fa-check"></i> Akses ribuan buku &amp; modul</li>
        <li><i class="fas fa-check"></i> Pinjam buku kapan saja</li>
        <li><i class="fas fa-check"></i> Koleksi pribadi digital</li>
        <li><i class="fas fa-check"></i> Gratis untuk semua siswa</li>
    </ul>
</div>

{{-- Right form side --}}
<div class="form-side">
    <div class="form-box">

        <div class="form-header">
            <span class="role-badge">
                <i class="fas fa-user-plus"></i> Buat Akun Baru
            </span>
            <h1>Daftar Sekarang</h1>
            <p>Bergabung dan nikmati akses perpustakaan digital gratis</p>
        </div>

        @if($errors->any())
            <div class="error-msg">
                <i class="fas fa-exclamation-circle"></i>
                Mohon isi data dengan benar atau email / username sudah terpakai.
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf

            {{-- Username --}}
            <div class="input-group">
                <label class="field-label" style="position:absolute;display:none">Username</label>
                <i class="fas fa-user input-icon"></i>
                <input type="text" name="username" class="form-input"
                       placeholder="Username" required
                       value="{{ old('username') }}" autocomplete="username">
            </div>

            {{-- Alamat --}}
            <div class="input-group">
                <i class="fas fa-map-marker-alt input-icon"></i>
                <select name="alamat" class="form-input" required>
                    <option value="" disabled {{ old('alamat') ? '' : 'selected' }}>Pilih kota</option>
                    <option value="Bogor"      {{ old('alamat') == 'Bogor'      ? 'selected' : '' }}>Bogor</option>
                    <option value="Jakarta"    {{ old('alamat') == 'Jakarta'    ? 'selected' : '' }}>Jakarta</option>
                    <option value="Depok"      {{ old('alamat') == 'Depok'      ? 'selected' : '' }}>Depok</option>
                    <option value="Tangerang"  {{ old('alamat') == 'Tangerang'  ? 'selected' : '' }}>Tangerang</option>
                    <option value="Bekasi"     {{ old('alamat') == 'Bekasi'     ? 'selected' : '' }}>Bekasi</option>
                </select>
            </div>

            {{-- Email --}}
            <div class="input-group">
                <i class="fas fa-envelope input-icon"></i>
                <input type="email" name="email" class="form-input"
                       placeholder="Alamat email" required
                       value="{{ old('email') }}" autocomplete="email">
            </div>

            {{-- Password --}}
            <div class="input-group">
                <i class="fas fa-lock input-icon"></i>
                <div class="password-container" style="width:100%">
                    <input type="password" name="password" id="passInput" class="form-input"
                           placeholder="Password (min. 8 karakter)" required
                           autocomplete="new-password">
                    <i class="fas fa-eye password-toggle" onclick="togglePassword()"></i>
                </div>
            </div>

            <button type="submit" class="btn-register">
                <i class="fas fa-user-plus"></i> Buat Akun
            </button>
        </form>

        <div class="form-divider">atau</div>
        <p class="footer-text">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
        </p>

    </div>
</div>

<script>
    function togglePassword() {
        const input = document.getElementById('passInput');
        const icon  = document.querySelector('.password-toggle');
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        icon.classList.replace(isHidden ? 'fa-eye' : 'fa-eye-slash',
                               isHidden ? 'fa-eye-slash' : 'fa-eye');
    }
</script>
</body>
</html>
