<html>
<head>
    <title>MODIFICAR ALUMNOS</title>
    <link href="styleCSS.css" rel="stylesheet" type="text/css"/>
</head>
<body>

<?php include "header.html"; ?>

<div id="contenedor">
    <div id="menu">
        <a href="ver_inscripciones.php"><img src="imagenes/back.png"> VOLVER</a>
    </div>
    <div id="contenido">
        <h1>MODIFICACIONES</h1>
        <?php
        $idalumno = $_GET["idalumno"];
        require_once ("OperacionesBBDD.php");
        $objBD=new conexion();
        $query = "SELECT * FROM alumno where IdAlumno = $idalumno";
        $objBD->consultarBD($query);
        $fila=$objBD->devolverFilas();
        echo '<h4>Elige la opcion que deseas editar del alumno: '.strtoupper($fila["Nombre"]);
        echo '</h4>
        
        <div>
            <a href="modificar_datospersonales.php?idalumno='.$idalumno.'">Modificar Datos Personales</a>
        </div>
        
        <br>
        <div>
            <a href="modificar_datos_deportivos.php?idalumno='.$idalumno.'">Modificar Deportes</a>
        </div>';
        ?>

    </div>
</div>
</body>
</html>