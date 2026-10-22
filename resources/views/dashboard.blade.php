@extends('layouts.app')
@section('title','Beranda')
@section('content')
<!-- Hero -->
<div style="background:linear-gradient(135deg,var(--navy-dark) 0%,var(--navy-light) 100%);border-radius:20px;padding:40px 48px;margin-bottom:32px;display:flex;align-items:center;gap:32px;overflow:hidden;position:relative">
  <div style="position:absolute;right:40px;top:50%;transform:translateY(-50%);font-size:8rem;opacity:.06">📚</div>
  <div style="flex:1;position:relative">
    <div style="font-size:.7rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--gold);margin-bottom:10px">Selamat datang di</div>
    <div style="font-family:'Playfair Display',serif;font-size:2rem;color:#fff;line-height:1.2;margin-bottom:10px">{{ \App\Models\Setting::get('navbar_site_name','YOMULIB') }}</div>
    <div style="font-size:.9rem;color:rgba(255,255,255,.6);margin-bottom:20px">Perpustakaan digital untuk membaca, belajar, dan berkembang.</div>
    <a href="{{ route('buku') }}" class="btn-primary-gold"><i class="fas fa-search"></i>Jelajahi Koleksi</a>
  </div>
</div>

<!-- Categories -->
@if($categories->count())
<div style="margin-bottom:32px">
  <div style="font-family:'Playfair Display',serif;font-size:1.1rem;color:var(--ink);margin-bottom:14px">Kategori</div>
  <div style="display:flex;gap:10px;flex-wrap:wrap">
    @foreach($categories as $cat)
    <a href="{{ route('buku',['category'=>$cat->slug]) }}" style="display:flex;align-items:center;gap:8px;padding:8px 16px;border-radius:10px;background:var(--white);border:1.5px solid var(--border);font-size:.78rem;font-weight:600;color:var(--ink);transition:all .15s" onmouseover="this.style.borderColor='var(--gold)';this.style.color='var(--gold)'" onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--ink)'">
      <span style="font-size:1.1rem">{{ $cat->icon ?? '📚' }}</span>{{ $cat->name }}
      <span style="font-size:.65rem;color:var(--muted);font-weight:400">({{ $cat->books_count }})</span>
    </a>
    @endforeach
  </div>
</div>
@endif

<!-- Trending -->
@if($trendingBooks->count())
<div style="margin-bottom:32px">
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
    <div style="font-family:'Playfair Display',serif;font-size:1.1rem">🔥 Paling Banyak Dipinjam</div>
    <a href="{{ route('buku') }}" style="font-size:.75rem;font-weight:600;color:var(--gold)">Lihat semua →</a>
  </div>
  <div class="book-grid">
    @foreach($trendingBooks as $book)
    <a href="{{ route('buku.show',$book) }}" class="book-card">
      @if($book->cover)<img src="{{ asset('storage/'.$book->cover) }}" class="book-cover">
      @else<div class="book-cover-placeholder">📚</div>@endif
      <div class="book-meta">
        <div class="book-title">{{ $book->title }}</div>
        <div class="book-author">{{ $book->author }}</div>
        <div style="display:flex;align-items:center;justify-content:space-between;margin-top:6px">
          @if($book->isAvailable())<span class="dl-badge dl-badge-green">Tersedia</span>@else<span class="dl-badge dl-badge-red">Habis</span>@endif
          <span style="font-size:.68rem;color:var(--muted)">{{ $book->borrowed_count }}×</span>
        </div>
      </div>
    </a>
    @endforeach
  </div>
</div>
@endif

<!-- New Books -->
@if($newBooks->count())
<div>
  <div style="font-family:'Playfair Display',serif;font-size:1.1rem;margin-bottom:14px">✨ Baru Ditambahkan</div>
  <div class="book-grid">
    @foreach($newBooks as $book)
    <a href="{{ route('buku.show',$book) }}" class="book-card">
      @if($book->cover)<img src="{{ asset('storage/'.$book->cover) }}" class="book-cover">
      @else<div class="book-cover-placeholder">📖</div>@endif
      <div class="book-meta">
        <div class="book-title">{{ $book->title }}</div>
        <div class="book-author">{{ $book->author }}</div>
        <div style="margin-top:6px">@if($book->isAvailable())<span class="dl-badge dl-badge-green">Tersedia</span>@else<span class="dl-badge dl-badge-red">Habis</span>@endif</div>
      </div>
    </a>
    @endforeach
  </div>
</div>
@endif
@endsection
