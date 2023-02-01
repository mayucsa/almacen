<?php 
date_default_timezone_set('America/Mexico_City');
function dd($var){
    if (is_array($var) || is_object($var)) {
        die(json_encode($var));
    }else{
        die($var);
    }
}
function ssMisRequis($dbcon, $id){
	$sql = "SELECT cve_req, nombre, apellido, comentarios, r.fecha_registro, estatus_req
			FROM requisicion r
			INNER JOIN cat_usuarios cu ON cu.cve_usuario = r.q_autoriza 
			WHERE tipo = 'N' AND estatus_req >= 1 AND r.cve_usuario = ".$id."
			ORDER BY cve_req DESC
			LIMIT 100 ";
    $datos = $dbcon->qBuilder($dbcon->conn(), 'all', $sql);
    dd($datos);
}
function CancelarRequi($dbcon, $Datos){
	$fecha = date('Y-m-d H:i:s');
	$status = 0;
	$conn = $dbcon->conn();
	$sql = "UPDATE requisicion SET estatus_req = '".$status."', fecha_cancelacion = '".$fecha."' WHERE cve_req = ".$Datos->cvereq." ";
	$qBuilder = $dbcon->qBuilder($conn, 'do', $sql);
	// dd($sql);
	$sql = "UPDATE requisicion_detalle SET estatus_req_det = '".$status."' WHERE cve_req = ".$Datos->cvereq." ";
	$qBuilder = $dbcon->qBuilder($conn, 'do', $sql);
}
function datosRequi($dbcon, $Datos){
	$sql = "SELECT cve_req, cve_alterna, nombre_articulo, cantidad
				FROM requisicion_detalle rd
				INNER JOIN cat_articulos ca ON rd.cve_art = ca.cve_articulo
				WHERE cve_req = ".$Datos->cvereq." ";
    $datos = $dbcon->qBuilder($dbcon->conn(), 'all', $sql);
    dd($datos);
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
	case 'ssMisRequis':
		ssMisRequis($dbcon, $objDatos->id);
		break;
	case 'datosRequi':
		datosRequi($dbcon, $objDatos);
		break;
	case 'CancelarRequi':
		CancelarRequi($dbcon, $objDatos);
		break;
}

?>
