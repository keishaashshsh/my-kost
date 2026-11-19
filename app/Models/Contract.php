<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $guarded = [];
    protected $casts = ['start_date' => 'date', 'end_date' => 'date'];

    public function user() { return $this->belongsTo(User::class); }
    public function room() { return $this->belongsTo(Room::class); }
    public function bills() { return $this->hasMany(Bill::class); }
}
