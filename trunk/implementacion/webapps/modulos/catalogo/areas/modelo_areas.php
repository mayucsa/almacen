<?php 
include_once "../../../dbconexion/conexion.php";

if ( isset($_GET['accion']) && $_GET['accion'] == "insertar") {
	// die (json_encode($_REQUEST));
	$area 	= $_POST['area'];
	$usuario 	= $_POST['usuario'];

    $sql		= "INSERT INTO cat_areas (nombre_area, creado_por, editado_por, eliminado_por, estatus_area, fecha_registro, fecha_editado, fecha_eliminado) VALUES	(:area, :usuario, '', '', 'VIG', NOW(), 0, 0);";

   $vquery = Conexion::conectar()->prepare($sql);

   $vquery->bindparam(':area', $area);
   $vquery->bindparam(':usuario', 	$usuario);

   $vquery->execute();

   exit();

}

if (isset($_GET["consultar"])) {
	$cve_area = $_GET["consultar"];

	$sql	= "	SELECT * FROM cat_areas WHERE cve_area =" .$cve_area;

	$vquery = Conexion::conectar()->prepare($sql);
	$vquery ->execute();
	$lista = $vquery->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($lista);
	exit();
}

if (isset($_GET['actualizar']) ) {
	$cve_area		= $_POST['cve_area'];
	$earea 	= $_POST['earea'];
	$usuario 		= $_POST['usuario'];


   $sql 	= "	UPDATE 	cat_areas 
   				SET 	nombre_area = :earea,
   						editado_por = :usuario,
   						fecha_editado = NOW()
   				WHERE 	cve_area = :cve_area";

   	// $sql		= "CALL updateentradas(?, ?, ?)";

   $vquery = Conexion::conectar()->prepare($sql);

   $vquery->bindparam(':cve_area', $cve_area);
   $vquery->bindparam(':earea', $earea);
   $vquery->bindparam(':usuario', $usuario);


   $vquery->execute();

   echo json_encode(["success"=>1]);
   exit();

}

if (isset($_GET['eliminar']) ) {
	$cve_areae		= $_POST['cve_areae'];
	// $egrupoe 		= $_POST['egrupoe'];
	$usuarioe 	= $_POST['usuarioe'];


   $sql 	= "	UPDATE 	cat_areas 
   				SET 	estatus_area = 'DELETE',
   						eliminado_por = :usuarioe,
   						fecha_eliminado = NOW()
   				WHERE 	cve_area = :cve_areae";

   	// $sql		= "CALL updateentradas(?, ?, ?)";

   $vquery = Conexion::conectar()->prepare($sql);

   $vquery->bindparam(':cve_areae', $cve_areae);
   // $vquery->bindparam(':egrupoe', $egrupoe);
   $vquery->bindparam(':usuarioe', $usuarioe);


   $vquery->execute();

   echo json_encode(["success"=>1]);
   exit();

}

 ?>