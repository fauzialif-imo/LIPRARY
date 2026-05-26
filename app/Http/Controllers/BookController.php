<?php
namespace App\Http\Controllers;
use App\Models\{Book, Category, Collection};
use Illuminate\Http\Request;

class BookController extends Controller {
    public function index(Request $request) {
        $query = Book::with('category');
        if ($request->search) $query->where(fn($q)=>$q->where('title','like',"%{$request->search}%")->orWhere('author','like',"%{$request->search}%"));
        if ($request->category) $query->whereHas('category',fn($q)=>$q->where('slug',$request->category));
        $books = $query->latest()->paginate(12)->withQueryString();
        $categories = Category::withCount('books')->get();
        $selectedCategory = $request->category;
        return view('buku', compact('books','categories','selectedCategory'));
    }
    public function show(Book $book) {
        $book->load(['category','reviews.user']);
        $reviews = $book->reviews()->with('user')->latest()->get();
        $userCollection = null;
        if (auth()->check()) $userCollection = Collection::where('user_id',auth()->id())->where('book_id',$book->id)->first();
        $relatedBooks = Book::where('category_id',$book->category_id)->where('id','!=',$book->id)->take(4)->get();
        return view('buku_detail', compact('book','reviews','userCollection','relatedBooks'));
    }
    public function toggleCollection(Book $book) {
        $existing = Collection::where('user_id',auth()->id())->where('book_id',$book->id)->first();
        if ($existing) { $existing->delete(); return back()->with('info','Buku dihapus dari koleksi.'); }
        Collection::create(['user_id'=>auth()->id(),'book_id'=>$book->id]);
        return back()->with('success','Buku ditambahkan ke koleksi!');
    }
}
