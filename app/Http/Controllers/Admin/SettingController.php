<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    private function handleImage(Request $request, string $key): void
    {
        if ($request->hasFile($key)) {
            $old = Setting::get($key);
            if ($old && Storage::disk('public')->exists($old)) Storage::disk('public')->delete($old);
            Setting::set($key, $request->file($key)->store('settings','public'));
        }
        if ($request->input("remove_{$key}") === '1') {
            $old = Setting::get($key);
            if ($old && Storage::disk('public')->exists($old)) Storage::disk('public')->delete($old);
            Setting::set($key, null);
        }
    }

    // ── HERO ─────────────────────────────────────────────────────────
    public function hero()
    {
        $s = [
            'hero_bg_image'   => Setting::get('hero_bg_image'),
            'hero_title'      => Setting::get('hero_title','Pintu Gerbang Digital Anda ke Ilmu Pengetahuan'),
            'hero_subtitle'   => Setting::get('hero_subtitle','Akses Buku dan Modul SMK di sini'),
            'navbar_logo'     => Setting::get('navbar_logo'),
            'navbar_site_name'=> Setting::get('navbar_site_name','YOMULIB'),
        ];
        return view('admin.settings.hero', compact('s'));
    }

    public function updateHero(Request $request)
    {
        $request->validate([
            'hero_bg_image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'navbar_logo'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'hero_title'      => 'nullable|string|max:200',
            'hero_subtitle'   => 'nullable|string|max:300',
            'navbar_site_name'=> 'nullable|string|max:60',
        ]);
        $this->handleImage($request, 'hero_bg_image');
        $this->handleImage($request, 'navbar_logo');
        if ($request->filled('hero_title'))      Setting::set('hero_title',      $request->input('hero_title'));
        if ($request->filled('hero_subtitle'))   Setting::set('hero_subtitle',   $request->input('hero_subtitle'));
        Setting::set('navbar_site_name', $request->input('navbar_site_name','YOMULIB'));
        return back()->with('success','Pengaturan Hero berhasil disimpan.');
    }

    // ── TENTANG ───────────────────────────────────────────────────────
    public function tentang()
    {
        $s = ['about_image' => Setting::get('about_image')];
        return view('admin.settings.tentang', compact('s'));
    }

    public function updateTentang(Request $request)
    {
        $request->validate(['about_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096']);
        $this->handleImage($request, 'about_image');
        return back()->with('success','Gambar Tentang berhasil disimpan.');
    }

    // ── FITUR ─────────────────────────────────────────────────────────
    public function fitur()
    {
        $s = [
            'feature_1_image' => Setting::get('feature_1_image'),
            'feature_2_image' => Setting::get('feature_2_image'),
            'feature_3_image' => Setting::get('feature_3_image'),
        ];
        return view('admin.settings.fitur', compact('s'));
    }

    public function updateFitur(Request $request)
    {
        $request->validate([
            'feature_1_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'feature_2_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'feature_3_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);
        $this->handleImage($request, 'feature_1_image');
        $this->handleImage($request, 'feature_2_image');
        $this->handleImage($request, 'feature_3_image');
        return back()->with('success','Gambar Fitur berhasil disimpan.');
    }

    // ── KATEGORI ──────────────────────────────────────────────────────
    public function kategori()
    {
        $s = [
            'category_1_image' => Setting::get('category_1_image'),
            'category_2_image' => Setting::get('category_2_image'),
            'category_3_image' => Setting::get('category_3_image'),
            'category_4_image' => Setting::get('category_4_image'),
        ];
        return view('admin.settings.kategori', compact('s'));
    }

    public function updateKategori(Request $request)
    {
        $request->validate([
            'category_1_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'category_2_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'category_3_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'category_4_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);
        $this->handleImage($request, 'category_1_image');
        $this->handleImage($request, 'category_2_image');
        $this->handleImage($request, 'category_3_image');
        $this->handleImage($request, 'category_4_image');
        return back()->with('success','Gambar Kategori berhasil disimpan.');
    }

    public function index()
    {
        return redirect()->route('admin.settings.hero');
    }
}
