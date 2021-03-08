<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mostrar</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
</head>
<body>

<form method="get" action="{{url('/verCarrito')}}">
    <button type='submit' ><i class="fas fa-shopping-cart fa-3x"></i></button>
</form>

<div class="card">
    <div class="card-body">
        <table class="table table-light">
            <thead class="thead-dark">
                <tr>
                    <th>foto</th>
                    <th>nombre</th>
                    <th>precio</th>
                    <th>añadir al carrito</th>
                </tr>
            </thead>
            <tbody>
            @foreach($productos as $producto)
                <tr>
                    <!-- Insertar foto -->
                    <td style="padding: auto; text-align: center"><img src="{{asset('storage').'/'.$producto->foto}}" width="150"></td>
                    <td>{{$producto->nombre}}</td>
                    <td>{{$producto->precio}}</td>

                    <td>
                        <form method="get" action="{{url('/addCarrito/'.$producto->id_producto.'/'.$producto->precio)}}">
                            <button type='submit' class="btn btn-primary" onclick="return confirm('¿añadir al carrito?');">añadir al carrito</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


</body>
</html>
