<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'phone'];
    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return ['email_verified_at' => 'datetime', 'password' => 'hashed'];
    }

    public function contracts() { return $this->hasMany(Contract::class); }
    public function activeContract() { return $this->hasOne(Contract::class)->where('status', 'aktif')->latestOfMany(); }
    public function isStaff(): bool { return in_array($this->role, ['owner', 'admin']); }
}
