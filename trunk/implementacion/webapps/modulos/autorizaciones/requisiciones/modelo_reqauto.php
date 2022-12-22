<?php
include_once "../../../dbconexion/conexion.php";

if (isset($_GET["consultar"])) {
	$cve_odc = $_GET["consultar"];

	$sql	= "	SELECT O.cve_odc AS cve_odc, O.cve_proveedor AS cve_proveedor, D.cve_req AS req, A.nombre_articulo AS articulo, RQ.comentario AS comentario, D.cantidad_cotizada AS cantidad, D.precio_unidad AS unitario, D.precio_total AS total
				FROM `orden_compra` O
				INNER JOIN orden_compra_detalle D ON D.cve_odc = O.cve_odc
				INNER JOIN cat_articulos A ON A.cve_articulo = D.cve_art
				INNER JOIN requisicion_detalle RQ ON D.cve_req = RQ.cve_req
				WHERE O.cve_odc =" .$cve_odc;
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
   	// die($sql);

   $vquery = Conexion::conectar()->prepare($sql);

   $vquery->bindparam(':cve_odc', $cve_odc);

   $vquery->execute();

   echo json_encode(["success"=>1]);
   exit();

}

?>