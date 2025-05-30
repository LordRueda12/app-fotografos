<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'photographer_id',
    ];

    public function photographer()
    {
        return $this->belongsTo(User::class, 'photographer_id');
    }
}
