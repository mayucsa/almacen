<?php 
	include_once "conexion.php";
	class Crud extends Conexion{
		public function mostrarDatos(){
			$sql = "SELECT nombre_mat_prima,
							cantidad,
							fecha_registro
					FROM seg_entradas";

			 $dbcon  = new Conexion;
             $con    = $dbcon->conectar();
             $vquery->execute();
             $vquery->close();
			 return $vquery->fetchAll();
			 // $vquery->close();
		}
	}

?>