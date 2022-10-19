<?php 
include_once "../../../dbconexion/conexion.php";

class ModeloCC{
	function showDeptos(){
		$sql = "	SELECT  	cve_depto,
								nombre_depto
					FROM cat_departamentos
					WHERE estatus_depto= 'VIG'";

			 $vquery = Conexion::conectar()->prepare($sql);
          $vquery->execute();
			 return $vquery->fetchAll();
			 $vquery->close();
			 $vquery = null;
	}
}

 ?>