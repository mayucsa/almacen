<?php 
function dd($var){
    if (is_array($var) || is_object($var)) {
        die(json_encode($var));
    }else{
        die($var);
    }
}

function guardarMovimiento($dbcon, $Datos){
	$tipo_mov = 'E';
	$status = '1';
	$fecha = date('Y-m-d H:i:s');
	$conn = $dbcon->conn();
	$sql = "INSERT INTO movimientos (tipo_mov, creado_por, cve_odc, tipo_documento, folio_documento, fecha_documento, estatus_mov, fecha_registro) VALUES ('".$tipo_mov."', ".$Datos->id.", ".$Datos->folioodc.", '".$Datos->tipo."', '".$Datos->foliofactura."', '".$Datos->fechafactura."', '".$status."', '".$fecha."' )";
	$qBuilder = $dbcon->qBuilder($conn, 'do', $sql);

	if ($qBuilder) {
		$getId = "SELECT max(cve_mov) cve_mov FROM movimientos WHERE
		fecha_registro = '".$fecha."'
		AND creado_por = ".$Datos->id."
		AND tipo_mov = '".$tipo_mov."'
		AND  cve_odc = ".$Datos->folioodc."
		AND tipo_documento = '".$Datos->tipo."'
		AND folio_documento = '".$Datos->foliofactura."'
		AND fecha_documento = '".$Datos->fechafactura."'
		AND estatus_mov = '".$status."'";

		$getId = $dbcon->qBuilder($conn, 'first', $getId);
		dd(['code'=>200,'msj'=>'Carga ok', 'folio'=>$getId->cve_mov]);
	}else{
		dd(['code'=>300, 'msj'=>'error al crear folio.', 'sql'=>$sql]);
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
	case 'guardarMovimiento':
		guardarMovimiento($dbcon, $objDatos);
		break;
}

 ?>