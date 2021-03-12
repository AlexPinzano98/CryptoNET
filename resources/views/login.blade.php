<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- <link href="{{ asset('css/styles.css') }}" rel="stylesheet" type="text/css"> -->
    <link href="{{ asset('css/estilos.css') }}" rel="stylesheet" type="text/css">
</head>

<body>
<div class="containerPrincipal" style="width: 50%; margin-top: 10%;">

    <form action="{{url('/validarlogin')}}" method="POST">
            {{csrf_field()}}
        <div class="containerSecundario">
        <h2>Inicio Sesión</h2><br>
          <div class="form-group">
            <input type="text"
              id="email"
              class="form-control" name="email" placeholder="Email"
            />
            <br />
            <br />
            <input
              type="password"
              id="pswd"
              class="form-control"
              name="pswd"
              placeholder="Password"
            />
            <br />
            <br />
            <button type="submit" class="boton-login">Login</button>
            </form>
            @if (empty($error))

                @else
                    <p class="message">{{$error}}<p><br>
                @endif
            <div id="mensaje"></div>
          </div>
        </div>
      </div>
</body>
</body>
</html>
