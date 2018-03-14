<html>
<head>
    <title>AÑADIR EQUIPO</title>
    <link href="styleCSS.css" rel="stylesheet" type="text/css"/>
</head>
<body>

<?php include "header.html"; ?>

<div id="contenedor">
    <div id="menu">
        <a href="mante_equipos.php"><img src="imagenes/back.png"> VOLVER</a>
    </div>

    <div id="contenido">
        <form method="POST" action="#" class="miFormu">
            <label>Deporte </label>
            <select name="deporte">
                <?php
                require_once ("OperacionesBBDD.php");
                $objBD = new conexion();
                $query="SELECT Nombre, IdDeporte FROM deportes WHERE Tipo='c'";
                $objBD->consultarBD($query);
                while($fila=$objBD->devolverFilas()){
                    echo '<option value="'.$fila["IdDeporte"].'">'.$fila["Nombre"].'</option>';
                }
                ?>
            </select>
            <div><label>Nombre Equipo: </label><br>
            <input type="text" placeholder="Introduzca nombre" name="equipo"/></div>
            <div><label>Codigo Equipo:</label>

            <?php
            //consulta para poner el codEquipo automaticamente
            $query="SELECT MAX(CodEquipo) as ultimoCod FROM equipos";
            $objBD->consultarBD($query);
            $fila=$objBD->devolverFilas();
            $ultimoCod=$fila["ultimoCod"];
            echo '<input type="text" name="codigo" value='.($ultimoCod+1).' readonly><br>';
            ?>
            </div>
            <div><label>Edad Equipo:</label>
            <input type="number" min="5" placeholder="Introduzca la edad del Equipo a añadir" name="edad"/></div>

            <div><input type="submit" name="enviar" value="Confirmar" /></div>
        </form>
    <?php


        if (isset($_POST["enviar"])) //pregunto primero si se ha pulsado enviar
        {
            if($_POST["equipo"]=='' or $_POST["codigo"]=="" or $_POST["edad"]==""){
                die('<span class="error">POR FAVOR RELLENE TODOS LOS DATOS REQUERIDOS(*).</span>');
            }else{

                $query="INSERT INTO equipos (IdDeporteColectivo, CodEquipo, Nombre, Edad) VALUES 
                                (" .$_POST["deporte"]. ", " . $_POST["codigo"] . ", '" . $_POST["equipo"] . "'," . $_POST["edad"] . ")";
                $objBD->consultarBD($query);
            }
            if ($objBD->comprobarError()){
                echo '<span class="error">Operacion No Realizada. ';
                die($objBD->comprobarError());
                echo '</span>';
            }

            //Forma de comprobar si inserto o no
            if($objBD->filasAfectadas()) {
                header("Location: mante_equipos.php");
            }
        }


        ?>
    </div>
</div>
</body>
</html>