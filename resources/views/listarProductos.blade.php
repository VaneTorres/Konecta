@extends('layouts.plantilla')
@section('titulo', 'Listado de productos')
@section('carrito')
    <div class="modal-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Producto</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Precio</th>
                </tr>
            </thead>
            <tbody id="productos_carrito">
            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-outline-success" id="comprar">Comprar</button>
    </div>
@endsection
@section('contenido')

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('mensaje'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('mensaje') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div id="alert"></div>
    <div class="btn-group mb-3" role="group">
        <button class=" btn btn-outline-primary " data-bs-toggle="modal"
            data-bs-target="#formularioAgregar">Agregar</button>
        <div class="btn-group" role="group">
            <button class="btn btn-outline-success dropdown-toggle" data-bs-toggle="dropdown"
                aria-expanded="false">Filtro</button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/">Todos los productos</a></li>
                <li><a class="dropdown-item" href="{{ route('ventas.filtrar') }}"">Los productos más vendidos</a></li>
                <li><a class="dropdown-item" href="{{ route('stock.filtrar') }}">Los productos con más stock</a></li>
            </ul>
        </div>
    </div>
    <table id="table_id" class="display ">
        <thead>
            <tr>
                <th>Referencia</th>
                <th>Producto</th>
                <th>Categoria</th>
                <th>Stock</th>
                <th>Precio</th>
                <th>Peso</th>
                <th>Fecha de creación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productos as $producto)
                <tr>
                    <td>{{ $producto->referencia }}</td>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->categoria->nombre }}</td>
                    <td>{{ $producto->stock }}</td>
                    <td>${{ number_format($producto->precio) }}</td>
                    <td>{{ $producto->peso }}</td>
                    <td>{{ $producto->fecha }}</td>
                    <td>
                        <button onclick="consultarProducto({{ $producto->id }})" class="btn btn-outline-secondary btn-sm"
                            id="editar">Editar</button>
                        <button class="btn btn-outline-danger  btn-sm"
                            onclick="eliminarProducto({{ $producto->id }})">Eliminar</button>
                        <button class="btn btn-outline-dark  btn-sm"
                            onclick="AgregarCarrito({{ $producto->id }},'{{ $producto->nombre }}',{{ $producto->precio }})">Agregar
                            a
                            carrito</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="modal" tabindex="-1" id='formularioAgregar'>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('productos.store') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="referencia" class="form-label">Referencia</label>
                                <input type="text" class="form-control" id="referencia" name="referencia">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="categoria" class="form-label">Categoria</label>
                                <select class="form-select" aria-label="Default select example" id="categoria"
                                    name="categoria">
                                    <option selected>Selecciona una categoria</option>
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="stock" class="form-label">Stock</label>
                                <input type="number" class="form-control" id="stock" name="stock">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="precio" class="form-label">Precio</label>
                                <input type="number" class="form-control" id="precio" name="precio">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="peso" class="form-label">Peso</label>
                                <input type="number" class="form-control" id="peso" name="peso">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-outline-success" id="submit">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" id='formularioEditar'>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('producto.update') }}" method="POST">
                    @method('PUT')
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="referencia" class="form-label">Referencia</label>
                                <input type="text" class="form-control" id="referencia_edit" name="referencia">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre_edit" name="nombre">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="categoria" class="form-label">Categoria</label>
                                <select class="form-select" aria-label="Default select example" id="categoria_edit"
                                    name="categoria">
                                    <option selected>Selecciona una categoria</option>
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="stock" class="form-label">Stock</label>
                                <input type="number" class="form-control" id="stock_edit" name="stock">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="precio" class="form-label">Precio</label>
                                <input type="number" class="form-control" id="precio_edit" name="precio">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="peso" class="form-label">Peso</label>
                                <input type="number" class="form-control" id="peso_edit" name="peso">
                            </div>
                            <input type="hidden" name="id" id="id_edit">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-outline-success" id="submitEdit">Guardar</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function formatMoney(number) {
            return new Intl.NumberFormat("es-CO", {
                style: "currency",
                currency: "COP",
                minimumFractionDigits: 0
            }).format(number);
        }
        var carrito = [];
        var total = 0;
        $(document).ready(function() {

            $('#table_id').DataTable({
                ordering: false,
            });
        });

        function consultarProducto(id) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/producto',
                data: {
                    id: id
                },
                type: 'Post',

                success: function(response) {
                    $('#id_edit').val(response.id);
                    $('#referencia_edit').val(response.referencia);
                    $('#nombre_edit').val(response.nombre);
                    $('#categoria_edit').val(response.categoria.id);
                    $('#stock_edit').val(response.stock);
                    $('#precio_edit').val(response.precio);
                    $('#peso_edit').val(response.peso);
                    $('#formularioEditar').modal('show');

                }
            });
        }

        function eliminarProducto(id) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                },
                url: '/producto/delete',
                data: {
                    id: id
                },
                type: 'DELETE',

                success: function(response) {
                    var successHtml =
                        '<div class="alert alert-success alert-dismissible fade show" role="alert">' + response
                        .mensaje +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                    $('#alert').html(successHtml);
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                }
            });
        }

        function AgregarCarrito(id, nombre, precio) {
            //add to cart
            var item = {
                id: id,
                nombre: nombre,
                precio: precio,
                cantidad: 1
            };
            let existe = false;
            for (var i in carrito) {
                if (carrito[i].id == id) {
                    carrito[i].cantidad++;
                    existe = true;
                    break;
                }
            }
            if (!existe) {
                carrito.push(item);
            }
            //show cart
            let html = "";

            for (var i in carrito) {
                html += "<tr><td>" + carrito[i].nombre + "</td><td>" + carrito[i].cantidad + "</td><td>" + formatMoney(
                        carrito[i].precio) + "</td><td>" + formatMoney(carrito[i].cantidad * carrito[i].precio) +
                    "</td><td><button class='btn btn-outline-danger' onclick='EliminarCarrito(" + i +
                    ")'>Eliminar</button></td></tr>";
                total += carrito[i].cantidad * carrito[i].precio;
            }
            html += "<tr><td colspan='3'>Total</td><td>" + formatMoney(total) + "</td></tr>";
            $("#productos_carrito").html(html);
        }

        function EliminarCarrito(index) {
            carrito.splice(index, 1);
            var html = "";
            var total = 0;
            for (var i in carrito) {
                html += "<tr><td>" + carrito[i].nombre + "</td><td>" + carrito[i].cantidad + "</td><td>" + formatMoney(
                        carrito[i].precio) + "</td><td>" + formatMoney(carrito[i].cantidad * carrito[i].precio) +
                    "</td><td><button class='btn btn-outline-danger' onclick='EliminarCarrito(" + i +
                    ")'>Eliminar</button></td></tr>";
                total += carrito[i].cantidad * carrito[i].precio;
            }
            html += "<tr><td colspan='3'>Total</td><td>" + formatMoney(total) + "</td></tr>";
            $("#productos_carrito").html(html);
        }
        //click en el boton de pagar
        $("#comprar").click(function() {
            //enviar el carrito al servidor
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/ventas',
                data: {

                    data: {
                        carrito: carrito,
                        total: total
                    }
                },
                type: 'POST',
                success: function(response) {
                    var successHtml =
                        '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                        response
                        .mensaje +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                    $('#alert').html(successHtml);
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                }
            });
        });
    </script>
@endsection
