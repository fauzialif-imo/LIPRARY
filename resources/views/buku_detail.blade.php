@extends('layouts.app')
@section('title',$book->title)
@section('content')
<a href="{{ route('buku') }}" style="display:inline-flex;align-items:center;gap:6px;font-size:.78rem;color:var(--muted);margin-bottom:20px"><i class="fas fa-arrow-left"></i>Kembali ke Koleksi</a>
<div style="display:grid;grid-template-columns:200px 1fr;gap:32px;margin-bottom:32px">
  <div>
    @if($book->cover)<img src="{{ asset('storage/'.$book->cover) }}" style="width:100%;border-radius:10px;box-shadow:0 8px 24px rgba(13,27,62,.2)">
    @else<div style="width:100%;aspect-ratio:2/3;background:var(--navy);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:3rem">📚</div>@endif

    @php $activeBorrow = auth()->check() ? \App\Models\Borrowing::where('user_id',auth()->id())->where('book_id',$book->id)->whereNotIn('status',['returned','rejected'])->first() : null; @endphp

    <div style="margin-top:14px;display:flex;flex-direction:column;gap:8px">
      @if($activeBorrow)
        <div class="dl-badge dl-badge-amber" style="justify-content:center">Sedang Dipinjam</div>
      @elseif($book->isAvailable())
        <a href="{{ route('borrow.create',['book_id'=>$book->id]) }}" class="btn-primary-gold" style="justify-content:center;width:100%"><i class="fas fa-book-reader"></i>Pinjam Buku</a>
      @else
        <div style="padding:10px;background:var(--surface);border-radius:10px;text-align:center;font-size:.8rem;color:var(--muted)">Stok Habis</div>
      @endif
      <form method="POST" action="{{ route('buku.collect',$book) }}">@csrf
        <button type="submit" style="width:100%;height:38px;border-radius:10px;border:1.5px solid var(--border);background:var(--white);font-size:.78rem;font-weight:600;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:7px;color:var(--ink);transition:all .15s" onmouseover="this.style.borderColor='var(--gold)'" onmouseout="this.style.borderColor='var(--border)'">
          <i class="fas {{ $userCollection?'fa-heart':'fa-heart' }}" style="color:{{ $userCollection?'#e74c3c':'var(--muted-2)' }}"></i>
          {{ $userCollection ? 'Hapus Koleksi' : 'Simpan ke Koleksi' }}
        </button>
      </form>
    </div>
  </div>
  <div>
    <span class="dl-badge dl-badge-blue" style="margin-bottom:10px;display:inline-flex">{{ $book->category->name??'-' }}</span>
    <h1 style="font-family:'Playfair Display',serif;font-size:1.6rem;color:var(--ink);margin-bottom:6px;line-height:1.3">{{ $book->title }}</h1>
    <div style="font-size:.9rem;color:var(--muted);margin-bottom:16px">{{ $book->author }} • {{ $book->publisher }}@if($book->publish_date) • {{ $book->publish_date->year }}@endif</div>

    <div style="display:flex;gap:6px;margin-bottom:18px;flex-wrap:wrap">
      @if($book->isAvailable())<span class="dl-badge dl-badge-green">{{ $book->stock }} tersedia</span>@else<span class="dl-badge dl-badge-red">Stok habis</span>@endif
      @if($book->isbn)<span class="dl-badge dl-badge-muted">ISBN: {{ $book->isbn }}</span>@endif
      @if($book->pages)<span class="dl-badge dl-badge-muted">{{ $book->pages }} halaman</span>@endif
      @if($book->language)<span class="dl-badge dl-badge-muted">{{ $book->language }}</span>@endif
    </div>

    <div style="display:flex;align-items:center;gap:6px;margin-bottom:16px">
      @for($s=1;$s<=5;$s++)<i class="fas fa-star" style="color:{{ $s<=$book->avgRating()?'var(--gold)':'var(--border)' }};font-size:.9rem"></i>@endfor
      <span style="font-size:.82rem;color:var(--muted);margin-left:4px">{{ number_format($book->avgRating(),1) }} dari {{ $reviews->count() }} ulasan</span>
    </div>

    @if($book->synopsis)
    <div style="font-size:.88rem;line-height:1.7;color:var(--ink-2,#2d3055);background:var(--bg);border-radius:10px;padding:16px">{{ $book->synopsis }}</div>
    @endif
  </div>
</div>

<!-- Reviews -->
<div class="dl-card-p">
  <div style="font-family:'Playfair Display',serif;font-size:1rem;margin-bottom:16px">Ulasan Pembaca ({{ $reviews->count() }})</div>
  @forelse($reviews as $r)
  <div style="padding:14px 0;border-bottom:1px solid var(--border)">
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px">
      <div style="width:32px;height:32px;border-radius:50%;background:var(--gold-pale,rgba(201,168,76,.1));display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:700;color:var(--gold)">{{ strtoupper(substr($r->user->username??'?',0,1)) }}</div>
      <div>
        <div style="font-size:.82rem;font-weight:600">{{ $r->user->username??'Anonim' }}</div>
        <div style="display:flex;gap:2px">@for($s=1;$s<=5;$s++)<i class="fas fa-star" style="font-size:.6rem;color:{{ $s<=$r->rating?'var(--gold)':'var(--border)' }}"></i>@endfor</div>
      </div>
      <span style="font-size:.7rem;color:var(--muted);margin-left:auto">{{ $r->created_at->format('d M Y') }}</span>
    </div>
    @if($r->comment)<p style="font-size:.82rem;color:var(--muted);margin-left:42px">{{ $r->comment }}</p>@endif
  </div>
  @empty<p style="color:var(--muted);font-size:.82rem">Belum ada ulasan.</p>
  @endforelse
</div>

<!-- Related -->
@if($relatedBooks->count())
<div style="margin-top:28px">
  <div style="font-family:'Playfair Display',serif;font-size:1rem;margin-bottom:14px">Buku Terkait</div>
  <div class="book-grid">
    @foreach($relatedBooks as $rb)
    <a href="{{ route('buku.show',$rb) }}" class="book-card">
      @if($rb->cover)<img src="{{ asset('storage/'.$rb->cover) }}" class="book-cover">
      @else<div class="book-cover-placeholder">📚</div>@endif
      <div class="book-meta">
        <div class="book-title">{{ $rb->title }}</div>
        <div class="book-author">{{ $rb->author }}</div>
      </div>
    </a>
    @endforeach
  </div>
</div>
@endif
@endsection
