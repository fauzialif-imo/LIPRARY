@push('styles')
<style>
.upload-zone{border:2px dashed var(--border-2);border-radius:12px;padding:28px 20px;text-align:center;cursor:pointer;transition:all .2s;background:var(--bg);position:relative}
.upload-zone:hover,.upload-zone.drag-over{border-color:var(--gold);background:rgba(201,168,76,.05)}
.upload-zone input[type=file]{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%}
.upload-icon{width:48px;height:48px;border-radius:12px;background:var(--gold-pale);display:flex;align-items:center;justify-content:center;margin:0 auto 10px;font-size:1.3rem;color:var(--gold)}
.mini-zone{padding:16px 12px;min-height:88px;display:flex;flex-direction:column;align-items:center;justify-content:center;border-radius:10px}
.thumb{width:100%;object-fit:cover;border-radius:10px;border:1.5px solid var(--border);display:block}
.thumb-wide{height:90px}
.remove-btn{display:inline-flex;align-items:center;gap:6px;padding:5px 12px;font-size:.72rem;font-weight:700;color:var(--red);background:var(--red-pale);border:1px solid transparent;border-radius:8px;cursor:pointer;transition:all .15s;margin-top:8px}
.remove-btn:hover{background:var(--red);color:#fff}
.hero-preview{width:100%;height:190px;border-radius:12px;overflow:hidden;position:relative;display:flex;align-items:center;padding:28px 32px;background:linear-gradient(135deg,#0d1b3e 0%,#1a2d5a 60%,#0a1628 100%);border:1.5px solid var(--border)}
.hero-preview::before{content:'';position:absolute;inset:0;background:radial-gradient(ellipse at 70% 50%,rgba(201,168,76,.08) 0%,transparent 60%)}
.hero-preview.has-bg{background-size:cover;background-position:center}
.hero-preview.has-bg::after{content:'';position:absolute;inset:0;background:rgba(10,20,50,.58)}
.hp-text{position:relative;z-index:2}
.hp-text h3{font-family:'Playfair Display',serif;color:#fff;font-size:1.05rem;font-weight:700;line-height:1.3;margin-bottom:5px;text-shadow:0 2px 8px rgba(0,0,0,.4)}
.hp-text p{color:rgba(255,255,255,.7);font-size:.78rem}
.preview-panel{position:sticky;top:20px}
.preview-info{margin-top:12px;padding:12px 16px;background:var(--bg);border-radius:10px;border:1px solid var(--border)}
.preview-info ul{font-size:.76rem;color:var(--muted);padding-left:16px;line-height:1.9}
.feat-prev-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:10px}
.feat-prev-card{border-radius:10px;overflow:hidden;height:88px;position:relative;display:flex;align-items:flex-end;background:var(--navy);background-size:cover;background-position:center}
.feat-prev-card::after{content:'';position:absolute;inset:0;background:linear-gradient(to top,rgba(10,18,50,.88),rgba(10,18,50,.2))}
.feat-prev-label{position:relative;z-index:1;padding:8px;font-size:.62rem;font-weight:700;color:var(--gold);line-height:1.2}
.cat-prev-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px}
.cat-prev-card{border-radius:10px;overflow:hidden;height:68px;position:relative;display:flex;align-items:flex-end;background-size:cover;background-position:center}
.cat-prev-card::after{content:'';position:absolute;inset:0;background:linear-gradient(to top,rgba(13,27,62,.85),transparent 60%)}
.cat-prev-label{position:relative;z-index:1;padding:7px 10px;font-size:.63rem;font-weight:700;color:#fff}
.ck1{background:linear-gradient(135deg,#4a6fa5,#2d4a7a)}.ck2{background:linear-gradient(135deg,#7a5c2a,#c9a84c)}.ck3{background:linear-gradient(135deg,#2a5a4a,#48a07a)}.ck4{background:linear-gradient(135deg,#5a2a4a,#a04878)}
.set-grid{display:grid;grid-template-columns:1fr 340px;gap:24px;align-items:start}
</style>
@endpush

@push('scripts')
<script>
function flagRemove(flagId){
    document.getElementById(flagId).value='1';
    document.getElementById(flagId).closest('form').submit();
}
function zonePreview(input,name,previewId){
    const file=input.files[0];if(!file)return;
    const url=URL.createObjectURL(file);
    if(previewId){const el=document.getElementById(previewId);if(el){if(el.tagName==='IMG')el.src=url;else{el.style.backgroundImage=`url('${url}')`;el.style.backgroundSize='cover';el.style.backgroundPosition='center';}}}
    const lbl=document.getElementById('lbl_'+name);
    if(lbl)lbl.innerHTML=`<div style="font-size:.82rem;font-weight:600"><i class="fas fa-check-circle" style="color:var(--green)"></i> ${file.name}</div><div style="font-size:.7rem;color:var(--muted);margin-top:3px">${(file.size/1024/1024).toFixed(2)} MB</div>`;
}
document.addEventListener('DOMContentLoaded',()=>{
    document.querySelectorAll('.upload-zone').forEach(zone=>{
        const input=zone.querySelector('input[type=file]');if(!input)return;
        zone.addEventListener('dragover',e=>{e.preventDefault();zone.classList.add('drag-over');});
        zone.addEventListener('dragleave',()=>zone.classList.remove('drag-over'));
        zone.addEventListener('drop',e=>{e.preventDefault();zone.classList.remove('drag-over');if(e.dataTransfer.files.length){input.files=e.dataTransfer.files;input.dispatchEvent(new Event('change'));}});
    });
});
</script>
@endpush
