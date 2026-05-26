<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class BookProposal extends Model {
    protected $fillable = ['user_id','category_id','title','author','publisher','publish_year','isbn','synopsis','reason','cover','status','reviewed_by','admin_note','reviewed_at'];
    protected $casts = ['reviewed_at'=>'datetime'];

    public function user()     { return $this->belongsTo(User::class); }
    public function category() { return $this->belongsTo(Category::class); }
    public function reviewer() { return $this->belongsTo(User::class, 'reviewed_by'); }

    public function scopePending($q)  { return $q->where('status','pending'); }
    public function scopeApproved($q) { return $q->where('status','approved'); }
    public function scopeRejected($q) { return $q->where('status','rejected'); }

    public function isPending(): bool  { return $this->status === 'pending'; }
    public function isApproved(): bool { return $this->status === 'approved'; }
    public function isRejected(): bool { return $this->status === 'rejected'; }
}
