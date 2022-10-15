<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $table = 'detalle_ventas';
    protected $fillable = ['id_producto', 'id_venta', 'cantidad'];
    public $timestamps = false;

    public function producto()
    {
        return $this->belongsTo('App\Producto', 'id_producto');
    }

    public function venta()
    {
        return $this->belongsTo('App\Venta', 'id_venta');
    }
}