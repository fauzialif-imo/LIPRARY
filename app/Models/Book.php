<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Book extends Model {
    protected $fillable = [
        'category_id','title','author','publisher','publish_date',
        'isbn','pages','language','width','height','weight',
        'synopsis','cover','stock','borrowed_count',
    ];
    protected $casts = ['publish_date'=>'date'];

    public function category()    { return $this->belongsTo(Category::class); }
    public function borrowings()  { return $this->hasMany(Borrowing::class); }
    public function reviews()     { return $this->hasMany(Review::class); }
    public function collections() { return $this->hasMany(Collection::class); }

    public function isAvailable(): bool { return $this->stock > 0; }

    public function avgRating(): float {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }

    public function getCoverUrlAttribute(): string {
        if ($this->cover) return asset('storage/'.$this->cover);
        return 'https://placehold.co/200x280/0d1b3e/c9a84c?text='.urlencode(mb_substr($this->title, 0, 8));
    }
}
