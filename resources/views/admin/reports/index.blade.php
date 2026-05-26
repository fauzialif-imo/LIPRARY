@extends('layouts.admin')
@section('title','Laporan')
@section('page-title','Generate Laporan')
@section('content')
@php
  if(auth()->user()->role === 'petugas'){
    $cards = [
      ['route'=>'admin.reports.borrowings','icon'=>'fas fa-exchange-alt','title'=>'Laporan Peminjaman','desc'=>'Histori semua transaksi peminjaman.','color'=>'var(--blue)','bg'=>'var(--blue-pale)','params'=>[]],
      ['route'=>'admin.reports.borrowings','icon'=>'fas fa-undo-alt','title'=>'Laporan Pengembalian','desc'=>'Daftar pengembalian buku (status dikembalikan).','color'=>'var(--green)','bg'=>'var(--green-pale)','params'=>['status'=>'returned']],
    ];
    $cols = 2;
  }else{
    $cards = [
      ['route'=>'admin.reports.books','icon'=>'fas fa-book','title'=>'Laporan Buku','desc'=>'Data seluruh koleksi buku, stok, dan statistik peminjaman.','color'=>'var(--gold)','bg'=>'rgba(201,168,76,.1)','params'=>[]],
      ['route'=>'admin.reports.borrowings','icon'=>'fas fa-exchange-alt','title'=>'Laporan Peminjaman','desc'=>'Histori semua transaksi peminjaman dan pengembalian buku.','color'=>'var(--blue)','bg'=>'var(--blue-pale)','params'=>[]],
      ['route'=>'admin.reports.users','icon'=>'fas fa-users','title'=>'Laporan Anggota','desc'=>'Data seluruh anggota dan statistik aktivitas mereka.','color'=>'var(--green)','bg'=>'var(--green-pale)','params'=>[]],
      ['route'=>'admin.reports.borrowings','icon'=>'fas fa-undo-alt','title'=>'Laporan Pengembalian','desc'=>'Daftar pengembalian buku (status dikembalikan).','color'=>'var(--green)','bg'=>'var(--green-pale)','params'=>['status'=>'returned']],
      ['route'=>'admin.reports.staff','icon'=>'fas fa-user-tie','title'=>'Laporan Petugas','desc'=>'Data seluruh petugas perpustakaan.','color'=>'var(--amber)','bg'=>'var(--amber-pale)','params'=>[]],
    ];
    $cols = count($cards);
  }
@endphp

<div style="display:grid;grid-template-columns:repeat({{ $cols }},1fr);gap:20px">
  @foreach($cards as $r)
  <div class="dl-card-p" style="display:flex;flex-direction:column;gap:14px">
    <div style="width:48px;height:48px;border-radius:14px;background:{{ $r['bg'] }};display:flex;align-items:center;justify-content:center">
      <i class="{{ $r['icon'] }}" style="color:{{ $r['color'] }};font-size:1.2rem"></i>
    </div>
    <div>
      <div style="font-family:'Playfair Display',serif;font-size:1rem;font-weight:600;color:var(--ink)">{{ $r['title'] }}</div>
      <div style="font-size:.78rem;color:var(--muted);margin-top:4px">{{ $r['desc'] }}</div>
    </div>
    <div style="display:flex;gap:8px;margin-top:auto">
      <a href="{{ route($r['route'], $r['params'] ?? []) }}" class="btn-dl-secondary" style="flex:1;justify-content:center"><i class="fas fa-eye"></i>Lihat</a>
      <a href="{{ route($r['route'], array_merge($r['params'] ?? [], ['format'=>'csv'])) }}" class="btn-dl-secondary"><i class="fas fa-file-csv"></i>CSV</a>
      <a href="{{ route($r['route'], array_merge($r['params'] ?? [], ['format'=>'pdf', 'download'=>'1'])) }}" class="btn-dl-secondary" download><i class="fas fa-file-pdf"></i>PDF</a>
    </div>
  </div>
  @endforeach
</div>
@endsection
