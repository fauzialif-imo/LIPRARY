<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController, DashboardController, ProfileController, BookController, BorrowingController, ChatbotController, NotificationController};
use App\Http\Controllers\Admin;

// Landing
Route::get('/', [App\Http\Controllers\LandingController::class, 'index']);

// Auth
Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',   [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register',[AuthController::class, 'register']);
Route::post('/logout',  [AuthController::class, 'logout'])->name('logout');

// User (auth required)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('/buku',                       [BookController::class, 'index'])->name('buku');
    Route::get('/buku/{book}',                [BookController::class, 'show'])->name('buku.show');
    Route::post('/buku/{book}/collect',       [BookController::class, 'toggleCollection'])->name('buku.collect');

    Route::get('/pinjam/create',                       [BorrowingController::class, 'create'])->name('borrow.create');
    Route::post('/pinjam',                             [BorrowingController::class, 'store'])->name('borrow.store');
    Route::post('/pinjam/{borrowing}/kembali',         [BorrowingController::class, 'submitReturn'])->name('borrow.return');
    Route::post('/pinjam/{borrowing}/ulasan',          [BorrowingController::class, 'storeReview'])->name('borrow.review');
    Route::get('/pinjam/{borrowing}/bukti',            [BorrowingController::class, 'receipt'])->name('borrow.receipt');
    Route::get('/pinjam/{borrowing}/bukti-kembali',    [BorrowingController::class, 'returnReceipt'])->name('borrow.return-receipt');

    Route::get('/profile',          [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update',  [ProfileController::class, 'update'])->name('profile.update');

    Route::post('/chatbot', [ChatbotController::class, 'reply'])->name('chatbot.reply');

    // Notifications
    Route::get('/notifications',              [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/read-all',    [NotificationController::class, 'markAllRead'])->name('notifications.read-all');
});

// Admin (auth + admin middleware)
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])
    ->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/buku/usulan',              [Admin\BookProposalController::class, 'index'])->name('books.proposals.index');
    Route::get('/buku/usulan/buat',         [Admin\BookProposalController::class, 'create'])->name('books.proposals.create');
    Route::post('/buku/usulan',             [Admin\BookProposalController::class, 'store'])->name('books.proposals.store');
    Route::get('/buku/usulan/{proposal}',   [Admin\BookProposalController::class, 'show'])->name('books.proposals.show');
    Route::post('/buku/usulan/{proposal}/setujui', [Admin\BookProposalController::class, 'approve'])->name('books.proposals.approve');
    Route::post('/buku/usulan/{proposal}/tolak',   [Admin\BookProposalController::class, 'reject'])->name('books.proposals.reject');
    Route::delete('/buku/usulan/{proposal}',       [Admin\BookProposalController::class, 'destroy'])->name('books.proposals.destroy');

    Route::resource('books', Admin\BookController::class);

    Route::get('/kategori',                    [Admin\CategoryController::class, 'index'])->name('categories.index');
    Route::post('/kategori',                   [Admin\CategoryController::class, 'store'])->name('categories.store');
    Route::put('/kategori/{category}',         [Admin\CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/kategori/{category}',      [Admin\CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/users',                [Admin\UserController::class, 'index'])->name('users.index');
    Route::post('/users',               [Admin\UserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}',         [Admin\UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}',      [Admin\UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/aktif',  [Admin\UserController::class, 'activate'])->name('users.activate');

    Route::get('/peminjaman',                               [Admin\BorrowingController::class, 'index'])->name('borrowings.index');
    Route::post('/peminjaman/{borrowing}/setujui',          [Admin\BorrowingController::class, 'approveBorrow'])->name('borrowings.approve');
    Route::post('/peminjaman/{borrowing}/tolak',            [Admin\BorrowingController::class, 'rejectBorrow'])->name('borrowings.reject');
    Route::post('/peminjaman/{borrowing}/setujui-kembali',  [Admin\BorrowingController::class, 'approveReturn'])->name('borrowings.approve-return');
    Route::post('/peminjaman/{borrowing}/tolak-kembali',    [Admin\BorrowingController::class, 'rejectReturn'])->name('borrowings.reject-return');
    Route::post('/peminjaman/{borrowing}/catatan',          [Admin\BorrowingController::class, 'addNote'])->name('borrowings.note');

    Route::get('/ulasan',              [Admin\ReviewController::class, 'index'])->name('reviews.index');
    Route::delete('/ulasan/{review}',  [Admin\ReviewController::class, 'destroy'])->name('reviews.destroy');

    Route::get('/laporan',             [Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('/laporan/buku',        [Admin\ReportController::class, 'books'])->name('reports.books');
    Route::get('/laporan/peminjaman',  [Admin\ReportController::class, 'borrowings'])->name('reports.borrowings');
    Route::get('/laporan/petugas',     [Admin\ReportController::class, 'staff'])->name('reports.staff');
    Route::get('/laporan/user',        [Admin\ReportController::class, 'users'])->name('reports.users');

    // Site Settings — per section (admin only)
    Route::get('/pengaturan/hero',      [Admin\SettingController::class, 'hero'])->name('settings.hero');
    Route::put('/pengaturan/hero',      [Admin\SettingController::class, 'updateHero'])->name('settings.hero.update');

    Route::get('/pengaturan/tentang',   [Admin\SettingController::class, 'tentang'])->name('settings.tentang');
    Route::put('/pengaturan/tentang',   [Admin\SettingController::class, 'updateTentang'])->name('settings.tentang.update');

    Route::get('/pengaturan/fitur',     [Admin\SettingController::class, 'fitur'])->name('settings.fitur');
    Route::put('/pengaturan/fitur',     [Admin\SettingController::class, 'updateFitur'])->name('settings.fitur.update');

    Route::get('/pengaturan/kategori',  [Admin\SettingController::class, 'kategori'])->name('settings.kategori');
    Route::put('/pengaturan/kategori',  [Admin\SettingController::class, 'updateKategori'])->name('settings.kategori.update');

    // Legacy redirect
    Route::get('/pengaturan',  fn() => redirect()->route('admin.settings.hero'))->name('settings.index');
});
