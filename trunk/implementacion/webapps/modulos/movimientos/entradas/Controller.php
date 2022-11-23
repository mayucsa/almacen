<?php 
function dd($var){
    if (is_array($var) || is_object($var)) {
        die(json_encode($var));
    }else{
        die($var);
    }
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
function validaFolio($dbcon, $folio){
	$sql = "SELECT cve_odc, cve_art, nombre_articulo, unidad_medida, cantidad_cotizada, precio_unidad, cve_req, false as chkd FROM orden_compra_detalle odcd
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
			if ($val->chkd == true) {
				$sql = "INSERT INTO movtos_entradas_detalle(cve_mov, cve_articulo, cantidad_cotizada, cantidad_entrada, estatus_mov, fecha_registro)
				VALUES (
					".$getId->cve_mov.", ".$val->cve_art.",
					".$val->cantidad_cotizada.", ".$val->cantidad.",
					1, '".$fecha."'
				)";
				if (!$dbcon->qBuilder($dbcon->conn(), 'do', $sql)) {
					dd(['code'=>400, 'msj'=>'error al insertar detalle.', 'sql'=>$sql]);
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
					$sql = "UPDATE requisicion_detalle SET estatus_req_det = 3
					WHERE cve_art = ".$val->cve_art." AND cve_req IN (SELECT cve_req FROM orden_compra_detalle where cve_odc = ".$Datos->folioodc.")";
					if (!$dbcon->qBuilder($dbcon->conn(), 'do', $sql)) {
						dd(['code'=>400, 'msj'=>'error al cambiar estatus_req_det = 3.', 'sql'=>$sql]);
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
			$sql = "UPDATE requisicion SET estatus_req = 3
			WHERE cve_req IN (SELECT cve_req FROM orden_compra_detalle where cve_odc = ".$Datos->folioodc.")";
			if (!$dbcon->qBuilder($dbcon->conn(), 'do', $sql)) {
				dd(['code'=>400, 'msj'=>'error al cambiar estatus_req = 3.', 'sql'=>$sql]);
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
}

 ?>