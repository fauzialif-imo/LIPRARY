<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Laporan Anggota</title>
<style>body{font-family:Arial,sans-serif;font-size:11px;color:#1a1a2e}h1{color:#0d1b3e;font-size:15px;margin-bottom:4px}.meta{color:#6b7280;font-size:10px;margin-bottom:16px}table{width:100%;border-collapse:collapse}th{background:#0d1b3e;color:#c9a84c;padding:7px 10px;text-align:left;font-size:10px}td{padding:6px 10px;border-bottom:1px solid #e8eaf0;font-size:10px}tr:nth-child(even){background:#f8f9fb}</style>
</head><body>
<h1>{{ \App\Models\Setting::get('navbar_site_name','YOMULIB') }} — Laporan Anggota</h1>
<div class="meta">Dicetak: {{ now()->format('d M Y H:i') }}</div>
<table>
<thead><tr><th>#</th><th>Username</th><th>Email</th><th>Status</th><th>Total Pinjam</th></tr></thead>
<tbody>@foreach($users as $i=>$u)<tr><td>{{ $i+1 }}</td><td>{{ $u->username }}</td><td>{{ $u->email }}</td><td>{{ $u->is_active?'Aktif':'Nonaktif' }}</td><td>{{ $u->borrowings_count }}</td></tr>@endforeach</tbody>
</table>
<div style="margin-top:50px;padding:0 50px;display:flex;justify-content:flex-end;font-size:11px">
	<div style="width:40%;text-align:center">
		<div style="margin-bottom:18px">.........................., {{ now()->format('d F Y') }}</div>
		<div style="margin-bottom:10px;font-weight:bold">{{ auth()->user()->role === 'petugas' ? 'Petugas' : 'Admin' }}</div>
		<div style="height:70px;display:flex;align-items:flex-end;justify-content:center;margin-bottom:8px">
			<div style="border-bottom:1px solid #000;width:40%"></div>
		</div>
		
	</div>
</div>
</body></html>
