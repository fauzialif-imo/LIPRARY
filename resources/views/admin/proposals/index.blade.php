@extends('layouts.admin')
@section('title','Usulan Buku')
@section('page-title','Usulan Buku')
@section('content')
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px">
  @foreach([['label'=>'Total','val'=>$stats['total'],'cls'=>'dl-badge-muted'],['label'=>'Pending','val'=>$stats['pending'],'cls'=>'dl-badge-amber'],['label'=>'Disetujui','val'=>$stats['approved'],'cls'=>'dl-badge-green'],['label'=>'Ditolak','val'=>$stats['rejected'],'cls'=>'dl-badge-red']] as $s)
  <div class="dl-card-p" style="text-align:center">
    <div style="font-size:1.6rem;font-weight:700;color:var(--ink)">{{ $s['val'] }}</div>
    <span class="dl-badge {{ $s['cls'] }}" style="margin-top:6px">{{ $s['label'] }}</span>
  </div>
  @endforeach
</div>
<div class="table-toolbar">
  <form class="tb-search" method="GET">
    <i class="fas fa-search" style="color:var(--muted-2);font-size:.8rem"></i>
    <input name="search" value="{{ request('search') }}" placeholder="Cari judul / penulis…">
  </form>
  <select class="tb-select" name="status" onchange="this.form.submit()" form="statusForm">
    <option value="">Semua Status</option>
    <option value="pending" {{ request('status')==='pending'?'selected':'' }}>Pending</option>
    <option value="approved" {{ request('status')==='approved'?'selected':'' }}>Disetujui</option>
    <option value="rejected" {{ request('status')==='rejected'?'selected':'' }}>Ditolak</option>
  </select>
  <form id="statusForm" method="GET" style="display:none"></form>
  <div class="tb-spacer"></div>
  @unless($isAdmin)
    <a href="{{ route('admin.books.proposals.create') }}" class="btn-dl-primary"><i class="fas fa-file-plus"></i>Buat Usulan</a>
  @endunless
</div>
<div class="data-table-wrap">
<table>
<thead><tr><th>#</th><th>Judul</th><th>Penulis</th><th>Kategori</th><th>Pengusul</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr></thead>
<tbody>
@forelse($proposals as $i=>$p)
<tr>
  <td style="color:var(--muted-2);font-size:.72rem">{{ $proposals->firstItem()+$i }}</td>
  <td>
    <div style="font-weight:600;font-size:.82rem">{{ Str::limit($p->title,40) }}</div>
    @if($p->isbn)<div style="font-size:.7rem;color:var(--muted)">ISBN: {{ $p->isbn }}</div>@endif
  </td>
  <td style="font-size:.82rem">{{ $p->author }}</td>
  <td><span class="dl-badge dl-badge-blue">{{ $p->category->name ?? '-' }}</span></td>
  <td style="font-size:.82rem">{{ $p->user->username }}</td>
  <td>
    @php $cls=match($p->status){'pending'=>'dl-badge-amber','approved'=>'dl-badge-green','rejected'=>'dl-badge-red',default=>'dl-badge-muted'}; @endphp
    <span class="dl-badge {{ $cls }}">{{ ucfirst($p->status) }}</span>
  </td>
  <td style="font-size:.78rem;color:var(--muted-2)">{{ $p->created_at->format('d M Y') }}</td>
  <td>
    <div class="row-actions">
      @if($p->isPending())
        @if($isAdmin)
          <button class="action-btn approve" title="Setujui" onclick="openApproveModal({{ $p->id }},'{{ addslashes($p->title) }}')"><i class="fas fa-check"></i></button>
          <button class="action-btn danger" title="Tolak" onclick="openRejectModal({{ $p->id }})"><i class="fas fa-times"></i></button>
        @endif
        @if($p->user_id===auth()->id())
          <form method="POST" action="{{ route('admin.books.proposals.destroy',$p) }}" onsubmit="return confirm('Tarik usulan ini?')">@csrf @method('DELETE')
            <button type="submit" class="action-btn danger" title="Tarik Usulan"><i class="fas fa-trash"></i></button>
          </form>
        @endif
      @endif
      @if($p->admin_note)
        <span class="action-btn view" title="{{ $p->admin_note }}"><i class="fas fa-comment-alt"></i></span>
      @endif
    </div>
  </td>
</tr>
@empty<tr><td colspan="8" style="text-align:center;padding:48px;color:var(--muted)">Belum ada usulan buku.</td></tr>
@endforelse
</tbody>
</table>
@if($proposals->hasPages())
<div class="dl-pagination"><div class="page-info">{{ $proposals->from() }}–{{ $proposals->to() }} dari {{ $proposals->total() }}</div>{{ $proposals->links() }}</div>
@endif
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content">
<div class="modal-header"><h5 class="modal-title">Setujui Usulan</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
<form method="POST" id="approveForm">@csrf
<div class="modal-body" style="display:grid;gap:12px">
  <div class="dl-alert dl-alert-gold"><i class="fas fa-info-circle"></i>Buku akan langsung ditambahkan ke koleksi perpustakaan.</div>
  <div><label class="field-label">Stok Awal *</label><input class="field-input" name="stock" type="number" min="1" value="1" required></div>
  <div><label class="field-label">Catatan (opsional)</label><textarea class="field-textarea" name="admin_note" rows="2"></textarea></div>
</div>
<div class="modal-footer"><button type="button" class="btn-dl-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn-dl-primary"><i class="fas fa-check"></i>Setujui & Tambah Buku</button></div>
</form>
</div></div></div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content">
<div class="modal-header"><h5 class="modal-title">Tolak Usulan</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
<form method="POST" id="rejectForm">@csrf
<div class="modal-body"><label class="field-label">Alasan Penolakan *</label><textarea class="field-textarea" name="admin_note" rows="3" required placeholder="Jelaskan alasan penolakan…"></textarea></div>
<div class="modal-footer"><button type="button" class="btn-dl-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn-dl-danger"><i class="fas fa-times"></i>Tolak</button></div>
</form>
</div></div></div>
@endsection
@push('scripts')
<script>
function openApproveModal(id,title){
  document.getElementById('approveForm').action='/admin/buku/usulan/'+id+'/setujui';
  new bootstrap.Modal(document.getElementById('approveModal')).show();
}
function openRejectModal(id){
  document.getElementById('rejectForm').action='/admin/buku/usulan/'+id+'/tolak';
  new bootstrap.Modal(document.getElementById('rejectModal')).show();
}
</script>
@endpush
