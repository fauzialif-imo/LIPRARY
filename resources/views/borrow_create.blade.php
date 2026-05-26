@extends('layouts.app')
@section('title','Pinjam Buku')
@section('content')
@if(session('success') === true)
<div style="text-align:center;padding:48px;background:var(--white);border-radius:16px;border:1px solid #a7d3b9">
  <div style="font-size:3rem;margin-bottom:12px">✅</div>
  <div style="font-family:'Playfair Display',serif;font-size:1.3rem;color:var(--ink);margin-bottom:6px">Pengajuan Terkirim!</div>
  <div style="font-size:.88rem;color:var(--muted);margin-bottom:24px">Permintaan peminjaman kamu sedang menunggu konfirmasi dari admin.</div>
  <div style="display:flex;gap:10px;justify-content:center">
    <a href="{{ route('profile') }}" class="btn-primary-gold"><i class="fas fa-list"></i>Riwayat Pinjam</a>
    <a href="{{ route('buku') }}" class="btn-outline-navy"><i class="fas fa-book"></i>Koleksi Lain</a>
  </div>
</div>
@else
<div style="display:grid;grid-template-columns:1fr 360px;gap:28px">
  <div class="dl-card-p">
    <div style="font-family:'Playfair Display',serif;font-size:1.1rem;margin-bottom:20px">Formulir Peminjaman</div>
    <form method="POST" action="{{ route('borrow.store') }}">
      @csrf
      <input type="hidden" name="book_id" value="{{ $book->id }}">
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px">
        <div>
          <label class="field-label">Tanggal Pinjam *</label>
          <input type="date" class="field-input" name="borrow_date" min="{{ today()->toDateString() }}" value="{{ old('borrow_date',today()->toDateString()) }}" required>
        </div>
        <div>
          <label class="field-label">Tanggal Kembali *</label>
          <input type="date" class="field-input" name="return_date" min="{{ today()->addDay()->toDateString() }}" value="{{ old('return_date',today()->addDays(7)->toDateString()) }}" required>
        </div>
      </div>
      <div style="margin-bottom:20px">
        <label class="field-label">Catatan (opsional)</label>
        <textarea class="field-textarea" name="notes" rows="3" placeholder="Catatan khusus untuk petugas…">{{ old('notes') }}</textarea>
      </div>
      <div style="background:var(--bg);border-radius:10px;padding:14px;margin-bottom:20px;font-size:.8rem;color:var(--muted)">
        <i class="fas fa-info-circle" style="color:var(--gold);margin-right:6px"></i>
        Denda keterlambatan <strong>Rp 2.000/hari</strong>. Maksimum 3 buku aktif.
      </div>
      @if($errors->any())
        <div class="alert-error"><i class="fas fa-exclamation-circle"></i>{{ $errors->first() }}</div>
      @endif
      <div style="display:flex;gap:10px">
        <a href="{{ route('buku.show',$book) }}" class="btn-outline-navy"><i class="fas fa-times"></i>Batal</a>
        <button type="submit" class="btn-primary-gold"><i class="fas fa-paper-plane"></i>Ajukan Peminjaman</button>
      </div>
    </form>
  </div>
  <div class="dl-card-p" style="align-self:start">
    <div style="font-size:.65rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--muted);margin-bottom:14px">Detail Buku</div>
    @if($book->cover)<img src="{{ asset('storage/'.$book->cover) }}" style="width:100%;border-radius:8px;margin-bottom:14px">
    @else<div style="width:100%;aspect-ratio:2/3;background:var(--navy);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:3rem;margin-bottom:14px">📚</div>@endif
    <div style="font-weight:700;font-size:.95rem;color:var(--ink);margin-bottom:4px">{{ $book->title }}</div>
    <div style="font-size:.8rem;color:var(--muted);margin-bottom:8px">{{ $book->author }}</div>
    <span class="dl-badge dl-badge-green">{{ $book->stock }} tersedia</span>
  </div>
</div>
@endif
@endsection
