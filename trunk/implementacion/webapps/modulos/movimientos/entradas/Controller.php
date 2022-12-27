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
	$sql = "UPDATE movtos_entradas SET estatus_mov = 0 WHERE cve_mov = ".$cve_mov;
	if (!$dbcon->qBuilder($dbcon->conn(), 'do', $sql)) {
		dd(['code'=>400, 'msj'=>'error al cancelar.', 'sql'=>$sql]);
	}
	// Eliminar del stock
	$sql = "SELECT * FROM movtos_entradas_detalle WHERE cve_mov = ".$cve_mov;
	$articulos = $dbcon->qBuilder($dbcon->conn(), 'all', $sql);
	foreach ($articulos as $i => $val) {
		$sql = "UPDATE cat_articulos SET existencia = existencia - ".$val->cantidad_entrada." WHERE cve_articulo = ".$val->cve_articulo;
		if (!$dbcon->qBuilder($dbcon->conn(), 'do', $sql)) {
			dd(['code'=>400, 'msj'=>'error al actualizar existencia.', 'sql'=>$sql]);
		}
	}
	$fecha = date('Y-m-d H:i:s');
	$sql = "INSERT INTO ctrl_dlt_movtos(cve_mov, tipo_mov, usuario, fecha_delete) VALUES (
		".$cve_mov.",
		'E',
		".$usuario.",
		'".$fecha."'
	)";
	if (!$dbcon->qBuilder($dbcon->conn(), 'do', $sql)) {
		dd(['code'=>400, 'msj'=>'error al insertar en ctrl_dlt_movtos.', 'sql'=>$sql]);
	}
	$sql = "SELECT * FROM ctrl_dlt_movtos WHERE 
	usuario = ".$usuario." 
	AND fecha_delete = '".$fecha."' 
	AND tipo_mov = 'E' 
	AND cve_mov = ".$cve_mov;
	$getFolio = $dbcon->qBuilder($dbcon->conn(), 'first', $sql);
	dd(['code'=>200,'msj'=>'Cancelación correcta', 'folio'=>$getFolio->cve_dlt]);
}
function envioCorreo($dbcon, $cve_mov){
	include_once "../../../correo/EnvioSMTP.php";
	$envioSMTP = new EnvioSMTP;
	$sql = "SELECT creado_por, correo, nombre, apellido FROM movtos_entradas mv
	INNER JOIN cat_usuarios cu ON cu.cve_usuario = mv.creado_por
	WHERE cve_mov = ".$cve_mov;
	$mvto = $dbcon->qBuilder($dbcon->conn(), 'first', $sql);
	$title = 'Captura de entrada';
	$Subject = 'Se ha generado una nueva captura de entrada';
	$Body = '<!doctype html>';
	$Body .= '<html lang="es" >';
	$Body .= '<head>';
	$Body .= '<meta charset="utf-8">';
	$Body .= '<meta name="viewport" content="width=device-width, initial-scale=1">';
	$Body .= '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">';
	$Body .= '<meta name="title" content="Mayucsa">';
	$Body .= '<title>Email Mayucsa</title>';
	$Body .= '</head>';
	$Body .= '<body style="background-color: white;">';
	$Body .= '<br><br>';
	$Body .= '<div class="container" style="border-radius: 15px; background-color: white; margin-top:2vH;margin-bottom:2vH; width:70%; margin-left:15%; text-align:center;">';
	$Body .= '<center>';
	$Body .= '<h1>Se ha generado nueva captura de entrada.</h1>';
	$Body .= '<br><hr style="width:30%;">';
	$Body .= '<br><p>Clave de movimiento #'.$cve_mov.'</p>';
	$Body .= '<br><p>Creado por usuario: '.$mvto->nombre.' '.$mvto->apellido.'</p>';
	$Body .= '<br><p>Acceda al sistema (SAM) para Generar cotizaciones.</p>';
	$Body .= '</center>';
	$Body .= '</div>';
	$Body .= '<br><br>';
	$Body .= '</body>';
	$Body .= '</html>';
	$correos = "SELECT req.cve_usuario, cu.correo FROM movtos_entradas mv
		INNER JOIN orden_compra_detalle odcd ON odcd.cve_odc = mv.cve_odc 
		INNER JOIN requisicion req ON req.cve_req = odcd.cve_req
		INNER JOIN cat_usuarios cu ON cu.cve_usuario = req.cve_usuario
		WHERE mv.cve_mov = ".$cve_mov."
		group by req.q_autoriza, cu.correo";
	$correos = $dbcon->qBuilder($dbcon->conn(), 'all', $correos);
	// $correos = ['a.chan@mayucsa.com.mx'];
	$email = $envioSMTP->correo($title, $Subject, $Body, $correos);
	if ($email) {
		return 'ok';
	}else{
		return 'error '.$email;
	}
}
function getDatosImprimir($dbcon, $cve_mov){
	$sql = "SELECT me.cve_mov, me.folio_documento, me.fecha_documento, cp.nombre_proveedor, oc.fecha_entrega, me.cve_odc, me.creado_por, CONCAT(cu.nombre, ' ', cu.apellido) as creadoPor
	FROM movtos_entradas me
	INNER JOIN orden_compra oc ON oc.cve_odc = me.cve_odc
	INNER JOIN cat_proveedores cp ON cp.cve_proveedor = oc.cve_proveedor
	INNER JOIN cat_usuarios cu ON cu.cve_usuario = me.creado_por
	WHERE me.cve_mov = ".$cve_mov;
	
	$ENTRADA = $dbcon->qBuilder($dbcon->conn(), 'first', $sql);
	$sql = "SELECT cve_req, cve_art, nombre_articulo, ca.seccion, cantidad_entrada, unidad_medida, precio_unidad, (precio_unidad * cantidad_entrada) as total 
	FROM movtos_entradas_detalle med
	INNER JOIN orden_compra_detalle ocd on ocd.cve_art = med.cve_articulo 
	INNER JOIN cat_articulos ca ON ca.cve_articulo = med.cve_articulo
	AND cve_odc = ".$ENTRADA->cve_odc." WHERE cve_mov = ".$cve_mov;
	$ENTRADAS_DET = $dbcon->qBuilder($dbcon->conn(), 'all', $sql);
	$totalFact = 0;
	foreach ($ENTRADAS_DET as $i => $val) {
		$totalFact += floatval($val->total);
	}
	dd([
		'ENTRADA' => $ENTRADA,
		'DETALLE' => $ENTRADAS_DET,
		'totalFact' => $totalFact
	]);
}
function getProveedor($dbcon, $cve_odc){
	$sql = "SELECT nombre_proveedor FROM cat_proveedores 
		INNER JOIN orden_compra ON orden_compra.cve_proveedor = cat_proveedores.cve_proveedor
	WHERE orden_compra.cve_odc = ".$cve_odc;
	dd($dbcon->qBuilder($dbcon->conn(), 'first', $sql));
}
function validaFolio($dbcon, $folio){
	$sql = "SELECT cve_odc, cve_art, nombre_articulo, ca.seccion, unidad_medida, cantidad_cotizada, precio_unidad, cve_req, false as chkd FROM orden_compra_detalle odcd
	INNER JOIN cat_articulos ca on ca.cve_articulo = odcd.cve_art WHERE odcd.estatus_req_det = 1 AND odcd.cve_odc = ".$folio;
	$detalle = $dbcon->qBuilder($dbcon->conn(), 'all', $sql);
	foreach ($detalle as $i => $val) {
		$sql = "SELECT sum(cantidad_entrada) cantidad_entrada FROM movtos_entradas_detalle mvd INNER JOIN movtos_entradas mv ON mv.cve_mov = mvd.cve_mov WHERE mv.cve_odc = ".$folio." AND cve_articulo = ".$val->cve_art;
		$cantidad_entrada = $dbcon->qBuilder($dbcon->conn(), 'first', $sql);
		$val->cantidad_cotizada = floatval($val->cantidad_cotizada) - floatval($cantidad_entrada->cantidad_entrada);
	}
	dd($detalle);
}
function revisarMovtosCompleto($dbcon, $cve_odc){
	$sql = "SELECT 
	(SELECT sum(cantidad_cotizada) FROM orden_compra_detalle WHERE cve_odc = ".$cve_odc.") as odc,
	(SELECT SUM(cantidad_entrada) FROM movtos_entradas_detalle WHERE cve_mov IN (SELECT cve_mov FROM movtos_entradas WHERE cve_odc = ".$cve_odc."))
	as mvtos
	";
	$getQry = $dbcon->qBuilder($dbcon->conn(), 'first', $sql);
	if (floatval($getQry->odc) == floatval($getQry->mvtos)) {
		return 'completado';
	}else{
		return 'pendiente';
	}
}
function guardarMovimiento($dbcon, $Datos){
	$tipo_mov = 'E';
	$status = '1';
	$fecha = date('Y-m-d H:i:s');
	$conn = $dbcon->conn();
	$estatus_req_completa = 4;
	$sql = "INSERT INTO movtos_entradas (tipo_mov, creado_por, cve_odc, tipo_documento, folio_documento, fecha_documento, estatus_mov, fecha_registro) VALUES ('".$tipo_mov."', ".$Datos->id.", ".$Datos->folioodc.", '".$Datos->tipo."', '".$Datos->foliofactura."', '".$Datos->fechafactura."', '".$status."', '".$fecha."' )";
	$qBuilder = $dbcon->qBuilder($conn, 'do', $sql);

	if ($qBuilder) {
		$getId = "SELECT max(cve_mov) cve_mov FROM movtos_entradas WHERE
		fecha_registro = '".$fecha."'
		AND creado_por = ".$Datos->id."
		AND tipo_mov = '".$tipo_mov."'
		AND  cve_odc = ".$Datos->folioodc."
		AND tipo_documento = '".$Datos->tipo."'
		AND folio_documento = '".$Datos->foliofactura."'
		AND fecha_documento = '".$Datos->fechafactura."'
		AND estatus_mov = '".$status."'";

		$getId = $dbcon->qBuilder($conn, 'first', $getId);
		foreach ($Datos->ordenCompraDetalle as $i => $val) {
			if ($val->chkd == true && floatval($val->chkd) > 0) {
				$sql = "INSERT INTO movtos_entradas_detalle(cve_mov, cve_articulo, cantidad_cotizada, cantidad_entrada, estatus_mov, fecha_registro)
				VALUES (
					".$getId->cve_mov.", ".$val->cve_art.",
					".$val->cantidad_cotizada.", ".$val->cantidad.",
					1, '".$fecha."'
				)";
				if (!$dbcon->qBuilder($dbcon->conn(), 'do', $sql)) {
					dd(['code'=>400, 'msj'=>'error al insertar detalle.', 'sql'=>$sql]);
				}
				// Store procedure costeo
				$sql = "CALL costeoentrada(".$val->cve_art.",".$val->cantidad.",".$Datos->folioodc." )";
				if (!$dbcon->qBuilder($dbcon->conn(), 'do', $sql)) {
					dd(['code'=>400, 'msj'=>'error al ejecutar Store Procedure.', 'sql'=>$sql]);
				}
				// Agregamos el stock en catalogo de articulos
				$sql = "UPDATE cat_articulos set existencia = existencia + ".$val->cantidad." WHERE cve_articulo = ".$val->cve_art;
				if (!$dbcon->qBuilder($dbcon->conn(), 'do', $sql)) {
					dd(['code'=>400, 'msj'=>'error al sumar existencia.', 'sql'=>$sql]);
				}
				// En caso de que se complete la requisición
				if ($val->cantidad_cotizada == $val->cantidad) {
					$sql = "UPDATE orden_compra_detalle SET estatus_req_det = 2
					WHERE cve_odc = ".$Datos->folioodc." AND cve_art = ".$val->cve_art;
					if (!$dbcon->qBuilder($dbcon->conn(), 'do', $sql)) {
						dd(['code'=>400, 'msj'=>'error al cambiar estatus_req_det = 2.', 'sql'=>$sql]);
					}
					$sql = "UPDATE requisicion_detalle SET estatus_req_det = ".$estatus_req_completa."
					WHERE cve_art = ".$val->cve_art." AND cve_req IN (SELECT cve_req FROM orden_compra_detalle where cve_odc = ".$Datos->folioodc.")";
					if (!$dbcon->qBuilder($dbcon->conn(), 'do', $sql)) {
						dd(['code'=>400, 'msj'=>'error al cambiar estatus_req_det = '.$estatus_req_completa.'.', 'sql'=>$sql]);
					}
				}
			}
		}
		if (revisarMovtosCompleto($dbcon, $Datos->folioodc) == 'completado') {
			$sql = "UPDATE orden_compra SET estatus_odc = 2
			WHERE cve_odc = ".$Datos->folioodc;
			if (!$dbcon->qBuilder($dbcon->conn(), 'do', $sql)) {
				dd(['code'=>400, 'msj'=>'error al cambiar estatus_odc = 2.', 'sql'=>$sql]);
			}
			$sql = "UPDATE requisicion SET estatus_req = ".$estatus_req_completa."
			WHERE cve_req IN (SELECT cve_req FROM orden_compra_detalle where cve_odc = ".$Datos->folioodc.")";
			if (!$dbcon->qBuilder($dbcon->conn(), 'do', $sql)) {
				dd(['code'=>400, 'msj'=>'error al cambiar estatus_req = '.$estatus_req_completa.'.', 'sql'=>$sql]);
			}
		}
		envioCorreo($dbcon, $getId->cve_mov);
		dd(['code'=>200,'msj'=>'Carga ok', 'folio'=>$getId->cve_mov]);
	}else{
		dd(['code'=>400, 'msj'=>'error al crear folio.', 'sql'=>$sql]);
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
	case 'validaFolio':
		validaFolio($dbcon, $objDatos->folio);
		break;
	case 'getProveedor':
		getProveedor($dbcon, $objDatos->cve_odc);
		break;
	case 'getDatosImprimir':
		getDatosImprimir($dbcon, $objDatos->cve_mov);
		break;
	case 'cancelar':
		cancelar($dbcon, $objDatos->cve_mov, $objDatos->ID);
		break;
}

 ?>