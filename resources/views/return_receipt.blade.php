@extends('layouts.app')
@section('title','Bukti Pengembalian')
@section('content')
<div style="max-width:560px;margin:0 auto">
  <div class="dl-card-p">
    <div style="text-align:center;margin-bottom:20px;padding-bottom:16px;border-bottom:1px solid var(--border)">
      <div style="font-family:'Playfair Display',serif;font-size:1.3rem;color:var(--navy)">YOMULIB</div>
      <div style="font-size:.7rem;color:var(--muted);letter-spacing:.08em;text-transform:uppercase">Bukti Pengembalian</div>
    </div>
    @php $b = $borrowing; @endphp
    <div style="display:grid;gap:10px;font-size:.85rem">
      @foreach(['Peminjam'=>$b->user->username,'Buku'=>$b->book->title,'Tgl Pinjam'=>$b->borrow_date->format('d M Y'),'Tgl Kembali'=>$b->return_date->format('d M Y'),'Tgl Aktual'=>$b->actual_return_date?$b->actual_return_date->format('d M Y'):'-','Status'=>$b->status_label,'Denda'=>$b->fine_amount>0?'Rp '.number_format($b->fine_amount,0,',','.'):'-'] as $k=>$v)
      <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--border)"><span style="color:var(--muted);font-size:.78rem">{{ $k }}</span><span style="font-weight:600;{{ $k==='Denda'&&$b->fine_amount>0?'color:#c0392b':'' }}">{{ $v }}</span></div>
      @endforeach
    </div>
    <div style="margin-top:20px;display:flex;gap:10px;justify-content:center">
      <button onclick="window.print()" class="btn-primary-gold"><i class="fas fa-print"></i>Cetak</button>
      <a href="{{ route('profile') }}" class="btn-outline-navy"><i class="fas fa-arrow-left"></i>Kembali</a>
    </div>
  </div>
</div>
@endsection
