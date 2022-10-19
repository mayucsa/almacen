<?php 
include_once "../../../dbconexion/conexion.php";

class ModeloReq{
	function showUserAutoriza(){
		$sql = "	SELECT  	*
					FROM cat_usuarios
					WHERE cve_rol = 1";

			 $vquery = Conexion::conectar()->prepare($sql);
          $vquery->execute();
			 return $vquery->fetchAll();
			 $vquery->close();
			 $vquery = null;
	}

}

 ?>