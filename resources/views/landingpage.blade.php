<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>YomuLib - Perpustakaan Digital SMK</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/landingpage.css') }}">
<style>
  
</style>
</head>
<body>

<nav>
  <a href="index.html" class="nav-logo">
    <i class="fas fa-book-open" style="color:var(--gold);font-size:28px;"></i>
    <span>YOMULIB</span>
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
  <div class="hero-content">
    <h1>Pintu Gerbang Digital Anda ke Ilmu Pengetahuan</h1>
    <p>Akses Buku dan Modul SMK di sini</p>
    <a href="{{ route('register') }}" class="hero-btn">Mulai Sekarang</a>
  </div>
  <div class="hero-books"><i class="fas fa-books"></i></div>
</section>

<!-- KOLEKSI POPULER -->
<section id="koleksi" style="background:#fff;">
  <div class="section-title">
    <h2>Koleksi Populer</h2>
    <p>Guidebook dan Modul SMK di sini</p>
  </div>
  <div class="book-grid">
    <div class="book-card">
      <div class="book-cover" style="background:linear-gradient(135deg,#1a3a6e,#2d5a9e)">
        <span style="font-size:50px">⚙️</span>
      </div>
      <div class="book-info">
        <h4>Teknik Mesin</h4>
        <div class="stars">★★★★★</div>
      </div>
    </div>
    <div class="book-card">
      <div class="book-cover" style="background:linear-gradient(135deg,#c9a84c,#8a6a1a)">
        <span style="font-size:50px">💰</span>
      </div>
      <div class="book-info">
        <h4>Akuntansi Keuangan</h4>
        <div class="stars">★★★★★</div>
      </div>
    </div>
    <div class="book-card">
      <div class="book-cover" style="background:linear-gradient(135deg,#1a6e4a,#2da05a)">
        <span style="font-size:50px">💻</span>
      </div>
      <div class="book-info">
        <h4>Pemrograman</h4>
        <div class="stars">★★★★★</div>
      </div>
    </div>
    <div class="book-card">
      <div class="book-cover" style="background:linear-gradient(135deg,#2d4a7a,#4a6fa5)">
        <span style="font-size:50px">📊</span>
      </div>
      <div class="book-info">
        <h4>Bisnis Digital</h4>
        <div class="stars">★★★★★</div>
      </div>
    </div>
    <div class="book-card">
      <div class="book-cover" style="background:linear-gradient(135deg,#7a2a2a,#c04040)">
        <span style="font-size:50px">📖</span>
      </div>
      <div class="book-info">
        <h4>Bu, Aku Ingin Pelukmu</h4>
        <div class="stars">★★★★★</div>
      </div>
    </div>
    <div class="book-card">
      <div class="book-cover" style="background:linear-gradient(135deg,#1a4a6e,#3a8aba)">
        <span style="font-size:50px">🌧️</span>
      </div>
      <div class="book-info">
        <h4>Hujan</h4>
        <div class="stars">★★★★★</div>
      </div>
    </div>
    <div class="book-card">
      <div class="book-cover" style="background:linear-gradient(135deg,#4a3a1a,#7a6a3a)">
        <span style="font-size:50px">✨</span>
      </div>
      <div class="book-info">
        <h4>Harapan Dari Tempat Paling Jauh</h4>
        <div class="stars">★★★★★</div>
      </div>
    </div>
    <div class="book-card">
      <div class="book-cover" style="background:linear-gradient(135deg,#2a1a4a,#5a3a8a)">
        <span style="font-size:50px">😊</span>
      </div>
      <div class="book-info">
        <h4>Seribu Wajah Ayah</h4>
        <div class="stars">★★★★★</div>
      </div>
    </div>
  </div>
</section>

<!-- APA ITU YOMULIB -->
<section class="about-section" id="tentang">
  <div class="section-title">
    <h2>Apa Itu YomuLib?</h2>
  </div>
  <div class="about-grid">
    <div class="about-icon">📚</div>
    <div>
      <div class="about-card">
        <p>YOMULIB adalah platform perpustakaan digital modern yang dirancang sebagai ruang baca tanpa batas di era inklusivitas digital. Nama YOMULIB sendiri merupakan representasi dari visi kami: "Your Modern Ultimate Library"—sebuah perpustakaan utama yang hadir untuk memenuhi gaya hidup modern Anda.</p>
      </div>
      <div class="about-card">
        <p>Platform ini memberikan kenyamanan tanpa batasan geografis. Dengan fokus pada aksesibilitas yang lebih mudah, Perpustakaan Platform YOMULIB membebaskan penggunanya dari keharusan menginstal aplikasi tambahan.</p>
      </div>
    </div>
  </div>
</section>

<!-- FITUR UNGGULAN -->
<section style="background:#f8f9fc;">
  <div class="section-title">
    <h2>Fitur Unggulan</h2>
    <p>Perpustakaan Digital SMK YOMULIB</p>
  </div>
  <div class="features-grid">
    <div class="feature-card">
      <div class="feature-icon"><i class="fas fa-globe"></i></div>
      <h3>Berbasis WEB</h3>
      <p>Perpustakaan yang berbasis digital melalui website</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon"><i class="fas fa-book-open"></i></div>
      <h3>Katalog Luas</h3>
      <p>Memberikan Informasi secara detail</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon"><i class="fas fa-puzzle-piece"></i></div>
      <h3>Modul Praktik</h3>
      <p>Sebagai Bahan Ajar Sistematis</p>
    </div>
  </div>
</section>

<!-- KATEGORI UTAMA -->
<section class="kategori-section" id="kategori">
  <div class="section-title">
    <h2>Kategori Utama</h2>
    <p>Menyampaikan Kategori – kategori Unggulan</p>
  </div>
  <div class="kategori-grid">
    <div class="kategori-card k1">
      <div class="kategori-overlay"></div>
      <div class="kategori-name"><i class="fas fa-book"></i> Buku Fiksi Novel</div>
    </div>
    <div class="kategori-card k2">
      <div class="kategori-overlay"></div>
      <div class="kategori-name"><i class="fas fa-comic-book"></i> Buku Fiksi Komik</div>
    </div>
    <div class="kategori-card k3">
      <div class="kategori-overlay"></div>
      <div class="kategori-name"><i class="fas fa-code"></i> Buku Non Fiksi Pemrograman</div>
    </div>
    <div class="kategori-card k4">
      <div class="kategori-overlay"></div>
      <div class="kategori-name"><i class="fas fa-landmark"></i> Buku Non Fiksi Sejarah</div>
    </div>
  </div>
</section>

<!-- TESTIMONI -->
<section style="background:#fff;">
  <div class="section-title">
    <h2>Testimoni Pelanggan</h2>
  </div>
  <div class="testimoni-grid">
    <div class="testi-card">
      <div class="testi-avatar"><i class="fas fa-user"></i></div>
      <p class="testi-text">"Sangat puas dengan buku yang di sediakan dan selalu lengkap-lengkap menarik untuk dibaca"</p>
      <div class="testi-name">Grace Syanatanugsih</div>
    </div>
    <div class="testi-card">
      <div class="testi-avatar"><i class="fas fa-user"></i></div>
      <p class="testi-text">"Isi bukunya sangat bagus untuk dibaca dan bisa menenangkan pikiran dengan membaca buku"</p>
      <div class="testi-name">Fauzian Prasetiyan</div>
    </div>
    <div class="testi-card">
      <div class="testi-avatar"><i class="fas fa-user"></i></div>
      <p class="testi-text">"Buku ini sangat membantu untuk mudah belajar melalui jalur jenis dengan adanya perpustakaan ini aku dapat memudahkan penggunaan buku"</p>
      <div class="testi-name">Angelina Matangsyih</div>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer id="kontak">
  <div class="footer-grid">
    <div class="footer-brand">
      <div class="logo">
        <i class="fas fa-book-open" style="color:var(--gold);font-size:28px;"></i>
        <span>YOMULIB</span>
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
  <div class="footer-bottom">© 2026 YomuLib. All rights reserved.</div>
</footer>

<script>
// Check if already logged in
if(localStorage.getItem('yomulib_user')) {
  document.querySelector('.nav-btn').textContent = 'Dashboard';
  document.querySelector('.nav-btn').href = 'dashboard';
}
</script>
</body>
</html>