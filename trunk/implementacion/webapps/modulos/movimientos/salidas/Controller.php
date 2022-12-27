<?php 
date_default_timezone_set('America/Mexico_City');
function dd($var){
    if (is_array($var) || is_object($var)) {
        die(json_encode($var));
    }else{
        die($var);
    }
}
function cancelar($dbcon, $cve_mov, $usuario){
	// insertar en movtos_entradas
	$sql = "UPDATE movtos_salidas SET estatus_mov = 0 WHERE cve_mov = ".$cve_mov;
	if (!$dbcon->qBuilder($dbcon->conn(), 'do', $sql)) {
		dd(['code'=>400, 'msj'=>'error al cancelar.', 'sql'=>$sql]);
	}
	// Eliminar del stock
	$sql = "SELECT * FROM movtos_salidas_detalle WHERE cve_mov = ".$cve_mov;
	$articulos = $dbcon->qBuilder($dbcon->conn(), 'all', $sql);
	foreach ($articulos as $i => $val) {
		$sql = "UPDATE cat_articulos SET existencia = existencia + ".$val->cantidad_salida." WHERE cve_articulo = ".$val->cve_articulo;
		if (!$dbcon->qBuilder($dbcon->conn(), 'do', $sql)) {
			dd(['code'=>400, 'msj'=>'error al actualizar existencia.', 'sql'=>$sql]);
		}
	}
	$fecha = date('Y-m-d H:i:s');
	$sql = "INSERT INTO ctrl_dlt_movtos(cve_mov, tipo_mov, usuario, fecha_delete) VALUES (
		".$cve_mov.",
		'S',
		".$usuario.",
		'".$fecha."'
	)";
	if (!$dbcon->qBuilder($dbcon->conn(), 'do', $sql)) {
		dd(['code'=>400, 'msj'=>'error al insertar en ctrl_dlt_movtos.', 'sql'=>$sql]);
	}
	$sql = "SELECT * FROM ctrl_dlt_movtos WHERE 
	usuario = ".$usuario." 
	AND fecha_delete = '".$fecha."' 
	AND tipo_mov = 'S' 
	AND cve_mov = ".$cve_mov;
	$getFolio = $dbcon->qBuilder($dbcon->conn(), 'first', $sql);
	dd(['code'=>200,'msj'=>'Cancelación correcta', 'folio'=>$getFolio->cve_dlt]);
}
function getDatosImprimir($dbcon, $cve_mov){
	$sql = "SELECT ms.cve_mov, ms.fecha_registro, ms.cve_maq, cm.nombre_maq, ms.concepto, ms.creado_por, CONCAT(cu.nombre, ' ', cu.apellido) as creadoPor
	FROM movtos_salidas ms
	INNER JOIN cat_maquinas cm ON cm.cve_maq = ms.cve_maq
	INNER JOIN cat_usuarios cu ON cu.cve_usuario = ms.creado_por
	WHERE ms.cve_mov = ".$cve_mov;
	
	$SALIDA = $dbcon->qBuilder($dbcon->conn(), 'first', $sql);
	$sql = "SELECT msd.cve_articulo, ca.cve_alterna, nombre_articulo, seccion, cantidad_salida, unidad_medida
	FROM movtos_salidas_detalle msd
	INNER JOIN cat_articulos ca ON ca.cve_articulo = msd.cve_articulo
	WHERE cve_mov = ".$cve_mov;
	$SALIDAS_DET = $dbcon->qBuilder($dbcon->conn(), 'all', $sql);
	dd([
		'SALIDA' => $SALIDA,
		'DETALLE' => $SALIDAS_DET
	]);
}
function getCcostos($dbcon, $centroCosto, $cve_depto){
	$sql = "SELECT cve_cc, cve_alterna, nombre_cc FROM cat_centro_costos WHERE 
	cve_depto = ".$cve_depto." AND cve_alterna LIKE '%".$centroCosto."%'
	or
	cve_depto = ".$cve_depto." AND nombre_cc LIKE '%".$centroCosto."%'
	ORDER BY nombre_cc asc";
	$return = $dbcon->qBuilder($dbcon->conn(), 'all', $sql);
	dd($return);
}
function getMaquinas($dbcon, $cve_depto){
	$sql = "SELECT * FROM cat_maquinas WHERE estatus_maq = 'VIG' AND cve_depto = ".$cve_depto;
	dd($dbcon->qBuilder($dbcon->conn(), 'all', $sql));
}
function getArticulos($dbcon, $codarticulo){
	$sql = "SELECT cve_articulo, cve_alterna, nombre_articulo, existencia, unidad_medida, seccion, empaque, max, min FROM cat_articulos WHERE cve_alterna = '".$codarticulo."' ";
	$articulo = $dbcon->qBuilder($dbcon->conn(), 'all', $sql);
	if (count($articulo) > 0) {
		if ($articulo[0]->existencia > 0) {
			dd(['tipo'=>1, 'datos'=>$articulo]);
		}else{
			dd(['tipo'=>0, 'datos'=>$articulo[0]->cve_alterna.'-'.$articulo[0]->nombre_articulo]);
		}
	}
	$sql = "SELECT cve_articulo, cve_alterna, nombre_articulo, existencia, unidad_medida, empaque, max, min FROM cat_articulos WHERE cve_alterna LIKE '%".$codarticulo."%' AND existencia > 0
		OR nombre_articulo LIKE '%".$codarticulo."%' AND existencia > 0 ORDER BY nombre_articulo LIMIT 20";
	$articulos = $dbcon->qBuilder($dbcon->conn(), 'all', $sql);
	dd(['tipo'=>2, 'datos'=>$articulos]);
}
function guardarMovimiento($dbcon, $Datos){
	$tipo_mov = 'S';
	$status = '1';
	$fecha = date('Y-m-d H:i:s');
	$conn = $dbcon->conn();
	$sql = " INSERT INTO movtos_salidas (tipo_mov, creado_por, folio_vale, concepto, cve_depto, cve_maq, horometro, comentario, estatus_mov, fecha_registro) VALUES ('".$tipo_mov."', ".$Datos->id.", ".$Datos->foliovale.", '".$Datos->concepto."', ".$Datos->departamento.", ".$Datos->maquinas.", ".intval($Datos->horometro).", '".$Datos->comentarios."', '".$status."', '".$fecha."' ) ";
	$qBuilder = $dbcon->qBuilder($conn, 'do', $sql);

	if ($qBuilder) {
		$sql = "SELECT max(cve_mov) cve_mov FROM movtos_salidas WHERE 
		fecha_registro = '".$fecha."'
		AND creado_por = ".$Datos->id."
		AND tipo_mov = '".$tipo_mov."'
		AND folio_vale = ".$Datos->foliovale."
		AND concepto = '".$Datos->concepto."'
		AND cve_depto = ".$Datos->departamento."
		AND cve_maq = ".$Datos->maquinas."
		AND estatus_mov = '".$status."'";
		$getId = $dbcon->qBuilder($conn, 'first', $sql);
		// detalle
		$articulos = $Datos->articulos;
		foreach ($articulos as $i => $val) {
			$existenciaFinal = floatval($val->existencia)- floatval($val->cantidad);
			if ( $existenciaFinal <= $val->min) {
				// requisición automática
				$sql = "INSERT INTO requisicion (cve_usuario, q_autoriza, comentarios, tipo, estatus_req, fecha_registro) VALUES (1, 1, 'Requisicion automatica', 'A', 1, '".$fecha."')";
				if ($dbcon->qBuilder($conn, 'do', $sql)) {
					$cve_req = "SELECT max(cve_req) cve_req FROM requisicion WHERE 
					fecha_registro = '".$fecha."' 
					AND cve_usuario = 1 
					AND comentarios = 'Requisicion automatica' 
					AND q_autoriza = 1 
					AND estatus_req = 1 
					AND tipo = 'A' ";
					$empaque = $val->empaque;
					$cve_req = $dbcon->qBuilder($conn, 'first', $cve_req);
					$sql = "INSERT INTO requisicion_detalle (cve_req, cve_art, cve_maquina, cantidad, comentario, cantidad_cotizado, precio_total, surtido, prioridad, estatus_req_det, fecha_registro) VALUES ($cve_req->cve_req, $val->cve_articulo, 0, $empaque, '', 0, 0, 0, '', 1, '".$fecha."')";
					if (!$dbcon->qBuilder($conn, 'do', $sql)) {
						dd(['code'=>300, 'msj'=>'error al insertar requisición detalle automática.', 'sql'=>$sql]);
					}
				}else{
					dd(['code'=>300, 'msj'=>'error al insertar requisición automática.', 'sql'=>$sql]);
				}
			}
			$sql = "INSERT INTO movtos_salidas_detalle 
			(cve_mov, cve_articulo, cve_cc, existencia, cantidad_salida, estatus_mov, fecha_registro)
			VALUES(
				".$getId->cve_mov.",
				".$val->cve_articulo.",
				".$val->cve_cc.",
				".$val->existencia.",
				".$val->cantidad.",
				1, '".$fecha."'
			)";
			if (!$dbcon->qBuilder($dbcon->conn(),'do',$sql)) {
				dd(['code'=>300, 'msj'=>'error al insertar detalle.', 'sql'=>$sql]);
			}
			// Restamos el stock en catalogo de articulos
			$sql = "UPDATE cat_articulos set existencia = existencia - ".$val->cantidad." WHERE cve_articulo = ".$val->cve_articulo;
			if (!$dbcon->qBuilder($dbcon->conn(), 'do', $sql)) {
				dd(['code'=>400, 'msj'=>'error al restar existencia.', 'sql'=>$sql]);
			}
			// Store procedure costeo
			$sql = "CALL costeosalida(".$val->cve_articulo.")";
			if (!$dbcon->qBuilder($dbcon->conn(), 'do', $sql)) {
				dd(['code'=>400, 'msj'=>'error al ejecutar Store Procedure.', 'sql'=>$sql]);
			}
		}
		dd(['code'=>200,'msj'=>'Carga ok', 'folio'=>$getId->cve_mov]);
	} else {
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
	case 'getArticulos':
		getArticulos($dbcon, $objDatos->codarticulo);
		break;
	case 'getMaquinas':
		getMaquinas($dbcon, $objDatos->cve_depto);
		break;
	case 'getCcostos':
		getCcostos($dbcon, $objDatos->centroCosto, $objDatos->cve_depto);
		break;
	case 'getDatosImprimir':
		getDatosImprimir($dbcon, $objDatos->cve_mov);
		break;
	case 'cancelar':
		cancelar($dbcon, $objDatos->cve_mov, $objDatos->ID);
		break;
}

?>