<?php
function dd($var){
    if (is_array($var) || is_object($var)) {
        die(json_encode($var));
    }else{
        die($var);
    }
}
function guardatRequisicion($dbcon, $Datos){
	$status = '0';
	$fecha = date('Y-m-d H:i:s');
	$conn = $dbcon->conn();
	$sql = "INSERT INTO requisicion (cve_usuario, q_autoriza, comentarios, estatus_req, fecha_registro)	VALUES ( ".$Datos->id.", ".$Datos->autoriza.", '".$Datos->comentario."', '".$status."', '".$fecha."')";
	$qBuilder = $dbcon->qBuilder($conn, 'do', $sql);
	if ($qBuilder) {
		$getId = "SELECT max(cve_req) cve_req FROM requisicion WHERE 
		fecha_registro = '".$fecha."' 
		AND cve_usuario = ".$Datos->id."
		AND comentarios = '".$Datos->comentario."'
		AND q_autoriza = ".$Datos->autoriza."
		AND estatus_req = '".$status."'";
		
		$getId = $dbcon->qBuilder($conn, 'first', $getId);
		foreach ($Datos->articulos as $i => $val) {
			$sql = "INSERT INTO requisicion_detalle (cve_req, cve_art, cve_maquina, cantidad, precio_total, surtido, prioridad, estatus_req_det, fecha_registro)
			VALUES (
				".$getId->cve_req.",
				".$val->cve_articulo.",
				".$val->cve_maquina.",
				".$val->cantidad.",
				0.0,
				0.0,
				'',
				'".$status."',
				'".$fecha."'
			)";
			$qBuilder = $dbcon->qBuilder($conn, 'do', $sql);
			if (!$qBuilder) {
				dd(['code'=>300, 'msj'=>'error al cargar detalle cve_articulo: '.$val->cve_articulo, 'sql'=>$sql]);
			}
		}
		dd(['code'=>200,'msj'=>'Carga ok', 'folio'=>$getId->cve_req]);
	}else{
		dd(['code'=>300, 'msj'=>'error al crear folio.', 'sql'=>$sql]);
	}
}
function getMaquinas($dbcon){
	$sql = "SELECT nombre_maq, cve_maq FROM cat_maquinas";
	$maquinas = $dbcon->qBuilder($dbcon->conn(), 'all', $sql);
	dd($maquinas);
}
function getArticulos($dbcon, $cve_alterna, $nombre_articulo){
	$sql = "SELECT cve_alterna, nombre_articulo, cve_articulo FROM cat_articulos WHERE estatus_articulo = 'VIG' ";
	if ($cve_alterna != '') {
		$sql .= " AND cve_alterna LIKE '%".$cve_alterna."%'";
	}
	if ($nombre_articulo != '') {
		$sql .= "AND nombre_articulo LIKE '%".$nombre_articulo."%'";
	}
	$articulos = $dbcon->qBuilder($dbcon->conn(), 'all', $sql);
	dd($articulos);
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
	case 'getMaquinas':
		getMaquinas($dbcon);
		break;
	case 'getArticulos':
		getArticulos($dbcon, $objDatos->cve_alterna, $objDatos->nombre_articulo);
		break;
	case 'guardatRequisicion':
		guardatRequisicion($dbcon, $objDatos);
		break;
}
?>
