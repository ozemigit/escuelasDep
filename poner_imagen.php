<html>
<head>
    <title>PERSONALIZAR</title>
    <link href="styleCSS.css" rel="stylesheet" type="text/css"/>
</head>
<body>

<?php include "header.html"; ?>

<div id="contenedor">
    <div id="menu">
        <?php include "menu.html"; ?>
    </div>

    <div id="contenido">

        <form enctype="multipart/form-data" action="" method="POST">
            <label>Selecciona imagen</label>
            <input type="file" name="archivo">
            <br><input type="submit" name="enviar" value="CAMBIAR LOGO">
        </form>

        <?php
            if(isset($_POST["enviar"])){
                if(!isset($_FILES["archivo"]))
                {
                    echo "NO HAS SELECCIONADO NINGUN ARCHIVO";
                    echo '<a href="inicio.html">Subir archivo</a>';
                }
                else {
                    $nombre = $_FILES["archivo"]['name'];
                    $nombre_tmp = $_FILES["archivo"]["tmp_name"];

                    if (exif_imagetype($nombre_tmp)) {
                        copy($nombre_tmp, "imagenes/logo.png");
                        echo '<span class="bieen">LOGO ACTUALIZADO CON ÉXITO</span>';
                        clearstatcache();
                        header("");
                    } else {
                        echo 'ERROR. No es un archivo de imagen';
                    }
                }
            }

        ?>
    </div>
</div>
</body>
</html>