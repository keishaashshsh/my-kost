<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $guarded = [];
    protected $casts = ['due_date' => 'date', 'paid_at' => 'datetime'];

    public function contract() { return $this->belongsTo(Contract::class); }
}
