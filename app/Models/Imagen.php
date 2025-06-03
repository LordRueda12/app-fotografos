<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    protected $table = 'imagenes';

    protected $fillable = [
        'ruta',
        'categoria_id',
        'user_id',
        'nombre',
    ];
    protected $with = [
        'categoria',
        'user',
    ];
    public function categoria()
    {
        return $this->belongsTo(CategoriaImagen::class, 'categoria_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
