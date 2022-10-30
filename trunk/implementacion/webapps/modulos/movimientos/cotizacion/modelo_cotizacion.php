<?php 
include_once "../../../dbconexion/conexion.php";

class ModeloCot{
	function ShowProveedores(){
		$sql = "	SELECT  	*
					FROM cat_proveedores
					WHERE estatus_proveedor = 'VIG'";

			 $vquery = Conexion::conectar()->prepare($sql);
          $vquery->execute();
			 return $vquery->fetchAll();
			 $vquery->close();
			 $vquery = null;
	}

}

 ?>