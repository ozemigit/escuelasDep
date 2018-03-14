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

        $query = "SELECT * FROM alumno where IdAlumno =".$idalumno;
        $objBD->consultarBD($query);

        $fila=$objBD->devolverFilas();
        echo '
			<form action="" class="miFormu" method="POST" enctype="multipart/form-data">
				<div><label>ID_ALUMNO: </label>
				<input type="text" name="iddep" disabled="disabled" value="'.$idalumno.'"/></div>
				<div><label>*Nombre: </label>
				<input type="text" name="nombreN" value="'.$fila["Nombre"].'"/></div>
				<div><label>Direccion: </label>
				<input type="text" name="direccionN" value="'.$fila["Direccion"].'"/></div>
				<div><label>*Poblacion: </label>
				<input type="text" name="poblacionN" value="'.$fila["Poblacion"].'"/></div>
				<div><label>Telefono: </label>
				<input type="text" name="telefonoN" value="'.$fila["Telefono"].'"/></div>
				<div><label>*Correo: </label>
				<input type="text" name="correoN" value="'.$fila["Correo"].'"/></div>
				<br>
				<div><label>*Fecha de Nacimiento: </label>
				<input type="date" name="fechaN" value="'.$fila["FechaNacimiento"].'"/></div>
				<div><label>Estudia en el Guadalupe: </label>
                <br>';
        if($fila["EstudiaGuadalupe"]==1){
            echo '<br/><input type="radio" name="estu" value=0 checked/>SI';
            echo '<br/><input type="radio" name="estu" value=1/>NO</div>';
        }elseif ($fila["EstudiaGuadalupe"] == 0){
            echo '<br/><input type="radio" name="estu" value=0/>SI';
            echo '<br/><input type="radio" name="estu" value=1 checked/>NO</div>';
        }elseif (!isset($fila["EstudiaGuadalupe"])){
            echo '<br/><input type="radio" name="estu" value=0/>SI';
            echo '<br/><input type="radio" name="estu" value=1/>NO</div>';
        }
        echo '<legend>Nota: los datos con (*) son obligatorios.</legend>';
       echo '<div><input type="submit" name="modif" value="Modificar"/></div>
			</form> 
			
		';

        if (isset($_POST["modif"])){
            if(empty($_POST["nombreN"]) || empty($_POST["direccionN"]) || empty($_POST["poblacionN"]) || $_POST["correoN"]=='' || $_POST["fechaN"]==0000-00-00){
                echo '<span class="error">Hay campos vacios. (*)</span>';
            }else {
                $query = "UPDATE alumno SET Nombre='".$_POST["nombreN"]."', Direccion='". $_POST["direccionN"]."', Poblacion='". $_POST["poblacionN"]."'
                , Correo='". $_POST["correoN"]."', FechaNacimiento='". $_POST["fechaN"]."', EstudiaGuadalupe='". $_POST["estu"]."'
                where IdAlumno='" . $idalumno . "'";
                $objBD->consultarBD($query);
//                echo $query;

                //Forma de comprobar si MODIFICO o no
                if(!$objBD->comprobarError() && $objBD->filasAfectadas()){
                    //echo '<span class="bieen">ALUMNO MODIFICADO CORRECTAMENTE.</span>';
                    //echo '<a href="ver_inscripciones.php"><button>VOLVER</button></a>';
                    header("Location: ver_inscripciones.php");
                } else {
                    echo "<span class='error'>Error: Cambios no realizados.</span><br />".$objBD->comprobarError();
                    echo '<a href="ver_inscripciones.php">Mejor no, retroceder</a>';
                }
            }
        }else{
            echo '<a href="modificar_alumnos.php?idalumno='.$idalumno.'">Mejor no, retroceder</a>';
        }

        ?>
    </div>
</div>
</body>
</html>