<?php
namespace App\Http\Controllers;
use App\Models\{Borrowing, Book, Review};
use Illuminate\Http\Request;

class BorrowingController extends Controller {
    public function create(Request $request) {
        $book = Book::with('category')->findOrFail($request->book_id);
        abort_if(!$book->isAvailable(), 403, 'Buku tidak tersedia.');
        return view('borrow_create', compact('book'));
    }
    public function store(Request $request) {
        $request->validate(['book_id'=>'required|exists:books,id','borrow_date'=>'required|date|after_or_equal:today','return_date'=>'required|date|after:borrow_date']);
        $book = Book::findOrFail($request->book_id);
        $user = auth()->user();
        if (!$user->is_active) return back()->with('error','Akun Anda belum diaktifkan oleh admin.');
        $activeCount = Borrowing::where('user_id',$user->id)->whereNotIn('status',['returned','rejected'])->count();
        if ($activeCount >= 3) return back()->with('error','Sudah ada 3 peminjaman aktif. Kembalikan buku dulu.');
        if (Borrowing::where('user_id',$user->id)->where('book_id',$book->id)->whereNotIn('status',['returned','rejected'])->exists()) return back()->with('error','Masih ada peminjaman aktif untuk buku ini!');
        if (!$book->isAvailable()) return back()->with('error','Buku sedang tidak tersedia!');
        Borrowing::create(['user_id'=>$user->id,'book_id'=>$book->id,'borrow_date'=>$request->borrow_date,'return_date'=>$request->return_date,'condition'=>'normal','status'=>'pending','user_note'=>$request->notes]);
        return redirect()->route('borrow.create',['book_id'=>$book->id])->with('success', true);
    }
    public function submitReturn(Borrowing $borrowing) {
        if ($borrowing->user_id!==auth()->id() || $borrowing->status!=='approved') return back()->with('error','Tidak dapat mengajukan pengembalian!');
        $borrowing->update(['status'=>'returning']);
        return back()->with('success','Pengajuan pengembalian terkirim! Menunggu konfirmasi admin.');
    }
    public function storeReview(Request $request, Borrowing $borrowing) {
        $request->validate(['rating'=>'required|integer|min:1|max:5','comment'=>'nullable|string|max:500']);
        if ($borrowing->user_id!==auth()->id() || $borrowing->status!=='returned') return back()->with('error','Tidak dapat memberikan ulasan!');
        if ($borrowing->review) return back()->with('error','Sudah memberikan ulasan untuk buku ini!');
        Review::create(['borrowing_id'=>$borrowing->id,'user_id'=>auth()->id(),'book_id'=>$borrowing->book_id,'rating'=>$request->rating,'comment'=>$request->comment]);
        return back()->with('success','Ulasan berhasil dikirim!');
    }
    public function receipt(Borrowing $borrowing) {
        if ($borrowing->user_id!==auth()->id()) abort(403);
        return view('borrow_receipt', compact('borrowing'));
    }
    public function returnReceipt(Borrowing $borrowing) {
        if ($borrowing->user_id!==auth()->id()) abort(403);
        return view('return_receipt', compact('borrowing'));
    }
}
