<?php 
date_default_timezone_set('America/Mexico_City');
function dd($var){
    if (is_array($var) || is_object($var)) {
        die(json_encode($var));
    }else{
        die($var);
    }
}
function actualizarRequ($dbcon, $Datos){
	$cve_art = '';
	$articulos = $Datos->articulos;
	$status = '1';
	$fecha = date('Y-m-d H:i:s');
	// dd($articulos);
	for ($i=0; $i < count($articulos); $i++) { 
		// Obtenemos los identificadores de cada artículo en la requisición
		if ($cve_art == '') {
			$cve_art = $articulos[$i]->cve_art;
		}else{
			$cve_art .= ", ".(isset($articulos[$i]->cve_art)?
						$articulos[$i]->cve_art:
						$articulos[$i]->cve_articulo);
		}
		// Si el artículo ya existía en la requisición
		if (isset($articulos[$i]->cve_req_det)) {
			// Actualizamos la cantidad por artículo
			$sql = "UPDATE requisicion_detalle SET cantidad = ".$articulos[$i]->cantidad."
				WHERE cve_req = ".$Datos->folio." AND cve_req_det = ".$articulos[$i]->cve_req_det." 
			";
		    if (!$dbcon->qBuilder($dbcon->conn(), 'do', $sql)) {
		    	dd(['code'=>400, 'msj'=>'error al actualizar requisicion_detalle.', 'sql'=>$sql]);
		    }
		}else{
	    	// De lo contrario insertamos
	    	$sql = "INSERT INTO requisicion_detalle (cve_req, cve_art, comentario, cantidad, precio_total, surtido, prioridad, estatus_req_det, fecha_registro, cve_maquina, cantidad_cotizado)
			VALUES (
				".$Datos->folio.",
				".$articulos[$i]->cve_articulo.",
				'Editado',
				".$articulos[$i]->cantidad.",
				0.0,
				0.0,
				'',
				'".$status."',
				'".$fecha."',
				0,
				0.0
			)";
			$qBuilder = $dbcon->qBuilder($dbcon->conn(), 'do', $sql);
			if (!$qBuilder) {
				dd(['code'=>300, 'msj'=>'error al cargar detalle cve_articulo: '.$articulos[$i]->cve_articulo, 'sql'=>$sql]);
			}
	    }
	}
	// Actualizamos a estatus 0 los artículos que no se encuentren en la requisición
	$sql = "UPDATE requisicion_detalle SET estatus_req_det = 0
		WHERE cve_req = ".$Datos->folio." AND cve_art NOT IN (".$cve_art.")
	";
    if (!$dbcon->qBuilder($dbcon->conn(), 'do', $sql)) {
    	dd(['code'=>400, 'msj'=>'error al actualizar requisicion_detalle.', 'sql'=>$sql]);
    }else{
    	dd(['code'=>200, 'sql'=>$sql]);
    }
}
function getArticulos($dbcon, $codarticulo){
	$sql = "SELECT cve_articulo, cve_alterna, nombre_articulo, existencia, unidad_medida, seccion, empaque, max, min FROM cat_articulos WHERE cve_alterna = '".$codarticulo."' AND estatus_articulo = 'VIG' ";
	$articulo = $dbcon->qBuilder($dbcon->conn(), 'all', $sql);
	if (count($articulo) > 0) {
		if ($articulo[0]->existencia > 0) {
			dd(['tipo'=>1, 'datos'=>$articulo]);
		}else{
			dd(['tipo'=>0, 'datos'=>$articulo[0]->cve_alterna.'-'.$articulo[0]->nombre_articulo]);
		}
	}
	$sql = "SELECT cve_articulo, cve_alterna, nombre_articulo, existencia, unidad_medida, empaque, max, min FROM cat_articulos WHERE cve_alterna LIKE '%".$codarticulo."%' AND existencia > 0 AND estatus_articulo = 'VIG' 
		OR nombre_articulo LIKE '%".$codarticulo."%' AND existencia > 0 AND estatus_articulo = 'VIG' 
		ORDER BY nombre_articulo LIMIT 20";
	$articulos = $dbcon->qBuilder($dbcon->conn(), 'all', $sql);
	dd(['tipo'=>2, 'datos'=>$articulos]);
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
	$sql = "SELECT cve_req, cve_req_det, cve_art, cve_alterna, nombre_articulo, cantidad
				FROM requisicion_detalle rd
				INNER JOIN cat_articulos ca ON rd.cve_art = ca.cve_articulo
				WHERE cve_req = ".$Datos->cvereq." AND estatus_req_det > 0";
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
	case 'getArticulos':
		getArticulos($dbcon, $objDatos->codarticulo);
		break;
	case 'actualizar':
		actualizarRequ($dbcon, $objDatos);
		break;
}

?>
