<?php 
include_once "../../../dbconexion/conexion.php";

if (isset($_GET['actualizar']) ) {
// if (isset($_GET["accion"]) && $_GET['accion'] == "actualizar") {
	$nueva		= $_POST['nueva'];
	$usuario 		= $_POST['usuario'];


   $sql 	= "	UPDATE 	cat_usuarios
   				SET 	contrasenia = :nueva
   				WHERE 	cve_usuario = :usuario";

   $vquery = Conexion::conectar()->prepare($sql);

   $vquery->bindparam(':nueva', md5($nueva));
   $vquery->bindparam(':usuario', $usuario);

   $vquery->execute();

   echo json_encode(["success"=>1]);
   exit();

}

 ?>