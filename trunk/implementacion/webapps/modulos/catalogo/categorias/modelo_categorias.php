<?php 
include_once "../../../dbconexion/conexion.php";


if ( isset($_GET['accion']) && $_GET['accion'] == "insertar") {
	// die (json_encode($_REQUEST));
	$categoria 	= $_POST['categoria'];
	$usuario 	= $_POST['usuario'];

    $sql		= "INSERT INTO cat_categorias (nombre_ctg, creado_por,editado_por, eliminado_por, estatus_ctg, fecha_registro, fecha_editado, fecha_eliminado) VALUES	(:categoria, :usuario, '', '', 'VIG', NOW(), 0, 0);";

   $vquery = Conexion::conectar()->prepare($sql);

   $vquery->bindparam(':categoria', $categoria);
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
	$cve_ctg = $_GET["consultar"];

	$sql	= "	SELECT * FROM cat_categorias WHERE cve_ctg =" .$cve_ctg;

	$vquery = Conexion::conectar()->prepare($sql);
	$vquery ->execute();
	$lista = $vquery->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($lista);
	exit();
}

if (isset($_GET['actualizar']) ) {
	$cve_ctg		= $_POST['cve_ctg'];
	$ecategoria 	= $_POST['ecategoria'];
	$usuario 		= $_POST['usuario'];


   $sql 	= "	UPDATE 	cat_categorias 
   				SET 	nombre_ctg = :ecategoria,
   						editado_por = :usuario,
   						fecha_editado = NOW()
   				WHERE 	cve_ctg = :cve_ctg";

   	// $sql		= "CALL updateentradas(?, ?, ?)";

   $vquery = Conexion::conectar()->prepare($sql);

   $vquery->bindparam(':cve_ctg', $cve_ctg);
   $vquery->bindparam(':ecategoria', $ecategoria);
   $vquery->bindparam(':usuario', $usuario);


   $vquery->execute();

   echo json_encode(["success"=>1]);
   exit();

}

if (isset($_GET['eliminar']) ) {
	$cve_ctge		= $_POST['cve_ctge'];
	// $egrupoe 		= $_POST['egrupoe'];
	$usuarioe 	= $_POST['usuarioe'];


   $sql 	= "	UPDATE 	cat_categorias 
   				SET 	estatus_ctg = 'DELETE',
   						eliminado_por = :usuarioe,
   						fecha_eliminado = NOW()
   				WHERE 	cve_ctg = :cve_ctge";

   	// $sql		= "CALL updateentradas(?, ?, ?)";

   $vquery = Conexion::conectar()->prepare($sql);

   $vquery->bindparam(':cve_ctge', $cve_ctge);
   // $vquery->bindparam(':egrupoe', $egrupoe);
   $vquery->bindparam(':usuarioe', $usuarioe);


   $vquery->execute();

   echo json_encode(["success"=>1]);
   exit();

}

 ?>