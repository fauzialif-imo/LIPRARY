@extends('layouts.admin')
@section('title','Laporan Anggota')
@section('page-title','Laporan Anggota')
@section('content')
<div class="table-toolbar">
  <div class="tb-spacer"></div>
  <a href="{{ route('admin.reports.users',['format'=>'csv']) }}" class="btn-dl-secondary"><i class="fas fa-file-csv"></i>CSV</a>
  <a href="{{ route('admin.reports.users',['format'=>'pdf']) }}" class="btn-dl-secondary"><i class="fas fa-file-pdf"></i>PDF</a>
</div>
<div class="data-table-wrap">
<table>
<thead><tr><th>#</th><th>Username</th><th>Email</th><th>Alamat</th><th>Status</th><th>Total Pinjam</th></tr></thead>
<tbody>
@forelse($users as $i=>$u)
<tr>
  <td style="color:var(--muted-2);font-size:.72rem">{{ $i+1 }}</td>
  <td style="font-weight:600;font-size:.82rem">{{ $u->username }}</td>
  <td style="font-size:.82rem">{{ $u->email }}</td>
  <td style="font-size:.78rem;color:var(--muted)">{{ $u->alamat??'-' }}</td>
  <td>@if($u->is_active)<span class="dl-badge dl-badge-green">Aktif</span>@else<span class="dl-badge dl-badge-red">Nonaktif</span>@endif</td>
  <td style="text-align:center;font-weight:600">{{ $u->borrowings_count }}</td>
</tr>
@empty<tr><td colspan="6" style="text-align:center;padding:40px;color:var(--muted)">Tidak ada data.</td></tr>
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
