<html>
<head>
    <title>MANTENIMIENTO EQUIPOS</title>
    <link href="styleCSS.css" rel="stylesheet" type="text/css"/>
</head>
<body>

<?php include "header.html"; ?>

<div id="contenedor">
    <div id="menu">
        <?php include "menu.html"; ?>
    </div>

    <div id="contenido">
        <h2>MANTENIMIENTO EQUIPOS</h2>
        <div id='nuevo'>AÑADIR NUEVO EQUIPO:
            <a href='anadir_equipo.php'><img src='imagenes/anadir.png'/></a>
        </div>
        <?php
        require_once ("OperacionesBBDD.php");
        $objBD=new conexion();

        $query = "SELECT IdDeporteColectivo, Edad, CodEquipo, equipos.Nombre, deportes.Nombre as ndeporte FROM equipos INNER JOIN deportes ON equipos.IdDeporteColectivo = deportes.IdDeporte";
        $objBD->consultarBD($query);

        $fila = $objBD->filasAfectadas();
        if (!$fila) {
            echo "NO HAY EQUIPOS AÑADIDOS";
        } else {

            echo "<div class='equipos'>";
            echo "<table>";
            echo "<tr class='trequipos'><td>ID_Equi:</td><td>EQUIPO:</td><td>DEPORTE:</td><td>EDAD:</td><td>MODIFICAR:</td><td>BORRAR:</td></tr>";
            while ($fila = $objBD->devolverFilas()) {
                echo '<tr><td>'.$fila["CodEquipo"].'</td><td>' . $fila["Nombre"] . '</td><td>' . $fila["ndeporte"] . '</td><td>'.$fila["Edad"].'</td>
                <td><a href="modificar_equipo.php?idequipo='.$fila["CodEquipo"].'"><img src="imagenes/edit.png"></a></img> </a></td>
                <td><a href="borrar_equipo.php?idequipo='.$fila["CodEquipo"].'"><img src="imagenes/papelera.png"></a></img>
                </tr>';
            }
            echo "</table>";
            echo "</div>";
        }
        echo "<div id='nuevo'>AÑADIR NUEVO EQUIPO: 
                        <a href='anadir_equipo.php'><img src='imagenes/anadir.png'/></a>";
        echo "</div>";
        ?>

    </div>
</div>
</body>
</html>