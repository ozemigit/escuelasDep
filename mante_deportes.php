<html>
	<head>
		<title>MANTENIMIENTO DEPORTES</title>
		<link href="styleCSS.css" rel="stylesheet" type="text/css"/>
	</head>
	<body>
	
		<?php include "header.html"; ?>
		
		<div id="contenedor">
			<div id="menu">
				<?php include "menu.html"; ?>
			</div>
			
			<div id="contenido">
				<h2>MANTENIMIENTO DEPORTES</h2>
                <?php
                    require_once ("OperacionesBBDD.php");
                    $objBD=new conexion();

                    $query = "SELECT * FROM deportes";
                    $objBD->consultarBD($query);

                    $fila = $objBD->filasAfectadas();
                    if (!$fila) {
                        echo "NO HAY EQUIPOS AÑADIDOS";
                    } else {
                        echo "
                        <div id='nuevo'>AÑADIR NUEVO DEPORTE:
                            <a href='anadir_deporte.php'><img src='imagenes/anadir.png'/></a>
                        </div>";
                        echo "<div id='colectivos'>";
                        echo "<table>";
                        echo "<tr><th colspan='4'>DEPORTES COLECTIVOS</th></tr>";
                        while ($fila = $objBD->devolverFilas()) {
                            if ($fila["Tipo"] == 'C') {
                                echo '<tr><td class="tdimg"><img src="imgDeportes/'.$fila["imagen"].'" onerror="this.src=\'default.png\'" /></td><td>'.$fila["Nombre"].'</td>
                                        <td><a href="modificar_deportes.php?iddeporte=' . $fila["IdDeporte"] . '"><img src="imagenes/edit.png"></a></img> </a></td>
                                        <td><a href="borrar_deporte.php?iddeporte=' . $fila["IdDeporte"] . '"><img src="imagenes/papelera.png"></a></img> </a></td></tr>
                                    ';
                            }
                        }
                        echo "</table>";
                        echo "</div>";

                        $objBD->consultarBD($query);
                        echo "<div id='individuales'>";
                        echo "<table>";
                        echo "<tr><th colspan='4'>DEPORTES INDIVIDUALES:</th></tr>";
                        while ($fila = $objBD->devolverFilas()) {
                            if ($fila["Tipo"] == 'I') {
                                echo '<tr><td class="tdimg"><img onerror="this.src=\'default.png\';" src="imgDeportes/' . $fila["imagen"] . '"/></td><td>' . $fila["Nombre"] . '</td>
                                       <td><a href="modificar_deportes.php?iddeporte=' . $fila["IdDeporte"] . '"><img src="imagenes/edit.png"></a></img> </a></td>
                                       <td><a href="borrar_deporte.php?iddeporte=' . $fila["IdDeporte"] . '"><img src="imagenes/papelera.png"></a></img> </a></td></tr>
                                    ';
                            }
                        }
                        echo "</table>";
                        echo "</div>";
                    }
                    ?>
                    <div id='nuevo'>AÑADIR NUEVO DEPORTE:
                        <a href='anadir_deporte.php'><img src='imagenes/anadir.png'/></a>
                    </div>
                    <div >
                        SACAR PDF<a href='sacarpdf.php' target="_blank"><img src='imagenes/print.gif'/></a>
                    </div>
			</div>
		</div>
	</body>
</html>