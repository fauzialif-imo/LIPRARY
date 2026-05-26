<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name','username','email','password','alamat','phone','profile_photo','role','is_active'];
    protected $hidden = ['password','remember_token'];
    protected $casts = ['email_verified_at'=>'datetime','password'=>'hashed','is_active'=>'boolean'];

    public function isAdmin(): bool    { return $this->role === 'admin'; }
    public function isPetugas(): bool  { return in_array($this->role, ['admin','petugas']); }

    public function borrowings()  { return $this->hasMany(Borrowing::class); }
    public function reviews()     { return $this->hasMany(Review::class); }
    public function collections() { return $this->hasMany(Collection::class); }

    public function activeBorrowings() {
        return $this->borrowings()->whereNotIn('status', ['returned','rejected']);
    }

    public function getAvatarUrlAttribute(): string {
        if ($this->profile_photo) return asset('storage/'.$this->profile_photo);
        $initial = strtoupper(substr($this->username, 0, 1));
        return 'https://placehold.co/80x80/0d1b3e/c9a84c?text='.$initial;
    }
}
