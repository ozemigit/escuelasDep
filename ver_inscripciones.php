<html>
<head>
    <title>INSCRIPCIONES</title>
    <link href="styleCSS.css" rel="stylesheet" type="text/css"/>
</head>
<body>

<?php include "header.html"; ?>

<div id="contenedor">
    <div id="menu">
        <?php include "menu.html"; ?>
    </div>

    <div id="contenido">
        <h2>ALUMNOS</h2>
        <?php
            require_once ("OperacionesBBDD.php");
            $objBD=new conexion();

            $query = "SELECT * FROM alumno";
            $objBD->consultarBD($query);
        ?>
        <div id='nuevo'>
            <a href='alumnos.php'><img style="float: left" title="VOLVER" src='imagenes/back.png'/></a>
            NUEVA INSCRIPCION:<a href='inscripciones.php'><img src='imagenes/anadir.png'/></a>
        </div>
        <table id='todosAlumnos'>
            <tr>
                <th>ID:</th>
                <th colspan="2">DATOS DE LOS ALUMNOS:</th>
                <th>DEPORTES:</th>
                <th>FOTO:</th>
                <th>EDITAR</th>
                <th>BORRAR</th>
            </tr>
        <?php
            while ($fila = $objBD->devolverFilas()) {
                echo '<tr>
                    <td>'.$fila["IdAlumno"].'</td>
                    <td>'.$fila["Nombre"].'<br/>'.$fila["FechaNacimiento"].'<br/>'.$fila["Telefono"].'</td>
                    <td>'.$fila["Direccion"].'<br/>'.$fila["Poblacion"].'<br/>'.$fila["Correo"].'<br/>ESTU</td>
                    <td>';include "consultadeporte.php"; echo '</td>
                    <td>FOTO</td>
                    <td><a href="modificar_alumnos.php?idalumno='.$fila["IdAlumno"].'"><img src="imagenes/edit.png"></a></td>
                    <td><a href="borrar_alumnos.php?idalumno='.$fila["IdAlumno"].'"><img src="imagenes/papelera.png"></a></td>
                </tr>';
            }
        ?>
        </table>
        <div id='nuevo'>
            <a href='alumnos.php'><img style="float: left" title="VOLVER" src='imagenes/back.png'/></a>
            NUEVA INSCRIPCION:
            <a href='inscripciones.php'><img src='imagenes/anadir.png'/></a>
        </div>
    </div>
</div>
</body>
</html>