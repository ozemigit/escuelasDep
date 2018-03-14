<html>
<head>
    <title>BORRAR DEPORTES</title>
    <link href="styleCSS.css" rel="stylesheet" type="text/css"/>
</head>
<body>

<?php include "header.html"; ?>

<div id="contenedor">
    <div id="menu">
        <a href="mante_deportes.php"><img src="imagenes/back.png"> VOLVER</a>
    </div>
    <div id="contenido">
    <?php
        require_once ("OperacionesBBDD.php");
        $objBD=new conexion();
        $iddeporte = $_GET["iddeporte"];

        //consulto los datos del deporte a borrar
        $query = "SELECT * FROM deportes where IdDeporte = $iddeporte";
        $objBD->consultarBD($query);
        $fila=$objBD->devolverFilas();
        $deporte = $fila["Nombre"];
        $img=$fila["imagen"]; //guardo la ruta de la img deporte para borrarla despues
        echo '<span class="error">';
        echo 'Se dispone a BORRAR el Deporte: '.strtoupper($fila["Nombre"]).'</br>';
        echo '</span>';
        //lo que viene a continuacion solo para los colectivos
        if($fila["Tipo"] == 'C'){
            $query = "SELECT * FROM equipos where IdDeporteColectivo = $iddeporte";
            $objBD->consultarBD($query);
            while($fila=$objBD->devolverFilas()){
                echo '<span class="error">';
                echo "El EQUIPO de $deporte cuyo nombre es ".strtoupper($fila["Nombre"])." tambien será borrado.<br>";
                echo '</span>';
            }
        }
        //ahora por si los deportes tienen alumnos
        $query = "SELECT IdDeporte, alumno.IdAlumno, alumno.Nombre FROM alumnos_deporte INNER JOIN alumno on alumnos_deporte.IdAlumno = alumno.IdAlumno WHERE IdDeporte = $iddeporte";
        $objBD->consultarBD($query);

        while($fila=$objBD->devolverFilas()){
            echo '<span class="error">';
            echo "La INSCRIPCION del alumno de $deporte cuyo nombre es ".strtoupper($fila["Nombre"])." tambien será borrada.<br>";
            echo '</span>';
        }
    ?>
        <form action="#" method="POST">
            <label>Esta seguro?: </label>
            <input type="submit" name="borrar" value="CONTINUAR"/>
        </form>
        <a href="mante_deportes.php">Mejor no, retroceder</a>
    <?php
        if (isset($_POST["borrar"])){

            //primero borro los alumnos de ese equipo de ese deporte
            $query = "DELETE from alumnos_equipo where IdDeporteColectivo = $iddeporte";
            $objBD->consultarBD($query);
            //despues el equipo
            $query = "DELETE from equipos where IdDeporteColectivo = $iddeporte";
            $objBD->consultarBD($query);
            //despues las inscripciones a ese deporte
            $query = "DELETE from alumnos_deporte where IdDeporte = $iddeporte";
            $objBD->consultarBD($query);
            //y por ultimo el deporte
            $query = "DELETE from deportes where IdDeporte = $iddeporte";
            $objBD->consultarBD($query);

            if(!$objBD->comprobarError()){
                if($objBD->filasAfectadas()) {
                    unlink("imgDeportes/".$img);
                    //echo '<span class="bieen">DEPORTE BORRADO CORRECTAMENTE.</span>';
                    header("location: mante_deportes.php");
                }
            }else{
                die($objBD->comprobarError());
            }

        }

    ?>
    </div>
</div>
</body>
</html>