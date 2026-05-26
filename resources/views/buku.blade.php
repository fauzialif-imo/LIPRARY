@extends('layouts.app')
@section('title','Koleksi Buku')
@section('content')
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px">
  <div style="font-family:'Playfair Display',serif;font-size:1.3rem">Koleksi Buku</div>
</div>
<form method="GET" style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:24px">
  <div style="display:flex;align-items:center;gap:8px;background:var(--white);border:1.5px solid var(--border);border-radius:10px;padding:0 14px;height:40px;flex:1;max-width:360px;transition:all .2s" onfocusin="this.style.borderColor='var(--gold)'" onfocusout="this.style.borderColor='var(--border)'">
    <i class="fas fa-search" style="color:var(--muted-2);font-size:.8rem"></i>
    <input name="search" value="{{ request('search') }}" placeholder="Cari judul atau penulis…" style="flex:1;border:none;outline:none;font-size:.83rem;background:transparent">
  </div>
  <select name="category" class="field-select" style="width:auto;min-width:160px;height:40px" onchange="this.form.submit()">
    <option value="">Semua Kategori</option>
    @foreach($categories as $cat)
      <option value="{{ $cat->slug }}" {{ $selectedCategory===$cat->slug?'selected':'' }}>{{ $cat->icon??'📚' }} {{ $cat->name }}</option>
    @endforeach
  </select>
  <button type="submit" class="btn-primary-gold" style="height:40px"><i class="fas fa-search"></i>Cari</button>
</form>
@if($books->count())
<div class="book-grid" style="margin-bottom:24px">
  @foreach($books as $book)
  <a href="{{ route('buku.show',$book) }}" class="book-card">
    @if($book->cover)<img src="{{ asset('storage/'.$book->cover) }}" class="book-cover">
    @else<div class="book-cover-placeholder">📚</div>@endif
    <div class="book-meta">
      <div class="book-title">{{ $book->title }}</div>
      <div class="book-author">{{ $book->author }}</div>
      <div style="margin-top:6px;display:flex;align-items:center;justify-content:space-between">
        @if($book->isAvailable())<span class="dl-badge dl-badge-green">Tersedia</span>@else<span class="dl-badge dl-badge-red">Habis</span>@endif
        <span class="dl-badge dl-badge-blue">{{ $book->category->name??'-' }}</span>
      </div>
    </div>
  </a>
  @endforeach
</div>
{{ $books->links() }}
@else
<div style="text-align:center;padding:80px 20px;color:var(--muted)">
  <div style="font-size:3rem;margin-bottom:12px;opacity:.3">📚</div>
  <div style="font-size:1rem;font-weight:600">Buku tidak ditemukan</div>
  <div style="font-size:.82rem;margin-top:4px">Coba kata kunci atau filter lain.</div>
</div>
@endif
@endsection
