<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\{Book, Category};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller {
    public function index(Request $request) {
        $query = Book::with('category');
        if ($request->search) $query->where(fn($q) => $q->where('title','like',"%{$request->search}%")->orWhere('author','like',"%{$request->search}%")->orWhere('isbn','like',"%{$request->search}%"));
        if ($request->category_id) $query->where('category_id', $request->category_id);
        if ($request->status === 'available') $query->where('stock','>',0);
        elseif ($request->status === 'empty') $query->where('stock',0);
        $books = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::withCount('books')->orderBy('name')->get();
        return view('admin.books.index', compact('books','categories'));
    }
    public function create() {
        $categories = Category::active()->orderBy('name')->get();
        return view('admin.books.create', compact('categories'));
    }
    public function store(Request $request) {
        $data = $request->validate([
            'category_id'=>'required|exists:categories,id','title'=>'required|string|max:255','author'=>'required|string|max:255',
            'publisher'=>'required|string|max:255','publish_date'=>'nullable|integer|min:1900|max:'.(date('Y')+1),
            'isbn'=>'nullable|string|max:20|unique:books','pages'=>'nullable|integer|min:1','language'=>'nullable|string|max:50',
            'synopsis'=>'nullable|string','cover'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:2048','stock'=>'required|integer|min:0',
        ]);
        if (!empty($data['publish_date'])) $data['publish_date'] = $data['publish_date'].'-01-01';
        if ($request->hasFile('cover')) $data['cover'] = $request->file('cover')->store('covers','public');
        Book::create($data);
        return redirect()->route('admin.books.index')->with('success','Buku berhasil ditambahkan!');
    }
    public function show(Book $book) {
        $book->load(['category','reviews.user','borrowings.user']);
        return view('admin.books.show', compact('book'));
    }
    public function edit(Book $book) {
        $categories = Category::active()->orderBy('name')->get();
        return view('admin.books.edit', compact('book','categories'));
    }
    public function update(Request $request, Book $book) {
        $data = $request->validate([
            'category_id'=>'required|exists:categories,id','title'=>'required|string|max:255','author'=>'required|string|max:255',
            'publisher'=>'required|string|max:255','publish_date'=>'nullable|integer|min:1900|max:'.(date('Y')+1),
            'isbn'=>'nullable|string|max:20|unique:books,isbn,'.$book->id,'pages'=>'nullable|integer|min:1',
            'synopsis'=>'nullable|string','cover'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:2048','stock'=>'required|integer|min:0',
        ]);
        if (!empty($data['publish_date'])) $data['publish_date'] = $data['publish_date'].'-01-01';
        if ($request->hasFile('cover')) {
            if ($book->cover) Storage::disk('public')->delete($book->cover);
            $data['cover'] = $request->file('cover')->store('covers','public');
        }
        $book->update($data);
        return redirect()->route('admin.books.index')->with('success','Buku berhasil diperbarui!');
    }
    public function destroy(Book $book) {
        if ($book->cover) Storage::disk('public')->delete($book->cover);
        $book->delete();
        return back()->with('success','Buku berhasil dihapus!');
    }
}
