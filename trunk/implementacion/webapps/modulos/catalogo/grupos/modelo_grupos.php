<?php 
include_once "../../../dbconexion/conexion.php";


if ( isset($_GET['accion']) && $_GET['accion'] == "insertar") {
	// die (json_encode($_REQUEST));
	$grupo 		= $_POST['grupo'];
	$usuario 	= $_POST['usuario'];

    $sql		= "INSERT INTO cat_grupos (nombre_gpo, creado_por,editado_por, eliminado_por, estatus_gpo, fecha_registro) VALUES	(:grupo, :usuario, '', '', 'VIG', NOW());";

   $vquery = Conexion::conectar()->prepare($sql);

   $vquery->bindparam(':grupo', 		$grupo);
   $vquery->bindparam(':usuario', 	$usuario);

   $vquery->execute();

   exit();

}

/*if (isset($_GET["accion"]) && $_GET['accion'] == "consultar") {
	// die (json_encode($_REQUEST));
	$grupo = $_REQUEST["grupo"];

	$sql	= "	SELECT nombre_gpo 
					FROM cat_grupos 
					WHERE nombre_gpo = 'grupo'";
	// $sql	= "	SELECT * FROM seg_entradas ORDER BY fecha_registro DESC";

	$vquery = Conexion::conectar()->prepare($sql);
	$vquery ->execute();
	$lista = $vquery->fetchAll(PDO::FETCH_ASSOC);
	// echo json_encode($lista);
	// $stock = $lista[0]['nombre_gpo'];
	if (strval($grupo) == strval($lista)) {
		echo "correcto";
	}else{
		echo "error";
	}
	exit();

}*/
// if (isset($_GET["accion"]) && $_GET['accion'] == "consultar") {
if (isset($_GET["consultar"])) {
	$cve_gpo = $_GET["consultar"];

	$sql	= "	SELECT * FROM cat_grupos WHERE cve_gpo =" .$cve_gpo;

	$vquery = Conexion::conectar()->prepare($sql);
	$vquery ->execute();
	$lista = $vquery->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($lista);
	exit();
}

if (isset($_GET['actualizar']) ) {
	$cve_gpo		= $_POST['cve_gpo'];
	$egrupo 		= $_POST['egrupo'];
	$usuario 	= $_POST['usuario'];


   $sql 	= "	UPDATE 	cat_grupos 
   				SET 	nombre_gpo = :egrupo,
   						editado_por = :usuario
   				WHERE 	cve_gpo = :cve_gpo";

   	// $sql		= "CALL updateentradas(?, ?, ?)";

   $vquery = Conexion::conectar()->prepare($sql);

   $vquery->bindparam(':cve_gpo', $cve_gpo);
   $vquery->bindparam(':egrupo', $egrupo);
   $vquery->bindparam(':usuario', $usuario);


   $vquery->execute();

   echo json_encode(["success"=>1]);
   exit();

}

if (isset($_GET['eliminar']) ) {
	$cve_gpoe		= $_POST['cve_gpoe'];
	// $egrupoe 		= $_POST['egrupoe'];
	$usuarioe 	= $_POST['usuarioe'];


   $sql 	= "	UPDATE 	cat_grupos 
   				SET 	estatus_gpo = 'DELETE',
   						eliminado_por = :usuarioe
   				WHERE 	cve_gpo = :cve_gpoe";

   	// $sql		= "CALL updateentradas(?, ?, ?)";

   $vquery = Conexion::conectar()->prepare($sql);

   $vquery->bindparam(':cve_gpoe', $cve_gpoe);
   // $vquery->bindparam(':egrupoe', $egrupoe);
   $vquery->bindparam(':usuarioe', $usuarioe);


   $vquery->execute();

   echo json_encode(["success"=>1]);
   exit();

}

 ?>