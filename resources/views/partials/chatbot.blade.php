{{-- Floating chatbot widget --}}
@php
  $siteName = \App\Models\Setting::get('navbar_site_name', 'YomuLib');
  $botName  = $siteName . 'Bot';
@endphp
<div id="chatbot-widget" style="position:fixed;bottom:24px;right:24px;z-index:9999;font-family:'DM Sans',sans-serif">
  <button id="chatbot-toggle" onclick="toggleChatbot()"
    style="width:56px;height:56px;border-radius:50%;background:linear-gradient(135deg,#0d1b3e,#1a2d5a);border:2px solid #c9a84c;color:#c9a84c;font-size:1.3rem;cursor:pointer;box-shadow:0 4px 20px rgba(13,27,62,.4);transition:all .2s;display:flex;align-items:center;justify-content:center">
    <i class="fas fa-comments" id="chatbot-icon"></i>
  </button>

  <div id="chatbot-window"
    style="display:none;position:absolute;bottom:68px;right:0;width:340px;background:#fff;border-radius:16px;box-shadow:0 8px 40px rgba(13,27,62,.2);border:1px solid #dde0ea;overflow:hidden;flex-direction:column">

    {{-- Header --}}
    <div style="background:linear-gradient(135deg,#0d1b3e,#1a2d5a);padding:14px 18px;display:flex;align-items:center;gap:10px">
      <div style="width:36px;height:36px;background:rgba(201,168,76,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;border:1px solid rgba(201,168,76,.3)">
        <i class="fas fa-robot" style="color:#c9a84c;font-size:.9rem"></i>
      </div>
      <div>
        <div style="color:#fff;font-weight:700;font-size:.88rem">{{ $botName }}</div>
        <div style="color:rgba(255,255,255,.5);font-size:.68rem">Asisten Perpustakaan {{ $siteName }}</div>
      </div>
      <button onclick="toggleChatbot()" style="margin-left:auto;background:none;border:none;color:rgba(255,255,255,.5);cursor:pointer;font-size:1rem;padding:4px">
        <i class="fas fa-times"></i>
      </button>
    </div>

    {{-- Messages --}}
    <div id="chatbot-messages"
      style="overflow-y:auto;padding:16px;display:flex;flex-direction:column;gap:10px;max-height:320px;min-height:200px;background:#f8f9fc">
      <div class="cb-msg bot">
        <div style="background:#0d1b3e;color:#fff;border-radius:12px 12px 12px 3px;padding:10px 14px;font-size:.82rem;line-height:1.5;max-width:88%;white-space:pre-line">
          Halo! 👋 Saya <strong>{{ $botName }}</strong>, asisten perpustakaan {{ $siteName }}.<br>Ada yang bisa saya bantu?
        </div>
      </div>
      <div id="welcome-suggestions" style="display:flex;flex-wrap:wrap;gap:6px">
        <button class="cb-chip" onclick="sendSuggestion('Cara pinjam buku')">Cara pinjam buku</button>
        <button class="cb-chip" onclick="sendSuggestion('Cari buku')">Cari buku</button>
        <button class="cb-chip" onclick="sendSuggestion('Status peminjaman saya')">Status pinjaman</button>
        <button class="cb-chip" onclick="sendSuggestion('Denda keterlambatan')">Denda</button>
      </div>
    </div>

    {{-- Input --}}
    <div style="padding:12px 14px;border-top:1px solid #dde0ea;background:#fff;display:flex;gap:8px">
      <input id="chatbot-input" type="text" placeholder="Ketik pesan..."
        style="flex:1;height:38px;padding:0 12px;border:1.5px solid #dde0ea;border-radius:10px;font-size:.82rem;outline:none;font-family:inherit;transition:border-color .2s"
        onfocus="this.style.borderColor='#c9a84c'"
        onblur="this.style.borderColor='#dde0ea'"
        onkeydown="if(event.key==='Enter')sendMessage()">
      <button onclick="sendMessage()"
        style="width:38px;height:38px;border-radius:10px;background:#c9a84c;border:none;color:#0d1b3e;font-size:.9rem;cursor:pointer;display:flex;align-items:center;justify-content:center"
        onmouseover="this.style.background='#e8c97a'" onmouseout="this.style.background='#c9a84c'">
        <i class="fas fa-paper-plane"></i>
      </button>
    </div>
  </div>
</div>

<style>
.cb-chip{padding:5px 12px;border-radius:99px;border:1.5px solid #c9a84c;background:rgba(201,168,76,.08);color:#8a6a1a;font-size:.72rem;font-weight:600;cursor:pointer;transition:all .15s;font-family:'DM Sans',sans-serif}
.cb-chip:hover{background:#c9a84c;color:#0d1b3e}
#chatbot-messages::-webkit-scrollbar{width:3px}
#chatbot-messages::-webkit-scrollbar-thumb{background:#c4c8d8;border-radius:99px}
</style>

<script>
const CHATBOT_URL='{{ route("chatbot.reply") }}';
const CSRF='{{ csrf_token() }}';
let chatbotOpen=false;

function toggleChatbot(){
  chatbotOpen=!chatbotOpen;
  const win=document.getElementById('chatbot-window');
  const icon=document.getElementById('chatbot-icon');
  win.style.display=chatbotOpen?'flex':'none';
  win.style.flexDirection='column';
  icon.className=chatbotOpen?'fas fa-times':'fas fa-comments';
  if(chatbotOpen){setTimeout(()=>document.getElementById('chatbot-input').focus(),100);scrollToBottom();}
}

function appendMessage(text,type){
  const msgs=document.getElementById('chatbot-messages');
  const div=document.createElement('div');
  div.style.cssText='display:flex;'+(type==='user'?'justify-content:flex-end':'');
  const bubble=document.createElement('div');
  bubble.style.cssText=type==='user'
    ?'background:#c9a84c;color:#0d1b3e;border-radius:12px 12px 3px 12px;padding:10px 14px;font-size:.82rem;line-height:1.5;max-width:82%;font-weight:500'
    :'background:#0d1b3e;color:#fff;border-radius:12px 12px 12px 3px;padding:10px 14px;font-size:.82rem;line-height:1.5;max-width:88%;white-space:pre-line';
  bubble.textContent=text;
  div.appendChild(bubble);msgs.appendChild(div);scrollToBottom();
}

function appendSuggestions(suggestions){
  if(!suggestions||!suggestions.length)return;
  const msgs=document.getElementById('chatbot-messages');
  const wrap=document.createElement('div');
  wrap.style.cssText='display:flex;flex-wrap:wrap;gap:6px';
  suggestions.forEach(s=>{const btn=document.createElement('button');btn.className='cb-chip';btn.textContent=s;btn.onclick=()=>sendSuggestion(s);wrap.appendChild(btn);});
  msgs.appendChild(wrap);scrollToBottom();
}

function showTyping(){
  const msgs=document.getElementById('chatbot-messages');
  const div=document.createElement('div');div.id='cb-typing';div.style.cssText='display:flex';
  div.innerHTML=`<div style="background:#0d1b3e;color:rgba(255,255,255,.5);border-radius:12px 12px 12px 3px;padding:10px 14px;font-size:.78rem">{{ $botName }} sedang mengetik...</div>`;
  msgs.appendChild(div);scrollToBottom();
}

function removeTyping(){const t=document.getElementById('cb-typing');if(t)t.remove();}
function scrollToBottom(){const msgs=document.getElementById('chatbot-messages');setTimeout(()=>msgs.scrollTop=msgs.scrollHeight,50);}

async function sendMessage(){
  const input=document.getElementById('chatbot-input');
  const msg=input.value.trim();if(!msg)return;
  input.value='';
  const ws=document.getElementById('welcome-suggestions');if(ws)ws.style.display='none';
  appendMessage(msg,'user');showTyping();
  try{
    const res=await fetch(CHATBOT_URL,{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF,'Accept':'application/json'},body:JSON.stringify({message:msg})});
    const data=await res.json();removeTyping();appendMessage(data.reply,'bot');appendSuggestions(data.suggestions);
  }catch(e){removeTyping();appendMessage('Maaf, terjadi gangguan koneksi. Silakan coba lagi.','bot');}
}

function sendSuggestion(text){document.getElementById('chatbot-input').value=text;sendMessage();}
</script>
