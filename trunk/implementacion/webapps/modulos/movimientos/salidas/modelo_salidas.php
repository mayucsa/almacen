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

 ?>