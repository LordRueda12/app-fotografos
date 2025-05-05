<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaImagen extends Model
{
    protected $table = 'categoria_imagenes';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function imagenes()
    {
        return $this->hasMany(Imagen::class, 'categoria_id');
    }
}
