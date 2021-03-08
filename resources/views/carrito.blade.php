<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <script src="{{asset('js/code.js')}}"></script>
    <meta name="csrf-token" id="token" content="{{ csrf_token() }}">
</head>
<body>

<form method="get" action="{{url('/verProductos')}}">
    <button type='submit'><i class="fab fa-bitcoin fa-3x"></i></button>
</form>

<table style="text-align: center;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Unidades</th>
                <th>Precio total</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        @foreach($productosCarrito as $producto)
            <tr>
                <td>{{$producto->id_producto}}</td>
                <td>
                    <img src="{{asset('storage').'/'.$producto->foto}}" width="100">
                </td>
                <td>{{$producto->nombre}}</td>
                <td>{{$producto->precio}}</td>
                <td>
                    <i onclick="restarUnidad('{{$producto->id_producto}}','{{$producto->precio}}')" class="fas fa-minus-square"></i>
                    <input type="number" id="{{$producto->id_producto}}" value="{{$producto->unidades}}" style="width: 30px; text-align: center; padding-left: 15px;" readonly>
                    <i onclick="sumarUnidad('{{$producto->id_producto}}','{{$producto->precio}}')" class="fas fa-plus-square"></i>
                </td>
                <td>
                    <input type="number" id="pt-{{$producto->id_producto}}" value="{{$producto->preciototal}}" style="width: 50px; text-align: center; padding-left: 15px;" readonly>
                </td>
                <td>
                    <form method="post" action="{{url('/borrar/'.$producto->id_producto)}}">
                    {{csrf_field()}}
                    {{method_field('DELETE')}}
                    <button type='submit' class="btn btn-danger" onclick="return confirm('¿Borrar?');">Borrar</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    <h1>Precio total</h1>
    <!-- Al hacer click saldrá una ventana modal que mostrara el precio total y una descripcion de la compra -->
    <form method="get" action="{{url('/pagar')}}">
        <button type="submit">PAGAR</button>
    </form>
</body>
</html>
