<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Book, Borrowing, User, Category};
use Illuminate\Http\Request;

class ReportController extends Controller {
    public function index() { return view('admin.reports.index'); }
    public function books(Request $request) {
        $categories = Category::all();
        $books = Book::with('category')->when($request->category_id,fn($q)=>$q->where('category_id',$request->category_id))->orderBy('title')->get();
        if ($request->format==='csv') return $this->exportBooksCsv($books);
        if ($request->format==='pdf') return $this->exportBooksPdf($books);
        return view('admin.reports.books', compact('books','categories'));
    }
    public function borrowings(Request $request) {
        $borrowings = Borrowing::with(['user','book'])->when($request->status,fn($q)=>$q->where('status',$request->status))->when($request->from,fn($q)=>$q->where('borrow_date','>=',$request->from))->when($request->to,fn($q)=>$q->where('borrow_date','<=',$request->to))->latest()->get();
        if ($request->format==='csv') return $this->exportBorrowingsCsv($borrowings);
        if ($request->format==='pdf') return $this->exportBorrowingsPdf($borrowings);
        return view('admin.reports.borrowings', compact('borrowings'));
    }
    public function users(Request $request) {
        $users = User::where('role','user')->withCount('borrowings')->orderBy('username')->get();
        if ($request->format==='csv') return $this->exportUsersCsv($users);
        if ($request->format==='pdf') return $this->exportUsersPdf($users);
        return view('admin.reports.users', compact('users'));
    }
    public function staff(Request $request) {
        $users = User::where('role','petugas')->withCount('borrowings')->orderBy('username')->get();
        if ($request->format==='csv') return $this->exportUsersCsv($users);
        if ($request->format==='pdf') return $this->exportStaffPdf($users);
        return view('admin.reports.staff', compact('users'));
    }
    private function exportBooksCsv($books) {
        $fn='laporan-buku-'.date('Ymd').'.csv';
        $headers=['Content-Type'=>'text/csv; charset=UTF-8','Content-Disposition'=>"attachment; filename=\"$fn\""];
        $cb=function() use ($books){$h=fopen('php://output','w');fprintf($h,chr(0xEF).chr(0xBB).chr(0xBF));fputcsv($h,['No','Judul','Penulis','Penerbit','Kategori','ISBN','Stok','Dipinjam','Rating']);foreach($books as $i=>$b){fputcsv($h,[$i+1,$b->title,$b->author,$b->publisher,$b->category->name??'-',$b->isbn??'-',$b->stock,$b->borrowed_count,number_format($b->avgRating(),1)]);}fclose($h);};
        return response()->stream($cb,200,$headers);
    }
    private function exportBorrowingsCsv($borrowings) {
        $fn='laporan-peminjaman-'.date('Ymd').'.csv';
        $headers=['Content-Type'=>'text/csv; charset=UTF-8','Content-Disposition'=>"attachment; filename=\"$fn\""];
        $cb=function() use ($borrowings){$h=fopen('php://output','w');fprintf($h,chr(0xEF).chr(0xBB).chr(0xBF));fputcsv($h,['No','Peminjam','Email','Buku','Tgl Pinjam','Tgl Kembali','Tgl Aktual','Status','Denda']);foreach($borrowings as $i=>$b){fputcsv($h,[$i+1,$b->user->username,$b->user->email,$b->book->title,$b->borrow_date->format('d/m/Y'),$b->return_date->format('d/m/Y'),$b->actual_return_date?$b->actual_return_date->format('d/m/Y'):'-',$b->status_label,$b->fine_amount>0?'Rp '.number_format($b->fine_amount,0,',','.'):'-']);}fclose($h);};
        return response()->stream($cb,200,$headers);
    }
    private function exportUsersCsv($users) {
        $fn='laporan-user-'.date('Ymd').'.csv';
        $headers=['Content-Type'=>'text/csv; charset=UTF-8','Content-Disposition'=>"attachment; filename=\"$fn\""];
        $cb=function() use ($users){$h=fopen('php://output','w');fprintf($h,chr(0xEF).chr(0xBB).chr(0xBF));fputcsv($h,['No','Username','Email','Alamat','Status','Total Pinjam']);foreach($users as $i=>$u){fputcsv($h,[$i+1,$u->username,$u->email,$u->alamat??'-',$u->is_active?'Aktif':'Nonaktif',$u->borrowings_count]);}fclose($h);};
        return response()->stream($cb,200,$headers);
    }
    private function exportBooksPdf($books) {
        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) { $pdf=\Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reports.pdf.books',compact('books')); return $pdf->download('laporan-buku-'.date('Ymd').'.pdf'); }
        return view('admin.reports.pdf.books', compact('books'));
    }
    private function exportBorrowingsPdf($borrowings) {
        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) { $pdf=\Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reports.pdf.borrowings',compact('borrowings')); return $pdf->download('laporan-peminjaman-'.date('Ymd').'.pdf'); }
        return view('admin.reports.pdf.borrowings', compact('borrowings'));
    }
    private function exportUsersPdf($users) {
        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) { $pdf=\Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reports.pdf.users',compact('users')); return $pdf->download('laporan-user-'.date('Ymd').'.pdf'); }
        return view('admin.reports.pdf.users', compact('users'));
    }
    private function exportStaffPdf($users) {
        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) { $pdf=\Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reports.pdf.staff',compact('users')); return $pdf->download('laporan-petugas-'.date('Ymd').'.pdf'); }
        return view('admin.reports.pdf.staff', compact('users'));
    }
}
