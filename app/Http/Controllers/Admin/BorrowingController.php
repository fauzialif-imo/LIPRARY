<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\{Borrowing, Notification};
use Illuminate\Http\Request;

class BorrowingController extends Controller {
    public function index(Request $request) {
        $tab = $request->get('tab','borrowing');
        $query = Borrowing::with(['user','book'])->latest();
        if ($tab==='returning') $query->where('status','returning');
        elseif ($tab==='returned') $query->where('status','returned');
        elseif ($tab==='rejected') $query->where('status','rejected');
        else $query->whereIn('status',['pending','approved']);
        if ($request->search) {
            $s = $request->search;
            $query->where(fn($q) => $q->whereHas('user',fn($u)=>$u->where('username','like',"%$s%"))->orWhereHas('book',fn($b)=>$b->where('title','like',"%$s%")));
        }
        if ($request->from) $query->where('borrow_date','>=',$request->from);
        if ($request->to)   $query->where('borrow_date','<=',$request->to);
        $data = $query->paginate(15)->withQueryString();
        return view('admin.borrowings.index', compact('data','tab'));
    }

    public function approveBorrow(Borrowing $borrowing) {
        if ($borrowing->status !== 'pending') return back()->with('error','Status tidak valid!');
        $borrowing->update(['status'=>'approved']);
        $borrowing->book->decrement('stock');
        $borrowing->book->increment('borrowed_count');

        Notification::send(
            $borrowing->user_id,
            'borrow_approved',
            '✅ Peminjaman Disetujui',
            "Pengajuan pinjam buku \"{$borrowing->book->title}\" telah disetujui. Selamat membaca!",
            ['url' => route('borrow.receipt', $borrowing)]
        );

        return back()->with('success','Peminjaman disetujui!');
    }

    public function rejectBorrow(Borrowing $borrowing) {
        if ($borrowing->status !== 'pending') return back()->with('error','Status tidak valid!');
        $borrowing->update(['status'=>'rejected','admin_note'=>request('admin_note')]);

        $note = request('admin_note') ? " Alasan: ".request('admin_note') : '';
        Notification::send(
            $borrowing->user_id,
            'borrow_rejected',
            '❌ Peminjaman Ditolak',
            "Pengajuan pinjam buku \"{$borrowing->book->title}\" ditolak.{$note}",
            ['url' => route('dashboard')]
        );

        return back()->with('success','Peminjaman ditolak.');
    }

    public function approveReturn(Borrowing $borrowing) {
        if ($borrowing->status !== 'returning') return back()->with('error','Status tidak valid!');
        $fine = $borrowing->calculateFine();
        $borrowing->update(['status'=>'returned','actual_return_date'=>now(),'fine_amount'=>$fine]);
        $borrowing->book->increment('stock');

        $fineMsg = $fine > 0 ? " Ada denda keterlambatan Rp ".number_format($fine,0,',','.')."." : " Terima kasih telah mengembalikan tepat waktu!";
        Notification::send(
            $borrowing->user_id,
            'return_approved',
            '📚 Pengembalian Disetujui',
            "Pengembalian buku \"{$borrowing->book->title}\" telah dikonfirmasi.{$fineMsg}",
            ['url' => route('borrow.return-receipt', $borrowing)]
        );

        return back()->with('success','Pengembalian disetujui!'.($fine>0?" Denda: Rp ".number_format($fine,0,',','.'):''));
    }

    public function rejectReturn(Borrowing $borrowing) {
        if ($borrowing->status !== 'returning') return back()->with('error','Status tidak valid!');
        $borrowing->update(['status'=>'approved','admin_note'=>request('admin_note')]);

        $note = request('admin_note') ? " Alasan: ".request('admin_note') : '';
        Notification::send(
            $borrowing->user_id,
            'return_rejected',
            '⚠️ Pengembalian Ditolak',
            "Pengajuan pengembalian buku \"{$borrowing->book->title}\" ditolak.{$note}",
            ['url' => route('dashboard')]
        );

        return back()->with('success','Pengembalian ditolak.');
    }

    public function addNote(Borrowing $borrowing) {
        $borrowing->update(['admin_note'=>request('admin_note')]);
        return back()->with('success','Catatan disimpan.');
    }
}
