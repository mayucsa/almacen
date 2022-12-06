<?php 
function dd($var){
    if (is_array($var) || is_object($var)) {
        die(json_encode($var));
    }else{
        die($var);
    }
}
function getUserPerfil($dbcon, $id){
	$sql = "SELECT * FROM permisos_almacen WHERE cve_usuario = ".$id;
	dd($dbcon->qBuilder($dbcon->conn(), 'first', $sql));
}
include_once "../../dbconexion/conn.php";
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
	case 'getUserPerfil':
		getUserPerfil($dbcon, $objDatos->id);
		break;
}

?>