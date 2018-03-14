<html>
<head>
    <title>INSCRIPCIONES ALUMNOS</title>
    <link href="styleCSS.css" rel="stylesheet" type="text/css"/>
</head>
<body>

<?php include "header.html"; ?>

<div id="contenedor">
    <div id="menu">
        <a href="alumnos.php"><img src="imagenes/back.png"> VOLVER</a>
    </div>

    <div id="contenido">
        <h2>INSCRIPCIÓN ALUMNOS</h2>
        <?php
            include "formularios/inscripciones_form.html";
            require_once ("OperacionesBBDD.php");
            $objBD=new conexion();

            //Forma de meter los deportes colectivos
            $query = "SELECT * FROM deportes";
            $objBD->consultarBD($query);
            echo '<div id="der">';
            echo '<div><label style="color: crimson">Deportes COLECTIVOS: </label></div>';
            while($fila=$objBD->devolverFilas()) {
                if($fila["Tipo"]=='C'){
                    echo '<div><input type="checkbox" name="colectivos[]" value="'.$fila["IdDeporte"].'">'.$fila["Nombre"].'</div>';
                }
            }

            //Forma de meter los individuales
            $query = "SELECT * FROM deportes";
            $objBD->consultarBD($query);
            echo '<div><label style="color: crimson">Deportes INDIVIDUALES: </label></div>';
            while($fila=$objBD->devolverFilas()) {
                if($fila["Tipo"]=='I'){
                    echo '<div><input type="checkbox" name="individuales[]" value="'.$fila["IdDeporte"].'">'.$fila["Nombre"].'</div>';
                }
            }
            echo '<div>Imagen de Alumno:<input type="file" name="imagen"/></div>';
            echo '<legend>Nota: los datos con (*) son obligatorios.</legend>';
            echo '<div><input type="submit" name="enviar" value="Añadir"/></div>';
            echo '</div>';
            echo '</form>';
            //////////////////////////////////

            if (isset($_POST["enviar"])) //pregunto primero si se ha pulsado enviar
            {
                if($_POST["nombre"]=='' || $_POST["poblacion"]=='' || $_POST["correo"]=='' || $_POST["fecha"]==0000-00-00){
                    echo '<span class="error">POR FAVOR RELLENE TODOS LOS DATOS. (*)</span>';
                }else{
                    if(isset($_POST["estu"])){
                        $cole = $_POST["estu"];
                    }else{
                        $cole = "NULL";
                    }
//        Parte de subir la foto de los alumnos
                    $archivo = $_FILES["imagen"]["tmp_name"];
                    $tamanio = $_FILES["imagen"]["size"];

                    if ( $archivo != "" )
                    {
                        $fp = fopen($archivo, "rb");
                        $contenido = fread($fp, $tamanio);
                        $contenido = addslashes($contenido);
                        fclose($fp);
                    }
                    else
                        print "No se ha podido subir el archivo al servidor";

                    //compruebo que ese nombre no existe ya en la bd
                    $query ="Select * from alumno where Nombre ='".$_POST["nombre"]."'";
                    $objBD->consultarBD($query);
                    if($objBD->filasAfectadas()) {
                        echo '<span class="error">';
                        die("ERROR: Ese nombre ya esta siendo utilizado.");
                        echo '</span>';
                    }


                    $query="INSERT INTO alumno (Nombre,Direccion,Poblacion,Telefono,Correo,FechaNacimiento,EstudiaGuadalupe,foto)
                        VALUES ('".$_POST["nombre"]."','".$_POST["direc"]."','".$_POST["poblacion"]."',
                                '".$_POST["telefono"]."','".$_POST["correo"]."','".$_POST["fecha"]."',$cole,'$contenido')";

                    $objBD->consultarBD($query);
                    if($objBD->comprobarError()){
                        die("ERROR");
                    }

                    if($objBD->filasAfectadas()) {
                        /*Si la consulta no da error, hacemos el resto de consultas*/
                        $id = $objBD->conexion->insert_id;

                        if(isset($_POST["colectivos"])){
                            foreach ($_POST["colectivos"] as $valor){
                                $consulta = "INSERT INTO alumnos_deporte VALUES($valor,$id)";
                                $objBD->consultarBD($consulta);
                            }
                        }

                        if(isset($_POST["individuales"])){
                            foreach ($_POST["individuales"] as $valor) {
                                $consulta = "INSERT INTO alumnos_deporte VALUES($valor,$id)";
                                $objBD->consultarBD($consulta);
                            }
                        }

                        echo '<span class="bieen">Inscripcion realizada correctamente.</span>';
                        echo '<a href="ver_inscripciones.php"><button>VOLVER</button></a>';
                    } else {
                        echo "error: $objBD->comprobarError()<br />";
                    }
                }
            }


        ?>
    </div>
</div>
</body>
</html>