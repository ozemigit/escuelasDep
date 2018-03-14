<html>
<head>
    <title>MODIFICAR DEPORTES</title>
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

        $query = "SELECT * FROM deportes where IdDeporte = $iddeporte";
        $objBD->consultarBD($query);

        $fila=$objBD->devolverFilas();
        echo '
			<form action="#" method="POST" enctype="multipart/form-data">
				<label>ID_DEPORTE: </label>
				<input type="text" name="iddep" disabled="disabled" value="'.$iddeporte.'"/>
				<label>Nombre: </label>
				<input type="text" name="nombreN" value="'.$fila["Nombre"].'"/>
				<div><label>Tipo del deporte: </label>';
                if($fila["Tipo"]=='C'){
                    echo '<br/><input type="radio" name="tipo" value="c" checked/>Colectivo';
                    echo '<br/><input type="radio" name="tipo" value="i"/>Individual</div>';
                }else{
                    echo '<br/><input type="radio" name="tipo" value="c"/>Colectivo';
                    echo '<br/><input type="radio" name="tipo" value="i" checked/>Individual</div>';
                }
                echo '<div class="modimg"><img src="imgDeportes/'.$fila["imagen"].'"></div><br/>';
                echo 'Si quiere cambiar imagen seleccione otra:';
                echo '<input type="file" style="color: transparent" title="Selecciona desde tu pc" name="imagen" value="'.$fila["imagen"].'"><br/>';
				echo '<input type="submit" name="modif" value="Modificar"/>
			</form> 
			
		';

        if (isset($_POST["modif"])){
            if(empty($_POST["nombreN"])){
                echo '<span class="error">Hay campos vacios.</span>';
            }else {

                if ($_FILES["imagen"]['name']!="") {
                    $img=$fila["imagen"]; //guardo la ruta de la img deporte para borrarla despues
                    $nombreImagen = $_FILES["imagen"]['name'];
                    $nombreImagen_tmp = $_FILES["imagen"]["tmp_name"];

                    if(file_exists("imgDeportes/".$nombreImagen))
                    {
                        die("ERROR. Ya existe una imagen con este nombre <a href=\"mante_deportes.php\"><button>VOLVER</button></a>") ;
                    }

                    if (exif_imagetype($nombreImagen_tmp)) {
                        copy($nombreImagen_tmp, "imgDeportes/$nombreImagen");
                        $nombreImagen = "'" . $nombreImagen . "'";
                    } else {
                        die ('ERROR. No es un archivo de imagen <a href="mante_deportes.php"><button>VOLVER</button></a>');
                    }
                    $query = "UPDATE deportes SET Nombre='" . $_POST["nombreN"] . "', Tipo='" . $_POST["tipo"] . "', imagen=$nombreImagen where IdDeporte='" . $iddeporte . "'";
                } else {
                    $query = "UPDATE deportes SET Nombre='" . $_POST["nombreN"] . "', Tipo='" . $_POST["tipo"] . "' where IdDeporte='" . $iddeporte . "'";
                }

                $objBD->consultarBD($query);
//                echo $query;

                //Forma de comprobar si MODIFICO o no
                if(!$objBD->comprobarError() && $objBD->filasAfectadas()){
                    if (isset($img)){
                        unlink("imgDeportes/".$img);
                    }
                    header("Location: mante_deportes.php");
//                    echo '<span class="bieen">DEPORTE MODIFICADO CORRECTAMENTE.</span>';
//                    echo '<a href="mante_deportes.php"><button>VOLVER</button></a>';

                }else{
                    echo "<span class='error'>Error: No se realizo ninguna modificacion.</span><br />".$objBD->comprobarError();
                    echo '<a href="mante_deportes.php"><br>Salir</a>';
                }
//                if ($objBD->filasAfectadas()) {
//                    if (isset($img)){
//                        unlink("imgDeportes/".$img);
//                    }
//                    echo '<span class="bieen">DEPORTE MODIFICADO CORRECTAMENTE.</span>';
//                    echo '<a href="mante_deportes.php"><button>VOLVER</button></a>';
//                } else {
//                    echo "<span class='error'>Error: No se realizo ninguna modificacion.</span><br />".$objBD->comprobarError();
//                    echo '<a href="mante_deportes.php">Mejor no, retroceder</a>';
//                }
            }
        }else{
            echo '<a href="mante_deportes.php">Mejor no, retroceder</a>';
        }

        ?>
    </div>
</div>
</body>
</html>