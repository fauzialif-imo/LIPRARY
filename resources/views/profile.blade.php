@extends('layouts.app')

@push('styles')
<style>
    :root{--navy:#0d1b3e;--navy-dark:#0b1622;--gold:#c9a84c;--gold-light:#e8c97a}
    *{box-sizing:border-box}
    body{font-family:'Poppins',sans-serif;background:#f8f9fa;margin:0}

    /* PROFILE HEADER */
    .profile-banner{background:linear-gradient(to right,#0b1622,#1a2a3a);color:#fff;padding:60px 5%;border-bottom:4px solid var(--gold)}
    .profile-title{color:var(--gold);font-weight:700;margin-bottom:12px}
    .avatar-main{width:110px;height:110px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:48px;background:linear-gradient(45deg,var(--gold),#f1d297);color:var(--navy)}
    .info-user h2{margin:0;font-weight:600}
    .info-user p{color:#bdc3c7;margin-top:6px}
    .btn-edit-profile{background:linear-gradient(90deg,var(--gold),#f1d297);color:var(--navy);border:none;padding:10px 18px;border-radius:10px;font-weight:700}

    /* TABS */
    .profile-nav-tabs{background:#fff;padding:0 5%;border-bottom:1px solid #ddd}
    .profile-nav-tabs .container{display:flex;gap:28px;justify-content:center;align-items:center;flex-wrap:wrap}
    .tab-link{padding:12px 22px;font-weight:600;color:#333;background:#fff;border:0;cursor:pointer;display:inline-flex;align-items:center;gap:10px;border-radius:10px;transition:all .15s}
    .tab-link:hover{color:var(--gold);transform:translateY(-2px);box-shadow:0 6px 20px rgba(13,27,62,.06)}
    .tab-link.active{color:var(--gold);border-bottom:3px solid var(--gold)}
    .tab-panel{background:#fff;padding:18px;border-radius:10px;margin-top:12px;box-shadow:0 6px 18px rgba(13,27,62,.06)}
    .tab-panel .table td,.tab-panel .table th{vertical-align:middle}
    .btn-return{min-width:120px}

    /* Modal form styles */
    .modal-content-custom{background:var(--navy-dark);border:1px solid var(--gold);border-radius:16px;color:#fff;padding:22px}
    .form-input-white{background:#fff;border-radius:10px;display:flex;align-items:center;padding:8px 12px;margin-bottom:12px}
    .form-input-white i{width:28px;color:#666}
    .form-input-white input{border:0;outline:0;width:100%;font-size:14px}
    .btn-simpan-modal{background:linear-gradient(90deg,var(--gold),#e0bc7a);border:none;width:100%;padding:10px;border-radius:10px;font-weight:700;color:var(--navy)}
    /* Clean (white) modal for edit profile */
    .modal-clean{background:#fff;color:#0d1b3e;border-radius:12px;padding:18px}
    .modal-clean .btn-close{filter:none}
    .modal-clean .form-input-white{background:#fff;border-radius:8px;padding:10px}
</style>
@endpush

@section('title','Profile Pengguna')

@section('content')

<header class="profile-banner">
    <div class="container">
        <h4 class="profile-title">Profile Pengguna</h4>
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-4 flex-nowrap">
                <div class="avatar-main">
                    @if(Auth::user()->profile_photo)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="avatar" style="width:110px;height:110px;border-radius:50%;object-fit:cover">
                    @else
                        <i class="fas fa-user"></i>
                    @endif
                </div>
                <div class="info-user">
                    <h2>Halo, <span style="color:var(--gold);">{{ Auth::user()->username ?? 'Nama Pengguna' }}</span></h2>
                    <p>Membangun jembatan digital antara pembaca dan ilmu pengetahuan.</p>
                </div>
            </div>
            <div class="ms-3">
                <button class="btn-edit-profile" data-bs-toggle="modal" data-bs-target="#editProfileModal">Edit Profile <i class="fas fa-arrow-right ms-2"></i></button>
            </div>
        </div>
    </div>
</header>

<div class="profile-nav-tabs mt-3">
    <div class="container">
        <button type="button" class="tab-link" data-target="#tab-aktivitas">Aktivitas Saya <i class="fas fa-clipboard-list small"></i></button>
        <button type="button" class="tab-link" data-target="#tab-koleksi">Koleksi Saya <i class="fas fa-book-open small"></i></button>
        <button type="button" class="tab-link" data-target="#tab-riwayat">Riwayat <i class="fas fa-history small"></i></button>
    </div>
</div>

<!-- Tab panels -->
<div class="container mt-3" id="tab-content">
    <div id="tab-aktivitas" class="tab-panel">
        <h5>Aktivitas Peminjaman</h5>
        <p class="text-muted small">Daftar peminjaman buku Anda. Gunakan tombol untuk mengembalikan atau cetak bukti.</p>
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $activeBorrowings = isset($borrowings) ? $borrowings->filter(function($b){ return !in_array($b->status, ['returned','rejected']); }) : collect();
                    @endphp
                    @if($activeBorrowings->isEmpty())
                        <tr><td colspan="5" class="text-center text-muted">Belum ada aktivitas peminjaman.</td></tr>
                    @else
                        @foreach($activeBorrowings as $b)
                            <tr>
                                <td>{{ $b->book->title ?? '-' }}</td>
                                <td>{{ $b->borrow_date ? $b->borrow_date->format('Y-m-d') : '-' }}</td>
                                <td>{{ $b->return_date ? $b->return_date->format('Y-m-d') : '-' }}</td>
                                <td>
                                    @if($b->status === 'approved')
                                        <span class="badge bg-warning text-dark">{{ $b->status_label }}</span>
                                    @elseif($b->status === 'pending')
                                        <span class="badge bg-info text-dark">{{ $b->status_label }}</span>
                                    @elseif($b->status === 'returning')
                                        <span class="badge bg-primary text-white">{{ $b->status_label }}</span>
                                    @elseif($b->status === 'rejected')
                                        <span class="badge bg-danger text-white">{{ $b->status_label }}</span>
                                    @elseif($b->status === 'returned')
                                        <span class="badge bg-secondary">{{ $b->status_label }}</span>
                                    @else
                                        <span class="badge bg-light text-dark">{{ $b->status_label }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($b->status === 'approved')
                                        <button class="btn btn-sm btn-success btn-return" data-borrow-id="{{ $b->id }}">Kembalikan Buku</button>
                                    @else
                                        <button class="btn btn-sm btn-success btn-return" disabled>Kembalikan Buku</button>
                                    @endif

                                    <button class="btn btn-sm btn-outline-primary btn-print ms-1"
                                        data-borrow-id="{{ $b->id }}"
                                        data-returned="{{ $b->status === 'returned' ? 1 : 0 }}"
                                        data-receipt-url="{{ route('borrow.receipt', ['borrowing' => $b->id]) }}"
                                        data-return-receipt-url="{{ route('borrow.return-receipt', ['borrowing' => $b->id]) }}">
                                        Cetak Bukti
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div id="tab-koleksi" class="tab-panel d-none">
        <h5>Daftar Koleksi</h5>
        <p class="text-muted small">Ini adalah koleksi buku yang Anda simpan.</p>
        @if(isset($collections) && $collections->count())
            <div class="list-group">
                @foreach($collections as $c)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3">
                            @if(optional($c->book)->cover)
                                <img src="{{ asset('storage/' . $c->book->cover) }}" alt="cover" style="width:48px;height:72px;object-fit:cover;border-radius:4px">
                            @else
                                <div style="width:48px;height:72px;background:#e9ecef;border-radius:4px"></div>
                            @endif
                            <div>
                                <div style="font-weight:600">{{ $c->book->title ?? '-' }}</div>
                                <div class="text-muted small">{{ $c->book->author ?? '' }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="mb-0">(Belum ada koleksi.)</p>
        @endif
    </div>

    <div id="tab-riwayat" class="tab-panel d-none">
        <h5>Riwayat</h5>
        <p class="text-muted small">Riwayat transaksi dan peminjaman.</p>
        <div class="table-responsive mt-2">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!isset($borrowings) || $borrowings->isEmpty())
                        <tr><td colspan="5" class="text-center text-muted">Belum ada riwayat peminjaman.</td></tr>
                    @else
                        @foreach($borrowings as $b)
                            <tr>
                                <td>{{ $b->book->title ?? '-' }}</td>
                                <td>{{ $b->borrow_date ? $b->borrow_date->format('Y-m-d') : '-' }}</td>
                                <td>{{ $b->actual_return_date ? $b->actual_return_date->format('Y-m-d') : ($b->return_date ? $b->return_date->format('Y-m-d') : '-') }}</td>
                                <td>
                                    <span class="badge {{ $b->status==='returned' ? 'bg-secondary' : ($b->status==='approved' ? 'bg-warning text-dark' : ($b->status==='pending' ? 'bg-info text-dark' : 'bg-light text-dark')) }}">{{ $b->status_label }}</span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary btn-print"
                                        data-borrow-id="{{ $b->id }}"
                                        data-returned="{{ $b->status === 'returned' ? 1 : 0 }}"
                                        data-receipt-url="{{ route('borrow.receipt', ['borrowing' => $b->id]) }}"
                                        data-return-receipt-url="{{ route('borrow.return-receipt', ['borrowing' => $b->id]) }}">
                                        Cetak Bukti
                                    </button>

                                    @if($b->status === 'returned')
                                        @if($b->review)
                                            <button class="btn btn-sm btn-secondary ms-1" data-bs-toggle="modal" data-bs-target="#viewReviewModal-{{ $b->id }}">Lihat Ulasan</button>
                                        @else
                                            <button class="btn btn-sm btn-primary ms-1" data-bs-toggle="modal" data-bs-target="#reviewModal-{{ $b->id }}">Ulas</button>
                                        @endif
                                    @endif
                                </td>
                            </tr>

                            {{-- Modal: Kirim Ulasan --}}
                            @if($b->status === 'returned' && !$b->review)
                                <div class="modal fade" id="reviewModal-{{ $b->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Ulas Buku: {{ $b->book->title ?? '-' }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="POST" action="{{ route('borrow.review', ['borrowing' => $b->id]) }}">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Rating</label>
                                                        <select name="rating" class="form-select" required>
                                                            <option value="">Pilih rating</option>
                                                            @for($i=5;$i>=1;$i--)
                                                                <option value="{{ $i }}">{{ $i }} bintang</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Komentar (opsional)</label>
                                                        <textarea name="comment" class="form-control" rows="4" maxlength="500"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- Modal: Lihat Ulasan (jika ada) --}}
                            @if($b->review)
                                <div class="modal fade" id="viewReviewModal-{{ $b->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Ulasan Anda: {{ $b->book->title ?? '-' }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div style="font-weight:700">Rating: {{ $b->review->rating }} / 5</div>
                                                <div class="mt-2">{{ $b->review->comment ?? '(Tidak ada komentar)' }}</div>
                                                <div class="text-muted small mt-3">Tanggal: {{ $b->review->created_at->format('Y-m-d') }}</div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- hidden form to submit return action -->
<form id="returnForm" method="POST" style="display:none">@csrf</form>

<!-- Modal Edit Profile -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-clean">
            <div class="text-end">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="text-center mb-3">
                <div style="width:80px;height:80px;border-radius:50%;background:var(--gold);display:inline-flex;align-items:center;justify-content:center;color:var(--navy);font-size:32px;margin-bottom:8px"><i class="fas fa-user"></i></div>
                <h4 class="mb-0" style="font-weight:700">Edit Profile</h4>
            </div>

            @if ($errors->any())
                <div class="px-3 mb-3">
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-input-white">
                    <i class="fas fa-image"></i>
                    <input type="file" name="profile_photo" accept="image/*">
                </div>
                <div class="form-input-white">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" placeholder="Username" value="{{ old('username', Auth::user()->username ?? '') }}">
                </div>
                <div class="form-input-white">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Email" value="{{ old('email', Auth::user()->email ?? '') }}">
                </div>
                <div class="form-input-white">
                    <i class="fas fa-home"></i>
                    <input type="text" name="alamat" placeholder="Alamat" value="{{ old('alamat', Auth::user()->alamat ?? '') }}">
                </div>
                <div class="form-input-white">
                    <i class="fas fa-key"></i>
                    <input type="password" name="password" placeholder="Password (kosongkan jika tidak ganti)">
                </div>
                <div class="form-input-white">
                    <i class="fas fa-key"></i>
                    <input type="password" name="password_confirmation" placeholder="Konfirmasi Password">
                </div>
                <button type="submit" class="btn-simpan-modal mt-2">Simpan</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    const tabLinks = document.querySelectorAll('.profile-nav-tabs .tab-link');
    const panels = document.querySelectorAll('.tab-panel');

    function showPanel(selector){
        panels.forEach(p=>p.classList.add('d-none'));
        const t = document.querySelector(selector);
        if(t) t.classList.remove('d-none');
    }

    tabLinks.forEach((btn, idx)=>{
        btn.addEventListener('click', function(e){
            tabLinks.forEach(b=>b.classList.remove('active'));
            this.classList.add('active');
            const target = this.getAttribute('data-target');
            if(target) showPanel(target);
            const content = document.querySelector('#tab-content');
            if(content) content.scrollIntoView({behavior:'smooth', block:'start'});
        });
    });

    if(tabLinks.length){
        const first = tabLinks[0];
        first.classList.add('active');
        showPanel(first.getAttribute('data-target') || '#tab-aktivitas');
    }

    // Delegate return and print actions to support dynamically rendered rows
    const returnForm = document.getElementById('returnForm');
    document.addEventListener('click', function(e){
        const retBtn = e.target.closest('.btn-return');
        if(retBtn){
            e.preventDefault();
            const id = retBtn.dataset.borrowId;
            if(!id) return;
            if(!confirm('Yakin ingin mengembalikan buku ini?')) return;
            // submit hidden form to POST /pinjam/{borrowing}/kembali with CSRF
            returnForm.action = '/pinjam/' + id + '/kembali';
            returnForm.submit();
            return;
        }

        const printBtn = e.target.closest('.btn-print');
        if(printBtn){
            e.preventDefault();
            const isReturned = printBtn.dataset.returned === '1';
            const url = isReturned ? printBtn.dataset.returnReceiptUrl : printBtn.dataset.receiptUrl;
            if(url) window.open(url, '_blank');
            return;
        }
    });
});
</script>
@endpush

@if ($errors->any())
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function(){
        var modalEl = document.getElementById('editProfileModal');
        if(modalEl){ var m = new bootstrap.Modal(modalEl); m.show(); }
    });
</script>
@endpush
@endif

@endsection
