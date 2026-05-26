<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Yomulib</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
<div class="login-container">
    <div class="left-side">
        <img src="asset/loginback.png" class="main-logo">
    </div>

    <div class="right-side">
        <div class="form-wrapper">
            <h1 class="title">Masuk</h1>
            
            <form method="POST" action="{{ route('login') }}">
    @csrf
    
    <div class="input-group">
        <img src="{{ asset('asset/iconamoon_profile-fill.png') }}" class="icon-main">
        <input type="text" name="username" class="form-input" placeholder="username" required>
    </div>

    <div class="input-group">
        <img src="{{ asset('asset/lets-icons_message-fill.png') }}" class="icon-main">
        <input type="email" name="email" class="form-input" placeholder="email" required>
    </div>

    <div class="input-group">
        <img src="{{ asset('asset/majesticons_key.png') }}" class="icon-main">
        <div class="password-container">
            <input type="password" name="password" id="passInput" class="form-input" placeholder="password" required>
            <img class="icon-eye" onclick="togglePassword()">
        </div>
    </div>

    @if($errors->has('loginError'))
        <p style="color: red; font-size: 0.8rem;">{{ $errors->first('loginError') }}</p>
    @endif

    <button type="submit" class="btn-login">Login</button>
</form>

            <p class="footer-text">
                belum punya akun? <a href="{{ route('register') }}" class="link-daftar">Daftar!</a>
            </p>
        </div>
    </div>
</div>

    <script>
    function togglePassword() {
    const passwordInput = document.getElementById("passInput");
    // Cek tipe input saat ini
    if (passwordInput.type === "password") {
        passwordInput.type = "text"; // Ubah jadi teks (lihat password)
    } else {
        passwordInput.type = "password"; // Ubah kembali ke bintang (sembunyi)
    }
}
</script>
</body>
</html>