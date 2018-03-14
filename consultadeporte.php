<?php
    $obj2BD = new conexion();
    $query2 = "SELECT deportes.Nombre, IdAlumno 
                    FROM deportes INNER JOIN alumnos_deporte on deportes.IdDeporte = alumnos_deporte.IdDeporte 
                    WHERE IdAlumno =" .$fila["IdAlumno"];
    $obj2BD->consultarBD($query2);
    while ($fila2 = $obj2BD->devolverFilas()) {
        echo $fila2["Nombre"];
        echo '<br>';
    }
?>