<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mostrar</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body>

<header style="display: flex; justify-content: center;">
    <form method="get" action="{{url('/verCarrito')}}">
        <button class="carrito" type='submit' ><i style="cursor: pointer; margin-top: 20px" class="fas fa-shopping-cart fa-3x"></i></button>
    </form>

    <a href="cerrar_sesion" class="btn btn-outline-info">Logout</a>
</header>


@foreach($productos as $producto)
    <div class="card">
        <div class="container">
            <img src="{{asset('storage').'/'.$producto->foto}}" style="width: 200px;">
            <br/>
            {{$producto->nombre}}
            <br/>
            <p>{{$producto->precio}}€</p>

                <form method="get" action="{{url('/addCarrito/'.$producto->id_producto.'/'.$producto->precio)}}">
                    <button type='submit' class="btn draw-border" onclick="return confirm('¿añadir al carrito?');">AÑADIR AL CARRITO</button>
                </form>
        </div>
    </div>
@endforeach


</body>
</html>
