<html>
<head>
    <title>BORRAR EQUIPOS</title>
    <link href="styleCSS.css" rel="stylesheet" type="text/css"/>
</head>
<body>

<?php include "header.html"; ?>

<div id="contenedor">
    <div id="menu">
        <a href="mante_equipos.php"><img src="imagenes/back.png"> VOLVER</a>
    </div>
    <div id="contenido">
    <?php
        require_once ("OperacionesBBDD.php");
        $objBD=new conexion();
        $idequipo = $_GET["idequipo"];

        //consulto los datos del equipo a borrar
        $query = "SELECT * FROM equipos where CodEquipo = $idequipo";
        $objBD->consultarBD($query);
        $fila=$objBD->devolverFilas();
        $equipo = $fila["Nombre"];
        echo '<span class="error">';
        echo 'Se dispone a BORRAR el Equipo: '.strtoupper($fila["Nombre"]).'</br>';
        echo '</span>';
        //ahora por si los equipos tienen alumnos
        $query = "SELECT CodEquipo, alumno.IdAlumno, alumno.Nombre FROM alumnos_equipo INNER JOIN alumno on alumnos_equipo.IdAlumno = alumno.IdAlumno WHERE CodEquipo=".$idequipo;
        $objBD->consultarBD($query);

        while($fila=$objBD->devolverFilas()){
            echo '<span class="error">';
            echo "El alumno de $equipo cuyo nombre es ".strtoupper($fila["Nombre"])." sera sacado del equipo.<br>";
            echo '</span>';
        }
    ?>
        <form action="#" method="POST">
            <label>Esta seguro?: </label>
            <input type="submit" name="borrar" value="CONTINUAR"/>
        </form>
        <a href="mante_equipos.php">Mejor no, retroceder</a>
        <?php
        if (isset($_POST["borrar"])){

            //primero borro los alumnos de ese equipo de ese deporte
            $query = "DELETE from alumnos_equipo where CodEquipo = $idequipo";
            $objBD->consultarBD($query);
            //despues el equipo
            $query = "DELETE from equipos where CodEquipo = $idequipo";
            $objBD->consultarBD($query);


            if(!$objBD->comprobarError()){
                if($objBD->filasAfectadas()) {
                    //echo '<span class="bieen">DEPORTE BORRADO CORRECTAMENTE.</span>';
                    header("location: mante_equipos.php");
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