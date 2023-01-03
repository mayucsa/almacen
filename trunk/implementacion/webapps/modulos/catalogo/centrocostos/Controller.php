<?php 
date_default_timezone_set('America/Mexico_City');
function dd($var){
    if (is_array($var) || is_object($var)) {
        die(json_encode($var));
    }else{
        die($var);
    }
}

function guardarCentroCostos($dbcon, $Datos){
	$status = '1';
	$depto = '0';
	$usuario = '0';
	$nombrecc = '0';
	$fecha = date('Y-m-d H:i:s');
	$conn = $dbcon->conn();
	$sql = " INSERT INTO cat_centro_costos (cve_alterna, nombre_cc, cve_depto, cuenta_cc, tipo, creado_por, editado_por, eliminado_por, estatus_cc, fecha_registro, fecha_editado, fecha_eliminado) VALUES (".$Datos->codcc.", '".$nombrecc."', ".$depto.", '".$Datos->concepto."', '".$Datos->tipo."' ,".$Datos->id.", ".$usuario.", ".$usuario.", '".$status."', '".$fecha."', '".$fecha."', '".$fecha."' )";
	$qBuilder = $dbcon->qBuilder($conn, 'do', $sql);
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
	case 'guardarCentroCostos':
		guardarCentroCostos($dbcon, $objDatos);
		break;
}

?>