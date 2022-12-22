<?php
date_default_timezone_set('America/Mexico_City');
function dd($var){
    if (is_array($var) || is_object($var)) {
        die(json_encode($var));
    }else{
        die($var);
    }
}
function descargaArchivos($dbcon, $cve_odc){
	$sql = "SELECT ruta, nombre, nombreOriginal FROM orden_compra_archivos WHERE cve_odc = ".$cve_odc;
    $archivos = $dbcon->qBuilder($dbcon->conn(), 'all', $sql);
    dd($archivos);
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
switch ($tarea) {
	case 'descargaArchivos':
		descargaArchivos($dbcon, $_REQUEST['cve_odc']);
		break;
}
?>
