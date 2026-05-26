<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Borrowing extends Model {
    protected $fillable = ['user_id','book_id','borrow_date','return_date','actual_return_date','condition','status','fine_amount','admin_note','user_note'];
    protected $casts = ['borrow_date'=>'date','return_date'=>'date','actual_return_date'=>'date','fine_amount'=>'decimal:2'];

    public function user()   { return $this->belongsTo(User::class); }
    public function book()   { return $this->belongsTo(Book::class); }
    public function review() { return $this->hasOne(Review::class); }

    public function isLate(): bool {
        $compare = $this->actual_return_date ?? now()->toDate();
        return $compare > $this->return_date;
    }
    public function lateDays(): int {
        if (!$this->isLate()) return 0;
        return (int) $this->return_date->diffInDays($this->actual_return_date ?? now());
    }
    public function calculateFine(): float { return $this->lateDays() * 2000; }

    public function getStatusLabelAttribute(): string {
        return match($this->status) {
            'pending'   => 'Menunggu Konfirmasi',
            'approved'  => 'Dipinjam',
            'rejected'  => 'Ditolak',
            'returning' => 'Mengajukan Pengembalian',
            'returned'  => 'Sudah Dikembalikan',
            default     => ucfirst($this->status),
        };
    }
}
