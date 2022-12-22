<?php 

include_once "../../../includes/librerias/fpdf/fpdf.php";
include_once "../../../dbconexion/conexion.php";
include_once "modelo_ordencompra.php";
date_default_timezone_set('America/Mexico_City');
class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
    $this->Image('../../../includes/imagenes/Mayucsa.png',12,8,63);
    // Salto de línea
    $this->Ln(10);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Movernos a la derecha
    $this->Cell(70);
    // Título
    $this->Cell(30,10,'Orden de compra');
    // Salto de línea
    $this->Ln(10);
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// Creación del objeto de la clase heredada
$pdf = new PDF('L','mm','Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','B',10);
// for($i=1;$i<=10;$i++)
    // $pdf->Cell(0,10,'Imprimiendo linea numero '.$i,0,1);

//impresión de fecha actual
$pdf->Cell(150);
$pdf->Cell(50,10,'Fecha: '.date('d-m-Y').'',50);

$pdf->Ln(10);

$pdf->Cell(15, 8, 'Folio req', 0);
$pdf->Cell(35, 8, 'Nombre de articulo', 0);
$pdf->Cell(20, 8, 'Cantidad', 0);
$pdf->Cell(30, 8, 'Precio unitario', 0);
$pdf->Cell(30, 8, 'Precio total', 0);
// $pdf->Cell(30, 8, 'Cantidad', 0);
// $pdf->Cell(30, 8, 'Fecha Registro', 0);

$pdf->Ln(8);

$pdf->SetFont('Arial','',8);
// if (strlen($_GET['fecha_inicio'])>0 AND strlen($_GET['fecha_fin'])>0) {
// $fecha_inicio = $_GET['fecha_inicio'];
// $fecha_fin = $_GET['fecha_fin'];
// }
// $datos = modeloSaqueria::reportepdf($fecha_inicio, $fecha_fin);

// $item = 0;
// foreach ($datos as $key => $value) {
// 	$item = $item + 1;
// 	$pdf->Cell(10, 8, $item, 0);
// 	$pdf->Cell(15, 8, $value['tipo'], 0);
// 	$pdf->Cell(20, 8, $value['codigo'], 0);
// 	$pdf->Cell(40, 8, $value['cve_producto'], 0);
// 	$pdf->Cell(30, 8, $value['valor_presentacion'].' KG', 0);
// 	$pdf->Cell(30, 8, $value['sacos_totales'].' Pzas', 0);
// 	$pdf->Cell(30, 8, $value['fecha_registro'], 0);
// 	$pdf->Ln(8);
// }


$pdf->Output('reporte_saqueria.pdf', 'D');

 ?>