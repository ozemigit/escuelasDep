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
        <?php
        require_once ("OperacionesBBDD.php");
        $objBD=new conexion();

        $idalumno = $_GET["idalumno"];

        echo '<div>';
        echo '<h2>Esta inscrito en los siguientes deportes: </h2>';
            $query = "SELECT alumnos_deporte.IdDeporte, deportes.Nombre 
                      FROM `alumnos_deporte` inner JOIN deportes 
                      ON alumnos_deporte.IdDeporte = deportes.IdDeporte 
                      WHERE IdAlumno =".$idalumno;
            $objBD->consultarBD($query);
        if($objBD->numeroFilas()==0){
            echo '<br/>No está apuntado a ningun deporte<br/>';
        }
        echo '<br/>';
            while ($fila=$objBD->devolverFilas()){
                echo $fila["Nombre"];
                echo '<a href="modificar_datos_deportivos.php?idalumno='.$idalumno.'&dep='.$fila["IdDeporte"].'&des=si"><button class="boton1">Desapuntarme</button></a><br/><br/>';
                echo '<br>';
            }
        echo '</div>';
        echo '<div>';
        echo '<h2>Se puede inscribir en los siguientes deportes: </h2>';
        $query = "SELECT * FROM deportes WHERE IdDeporte NOT IN 
                  (SELECT IdDeporte FROM alumnos_deporte WHERE IdAlumno='.$idalumno.')";
        $objBD->consultarBD($query);
        if($objBD->numeroFilas()==0){
            echo '<br/>No hay deportes disponibles a lso que apuntarse.<br/>';
        }
        echo '<br/>';
        while ($fila=$objBD->devolverFilas()){
            echo $fila["Nombre"];
            echo '<a href="modificar_datos_deportivos.php?idalumno='.$idalumno.'&dep='.$fila["IdDeporte"].'&apu=si"><button class="boton1">Apuntarme</button></a><br/><br/>';
            echo '<br>';
        }
        echo '</div>';
        echo '<br><a href="modificar_alumnos.php?idalumno='.$idalumno.'">Mejor no, retroceder</a>';

        if(isset($_GET["des"])){
            $id=$_GET["id"];
            $consulta='DELETE FROM alumnos_deporte WHERE IdDeporte='.$_GET["dep"].' AND IdAlumno='.$idalumno;
            $objBD->consultarBD($consulta);
            header('Location:modificar_datos_deportivos.php?idalumno='.$idalumno);
        }

        if(isset($_GET["apu"])){
            $id=$_GET["id"];
            $idDep=$_GET["dep"];
            $consulta="INSERT INTO alumnos_deporte VALUES ('.$idDep.','.$idalumno.')";
            $objBD->consultarBD($consulta);
            header('Location:modificar_datos_deportivos.php?idalumno='.$idalumno);
        }
        ?>
    </div>
</div>
</body>
</html>