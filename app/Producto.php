<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    protected $fillable = ['nombre', 'referencia', 'precio', 'peso', 'stock', 'id_categoria', 'fecha'];
    public $timestamps = false;

    public function categoria()
    {
        return $this->belongsTo('App\Categoria', 'id_categoria');
    }
}