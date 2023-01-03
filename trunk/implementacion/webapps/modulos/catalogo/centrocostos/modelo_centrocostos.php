<?php 
include_once "../../../dbconexion/conexion.php";

class ModeloCC{
	function showConcepto(){
		$sql = "	SELECT  	cve_ncc,
								cve_alterna,
								nombre
					FROM cat_nombre_cc
					WHERE estatus = 1";

			 $vquery = Conexion::conectar()->prepare($sql);
          $vquery->execute();
			 return $vquery->fetchAll();
			 $vquery->close();
			 $vquery = null;
	}
	function showAreas(){
		$sql = "	SELECT  	cve_area,
								cve_alterna,
								nombre_area
					FROM cat_areas
					WHERE estatus_area = 'VIG'";

			 $vquery = Conexion::conectar()->prepare($sql);
          $vquery->execute();
			 return $vquery->fetchAll();
			 $vquery->close();
			 $vquery = null;
	}
}

 ?>