<?php
namespace App\Http\Controllers;
use App\Models\{Book, Category};
use Illuminate\Http\Request;

class DashboardController extends Controller {
    public function dashboard(Request $request) {
        if ($request->search) return redirect()->route('buku', ['search'=>$request->search]);
        $categories    = Category::withCount('books')->get();
        $trendingBooks = Book::orderBy('borrowed_count','desc')->where('stock','>',0)->take(8)->get();
        $newBooks      = Book::latest()->take(8)->get();
        $topBooks      = Book::orderBy('borrowed_count','desc')->take(10)->get();
        return view('dashboard', compact('categories','trendingBooks','newBooks','topBooks'));
    }
}
