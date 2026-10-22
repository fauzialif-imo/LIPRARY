<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\Setting;

class ChatbotController extends Controller
{
    private string $geminiKey;
    private string $geminiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-3.8-flash:generateContent';

    public function __construct()
    {
        $this->geminiKey = env('GEMINI_API_KEY', '');
    }

    public function reply(Request $request): JsonResponse
    {
        $message  = strtolower(trim($request->input('message', '')));
        $original = trim($request->input('message', ''));
        $siteName = Setting::get('navbar_site_name', 'YomuLib');

        // 1. Greeting
        if ($this->matches($message, ['halo','hai','hi','selamat','hei','hy','hello','hey'])) {
            return $this->respond(
                "Halo! 👋 Saya asisten perpustakaan {$siteName}. Ada yang bisa saya bantu?",
                ['Cara pinjam buku','Cari buku','Status peminjaman saya','Denda keterlambatan']
            );
        }

        // 2. Cari buku
        if ($this->matches($message, ['cari','ada buku','buku apa','judul','pengarang','author','koleksi'])) {
            return $this->handleSearchBook($message);
        }

        // 3. Cara pinjam
        if ($this->matches($message, ['cara pinjam','bagaimana pinjam','gimana pinjam','prosedur','langkah','pinjam buku'])) {
            return $this->respond(
                "Cara meminjam buku di {$siteName}:\n\n1️⃣ Buka halaman Koleksi dan cari buku yang diinginkan\n2️⃣ Klik tombol \"Pinjam\" pada halaman detail buku\n3️⃣ Tunggu konfirmasi dari petugas (1×24 jam)\n4️⃣ Setelah disetujui, buku siap dipinjam\n\n📌 Pastikan akun kamu sudah aktif ya!",
                ['Berapa lama masa peminjaman?','Bagaimana cara pengembalian?','Denda keterlambatan']
            );
        }

        // 4. Durasi pinjam
        if ($this->matches($message, ['berapa lama','durasi','batas waktu','lama pinjam','masa pinjam','berapa hari'])) {
            return $this->respond(
                "⏱ Masa peminjaman di {$siteName} adalah **7 hari** sejak disetujui.\n\nJika melewati batas waktu, akan dikenakan denda Rp 2.000 per hari. Kamu bisa mengajukan pengembalian kapan saja melalui menu peminjaman.",
                ['Denda keterlambatan','Cara perpanjang peminjaman','Bagaimana cara pengembalian?']
            );
        }

        // 5. Cara kembali
        if ($this->matches($message, ['kembalikan','pengembalian','cara kembali','mau kembali','return'])) {
            return $this->respond(
                "Cara mengembalikan buku:\n\n1️⃣ Buka menu Peminjaman di dashboard\n2️⃣ Klik \"Ajukan Pengembalian\" pada buku yang ingin dikembalikan\n3️⃣ Petugas akan memverifikasi pengembalian\n4️⃣ Status akan berubah menjadi \"Sudah Dikembalikan\"\n\n⚠️ Pastikan buku dikembalikan dalam kondisi baik!",
                ['Denda keterlambatan','Status peminjaman saya','Buku rusak atau hilang']
            );
        }

        // 6. Denda
        if ($this->matches($message, ['denda','telat','terlambat','keterlambatan','lewat batas'])) {
            return $this->respond(
                "💰 Denda keterlambatan {$siteName}:\n\n• Rp 2.000 per hari keterlambatan\n• Dihitung sejak tanggal jatuh tempo\n• Denda dibayarkan saat pengembalian\n\nContoh: terlambat 5 hari = Rp 10.000",
                ['Cara pengembalian','Status peminjaman saya','Hubungi petugas']
            );
        }

        // 7. Status peminjaman
        if ($this->matches($message, ['status','pinjaman saya','sedang pinjam','peminjaman saya','history','riwayat'])) {
            return $this->handleBorrowingStatus();
        }

        // 8. Buku rusak/hilang
        if ($this->matches($message, ['rusak','hilang','damage','lost'])) {
            return $this->respond(
                "😟 Jika buku rusak atau hilang:\n\n• Segera hubungi petugas perpustakaan\n• Akan dilakukan evaluasi kondisi\n• Penggantian biaya sesuai kebijakan perpustakaan\n\nJangan panik — segera lapor agar dapat ditangani dengan baik.",
                ['Hubungi petugas','Status peminjaman saya']
            );
        }

        // 9. Stok/ketersediaan
        if ($this->matches($message, ['stok','tersedia','habis','tidak ada','ketersediaan'])) {
            return $this->handleStock();
        }

        // 10. Aktivasi akun
        if ($this->matches($message, ['aktif','aktivasi','akun','belum aktif','kenapa tidak bisa'])) {
            return $this->respond(
                "🔐 Aktivasi akun:\n\nAkun baru memerlukan aktivasi oleh admin sebelum bisa meminjam buku. Biasanya proses ini memakan waktu 1×24 jam.\n\nJika sudah lama menunggu, silakan hubungi petugas perpustakaan.",
                ['Hubungi petugas','Cara pinjam buku']
            );
        }

        // 11. Kontak
        if ($this->matches($message, ['hubungi','kontak','bantuan','admin','petugas','telepon','email'])) {
            return $this->respond(
                "📞 Hubungi kami:\n\n• 📱 WhatsApp: +62 812 3456 7890\n• 📧 Email: info@smk.sch.id\n• 🌐 Website: www.yomulib.co.id\n• 📍 Alamat: Tajung Utik, Kec. Gb, Putri, Kab. Bogor\n\nJam operasional: Senin–Jumat, 08.00–16.00 WIB",
                ['Cara pinjam buku','Denda keterlambatan']
            );
        }

        // 12. Kategori
        if ($this->matches($message, ['kategori','genre','jenis','fiksi','non fiksi','pemrograman','novel','komik'])) {
            return $this->handleCategories();
        }

        // 13. Ulasan/rating
        if ($this->matches($message, ['ulasan','review','rating','bintang','komentar'])) {
            return $this->respond(
                "⭐ Ulasan buku:\n\nKamu bisa memberikan ulasan dan rating setelah mengembalikan buku. Caranya:\n1. Buka riwayat peminjaman\n2. Klik \"Beri Ulasan\" pada buku yang sudah dikembalikan\n3. Berikan rating 1–5 bintang dan komentar",
                ['Status peminjaman saya','Cara pinjam buku']
            );
        }

        // 14. Perpanjang
        if ($this->matches($message, ['perpanjang','extend','tambah waktu'])) {
            return $this->respond(
                "⏳ Perpanjangan peminjaman:\n\nSaat ini {$siteName} belum memiliki fitur perpanjangan otomatis. Jika kamu membutuhkan waktu lebih, silakan:\n1. Kembalikan buku terlebih dahulu\n2. Pinjam kembali jika stok masih tersedia\n\nAtau hubungi petugas untuk kebijakan khusus.",
                ['Cara pengembalian','Hubungi petugas','Denda keterlambatan']
            );
        }

        // 15. Fallback → Gemini AI
        return $this->callGemini($original, $siteName);
    }

    // ── Gemini AI fallback ────────────────────────────────────────────
    private function callGemini(string $message, string $siteName): JsonResponse
    {
        if (empty($this->geminiKey)) {
            return $this->respond(
                "Maaf, saya kurang memahami pertanyaan kamu. 😅\n\nSilakan pilih topik di bawah atau coba tanyakan dengan kata yang berbeda:",
                ['Cara pinjam buku','Cari buku','Status peminjaman saya','Denda keterlambatan','Hubungi petugas']
            );
        }

        try {
            $systemPrompt = "Kamu adalah asisten perpustakaan digital bernama {$siteName}Bot. "
                . "Bantu pengguna menjawab pertanyaan seputar perpustakaan, buku, peminjaman, pengembalian, denda, dan layanan perpustakaan {$siteName}. "
                . "Jawab dalam Bahasa Indonesia yang ramah, singkat, dan jelas (maksimal 4 kalimat). "
                . "Jika pertanyaan tidak berhubungan dengan perpustakaan, jawab: \"Maaf, saya hanya bisa membantu seputar layanan perpustakaan {$siteName}.\"";

            $response = Http::timeout(20)
                ->withOptions(['verify' => false])
                ->post(
                $this->geminiUrl . '?key=' . $this->geminiKey,
                [
                    'contents' => [
                        [
                            'role'  => 'user',
                            'parts' => [['text' => $systemPrompt . "\n\nPertanyaan: " . $message]],
                        ]
                    ],
                    'generationConfig' => [
                        'temperature'     => 0.7,
                        'maxOutputTokens' => 256,
                    ],
                ]
            );

            if ($response->successful()) {
                $data  = $response->json();
                $reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
                if ($reply) {
                    return $this->respond(
                        trim($reply),
                        ['Cara pinjam buku','Cari buku','Status peminjaman saya','Hubungi petugas']
                    );
                }
            }
        } catch (\Throwable $e) {
            // fall through
        }

        // Hard fallback
        return $this->respond(
            "Maaf, saya kurang memahami pertanyaan kamu. 😅\n\nSilakan pilih topik di bawah atau coba tanyakan dengan kata yang berbeda:",
            ['Cara pinjam buku','Cari buku','Status peminjaman saya','Denda keterlambatan','Hubungi petugas']
        );
    }

    // ── Intent handlers ───────────────────────────────────────────────
    private function handleSearchBook(string $message): JsonResponse
    {
        $term = '';
        foreach (['cari buku','cari','ada buku','buku apa','judul','pengarang','author'] as $kw) {
            if (str_contains($message, $kw)) {
                $term = trim(substr($message, strpos($message, $kw) + strlen($kw)));
                break;
            }
        }
        $term = trim(preg_replace('/^(tentang|yang|berjudul|dengan|oleh)\s+/i', '', $term));

        if ($term === '') {
            return $this->respond(
                "Silakan sebutkan judul atau nama penulis yang ingin dicari.\nContoh: 'cari buku Laskar Pelangi'",
                ['Lihat semua koleksi','Cari berdasarkan kategori']
            );
        }

        $books = Book::where('title','like',"%{$term}%")
            ->orWhere('author','like',"%{$term}%")
            ->take(4)->get();

        if ($books->isEmpty()) {
            return $this->respond(
                "Maaf, buku '{$term}' tidak ditemukan. Coba kata kunci lain atau lihat koleksi lengkap kami.",
                ['Lihat semua koleksi','Cari berdasarkan kategori']
            );
        }

        $list = $books->map(fn($b) => "• {$b->title} — {$b->author} (" . ($b->isAvailable() ? 'Tersedia' : 'Tidak Tersedia') . ")")->implode("\n");
        return $this->respond("Ditemukan {$books->count()} buku:\n{$list}", ['Lihat semua koleksi']);
    }

    private function handleBorrowingStatus(): JsonResponse
    {
        if (!auth()->check()) {
            return $this->respond(
                "Silakan login terlebih dahulu untuk melihat status peminjaman.",
                ['Cara pinjam buku']
            );
        }
        $borrowings = Borrowing::where('user_id', auth()->id())->with('book')->latest()->take(3)->get();
        if ($borrowings->isEmpty()) {
            return $this->respond("Kamu belum memiliki riwayat peminjaman.", ['Cara pinjam buku']);
        }
        $list = $borrowings->map(fn($b) => "• " . (optional($b->book)->title ?? '?') . " — {$b->status_label}")->implode("\n");
        return $this->respond("Riwayat peminjaman terakhirmu:\n{$list}", ['Cara pengembalian']);
    }

    private function handleStock(): JsonResponse
    {
        $available   = Book::where('stock','>',0)->count();
        $unavailable = Book::where('stock',0)->count();
        return $this->respond(
            "📚 Ketersediaan koleksi saat ini:\n• Tersedia: {$available} buku\n• Tidak tersedia: {$unavailable} buku",
            ['Cari buku','Lihat semua koleksi']
        );
    }

    private function handleCategories(): JsonResponse
    {
        $cats = Category::withCount('books')->get();
        if ($cats->isEmpty()) return $this->respond("Belum ada kategori.", ['Cari buku']);
        $list = $cats->map(fn($c) => "• " . ($c->icon ?? '📁') . " {$c->name} ({$c->books_count} buku)")->implode("\n");
        return $this->respond("📂 Kategori yang tersedia:\n{$list}", ['Cari buku','Cara pinjam buku']);
    }

    // ── Helpers ───────────────────────────────────────────────────────
    private function matches(string $message, array $keywords): bool
    {
        foreach ($keywords as $kw) {
            if (str_contains($message, $kw)) return true;
        }
        return false;
    }

    private function respond(string $reply, array $suggestions = []): JsonResponse
    {
        return response()->json(['reply' => $reply, 'suggestions' => $suggestions]);
    }
}
