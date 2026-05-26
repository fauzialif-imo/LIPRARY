@extends('layouts.admin')
@section('title','Kelola Buku')
@section('page-title','Kelola Buku')
@section('content')
<div class="table-toolbar">
  <form class="tb-search" method="GET">
    <i class="fas fa-search" style="color:var(--muted-2);font-size:.8rem"></i>
    <input name="search" value="{{ request('search') }}" placeholder="Cari judul, penulis, ISBN…">
  </form>
  <select class="tb-select" name="category_id" onchange="this.form.submit()" form="filterForm">
    <option value="">Semua Kategori</option>
    @foreach($categories as $cat)<option value="{{ $cat->id }}" {{ request('category_id')==$cat->id?'selected':'' }}>{{ $cat->name }} ({{ $cat->books_count }})</option>@endforeach
  </select>
  <form id="filterForm" method="GET" style="display:none"></form>
  <div class="tb-spacer"></div>
  <a href="{{ route('admin.books.create') }}" class="btn-dl-primary"><i class="fas fa-plus"></i>Tambah Buku</a>
</div>
<div class="data-table-wrap">
  <table>
    <thead><tr>
      <th>#</th><th>Buku</th><th>Kategori</th><th>ISBN</th><th>Stok</th><th>Dipinjam</th><th>Rating</th><th>Aksi</th>
    </tr></thead>
    <tbody>
    @forelse($books as $i=>$book)
    <tr>
      <td style="color:var(--muted-2);font-size:.72rem">{{ $books->firstItem()+$i }}</td>
      <td>
        <div class="book-col">
          @if($book->cover)<img src="{{ asset('storage/'.$book->cover) }}" class="mini-cover">@else<div class="mini-cover" style="background:var(--navy);display:flex;align-items:center;justify-content:center;font-size:.6rem;color:var(--gold)">📚</div>@endif
          <div>
            <div style="font-weight:600;font-size:.82rem">{{ Str::limit($book->title,40) }}</div>
            <div style="font-size:.7rem;color:var(--muted)">{{ $book->author }}</div>
          </div>
        </div>
      </td>
      <td><span class="dl-badge dl-badge-blue">{{ $book->category->name ?? '-' }}</span></td>
      <td style="font-size:.72rem;color:var(--muted-2)">{{ $book->isbn ?? '-' }}</td>
      <td>
        @if($book->stock>0)<span class="dl-badge dl-badge-green">{{ $book->stock }} ada</span>
        @else<span class="dl-badge dl-badge-red">Habis</span>@endif
      </td>
      <td style="text-align:center;font-size:.82rem">{{ $book->borrowed_count }}×</td>
      <td style="text-align:center">
        <div style="display:flex;align-items:center;gap:2px;justify-content:center">
          @for($s=1;$s<=5;$s++)<i class="fas fa-star" style="font-size:.55rem;color:{{ $s<=$book->avgRating()?'var(--gold)':'var(--border-2)' }}"></i>@endfor
          <span style="font-size:.7rem;color:var(--muted);margin-left:3px">{{ number_format($book->avgRating(),1) }}</span>
        </div>
      </td>
      <td>
        <div class="row-actions">
          <a href="{{ route('admin.books.edit',$book) }}" class="action-btn edit" title="Edit"><i class="fas fa-edit"></i></a>
          <form method="POST" action="{{ route('admin.books.destroy',$book) }}" onsubmit="return confirm('Hapus buku {{ addslashes($book->title) }}?')">@csrf @method('DELETE')
            <button type="submit" class="action-btn danger"><i class="fas fa-trash"></i></button>
          </form>
        </div>
      </td>
    </tr>
    @empty
    <tr><td colspan="8" style="text-align:center;padding:48px;color:var(--muted)"><i class="fas fa-book-open" style="font-size:2rem;margin-bottom:8px;display:block;opacity:.3"></i>Belum ada buku.</td></tr>
    @endforelse
    </tbody>
  </table>
  @if($books->hasPages())
  <div class="dl-pagination"><div class="page-info">{{ $books->from() }}–{{ $books->to() }} dari {{ $books->total() }}</div>{{ $books->links() }}</div>
  @endif
</div>
@endsection
