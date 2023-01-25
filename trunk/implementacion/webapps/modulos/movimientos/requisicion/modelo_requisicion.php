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
	function showDepto(){
		$sql = "	SELECT  	*
					FROM cat_departamentos
					WHERE estatus_depto = 'VIG'";

			 $vquery = Conexion::conectar()->prepare($sql);
          $vquery->execute();
			 return $vquery->fetchAll();
			 $vquery->close();
			 $vquery = null;
	}
	function showCC(){
		$sql = "	SELECT  	*
					FROM cat_nombre_cc
					WHERE estatus = 1 ";

			 $vquery = Conexion::conectar()->prepare($sql);
          $vquery->execute();
			 return $vquery->fetchAll();
			 $vquery->close();
			 $vquery = null;
	}
	function showTgasto(){
		$sql = "	SELECT  	*
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