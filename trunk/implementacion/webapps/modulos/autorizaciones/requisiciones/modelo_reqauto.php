<?php
include_once "../../../dbconexion/conexion.php";
include_once "../../../dbconexion/conn.php";
function dd($var){
    if (is_array($var) || is_object($var)) {
        die(json_encode($var));
    }else{
        die($var);
    }
}

if (isset($_GET["consultar"])) {
	$cve_odc = $_GET["consultar"];

	$sql	= "	SELECT ocd.cve_odc AS cve_odc, ocd.cve_req AS req, ca.nombre_articulo AS articulo, rd.comentario AS comentario, ocd.cantidad_cotizada AS cantidad, ocd .precio_unidad AS unitario, ocd.precio_total AS total
				FROM orden_compra_detalle ocd
				INNER JOIN cat_articulos ca ON ca.cve_articulo = ocd.cve_art
				INNER JOIN orden_compra oc ON ocd.cve_odc = oc.cve_odc
				INNER JOIN requisicion_detalle rd ON ocd.cve_req = rd.cve_req AND rd.cve_art = ocd.cve_art 
				WHERE ocd.cve_odc =" .$cve_odc;
	// $sql	= "	SELECT * FROM seg_entradas ORDER BY fecha_registro DESC";

	$vquery = Conexion::conectar()->prepare($sql);
	$vquery ->execute();
	$lista = $vquery->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($lista);
	exit();

}

if (isset($_GET['actualizar']) ) {
	// die(json_encode ($_REQUEST));
	$cve_odc = $_REQUEST['cve_odc'];
	// $cve_odc	= $registros[0]['cve_odc'];

   $sql 	= "	UPDATE 	orden_compra 
   				SET 	estatus_autorizado = 1
   				WHERE 	cve_odc =" .$cve_odc;

   	// $sql 	= "	UPDATE orden_compra
   	// 			SET "
   	// die($sql);
   	/*$sql 	= " UPDATE requisicion
   				SET estatus_req ";*/

   $vquery = Conexion::conectar()->prepare($sql);

   $vquery->bindparam(':cve_odc', $cve_odc);

   $vquery->execute();

   echo json_encode(["success"=>1]);
   exit();

}

if (isset($_GET['eliminar']) && $_GET['eliminar'] == 1) {
	$id = $_REQUEST['id'];
	$motivo = $_REQUEST['motivo'];
	$usuario = $_REQUEST['usuario'];
	$sinReCotizar = $_REQUEST['sinReCotizar'];
	$dbcon	= new MysqlConn;
	$sql = "UPDATE orden_compra SET estatus_odc = 0 WHERE cve_odc = ".$id;
	if (!$dbcon->qBuilder($dbcon->conn(), 'do', $sql)) {
		dd(['code'=>400, 'msj'=>'Error al actualizar orden_compra', 'sql'=>$sql]);
	}
	$sql = "UPDATE orden_compra_detalle SET estatus_req_det = 0 WHERE cve_odc = ".$id;
	if (!$dbcon->qBuilder($dbcon->conn(), 'do', $sql)) {
		dd(['code'=>400, 'msj'=>'Error al actualizar orden_compra_detalle', 'sql'=>$sql]);
	}
	$fecha = date('Y-m-d H:i:s');
	$sql = "INSERT INTO seg_noautorizado(cve_odc, no_cotizar, motivo, fecha_noautorizo)
	VALUES(
		".$id.", ".($sinReCotizar == 'true'?'1':'0').", '".$motivo."', '".$fecha."'
	)";
	if (!$dbcon->qBuilder($dbcon->conn(), 'do', $sql)) {
		dd(['code'=>400, 'msj'=>'Error al insertar seg_noautorizado', 'sql'=>$sql]);
	}
	$sql = "SELECT * FROM orden_compra_detalle WHERE cve_odc = ".$id;
	$ocd = $dbcon->qBuilder($dbcon->conn(), 'all', $sql);
	if (!isset($ocd[0]->cve_req)) {
		dd(['code'=>400, 'msj'=>'Error, no se obtuvo cve_req', 'sql'=>$sql]);
	}
	// Si el check se ha seleccionado
	if ($sinReCotizar == 'true') {
		$sql = "UPDATE requisicion SET estatus_req = 0 WHERE cve_req = ".$ocd[0]->cve_req;
		if (!$dbcon->qBuilder($dbcon->conn(), 'do', $sql)) {
			dd(['code'=>400, 'msj'=>'Error al actualizar estatus req', 'sql'=>$sql]);
		}
		foreach ($ocd as $i => $val) {
			$sql = "UPDATE requisicion_detalle SET estatus_req_det = 0 
				WHERE cve_req = ".$val->cve_req." AND cve_art = ".$val->cve_art;
			if (!$dbcon->qBuilder($dbcon->conn(), 'do', $sql)) {
				dd(['code'=>400, 'msj'=>'Error al actualizar estatus req det', 'sql'=>$sql]);
			}
		}
	}else{
		$sql = "UPDATE requisicion SET estatus_req = 1 WHERE cve_req = ".$ocd[0]->cve_req;
		if (!$dbcon->qBuilder($dbcon->conn(), 'do', $sql)) {
			dd(['code'=>400, 'msj'=>'Error al actualizar estatus req', 'sql'=>$sql]);
		}
		foreach ($ocd as $i => $val) {
			$sql = "UPDATE requisicion_detalle SET estatus_req_det = 1, cantidad_cotizado = cantidad_cotizado - ".$val->cantidad_cotizada." 
				WHERE cve_req = ".$val->cve_req." AND cve_art = ".$val->cve_art;
			if (!$dbcon->qBuilder($dbcon->conn(), 'do', $sql)) {
				dd(['code'=>400, 'msj'=>'Error al restar cantidad cotizado', 'sql'=>$sql]);
			}
		}
	}
	dd('ok');
}

?>