<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - YomuLib</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/regis.css') }}">
</head>
<body>

<div class="container">
    <div class="brand-side">
        <img src="{{ asset('asset/loginback.png') }}" alt="YomuLib Logo">
    </div>

    <div class="form-side">
        <div class="form-box">
            <h1>Daftar</h1>

            <form action="{{ route('register') }}" method="POST">
    @csrf 
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" class="form-input" placeholder="username" required value="{{ old('username') }}">
                </div>

                <div class="input-group">
                    <i class="fas fa-map-marker-alt"></i>
                    <select name="alamat" class="form-input" required>
                        <option value="" disabled selected>alamat</option>
                        <option value="Bogor">Bogor</option>
                        <option value="Jakarta">Jakarta</option>
                        <option value="Depok">Depok</option>
                        <option value="Tangerang">Tangerang</option>
                        <option value="Bekasi">Bekasi</option>
                    </select>
                </div>

                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" class="form-input" placeholder="email" required value="{{ old('email') }}">
                </div>

                <div class="input-group">
                    <i class="fas fa-key"></i>
                    <input type="password" name="password" id="passInput" class="form-input" placeholder="password" required>
                    <i class="fas fa-eye password-toggle" onclick="togglePassword()"></i>
                </div>

                @if($errors->any())
                    <small class="error-msg">Mohon isi data dengan benar atau email/username sudah terpakai!</small>
                @else
                    <small class="error-msg" style="color: transparent;">Placeholder</small> 
                @endif

                <button type="submit" class="btn-register">Daftar</button>
                
            </form>

            <p class="footer-text">
                Sudah punya akun? <a href="{{ route('login') }}">Login!</a>
            </p>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const passInput = document.getElementById('passInput');
        const icon = document.querySelector('.password-toggle');
        if (passInput.type === 'password') {
            passInput.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            passInput.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>

</body>
</html>