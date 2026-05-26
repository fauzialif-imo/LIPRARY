<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Book, Borrowing, Category, Review, User};

class DashboardController extends Controller {
    public function index() {
        $stats = [
            'total_books'       => Book::count(),
            'total_users'       => User::where('role','user')->count(),
            'total_borrowings'  => Borrowing::count(),
            'active_borrowings' => Borrowing::whereIn('status',['approved','returning'])->count(),
            'pending_borrow'    => Borrowing::where('status','pending')->count(),
            'pending_return'    => Borrowing::where('status','returning')->count(),
            'total_categories'  => Category::count(),
            'total_reviews'     => Review::count(),
        ];
        $recentBorrowings = Borrowing::with(['user','book'])->latest()->take(5)->get();
        $popularBooks = Book::orderBy('borrowed_count','desc')->take(5)->get();
        $db = config('database.default');
        if ($db === 'sqlite') {
            $monthlyData = Borrowing::selectRaw("CAST(strftime('%m', created_at) AS INTEGER) as month, COUNT(*) as total")
                ->whereRaw("strftime('%Y', created_at) = ?", [date('Y')])
                ->groupBy('month')->pluck('total','month')->toArray();
        } else {
            $monthlyData = Borrowing::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')->pluck('total','month')->toArray();
        }
        $chartData = array_fill(1, 12, 0);
        foreach ($monthlyData as $m => $t) $chartData[$m] = $t;
        return view('admin.dashboard', compact('stats','recentBorrowings','popularBooks','chartData'));
    }
}
