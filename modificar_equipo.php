<html>
<head>
    <title>MODIFICAR EQUIPOS</title>
    <link href="styleCSS.css" rel="stylesheet" type="text/css"/>
</head>
<body>

<?php include "header.html"; ?>

<div id="contenedor">
    <div id="menu">
        <?php include "menu.html"; ?>
    </div>
    <div id="contenido">
        <?php
        require_once ("OperacionesBBDD.php");
        $objBD=new conexion();

        $idequipo = $_GET["idequipo"];

        $query = "SELECT * FROM equipos where CodEquipo = $idequipo";
        $objBD->consultarBD($query);

        $fila=$objBD->devolverFilas();
        echo '
			<form action="#" method="POST" enctype="multipart/form-data">
				<label>ID_EQUIPO: </label>
				<input type="text" name="iddep" disabled="disabled" value="'.$idequipo.'"/>
				<label>Nombre: </label>
				<input type="text" name="nombreN" value="'.$fila["Nombre"].'"/>
                <label>Edad: </label>
                <input type="number" name="anos" value="'.$fila["Edad"].'" ><br>';
				echo '<input type="submit" name="modif" value="Modificar"/>
			</form> 
			
		';

        if (isset($_POST["modif"])){
            if(empty($_POST["nombreN"])){
                echo '<span class="error">Hay campos vacios.</span>';
            }else {
                $query="UPDATE equipos SET Nombre='".$_POST["nombreN"]."',
                                    Edad=".$_POST["anos"]."
                                    WHERE equipos.CodEquipo=" .$idequipo;

                $objBD->consultarBD($query);


                //Forma de comprobar si MODIFICO o no
                if(!$objBD->comprobarError() && $objBD->filasAfectadas()){
                    header("Location: mante_equipos.php");
                } else {
                    echo "<span class='error'>Error: No se realizo ninguna modificacion.</span><br />".$objBD->comprobarError();
                    echo '<a href="mante_equipos.php"><br>Salir</a>';
                }
            }
        }else{
            echo '<a href="mante_equipos.php">Mejor no, retroceder</a>';
        }

        ?>
    </div>
</div>
</body>
</html>