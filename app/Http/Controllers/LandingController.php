<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
use App\Models\Setting;

class LandingController extends Controller
{
    public function index()
    {
        $popularBooks = Book::orderBy('borrowed_count','desc')->latest()->take(8)->get();

        $testimonials = Review::with(['user','book'])
            ->where('rating','>=',4)
            ->whereNotNull('comment')
            ->where('comment','!=','')
            ->latest()->take(6)->get();

        $heroBg         = Setting::get('hero_bg_image');
        $heroTitle      = Setting::get('hero_title','Pintu Gerbang Digital Anda ke Ilmu Pengetahuan');
        $heroSub        = Setting::get('hero_subtitle','Akses Buku dan Modul SMK di sini');
        $aboutImage     = Setting::get('about_image');
        $navbarLogo     = Setting::get('navbar_logo');
        $navbarSiteName = Setting::get('navbar_site_name','YOMULIB');

        $featureImages  = [
            1 => Setting::get('feature_1_image'),
            2 => Setting::get('feature_2_image'),
            3 => Setting::get('feature_3_image'),
        ];
        $categoryImages = [
            1 => Setting::get('category_1_image'),
            2 => Setting::get('category_2_image'),
            3 => Setting::get('category_3_image'),
            4 => Setting::get('category_4_image'),
        ];

        return view('landingpage', compact(
            'popularBooks','testimonials',
            'heroBg','heroTitle','heroSub',
            'aboutImage','featureImages','categoryImages',
            'navbarLogo','navbarSiteName'
        ));
    }
}
