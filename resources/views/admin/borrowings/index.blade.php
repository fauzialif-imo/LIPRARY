@extends('layouts.admin')
@section('title','Peminjaman')
@section('page-title','Manajemen Peminjaman')
@section('content')
<div class="dl-tabs">
  <a href="?tab=borrowing" class="dl-tab {{ $tab==='borrowing'?'active':'' }}">Aktif/Pending</a>
  <a href="?tab=returning" class="dl-tab {{ $tab==='returning'?'active':'' }}">Pengajuan Kembali</a>
  <a href="?tab=returned" class="dl-tab {{ $tab==='returned'?'active':'' }}">Selesai</a>
  <a href="?tab=rejected" class="dl-tab {{ $tab==='rejected'?'active':'' }}">Ditolak</a>
</div>
<div class="table-toolbar">
  <form class="tb-search" method="GET">
    <input type="hidden" name="tab" value="{{ $tab }}">
    <i class="fas fa-search" style="color:var(--muted-2);font-size:.8rem"></i>
    <input name="search" value="{{ request('search') }}" placeholder="Cari peminjam / judul buku…">
  </form>
</div>
<div class="data-table-wrap">
<table>
<thead><tr><th>#</th><th>Peminjam</th><th>Buku</th><th>Tgl Pinjam</th><th>Tgl Kembali</th><th>Status</th><th>Denda</th><th>Aksi</th></tr></thead>
<tbody>
@forelse($data as $i=>$b)
<tr>
  <td style="color:var(--muted-2);font-size:.72rem">{{ $data->firstItem()+$i }}</td>
  <td>
    <div style="font-weight:600;font-size:.82rem">{{ $b->user->username }}</div>
    <div style="font-size:.7rem;color:var(--muted)">{{ $b->user->email }}</div>
  </td>
  <td>
    <div class="book-col">
      <div>
        <div style="font-weight:600;font-size:.82rem">{{ Str::limit($b->book->title,35) }}</div>
        <div style="font-size:.7rem;color:var(--muted)">{{ $b->book->author }}</div>
      </div>
    </div>
  </td>
  <td style="font-size:.8rem">{{ $b->borrow_date->format('d M Y') }}</td>
  <td style="font-size:.8rem">
    {{ $b->return_date->format('d M Y') }}
    @if($b->isLate() && !in_array($b->status,['returned','rejected']))
      <span class="dl-badge dl-badge-red" style="margin-left:4px">+{{ $b->lateDays() }}hr</span>
    @endif
  </td>
  <td>
    @php $cls = match($b->status){'pending'=>'dl-badge-amber','approved'=>'dl-badge-green','returning'=>'dl-badge-blue','returned'=>'dl-badge-muted','rejected'=>'dl-badge-red',default=>'dl-badge-muted'}; @endphp
    <span class="dl-badge {{ $cls }}">{{ $b->status_label }}</span>
  </td>
  <td style="font-size:.8rem">{{ $b->fine_amount>0?'Rp '.number_format($b->fine_amount,0,',','.'):'—' }}</td>
  <td>
    <div class="row-actions">
      @if($b->status==='pending')
        <form method="POST" action="{{ route('admin.borrowings.approve',$b) }}">@csrf<button type="submit" class="action-btn approve" title="Setujui"><i class="fas fa-check"></i></button></form>
        <button class="action-btn danger" onclick="openRejectModal({{ $b->id }},'borrow')" title="Tolak"><i class="fas fa-times"></i></button>
      @elseif($b->status==='returning')
        <form method="POST" action="{{ route('admin.borrowings.approve-return',$b) }}">@csrf<button type="submit" class="action-btn approve" title="Konfirmasi Kembali"><i class="fas fa-check-double"></i></button></form>
        <button class="action-btn danger" onclick="openRejectModal({{ $b->id }},'return')" title="Tolak Kembali"><i class="fas fa-times"></i></button>
      @endif
      @if($b->admin_note)<span title="{{ $b->admin_note }}" class="action-btn view"><i class="fas fa-comment-alt"></i></span>@endif
    </div>
  </td>
</tr>
@empty
<tr><td colspan="8" style="text-align:center;padding:48px;color:var(--muted)">Tidak ada data.</td></tr>
@endforelse
</tbody>
</table>
@if($data->hasPages())
<div class="dl-pagination"><div class="page-info">{{ $data->from() }}–{{ $data->to() }} dari {{ $data->total() }}</div>{{ $data->links() }}</div>
@endif
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content">
<div class="modal-header"><h5 class="modal-title" id="rejectModalTitle">Tolak</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
<form method="POST" id="rejectForm">@csrf
<div class="modal-body"><label class="field-label">Catatan penolakan</label><textarea class="field-textarea" name="admin_note" rows="3" placeholder="Alasan penolakan…"></textarea></div>
<div class="modal-footer"><button type="button" class="btn-dl-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn-dl-danger"><i class="fas fa-times"></i>Tolak</button></div>
</form>
</div></div></div>
@endsection
@push('scripts')
<script>
function openRejectModal(id,type){
  const form=document.getElementById('rejectForm');
  if(type==='borrow') form.action='/admin/peminjaman/'+id+'/tolak';
  else form.action='/admin/peminjaman/'+id+'/tolak-kembali';
  new bootstrap.Modal(document.getElementById('rejectModal')).show();
}
</script>
@endpush
