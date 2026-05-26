@extends('layouts.admin')
@section('title','Kelola User')
@section('page-title','Kelola Pengguna')
@section('content')
<div style="display:flex;gap:10px;margin-bottom:18px">
  <a href="?role=user" class="dl-tab {{ request('role','user')==='user'?'active':'' }}">Member <span class="tab-cnt {{ request('role','user')==='user'?'red':'normal' }}">{{ $counts['user'] }}</span></a>
  <a href="?role=petugas" class="dl-tab {{ request('role')==='petugas'?'active':'' }}">Petugas <span class="tab-cnt normal">{{ $counts['petugas'] }}</span></a>
  <a href="?role=admin" class="dl-tab {{ request('role')==='admin'?'active':'' }}">Admin <span class="tab-cnt normal">{{ $counts['admin'] }}</span></a>
</div>
<div class="table-toolbar">
  <form class="tb-search" method="GET" action="">
    <input type="hidden" name="role" value="{{ request('role','user') }}">
    <i class="fas fa-search" style="color:var(--muted-2);font-size:.8rem"></i>
    <input name="search" value="{{ request('search') }}" placeholder="Cari username / email…">
  </form>
  <div class="tb-spacer"></div>
  <button class="btn-dl-primary" data-bs-toggle="modal" data-bs-target="#addUserModal"><i class="fas fa-user-plus"></i>Tambah Akun</button>
</div>
<div class="data-table-wrap">
<table>
<thead><tr><th>#</th><th>Pengguna</th><th>Email</th><th>Alamat</th><th>Role</th><th>Status</th><th>Aksi</th></tr></thead>
<tbody>
@forelse($users as $i=>$u)
<tr>
  <td style="color:var(--muted-2);font-size:.72rem">{{ $users->firstItem()+$i }}</td>
  <td>
    <div style="display:flex;align-items:center;gap:9px">
      @if($u->profile_photo)<img src="{{ asset('storage/'.$u->profile_photo) }}" style="width:30px;height:30px;border-radius:50%;object-fit:cover">
      @else<div style="width:30px;height:30px;border-radius:50%;background:var(--gold-pale);display:flex;align-items:center;justify-content:center;font-size:.7rem;font-weight:700;color:var(--gold)">{{ strtoupper(substr($u->username,0,1)) }}</div>@endif
      <div>
        <div style="font-weight:600;font-size:.82rem">{{ $u->username }}</div>
        @if($u->phone)<div style="font-size:.7rem;color:var(--muted)">{{ $u->phone }}</div>@endif
      </div>
    </div>
  </td>
  <td style="font-size:.82rem">{{ $u->email }}</td>
  <td style="font-size:.78rem;color:var(--muted)">{{ $u->alamat ?? '-' }}</td>
  <td><span class="dl-badge {{ $u->role==='admin'?'dl-badge-red':($u->role==='petugas'?'dl-badge-amber':'dl-badge-blue') }}">{{ ucfirst($u->role) }}</span></td>
  <td>@if($u->is_active)<span class="dl-badge dl-badge-green">Aktif</span>@else<span class="dl-badge dl-badge-red">Nonaktif</span>@endif</td>
  <td>
    <div class="row-actions">
      <form method="POST" action="{{ route('admin.users.activate',$u) }}">@csrf
        <button type="submit" class="action-btn {{ $u->is_active?'danger':'approve' }}" title="{{ $u->is_active?'Nonaktifkan':'Aktifkan' }}"><i class="fas {{ $u->is_active?'fa-user-slash':'fa-user-check' }}"></i></button>
      </form>
      <button class="action-btn edit" onclick="openEditUser({{ $u->id }},'{{ addslashes($u->username) }}','{{ $u->email }}','{{ addslashes($u->alamat) }}','{{ $u->phone }}')" title="Edit"><i class="fas fa-edit"></i></button>
      <form method="POST" action="{{ route('admin.users.destroy',$u) }}" onsubmit="return confirm('Hapus akun {{ addslashes($u->username) }}?')">@csrf @method('DELETE')
        <button type="submit" class="action-btn danger"><i class="fas fa-trash"></i></button>
      </form>
    </div>
  </td>
</tr>
@empty<tr><td colspan="7" style="text-align:center;padding:40px;color:var(--muted)">Tidak ada pengguna.</td></tr>
@endforelse
</tbody>
</table>
@if($users->hasPages())
<div class="dl-pagination"><div class="page-info">{{ $users->from() }}–{{ $users->to() }} dari {{ $users->total() }}</div>{{ $users->links() }}</div>
@endif
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content">
<div class="modal-header"><h5 class="modal-title">Tambah Akun</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
<form method="POST" action="{{ route('admin.users.store') }}">@csrf
<div class="modal-body" style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
  <div><label class="field-label">Username *</label><input class="field-input" name="username" required></div>
  <div><label class="field-label">Email *</label><input class="field-input" name="email" type="email" required></div>
  <div><label class="field-label">Password *</label><input class="field-input" name="password" type="password" required minlength="6"></div>
  <div><label class="field-label">Role *</label><select class="field-select" name="role" required><option value="user">User</option><option value="petugas">Petugas</option><option value="admin">Admin</option></select></div>
  <div><label class="field-label">Alamat</label><input class="field-input" name="alamat"></div>
  <div><label class="field-label">Telepon</label><input class="field-input" name="phone"></div>
</div>
<div class="modal-footer"><button type="button" class="btn-dl-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn-dl-primary"><i class="fas fa-save"></i>Simpan</button></div>
</form>
</div></div></div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content">
<div class="modal-header"><h5 class="modal-title">Edit Akun</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
<form method="POST" id="editUserForm">@csrf @method('PUT')
<div class="modal-body" style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
  <div><label class="field-label">Username *</label><input class="field-input" name="username" id="eu_user" required></div>
  <div><label class="field-label">Email *</label><input class="field-input" name="email" id="eu_email" type="email" required></div>
  <div><label class="field-label">Password baru (kosongkan jika tidak ganti)</label><input class="field-input" name="password" type="password" minlength="6"></div>
  <div><label class="field-label">Alamat</label><input class="field-input" name="alamat" id="eu_alamat"></div>
  <div><label class="field-label">Telepon</label><input class="field-input" name="phone" id="eu_phone"></div>
</div>
<div class="modal-footer"><button type="button" class="btn-dl-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn-dl-primary"><i class="fas fa-save"></i>Simpan</button></div>
</form>
</div></div></div>

@if(session('success'))<script>document.addEventListener('DOMContentLoaded',()=>showToast('{{ session('success') }}'))</script>@endif
@endsection
@push('scripts')
<script>
function openEditUser(id,user,email,alamat,phone){
  document.getElementById('eu_user').value=user;
  document.getElementById('eu_email').value=email;
  document.getElementById('eu_alamat').value=alamat;
  document.getElementById('eu_phone').value=phone;
  document.getElementById('editUserForm').action='/admin/users/'+id;
  new bootstrap.Modal(document.getElementById('editUserModal')).show();
}
</script>
@endpush
