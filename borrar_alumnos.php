<html>
<head>
    <title>BORRAR ALUMNOS</title>
    <link href="styleCSS.css" rel="stylesheet" type="text/css"/>
</head>
<body>

<?php include "header.html"; ?>

<div id="contenedor">
    <div id="menu">
        <a href="borrar_alumnos.php"><img src="imagenes/back.png"> VOLVER</a>
    </div>
    <div id="contenido">
    <?php
        require_once ("OperacionesBBDD.php");
        $objBD=new conexion();
        $idalumno = $_GET["idalumno"];

        $query = "SELECT Nombre FROM alumno where IdAlumno = $idalumno";
        $objBD->consultarBD($query);
        $fila=$objBD->devolverFilas();
        $nombreAlumno = $fila["Nombre"];
        echo '<span class="error">';
        echo 'Se dispone a BORRAR el Alumno con nombre: '.strtoupper($nombreAlumno).'</br>';
        echo '</span>';

        //consulto los deportes donde esta ese alumno
        $query = "SELECT alumnos_deporte.IdDeporte, IdAlumno, Nombre FROM alumnos_deporte INNER JOIN deportes on alumnos_deporte.IdDeporte = deportes.IdDeporte WHERE alumnos_deporte.IdAlumno = $idalumno";
        $objBD->consultarBD($query);

        while($fila=$objBD->devolverFilas()){
            echo '<span class="error">';
            echo "La INSCRIPCION del alumno de $nombreAlumno a ".strtoupper($fila["Nombre"])." tambien será borrada.<br>";
            echo '</span>';
        }

        echo '
        <form action="#" method="POST">
            <label>Esta seguro?: </label>
            <input type="submit" name="borrar" value="CONTINUAR"/>
        </form> 
        <a href="ver_inscripciones.php">Mejor no, retroceder</a>';
        if (isset($_POST["borrar"])){

            //primero lo borro del equipo en el que esté
            $query = "DELETE from alumnos_equipo where IdAlumno = $idalumno";
            $objBD->consultarBD($query);

            //hacer el delete de alumno_deporte
            $query = "DELETE from alumnos_deporte where IdAlumno = $idalumno";
            $objBD->consultarBD($query);

            //por ultimo hacer el delete de alumno
            $query = "DELETE from alumno where IdAlumno = $idalumno";
            $objBD->consultarBD($query);

            if($objBD->comprobarError()){
                die($objBD->comprobarError());
            }else{
                header("location: ver_inscripciones.php");
            }
        }

    ?>
    </div>
</div>
</body>
</html>