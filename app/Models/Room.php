<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $guarded = [];

    public function contracts() { return $this->hasMany(Contract::class); }
    public function bookings() { return $this->hasMany(Booking::class); }

    public function facilityList(): array
    {
        return array_filter(array_map('trim', explode(',', $this->facilities ?? '')));
    }
}
