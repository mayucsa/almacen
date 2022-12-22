<?php
include_once "../../../dbconexion/conexion.php";

if (isset($_GET["consultar"])) {
	$cve_odc = $_GET["consultar"];

	$sql	= "	SELECT O.cve_odc AS cveodc, O.cve_proveedor AS cveproveedor, D.cve_req AS req, A.nombre_articulo AS articulo, D.cantidad_cotizada AS cantidad, D.precio_unidad AS unitario, D.precio_total AS total
				FROM `orden_compra` O
				INNER JOIN orden_compra_detalle D ON D.cve_odc = O.cve_odc
				INNER JOIN cat_articulos A ON A.cve_articulo = D.cve_art
				WHERE O.cve_odc =" .$cve_odc;
	// $sql	= "	SELECT * FROM seg_entradas ORDER BY fecha_registro DESC";

	$vquery = Conexion::conectar()->prepare($sql);
	$vquery ->execute();
	$lista = $vquery->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($lista);
	exit();

}

?>