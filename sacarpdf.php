<?php

    define('fpdf181/fpdf.php','fpdf181/font');
    require('fpdf181/fpdf.php');
    $pdf=new FPDF();

    $pdf->AddPage();

    $pdf->SetFont('Arial','B',20);

    $texto="LISTADO DE DEPORTES: ";

    $pdf->Write(10,$texto);
    $pdf->ln(30);
    $pdf->SetFont('Arial','B',16);
    $pdf->SetTextColor(150,20,180);

    $pdf->Cell(30,10,'ID','B',0);
    $pdf->Cell(60,10,'DEPORTE','B',0);
    $pdf->Cell(40,10,'TIPO','B',0);
    $pdf->Cell(40,10,'IMAGEN','B',1);

    $pdf->SetFont('Arial','i',12);
    $pdf->SetTextColor(0,0,0);

    require_once ("OperacionesBBDD.php");

    $objOperacionesBBDD = new conexion();

    $consulta = "SELECT * FROM DEPORTES";

    $objOperacionesBBDD->consultarBD($consulta);
    $i = 51;
    while ($fila = $objOperacionesBBDD->devolverFilas()) {

        $id = $fila["IdDeporte"];
        $nombre = $fila["Nombre"];
        $tipo = $fila["Tipo"];
        $img = $fila["imagen"];


//        $pdf->Cell(30,10,$id,'B',0);
//        $pdf->Cell(60,10,$nombre,'B',0);
//        $pdf->Cell(40,10,$tipo,'B',1);
//        $pdf->Image("imgDeportes/baloncesto.png",150,50,8);

        if($img!= NULL){
            $pdf->Cell(30,10,$id,'B',0);
            $pdf->Cell(60,10,$nombre,'B',0);
            $pdf->Cell(40,10,$tipo,'B',0);
            $pdf->Cell(40,10,NULL,'B',1);
            $pdf->Image("imgDeportes/$img",150,$i,8);

        }else{
            $pdf->Cell(30,10,$id,'B',0);
            $pdf->Cell(60,10,$nombre,'B',0);
            $pdf->Cell(40,10,$tipo,'B',0);
            $pdf->Cell(40,10,NULL,'B',1);
        }
        $i+=10;
    }

    $pdf->Output('ListadoDeporte','i');

?>
