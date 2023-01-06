<?php
include_once "../../../dbconexion/conexion.php";

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

?>