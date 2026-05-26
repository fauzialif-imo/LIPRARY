@extends('layouts.admin')
@section('title','Laporan Peminjaman')
@section('page-title','Laporan Peminjaman')
@section('content')
<div class="table-toolbar">
  <form method="GET" style="display:flex;gap:10px;flex-wrap:wrap">
    <select class="tb-select" name="status"><option value="">Semua Status</option><option value="approved" {{ request('status')==='approved'?'selected':'' }}>Dipinjam</option><option value="returned" {{ request('status')==='returned'?'selected':'' }}>Dikembalikan</option></select>
    <input type="date" class="tb-select" name="from" value="{{ request('from') }}" title="Dari tanggal">
    <input type="date" class="tb-select" name="to" value="{{ request('to') }}" title="Sampai tanggal">
    <button type="submit" class="btn-dl-secondary"><i class="fas fa-filter"></i>Filter</button>
    <div class="tb-spacer"></div>
    <a href="{{ route('admin.reports.borrowings',array_merge(request()->all(),['format'=>'csv'])) }}" class="btn-dl-secondary"><i class="fas fa-file-csv"></i>CSV</a>
    <a href="{{ route('admin.reports.borrowings',array_merge(request()->all(),['format'=>'pdf'])) }}" class="btn-dl-secondary"><i class="fas fa-file-pdf"></i>PDF</a>
  </form>
</div>
<div class="data-table-wrap">
<table>
<thead><tr><th>#</th><th>Peminjam</th><th>Buku</th><th>Tgl Pinjam</th><th>Tgl Kembali</th><th>Tgl Aktual</th><th>Status</th><th>Denda</th></tr></thead>
<tbody>
@forelse($borrowings as $i=>$b)
<tr>
  <td style="color:var(--muted-2);font-size:.72rem">{{ $i+1 }}</td>
  <td><div style="font-weight:600;font-size:.82rem">{{ $b->user->username }}</div><div style="font-size:.7rem;color:var(--muted)">{{ $b->user->email }}</div></td>
  <td style="font-size:.82rem">{{ Str::limit($b->book->title,35) }}</td>
  <td style="font-size:.8rem">{{ $b->borrow_date->format('d/m/Y') }}</td>
  <td style="font-size:.8rem">{{ $b->return_date->format('d/m/Y') }}</td>
  <td style="font-size:.8rem">{{ $b->actual_return_date?$b->actual_return_date->format('d/m/Y'):'—' }}</td>
  <td>@php $cls=match($b->status){'pending'=>'dl-badge-amber','approved'=>'dl-badge-green','returning'=>'dl-badge-blue','returned'=>'dl-badge-muted','rejected'=>'dl-badge-red',default=>'dl-badge-muted'}@endphp<span class="dl-badge {{ $cls }}">{{ $b->status_label }}</span></td>
  <td style="font-size:.8rem">{{ $b->fine_amount>0?'Rp '.number_format($b->fine_amount,0,',','.'):'—' }}</td>
</tr>
@empty<tr><td colspan="8" style="text-align:center;padding:40px;color:var(--muted)">Tidak ada data.</td></tr>
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
