@extends('layouts.admin')
@section('title','Ulasan')
@section('page-title','Manajemen Ulasan')
@section('content')
<div class="data-table-wrap">
<table>
<thead><tr><th>#</th><th>Buku</th><th>Pemberi Ulasan</th><th>Rating</th><th>Komentar</th><th>Tanggal</th><th>Aksi</th></tr></thead>
<tbody>
@forelse($reviews as $i=>$r)
<tr>
  <td style="color:var(--muted-2);font-size:.72rem">{{ $reviews->firstItem()+$i }}</td>
  <td style="font-size:.82rem;font-weight:600">{{ Str::limit($r->book->title??'-',35) }}</td>
  <td style="font-size:.82rem">{{ $r->user->username??'-' }}</td>
  <td>
    <div style="display:flex;gap:2px">
      @for($s=1;$s<=5;$s++)<i class="fas fa-star" style="font-size:.65rem;color:{{ $s<=$r->rating?'var(--gold)':'var(--border-2)' }}"></i>@endfor
    </div>
  </td>
  <td style="font-size:.78rem;color:var(--muted);max-width:260px">{{ Str::limit($r->comment,80,'…') ?? '<em>tanpa komentar</em>' }}</td>
  <td style="font-size:.78rem;color:var(--muted-2)">{{ $r->created_at->format('d M Y') }}</td>
  <td>
    <form method="POST" action="{{ route('admin.reviews.destroy',$r) }}" onsubmit="return confirm('Hapus ulasan ini?')">@csrf @method('DELETE')
      <button type="submit" class="action-btn danger"><i class="fas fa-trash"></i></button>
    </form>
  </td>
</tr>
@empty<tr><td colspan="7" style="text-align:center;padding:48px;color:var(--muted)">Belum ada ulasan.</td></tr>
@endforelse
</tbody>
</table>
@if($reviews->hasPages())
<div class="dl-pagination"><div class="page-info">{{ $reviews->from() }}–{{ $reviews->to() }} dari {{ $reviews->total() }}</div>{{ $reviews->links() }}</div>
@endif
</div>
@endsection
