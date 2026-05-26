@extends('layouts.admin')
@section('title','Kategori')
@section('page-title','Kategori Buku')
@section('content')
<div style="display:flex;gap:20px;align-items:flex-start">
<div style="flex:1">
<div class="data-table-wrap">
<table>
<thead><tr><th>#</th><th>Ikon</th><th>Nama</th><th>Deskripsi</th><th>Jumlah Buku</th><th>Status</th><th>Aksi</th></tr></thead>
<tbody>
@forelse($categories as $i=>$cat)
<tr>
  <td style="color:var(--muted-2);font-size:.72rem">{{ $i+1 }}</td>
  <td style="font-size:1.4rem">{{ $cat->icon ?? '📚' }}</td>
  <td>{{ $cat->name }}</td>
  <td style="font-size:.78rem;color:var(--muted)">{{ Str::limit($cat->description,50,'…') ?? '-' }}</td>
  <td style="text-align:center"><span class="dl-badge dl-badge-blue">{{ $cat->books_count }} buku</span></td>
  <td>@if($cat->is_active)<span class="dl-badge dl-badge-green">Aktif</span>@else<span class="dl-badge dl-badge-muted">Nonaktif</span>@endif</td>
  <td>
    <div class="row-actions">
      <button class="action-btn edit" onclick="openEditCat({{ $cat->id }},'{{ addslashes($cat->name) }}','{{ addslashes($cat->description) }}','{{ $cat->icon }}',{{ $cat->is_active?'true':'false' }})" title="Edit"><i class="fas fa-edit"></i></button>
      <form method="POST" action="{{ route('admin.categories.destroy',$cat) }}" onsubmit="return confirm('Hapus kategori ini?')">@csrf @method('DELETE')
        <button type="submit" class="action-btn danger"><i class="fas fa-trash"></i></button>
      </form>
    </div>
  </td>
</tr>
@empty<tr><td colspan="7" style="text-align:center;padding:40px;color:var(--muted)">Belum ada kategori.</td></tr>
@endforelse
</tbody>
</table>
</div>
</div>
<div class="dl-card-p" style="width:300px;flex-shrink:0">
  <div class="section-title">Tambah Kategori</div>
  <form method="POST" action="{{ route('admin.categories.store') }}">@csrf
    <div style="margin-bottom:12px"><label class="field-label">Nama *</label><input class="field-input" name="name" required placeholder="Nama kategori"></div>
    <div style="margin-bottom:12px"><label class="field-label">Ikon (emoji)</label><input class="field-input" name="icon" placeholder="📚" maxlength="5"></div>
    <div style="margin-bottom:12px"><label class="field-label">Deskripsi</label><textarea class="field-textarea" name="description" rows="2"></textarea></div>
    <div style="margin-bottom:14px;display:flex;align-items:center;gap:8px"><input type="checkbox" name="is_active" id="ia" value="1" checked><label for="ia" style="font-size:.82rem;color:var(--ink)">Aktif</label></div>
    <button type="submit" class="btn-dl-primary" style="width:100%"><i class="fas fa-plus"></i>Tambah</button>
    @if($errors->any())<div class="dl-alert dl-alert-error" style="margin-top:10px;font-size:.72rem"><i class="fas fa-exclamation-circle"></i>{{ $errors->first() }}</div>@endif
  </form>
</div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editCatModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content">
<div class="modal-header"><h5 class="modal-title">Edit Kategori</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
<form method="POST" id="editCatForm">@csrf @method('PUT')
<div class="modal-body" style="display:grid;gap:12px">
  <div><label class="field-label">Nama *</label><input class="field-input" name="name" id="ec_name" required></div>
  <div><label class="field-label">Ikon (emoji)</label><input class="field-input" name="icon" id="ec_icon" maxlength="5"></div>
  <div><label class="field-label">Deskripsi</label><textarea class="field-textarea" name="description" id="ec_desc" rows="2"></textarea></div>
  <div style="display:flex;align-items:center;gap:8px"><input type="checkbox" name="is_active" id="ec_active" value="1"><label for="ec_active" style="font-size:.82rem">Aktif</label></div>
</div>
<div class="modal-footer"><button type="button" class="btn-dl-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn-dl-primary"><i class="fas fa-save"></i>Simpan</button></div>
</form>
</div></div></div>
@endsection
@push('scripts')
<script>
function openEditCat(id,name,desc,icon,active){
  document.getElementById('ec_name').value=name;
  document.getElementById('ec_desc').value=desc;
  document.getElementById('ec_icon').value=icon;
  document.getElementById('ec_active').checked=active;
  document.getElementById('editCatForm').action='/admin/kategori/'+id;
  new bootstrap.Modal(document.getElementById('editCatModal')).show();
}
</script>
@endpush
