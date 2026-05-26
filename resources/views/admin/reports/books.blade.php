@extends('layouts.admin')
@section('title','Laporan Buku')
@section('page-title','Laporan Buku')
@section('content')
<div class="table-toolbar">
  <form method="GET" style="display:flex;gap:10px;flex-wrap:wrap">
    <select class="tb-select" name="category_id"><option value="">Semua Kategori</option>@foreach($categories as $c)<option value="{{ $c->id }}" {{ request('category_id')==$c->id?'selected':'' }}>{{ $c->name }}</option>@endforeach</select>
    <button type="submit" class="btn-dl-secondary"><i class="fas fa-filter"></i>Filter</button>
    <div class="tb-spacer"></div>
    <a href="{{ route('admin.reports.books',array_merge(request()->all(),['format'=>'csv'])) }}" class="btn-dl-secondary"><i class="fas fa-file-csv"></i>CSV</a>
    <a href="{{ route('admin.reports.books',array_merge(request()->all(),['format'=>'pdf'])) }}" class="btn-dl-secondary"><i class="fas fa-file-pdf"></i>PDF</a>
  </form>
</div>
<div class="data-table-wrap">
<table>
<thead><tr><th>#</th><th>Judul</th><th>Penulis</th><th>Penerbit</th><th>Kategori</th><th>ISBN</th><th>Stok</th><th>Dipinjam</th><th>Rating</th></tr></thead>
<tbody>
@forelse($books as $i=>$b)
<tr>
  <td style="color:var(--muted-2);font-size:.72rem">{{ $i+1 }}</td>
  <td style="font-weight:600;font-size:.82rem">{{ $b->title }}</td>
  <td style="font-size:.8rem">{{ $b->author }}</td>
  <td style="font-size:.78rem;color:var(--muted)">{{ $b->publisher }}</td>
  <td><span class="dl-badge dl-badge-blue">{{ $b->category->name??'-' }}</span></td>
  <td style="font-size:.72rem;color:var(--muted-2)">{{ $b->isbn??'-' }}</td>
  <td>@if($b->stock>0)<span class="dl-badge dl-badge-green">{{ $b->stock }}</span>@else<span class="dl-badge dl-badge-red">0</span>@endif</td>
  <td style="text-align:center">{{ $b->borrowed_count }}</td>
  <td style="text-align:center">{{ number_format($b->avgRating(),1) }}</td>
</tr>
@empty<tr><td colspan="9" style="text-align:center;padding:40px;color:var(--muted)">Tidak ada data.</td></tr>
@endforelse
</tbody>
</table>
</div>
<div style="margin-top:28px;display:flex;justify-content:space-between;align-items:flex-end">
  <div style="text-align:left">
    <div style="height:70px;width:240px;border-bottom:1px solid #000"></div>
    <div style="margin-top:6px;font-size:.9rem">Petugas<br><strong>{{ auth()->user()->username }}</strong></div>
  </div>
  <div style="text-align:right">
    <div style="height:70px;width:240px;border-bottom:1px solid #000;margin-left:auto"></div>
    <div style="margin-top:6px;font-size:.9rem">Admin<br><strong>_____________________</strong></div>
  </div>
</div>
@endsection
