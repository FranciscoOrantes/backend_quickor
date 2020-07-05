<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>maras</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>
<body>



<form action="registro-marca" method="post" files="true" enctype="multipart/form-data">
        {{csrf_field()}}

    <br>

    <label for="">Nombre</label>
    <input type="text" name="nombre" id="">
    <br>

    <label for="">Logo</label>
    <input type="file" name="logo" id="" required>  <!--Aqui iria la Url del Audio a seleccionar, 
    Sería mejor dejarlo como un Boton para cargar el Archivo-->
    
    <button>Crear</button>
    </form>
    <a href="http://127.0.0.1:8000">Cancelar</a>



    

</body>
</html>