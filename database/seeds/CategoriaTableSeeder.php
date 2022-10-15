<?php

use Illuminate\Database\Seeder;
use App\Categoria;

class CategoriaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Categoria::create([
            'nombre' => 'Electrodomésticos',
        ]);
        Categoria::create([
            'nombre' => 'Ropa',
        ]);
        Categoria::create([
            'nombre' => 'Telefonía',
        ]);
        Categoria::create([
            'nombre' => 'Material de oficina',
        ]);
        Categoria::create([
            'nombre' => 'Deportes',
        ]);
    }
}