<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" type="text/css">
</head>

<body>
<div class="col-md-6 login-form-1">
    <h2>Inicio Sesión</h2>
    <div class="cont">
        <form action="{{url('/validarlogin')}}" method="POST">
        {{csrf_field()}}
            <input type="email" id="email" class="form-control" placeholder="Usuario..." name="email"><br><br>
            <input type="password" id="pswd" class="form-control" placeholder="Contraseña..." name="pswd"><br><br>
            <button type="submit" value="enviar">Acceder</button>
        </form>
        @if (empty($error))

        @else
            <p style="color:white; border-radius: 8px; border: 3px solid black; background-color: rgb(141, 32, 31); width: 80%; padding: 5%; text-align: center; margin-top: 12%; margin-left: 4%;">{{$error}}<p>

        @endif
        <div id="msg"></div>
    </div>
    <div class="lateral"></div>
</div>
</body>
</html>
