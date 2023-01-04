<?php 
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
}

?>