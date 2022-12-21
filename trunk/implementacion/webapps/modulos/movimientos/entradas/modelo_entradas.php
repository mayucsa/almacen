<?php
include_once "../../../dbconexion/conexion.php";

if (isset($_GET["consultar"])) {
	$cve_mov = $_GET["consultar"];

	$sql	= "	SELECT med.cve_mov AS cve_mov, ocd.cve_req AS cve_req, me.tipo_documento AS tipo_documento, me.folio_documento AS folio_documento, me.fecha_documento AS fecha_documento, med.cve_articulo AS cve_articulo, ca.nombre_articulo AS nombre_articulo, ca.unidad_medida AS unidad_medida, med.cantidad_entrada AS cantidad_entrada, ocd.precio_unidad AS precio_unidad, ocd.precio_total  AS precio_total
				FROM movtos_entradas_detalle med
				INNER JOIN movtos_entradas AS me ON (med.cve_mov = me.cve_mov)
				INNER JOIN cat_articulos AS ca ON (med.cve_articulo = ca.cve_articulo)
				INNER JOIN orden_compra_detalle  AS ocd ON (me.cve_odc = ocd.cve_odc AND med.cve_articulo = ocd.cve_art)
				WHERE me.estatus_mov = 1 AND me.cve_mov =" .$cve_mov;
	// $sql	= "	SELECT * FROM seg_entradas ORDER BY fecha_registro DESC";

	$vquery = Conexion::conectar()->prepare($sql);
	$vquery ->execute();
	$lista = $vquery->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($lista);
	exit();

}

?>