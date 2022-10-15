<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;
use App\Categoria;
use App\DetalleVenta;
use App\Venta;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = Categoria::all();
        $productos = Producto::with('categoria')->get();
        return view('listarProductos', compact('productos', 'categorias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate the request data
        $request->validate([
            'nombre' => 'required',
            'referencia' => 'required',
            'precio' => 'required |integer',
            'peso' => 'required |integer',
            'stock' => 'required |integer',
            'categoria' => 'required'
        ]);
        //first or new es para que no se dupliquen los datos
        $producto = Producto::firstOrCreate(['nombre' => $request->nombre, 'referencia' => $request->referencia, 'precio' => $request->precio, 'peso' => $request->peso, 'stock' => $request->stock, 'id_categoria' => $request->categoria, 'fecha' => date('Y-m-d')]);

        return back()->with('mensaje', 'Producto creado correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $producto = Producto::where('id', $request->id)->with('categoria')->first();
        return response()->json($producto);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //validate the request data
        $request->validate([
            'nombre' => 'required',
            'referencia' => 'required',
            'precio' => 'required |integer',
            'peso' => 'required |integer',
            'stock' => 'required |integer',
            'categoria' => 'required'
        ]);
        $producto = Producto::where('id', $request->id)->update(['nombre' => $request->nombre, 'referencia' => $request->referencia, 'precio' => $request->precio, 'peso' => $request->peso, 'stock' => $request->stock, 'id_categoria' => $request->categoria, 'fecha' => date('Y-m-d')]);
        return back()->with('mensaje', 'Producto actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $producto = Producto::where('id', $request->id)->delete();
        return response()->json(['mensaje'=>'Producto eliminado correctamente']);
    }
    public function ventas(Request $request)
    {
        $venta=Venta::create(['total'=>$request->data['total']]);
        for ($i = 0; $i < count($request->data['carrito']); $i++) {
            $producto = Producto::where('id', $request->data['carrito'][$i]['id'])->first();
            if ($producto->stock >= $request->data['carrito'][$i]['cantidad']) {
                $detalleVenta=DetalleVenta::create(['id_producto'=>$request->data['carrito'][$i]['id'],'id_venta'=>$venta->id,'cantidad'=>$request->data['carrito'][$i]['cantidad']]);
                $producto->stock = $producto->stock - $request->data['carrito'][$i]['cantidad'];
                $producto->save();
            } else {
                return response()->json(['mensaje'=>'No hay suficiente stock del producto '.$producto->nombre], 400);
            }
        }
        return response()->json(['mensaje'=>'Venta realizada correctamente'], 200);
    }
    public function filtrarStrock()
    {
        $productos = Producto::with('categoria')->orderBy('stock', 'desc')->get();
        $categorias = Categoria::all();
        return view('listarProductos', compact('productos', 'categorias'));
    }
    public function filtrarVentas()
    {
        // best-selling products depending on the table DetalleVenta
        $productos=[];
        $productos_ventas= DetalleVenta::selectRaw('id_producto, sum(cantidad) as total')
        ->groupBy('id_producto')
        ->orderBy('total', 'desc')
        ->with('producto')
        ->get();
        for ($i = 0; $i < count($productos_ventas->pluck('id_producto')); $i++) {
            $productos[$i]=Producto::where('id', $productos_ventas->pluck('id_producto')[$i])->first();
        }
        $categorias = Categoria::all();
        return view('listarProductos', compact('productos', 'categorias'));
    }
}