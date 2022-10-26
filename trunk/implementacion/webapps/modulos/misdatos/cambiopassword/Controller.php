<?php
function dd($var){
    if (is_array($var) || is_object($var)) {
        die(json_encode($var));
    }else{
        die($var);
    }
}
function validaPass($dbcon, $objDatos){
	$sql = "SELECT 
	CASE
	    WHEN nombre_usuario = '".$objDatos->pass."' THEN 1
	    ELSE 0
	END as pass,
	CASE
	    WHEN nombre_usuario = '".$objDatos->pass."' THEN 1
	    ELSE 0
	END as user FROM cat_usuarios WHERE cve_usuario = ".$objDatos->id;
	$sql = $dbcon->qBuilder($dbcon->conn(), 'first', $sql);
	dd([
		'validaPass' => $sql->pass,
		'validaUser' => $sql->user
	]);
	// Verificará si la contraseña es igual a la actual y si la contraseña es igual al nombre de usuario
}
function setPass($dbcon, $datos){
	$sql = "UPDATE cat_usuarios SET contrasenia = '".md5($datos->pass)."' WHERE cve_usuario = ".$datos->user;
	$update = $dbcon->qBuilder($dbcon->conn(), 'do', $sql);
	dd([
		'code'=>$update?200:300
	]);
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
	case 'setPass':
		setPass($dbcon, $objDatos);
		break;
	case 'validaPass':
		validaPass($dbcon, $objDatos);
		break;
}
?>
