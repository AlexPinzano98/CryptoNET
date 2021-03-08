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
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body>

<form method="get" action="{{url('/verProductos')}}">
    <button type="submit" class="btn btn-outline-warning">Volver a productos</button>
</form>

<div class="container">
<table class="table">
    <thead class="table-dark">
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
    <tbody>
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
                    <input type="number" id="{{$producto->id_producto}}" value="{{$producto->unidades}}" style="width: 50px; text-align: center; padding-left: 15px;" readonly>
                    <i onclick="sumarUnidad('{{$producto->id_producto}}','{{$producto->precio}}')" class="fas fa-plus-square"></i>
                </td>
                <td>
                    <input type="number" id="pt-{{$producto->id_producto}}" value="{{$producto->preciototal}}" style="width: 100px; text-align: center; padding-left: 15px;" readonly>
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
    </tbody>
</table>
</div>

<br>

    <!-- Al hacer click saldrá una ventana modal que mostrara el precio total y una descripcion de la compra -->
<center>
        <!-- <button type="submit" >PAGAR</button> -->
        <button type="submit" onclick="openModal()" class="btn btn-outline-dark">Pagar</button>
</center>

    <!-- MODAL -->
    <div id="modalUpdate" class="modal">
        <!-- Modal content -->
        <div class="modal-content" style="text-align: center;">
            <span class="close" onclick="closeModal()">&times;</span>

            <h2> CONFIRMA TUS PRODUCTOS </h2>

            <p id="total"></p>

            <p id="desc"></p>

            <input type="submit" id="pagar" value="PAGAR"
            class="btn btn-dark" style="width: 60%; margin: 0 20%;">
        </div>
    </div>
    </div>
</body>
</html>
