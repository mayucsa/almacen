<?php
include_once "../../../dbconexion/conexion.php";

if (isset($_GET["consultar"])) {
	$cve_req = $_GET["consultar"];

	$sql	= "	SELECT rd.cve_req AS cvereq, ca.nombre_articulo AS articulo, rd.cantidad AS cantidad
				FROM requisicion_detalle rd
				INNER JOIN cat_articulos AS ca ON (rd.cve_art = ca.cve_articulo)
				WHERE cve_req =" .$cve_req;
	// $sql	= "	SELECT * FROM seg_entradas ORDER BY fecha_registro DESC";

	$vquery = Conexion::conectar()->prepare($sql);
	$vquery ->execute();
	$lista = $vquery->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($lista);
	exit();

}

?>