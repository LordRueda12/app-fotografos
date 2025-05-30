<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'client_id',
        'photographer_id',
        'details',
        'total',
        'status',
    ];

    protected $casts = [
        'details' => 'array',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function photographer()
    {
        return $this->belongsTo(User::class, 'photographer_id');
    }
}
