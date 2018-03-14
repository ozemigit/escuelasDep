<html>
<head>
    <title>AÑADIR DEPORTES</title>
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
        include "formularios/deporte_form.html";
        require_once ("OperacionesBBDD.php");
        $objBD=new conexion();

        if (isset($_POST["enviar"])) //pregunto primero si se ha pulsado enviar
        {
            if(!isset($_POST["tipo"]) || $_POST["nombre"]==''){
                echo '<span class="error">POR FAVOR RELLENE TODOS LOS DATOS REQUERIDOS(*).</span>';
            }else{

                if(isset($_FILES["imagen"]) && $_FILES["imagen"]['name']!=""){
                    $nombreImagen = $_FILES["imagen"]['name'];
                    $nombreImagen_tmp = $_FILES["imagen"]["tmp_name"];
                    if(file_exists("imgDeportes/".$nombreImagen))
                    {
                        die("<span class=\"error\">ERROR: Esa imagen ya existe en nuestro servidor.</span>") ;
                    }
                    if (exif_imagetype($nombreImagen_tmp)) {
                        copy($nombreImagen_tmp, "imgDeportes/$nombreImagen");
                        $nombreImagen = "'".$nombreImagen."'";
                    } else {
                        die ('<span class="error">ERROR: No es un archivo de imagen. </span>');
                    }
                }else{
                    $nombreImagen = 'NULL';
                }

                $query="INSERT INTO deportes (Nombre,Tipo,imagen)
                    VALUES ('".$_POST["nombre"]."','".$_POST["tipo"]."',".$nombreImagen.")";
                $objBD->consultarBD($query);
            }
            if ($objBD->comprobarError()){
                echo '<span class="error">Operacion No Realizada. ';
                    die($objBD->comprobarError());
                echo '</span>';
            }

            //Forma de comprobar si inserto o no
            if($objBD->filasAfectadas()) {
                echo '<span class="bieen">DEPORTE AÑADIDO CORRECTAMENTE.</span>';
                echo '<a href="mante_deportes.php"><button>VOLVER</button></a>';
            }
        }


        ?>
    </div>
</div>
</body>
</html>