<?php 
require_once '../../../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

date_default_timezone_set('America/Mexico_City');
function dd($var){
    if (is_array($var) || is_object($var)) {
        die(json_encode($var));
    }else{
        die($var);
    }
}

function getArticulos($dbcon, $arti){
	$sql = "SELECT cve_articulo, cve_alterna, nombre_articulo  FROM cat_articulos ca 
	WHERE cve_alterna LIKE '%".$arti."%'
	or
	nombre_articulo LIKE '%".$arti."%'
	ORDER BY nombre_articulo asc";
	$return = $dbcon->qBuilder($dbcon->conn(), 'all', $sql);
	dd($return);
}
function catArticulos($dbcon){
	$sql = "SELECT cve_alterna, nombre_articulo, existencia, min, max, precio_unitario, costo_promedio FROM cat_articulos";
	$articulos = $dbcon->qBuilder($dbcon->conn(), 'all', $sql);
	$resultado = [];
	$aux = 0;
	foreach ($articulos as $i => $val) {
		if($i == 55){
			$aux++;
		}
		if(($i - 55 ) % 65 == 0){
			$aux++;
		}
		$resultado[$aux][$i] = $val;
	}
	dd($resultado);
}
function getExcel($dbcon, $tipo){
	if ($tipo == 'existencias') {
		$sql = "SELECT cve_alterna, nombre_articulo, existencia, min, max, precio_unitario, costo_promedio FROM cat_articulos";
		$articulos = $dbcon->qBuilder($dbcon->conn(), 'all', $sql);
		$spreadsheet = new Spreadsheet();
		$spreadsheet ->getProperties()->setCreator("LCDevelopersMx")->setTitle("Existencias");
		$spreadsheet->setActiveSheetIndex(0);
		$spreadsheet->getActiveSheet()->setTitle("Existencias");
		$hojaActiva = $spreadsheet->getActiveSheet();
		$hojaActiva->setCellValue('A1', 'Mayucsa');
		$hojaActiva->setCellValue('G1', date('Y/m/d'));

		$hojaActiva->setCellValue('A3', 'cve alterna');
		$hojaActiva->setCellValue('B3', 'cve alterna');
		$hojaActiva->setCellValue('C3', 'cve alterna');
		$hojaActiva->setCellValue('D3', 'cve alterna');
		$hojaActiva->setCellValue('E3', 'cve alterna');
		$hojaActiva->setCellValue('F3', 'cve alterna');
		$hojaActiva->setCellValue('G3', 'cve alterna');

		foreach ($articulos as $key => $value) {
			$hojaActiva->setCellValue('A'.($key+4), $value->cve_alterna);
			$hojaActiva->setCellValue('B'.($key+4), $value->nombre_articulo);
			$hojaActiva->setCellValue('C'.($key+4), $value->existencia);
			$hojaActiva->setCellValue('D'.($key+4), $value->min);
			$hojaActiva->setCellValue('E'.($key+4), $value->max);
			$hojaActiva->setCellValue('F'.($key+4), $value->precio_unitario);
			$hojaActiva->setCellValue('G'.($key+4), $value->costo_promedio);
		}
		$hojaActiva->getColumnDimension('A')->setAutoSize(true);
		$hojaActiva->getColumnDimension('B')->setAutoSize(true);
		$hojaActiva->getColumnDimension('C')->setAutoSize(true);
		$hojaActiva->getColumnDimension('D')->setAutoSize(true);
		$hojaActiva->getColumnDimension('E')->setAutoSize(true);
		$hojaActiva->getColumnDimension('F')->setAutoSize(true);
		$hojaActiva->getColumnDimension('G')->setAutoSize(true);
		$hojaActiva->getStyle('A:B')->getAlignment()->setHorizontal('left');
		$writer = new Xlsx($spreadsheet);
		$path = "../../../includees/archivos/excel/";
		if (!file_exists($path)) {
	        mkdir($path,0755,true);
	    }
	    $filename = $path."Reporte de existencia.xlsx";
		$writer->save($filename);
		dd($filename);
	}
}

include_once "../../../dbconexion/conn.php";
$dbcon	= 	new MysqlConn;
$conn 	= 	$dbcon->conn();
// inicio
$tarea = isset($_REQUEST['task']) ? $_REQUEST['task'] : '';
if ($tarea == '') {
	// en caso de que el llamado al controlador haya sido por http post y no por formulario
	$objDatos = json_decode(file_get_contents("php://input"));
	$tarea = $objDatos->task;
}
switch ($tarea){
	case 'getArticulos':
		getArticulos($dbcon, $objDatos->arti);
		break;
	case 'catArticulos':
		catArticulos($dbcon);
		break;
	case 'getExcel':
		getExcel($dbcon, $objDatos->tipo);
		break;
}

?>