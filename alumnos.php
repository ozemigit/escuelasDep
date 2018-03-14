<html>
<head>
    <title>ALUMNOS</title>
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
        ?>
        <form method="post" action="#">
            Introduce busqueda: <input type="text" name="id"/>
            <input type="submit" name="enviar" value="BUSCAR">
        </form>
        <button><a href="ver_inscripciones.php">VER TODAS INSCRIPCIONES</a></button>
        <?php
        if (isset($_POST["enviar"])) {


            $query = "SELECT * FROM alumno WHERE idAlumno =".$_POST["id"];
            $objBD->consultarBD($query);

            echo "<table>";
            while ($fila = $objBD->devolverFilas()) {
                echo '<tr>
                        <td>NOMBRE:</td><td>DIRECCION:</td><td>POBLACION:</td><td>TFNO:</td><td>CORREO:</td><td>FECHANACIMIENTO:</td>
                        <td>ESTUDIANTE G:</td><td>FOTO:</td>
                    </tr>';
                echo '<tr><td>'.$fila["Nombre"].'</td><td>'.$fila["Direccion"].'</td><td>'.$fila["Poblacion"].'</td>
                           <td>'.$fila["Telefono"].'</td><td>'.$fila["Correo"].'</td><td>'.$fila["FechaNacimiento"].'</td>
                           <td>ESTU</td><td>FOTO</td>
                      </tr>';
            }
        }
        ?>
        </table>
        <div id='nuevo'>NUEVA INSCRIPCION:
            <a href='inscripciones.php'><img src='imagenes/anadir.png'/></a>
        </div>
    </div>
</div>
</body>
</html>