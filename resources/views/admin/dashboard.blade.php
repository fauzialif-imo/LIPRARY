@extends('layouts.admin')
@section('title','Dashboard')
@section('page-title','Dashboard')
@section('page-subtitle','Selamat datang, '.auth()->user()->username)
@section('content')
@php
$statCards = [
  ['label'=>'Total Buku','value'=>$stats['total_books'],'icon'=>'fas fa-book','color'=>'var(--gold)','bg'=>'rgba(201,168,76,.1)'],
  ['label'=>'Total Member','value'=>$stats['total_users'],'icon'=>'fas fa-users','color'=>'var(--blue)','bg'=>'var(--blue-pale)'],
  ['label'=>'Dipinjam Aktif','value'=>$stats['active_borrowings'],'icon'=>'fas fa-bookmark','color'=>'var(--green)','bg'=>'var(--green-pale)'],
  ['label'=>'Perlu Konfirmasi','value'=>$stats['pending_borrow']+$stats['pending_return'],'icon'=>'fas fa-bell','color'=>'var(--red)','bg'=>'var(--red-pale)'],
];
@endphp
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px">
  @foreach($statCards as $c)
  <div class="dl-card-p" style="display:flex;align-items:center;gap:14px">
    <div style="width:44px;height:44px;border-radius:12px;background:{{$c['bg']}};display:flex;align-items:center;justify-content:center;flex-shrink:0">
      <i class="{{ $c['icon'] }}" style="color:{{$c['color']}};font-size:1.1rem"></i>
    </div>
    <div>
      <div style="font-size:1.5rem;font-weight:700;color:var(--ink);line-height:1">{{ number_format($c['value']) }}</div>
      <div style="font-size:.68rem;font-weight:600;color:var(--muted);margin-top:2px;letter-spacing:.02em">{{ $c['label'] }}</div>
    </div>
  </div>
  @endforeach
</div>

@if($stats['pending_borrow']>0 || $stats['pending_return']>0)
<div class="dl-alert dl-alert-gold" style="margin-bottom:20px">
  <i class="fas fa-exclamation-triangle"></i>
  Ada <strong>{{ $stats['pending_borrow'] }}</strong> pengajuan pinjam & <strong>{{ $stats['pending_return'] }}</strong> pengajuan kembali menunggu konfirmasi.
  <a href="{{ route('admin.borrowings.index') }}" style="margin-left:8px;font-weight:700;text-decoration:underline">Proses sekarang →</a>
</div>
@endif

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">
  <div class="dl-card-p">
    <div class="section-title" style="margin-bottom:18px">Peminjaman Terkini</div>
    @forelse($recentBorrowings as $b)
    <div style="display:flex;align-items:center;gap:12px;padding:10px 0;border-bottom:1px solid var(--border);font-size:.82rem">
      <div style="width:34px;height:34px;border-radius:50%;background:var(--gold-pale);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--gold);font-size:.8rem;flex-shrink:0">{{ strtoupper(substr($b->user->username,0,1)) }}</div>
      <div style="flex:1;min-width:0">
        <div style="font-weight:600;color:var(--ink);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $b->book->title }}</div>
        <div style="color:var(--muted);font-size:.72rem">{{ $b->user->username }}</div>
      </div>
      @php $cls = match($b->status){'pending'=>'dl-badge-amber','approved'=>'dl-badge-green','returned'=>'dl-badge-muted','rejected'=>'dl-badge-red',default=>'dl-badge-blue'}; @endphp
      <span class="dl-badge {{ $cls }}">{{ $b->status_label }}</span>
    </div>
    @empty<p style="color:var(--muted);font-size:.82rem">Belum ada peminjaman.</p>@endforelse
  </div>

  <div class="dl-card-p">
    <div class="section-title" style="margin-bottom:18px">Buku Terpopuler</div>
    @foreach($popularBooks as $i=>$b)
    <div style="display:flex;align-items:center;gap:12px;padding:8px 0;border-bottom:1px solid var(--border);font-size:.82rem">
      <div style="width:22px;height:22px;border-radius:50%;background:var(--navy);color:var(--gold);font-size:.6rem;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0">{{ $i+1 }}</div>
      <div style="flex:1;min-width:0">
        <div style="font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $b->title }}</div>
        <div style="color:var(--muted);font-size:.72rem">{{ $b->author }}</div>
      </div>
      <div style="font-size:.72rem;font-weight:700;color:var(--gold)">{{ $b->borrowed_count }}×</div>
    </div>
    @endforeach
  </div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// chart can be added later
</script>
@endpush
