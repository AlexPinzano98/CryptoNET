<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
</head>
<body>

<form method="get" action="{{url('/verProductos')}}">
    <button type='submit' ><i class="fas fa-shopping-cart"></i></button>
</form>

<table>
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        @foreach($productosCarrito as $productos)
            <tr>
                <td>

                </td>
                <td>{{$productos->nombre}}</td>
                <td>{{$productos->precio}}</td>
                <td>
                    <form method="post" action="{{url('/borrar/'.$productos->id_producto)}}">
                    {{csrf_field()}}
                    {{method_field('DELETE')}}
                    <button type='submit' class="btn btn-danger" onclick="return confirm('¿Borrar?');">Borrar</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    <form method="post" action="{{url('/borrar/'.$productos->id_producto)}}">
        {{csrf_field()}}
        <button type='submit' class="btn btn-danger" onclick="return confirm('¿Desea pagar?');">PAGAR</button>
    </form>
</body>
</html>
