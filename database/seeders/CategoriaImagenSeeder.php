<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaImagenSeeder extends Seeder
{
    
    public function run(): void
    {
        DB::table('categoria_imagenes')->insert([
            ['nombre' => 'Boda'],
            ['nombre' => 'retrato'],
            ['nombre' => 'Eventos'],
            ['nombre' => 'Naturaleza'],
            ['nombre' => 'Comercial'],
            ['nombre' => 'Social'],
            ['nombre' => 'Deportivo'],
            ['nombre' => 'Moda'],
        ]);
    }
}
