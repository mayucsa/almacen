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
	$sql = "SELECT cve_alterna, nombre_articulo, existencia, min, max, costo_unitario, costo_total FROM cat_articulos";
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
function getExcel($dbcon, $tipo, $datos){
	if ($tipo == 'existencias') {
		$sql = "SELECT cve_alterna, nombre_articulo, existencia, min, max, costo_unitario, costo_total FROM cat_articulos";
		$articulos = $dbcon->qBuilder($dbcon->conn(), 'all', $sql);
		$spreadsheet = new Spreadsheet();
		$spreadsheet ->getProperties()->setCreator("LCDevelopersMx")->setTitle("Existencias");
		$spreadsheet->setActiveSheetIndex(0);
		$spreadsheet->getActiveSheet()->setTitle("Existencias");
		$hojaActiva = $spreadsheet->getActiveSheet();
		$hojaActiva->setCellValue('A1', 'Mayucsa');
		$hojaActiva->setCellValue('G1', date('Y/m/d'));

		$hojaActiva->setCellValue('A3', 'cve alterna');
		$hojaActiva->setCellValue('B3', 'Nombre');
		$hojaActiva->setCellValue('C3', 'Existencia');
		$hojaActiva->setCellValue('D3', 'Mínimo');
		$hojaActiva->setCellValue('E3', 'Máximo');
		$hojaActiva->setCellValue('F3', 'Precio unitario');
		$hojaActiva->setCellValue('G3', 'Costo total');

		foreach ($articulos as $key => $value) {
			$hojaActiva->setCellValue('A'.($key+4), $value->cve_alterna);
			$hojaActiva->setCellValue('B'.($key+4), $value->nombre_articulo);
			$hojaActiva->setCellValue('C'.($key+4), $value->existencia);
			$hojaActiva->setCellValue('D'.($key+4), $value->min);
			$hojaActiva->setCellValue('E'.($key+4), $value->max);
			$hojaActiva->setCellValue('F'.($key+4), $value->costo_unitario);
			$hojaActiva->setCellValue('G'.($key+4), $value->costo_total);
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
	if ($tipo == 'RequisicionesAuto') {
		$sql = "SELECT rd.cve_req, tipo, ca.cve_alterna, ca.nombre_articulo , rd.cantidad, cantidad_cotizado, rd.fecha_registro 
		FROM requisicion_detalle rd 
		INNER JOIN requisicion r ON r.cve_req = rd.cve_req 
		INNER JOIN cat_articulos ca ON ca.cve_articulo = rd.cve_art 
		WHERE tipo = 'A' AND r.fecha_registro BETWEEN '".$datos->f_ini."' AND '".$datos->f_fin." 23:59:59'";
		// dd($sql);
		$articulos = $dbcon->qBuilder($dbcon->conn(), 'all', $sql);
		$spreadsheet = new Spreadsheet();
		$spreadsheet ->getProperties()->setCreator("LCDevelopersMx")->setTitle("Requisiciones automáticas");
		$spreadsheet->setActiveSheetIndex(0);
		$spreadsheet->getActiveSheet()->setTitle("Requisiciones automáticas");
		$hojaActiva = $spreadsheet->getActiveSheet();
		$hojaActiva->setCellValue('A1', 'Mayucsa');
		$hojaActiva->setCellValue('G1', date('Y/m/d'));

		$hojaActiva->setCellValue('A3', 'Clave');
		$hojaActiva->setCellValue('B3', 'Tipo');
		$hojaActiva->setCellValue('C3', 'Clave artículo');
		$hojaActiva->setCellValue('D3', 'Descripción artículo');
		$hojaActiva->setCellValue('E3', 'Cantidad');
		$hojaActiva->setCellValue('F3', 'Cantidad cotizado');
		$hojaActiva->setCellValue('G3', 'Fecha registro');

		foreach ($articulos as $key => $value) {
			$hojaActiva->setCellValue('A'.($key+4), $value->cve_req);
			$hojaActiva->setCellValue('B'.($key+4), $value->tipo);
			$hojaActiva->setCellValue('C'.($key+4), $value->cve_alterna);
			$hojaActiva->setCellValue('D'.($key+4), $value->nombre_articulo);
			$hojaActiva->setCellValue('E'.($key+4), $value->cantidad);
			$hojaActiva->setCellValue('F'.($key+4), $value->cantidad_cotizado);
			$hojaActiva->setCellValue('G'.($key+4), $value->fecha_registro);
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
	    $filename = $path."Requisiciones automaticas.xlsx";
		$writer->save($filename);
		dd($filename);
	}
}
function RequisicionesAuto($dbcon, $fechainicio, $fechafin){
	$sql = "SELECT rd.cve_req, tipo, ca.cve_alterna, ca.nombre_articulo , rd.cantidad, cantidad_cotizado, rd.fecha_registro 
	FROM requisicion_detalle rd 
	INNER JOIN requisicion r ON r.cve_req = rd.cve_req 
	INNER JOIN cat_articulos ca ON ca.cve_articulo = rd.cve_art 
	WHERE tipo = 'A' AND r.fecha_registro BETWEEN '".$fechainicio."' AND '".$fechafin." 23:59:59'";
	// dd($sql);
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
		$val->fecha_registro = explode(' ', $val->fecha_registro)[0];
		$resultado[$aux][$i] = $val;
	}
	dd($resultado);
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
		getExcel($dbcon, $objDatos->tipo, $objDatos->datos);
		break;
	case 'RequisicionesAuto':
		RequisicionesAuto($dbcon, $objDatos->fechainicio, $objDatos->fechafin);
		break;
}

?>