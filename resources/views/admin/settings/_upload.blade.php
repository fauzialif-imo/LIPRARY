{{-- Props: $name, $current, $label, $rec, $previewId --}}
@if($current ?? null)
  <label class="field-label">Gambar Saat Ini</label>
  <img src="{{ asset('storage/'.$current) }}" class="thumb thumb-wide" style="margin-bottom:8px">
  <input type="hidden" name="remove_{{ $name }}" id="removeFlag_{{ $name }}" value="0">
  <button type="button" class="remove-btn" onclick="flagRemove('removeFlag_{{ $name }}')">
    <i class="fas fa-trash-alt"></i> Hapus
  </button>
  <div style="margin-top:14px"><label class="field-label">Ganti Gambar</label>
@else
  <label class="field-label">{{ $label ?? 'Upload Gambar' }}</label>
  <input type="hidden" name="remove_{{ $name }}" value="0">
@endif
<div class="upload-zone" id="zone_{{ $name }}">
  <input type="file" name="{{ $name }}" id="file_{{ $name }}" accept="image/jpeg,image/png,image/webp"
         onchange="zonePreview(this,'{{ $name }}','{{ $previewId ?? '' }}')">
  <div class="upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
  <div id="lbl_{{ $name }}">
    <div style="font-size:.85rem;font-weight:600;color:var(--ink-2);margin-bottom:4px">Klik atau drag &amp; drop</div>
    <div style="font-size:.72rem;color:var(--muted)">JPG, PNG, WebP — Maks. 4 MB</div>
    @if($rec ?? null)<div style="font-size:.72rem;color:var(--muted);margin-top:3px">{{ $rec }}</div>@endif
  </div>
</div>
@if($current ?? null)</div>@endif
