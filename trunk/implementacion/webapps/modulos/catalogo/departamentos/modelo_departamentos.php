<?php 
include_once "../../../dbconexion/conexion.php";

class ModeloDepto{
	function showAreas(){
		$sql = "	SELECT  	cve_area,
								nombre_area
					FROM cat_areas
					WHERE estatus_area = 'VIG'";

			 $vquery = Conexion::conectar()->prepare($sql);
          $vquery->execute();
			 return $vquery->fetchAll();
			 $vquery->close();
			 $vquery = null;
	}
}

if ( isset($_GET['accion']) && $_GET['accion'] == "insertar") {
	// die (json_encode($_REQUEST));
	$coddepto 		= $_POST['coddepto'];
	$depto 		= $_POST['depto'];
	$area 		= 0;
	$usuario 	= $_POST['usuario'];

    $sql		= "INSERT INTO cat_departamentos (nombre_depto, cve_area, cve_alterna, creado_por,editado_por, eliminado_por, estatus_depto, fecha_registro, fecha_editado, fecha_eliminado) VALUES	(:depto, :area, :coddepto, :usuario, '', '', 'VIG', NOW(), 0, 0);";

   $vquery = Conexion::conectar()->prepare($sql);

   $vquery->bindparam(':coddepto', $coddepto);
   $vquery->bindparam(':depto', $depto);
   $vquery->bindparam(':area', $area);
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
	$cve_depto = $_GET["consultar"];

	$sql	= "	SELECT * FROM cat_departamentos WHERE cve_depto =" .$cve_depto;

	$vquery = Conexion::conectar()->prepare($sql);
	$vquery ->execute();
	$lista = $vquery->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($lista);
	exit();
}

if (isset($_GET['actualizar']) ) {
	$cve_depto		= $_POST['cve_depto'];
	$edepto 	= $_POST['edepto'];
	$usuario 		= $_POST['usuario'];


   $sql 	= "	UPDATE 	cat_departamentos 
   				SET 	nombre_depto = :edepto,
   						editado_por = :usuario,
   						fecha_editado = NOW()
   				WHERE 	cve_depto = :cve_depto";

   	// $sql		= "CALL updateentradas(?, ?, ?)";

   $vquery = Conexion::conectar()->prepare($sql);

   $vquery->bindparam(':cve_depto', $cve_depto);
   $vquery->bindparam(':edepto', $edepto);
   $vquery->bindparam(':usuario', $usuario);


   $vquery->execute();

   echo json_encode(["success"=>1]);
   exit();

}

if (isset($_GET['eliminar']) ) {
	$cve_deptoe		= $_POST['cve_deptoe'];
	// $egrupoe 		= $_POST['egrupoe'];
	$usuarioe 	= $_POST['usuarioe'];


   $sql 	= "	UPDATE 	cat_departamentos 
   				SET 	estatus_depto = 'DELETE',
   						eliminado_por = :usuarioe,
   						fecha_eliminado = NOW()
   				WHERE 	cve_depto = :cve_deptoe";

   	// $sql		= "CALL updateentradas(?, ?, ?)";

   $vquery = Conexion::conectar()->prepare($sql);

   $vquery->bindparam(':cve_deptoe', $cve_deptoe);
   // $vquery->bindparam(':egrupoe', $egrupoe);
   $vquery->bindparam(':usuarioe', $usuarioe);


   $vquery->execute();

   echo json_encode(["success"=>1]);
   exit();

}

if (isset($_GET["accion"]) && $_GET['accion'] == "verificar") {
	// die (json_encode($_REQUEST));
	$codigodepto = $_REQUEST["codigodepto"];

/*	$sql	= "	SELECT cve_alterna 
	 			FROM cat_maquinas
				WHERE cve_alterna = 'codigomaq'";*/

	$sql	= "	SELECT count(*) as existe 
				FROM cat_departamentos 
				WHERE cve_alterna ='".$codigodepto."'";
	// $sql	= "	SELECT * FROM seg_entradas ORDER BY fecha_registro DESC";

	$vquery = Conexion::conectar()->prepare($sql);
	$vquery ->execute();
	$lista = $vquery->fetchAll(PDO::FETCH_ASSOC);
	// echo json_encode($lista);
	$existenciacoddepto = $lista[0]['existe'];
	if ($existenciacoddepto > 0) {
		echo "correcto";
	}else{
		echo "error";
	}
	exit();

}

 ?>