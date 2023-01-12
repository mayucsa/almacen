<?php 
include_once "../../../dbconexion/conexion.php";

class ModeloSalidas{
	function ShowDepartamentos(){
		$sql = "	SELECT  	*
					FROM cat_departamentos
					WHERE estatus_depto = 'VIG'";

			 $vquery = Conexion::conectar()->prepare($sql);
          $vquery->execute();
			 return $vquery->fetchAll();
			 $vquery->close();
			 $vquery = null;
	}
	function ShowMaquinas(){
		$sql = "	SELECT  	*
					FROM cat_maquinas
					WHERE estatus_maq = 'VIG'";

			 $vquery = Conexion::conectar()->prepare($sql);
          $vquery->execute();
			 return $vquery->fetchAll();
			 $vquery->close();
			 $vquery = null;
	}

}

if (isset($_GET["consultar"])) {
	$cve_mov = $_GET["consultar"];

	$sql	= "	SELECT msd.cve_mov_det, msd.cve_mov AS cve_mov, ms.folio_vale AS folio_vale, ms.concepto AS concepto, cd.nombre_depto AS nombre_depto, cm.nombre_maq AS nombre_maq, msd.cve_articulo AS cve_articulo, ca.nombre_articulo AS nombre_articulo, ca.unidad_medida AS unidad_medida, msd.cve_cc AS cve_cc, msd.cantidad_salida AS cantidad_salida 
				FROM movtos_salidas_detalle AS msd
				INNER JOIN cat_articulos AS ca ON (msd.cve_articulo = ca.cve_articulo)
				INNER JOIN movtos_salidas AS ms ON (msd.cve_mov = ms.cve_mov)
				INNER JOIN cat_departamentos AS cd ON (ms.cve_depto = cd.cve_depto)
				INNER JOIN cat_maquinas AS cm ON (ms.cve_maq = cm.cve_maq)
				WHERE ms.estatus_mov = 1 AND ms.cve_mov =" .$cve_mov;
	// $sql	= "	SELECT * FROM seg_entradas ORDER BY fecha_registro DESC";

	$vquery = Conexion::conectar()->prepare($sql);
	$vquery ->execute();
	$lista = $vquery->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($lista);
	exit();

}


 ?>