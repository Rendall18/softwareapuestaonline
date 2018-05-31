<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Registrar Partidos</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <!-- bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    </head>
    <body>
    
    <div class="container">
        <h1>Registro de Equipos</h1>
        @isset($status)
            @if($status>-1)
                <div class="alert alert-success alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                    <strong>Equipo Registrado con Exito!. :-)</strong>
                </div>
            @elseif($status==-1)
                <div class="alert alert-warning alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                    <strong>Este equipo ya esta registrao :-|</strong>
                </div>
            @else
                <div class="alert alert-danger alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                    <strong>ERROR al registrar Equipo!.:-(</strong>
                </div>
            @endif
        @endisset

        <form action="http://localhost/Laravel/Scraping/Apocalipsis/public/ingresar" method="POST" role="form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
            <div class="form-group">
                <label for="exampleInputEmail1">Nombre BetFair</label>
                <input type="text" class="form-control" name="nombre_betfair" id="nombre_betfair" aria-describedby="nombre_betfair" placeholder="Nombre BetFair">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Nombre Espn</label>
                <input type="text" class="form-control" name="nombre_espn" id="nombre_espn" aria-describedby="nombre_espn" placeholder="Nombre Espn">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Url Espn</label>
                <input type="text" class="form-control" name="url_espn" id="ur_espn" aria-describedby="ur_espn" placeholder="Url Espn">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>

        </form>
    </div>
    </body>
</html>
