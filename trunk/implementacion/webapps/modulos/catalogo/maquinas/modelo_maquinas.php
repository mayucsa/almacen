<?php 
include_once "../../../dbconexion/conexion.php";

class ModeloMaquina{
	function showDeptos(){
		$sql = "	SELECT  	cve_depto,
								nombre_depto
					FROM cat_departamentos
					WHERE estatus_depto= 'VIG'";

			 $vquery = Conexion::conectar()->prepare($sql);
          $vquery->execute();
			 return $vquery->fetchAll();
			 $vquery->close();
			 $vquery = null;
	}
}

if ( isset($_GET['accion']) && $_GET['accion'] == "insertar") {
	// die (json_encode($_REQUEST));
	$codmaq 	= $_POST['codmaq'];
	$depto 		= $_POST['depto'];
	$codnombre 	= $_POST['codnombre'];
	$usuario 	= $_POST['usuario'];

    $sql		= "INSERT INTO cat_maquinas (cve_alterna, cve_depto, nombre_maq, creado_por,editado_por, eliminado_por, estatus_maq, fecha_registro, fecha_editado, fecha_eliminado) VALUES	(:codmaq, :depto, :codnombre, :usuario, '', '', 'VIG', NOW(), 0, 0);";

   $vquery = Conexion::conectar()->prepare($sql);

   $vquery->bindparam(':codmaq', 		$codmaq);
   $vquery->bindparam(':depto', 		$depto);
   $vquery->bindparam(':codnombre', 	$codnombre);
   $vquery->bindparam(':usuario', 		$usuario);

   $vquery->execute();

   exit();

}

if (isset($_GET["consultar"])) {
	$cve_maq = $_GET["consultar"];

	$sql	= "	SELECT * FROM cat_maquinas WHERE cve_maq =" .$cve_maq;

	$vquery = Conexion::conectar()->prepare($sql);
	$vquery ->execute();
	$lista = $vquery->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($lista);
	exit();
}

if (isset($_GET['actualizar']) ) {
	$cve_maq		= $_POST['cve_maq'];
	$edepto 		= $_POST['edepto'];
	$enommbre 		= $_POST['enommbre'];
	$usuario 		= $_POST['usuario'];


   $sql 	= "	UPDATE 	cat_maquinas 
   				SET 	cve_depto = :edepto,
   						nombre_maq = :enommbre,
   						editado_por = :usuario
   				WHERE 	cve_maq = :cve_maq";

   	// $sql		= "CALL updateentradas(?, ?, ?)";

   $vquery = Conexion::conectar()->prepare($sql);

   $vquery->bindparam(':cve_maq', $cve_maq);
   $vquery->bindparam(':edepto', $edepto);
   $vquery->bindparam(':enommbre', $enommbre);
   $vquery->bindparam(':usuario', $usuario);


   $vquery->execute();

   echo json_encode(["success"=>1]);
   exit();

}

if (isset($_GET['eliminar']) ) {
	$cve_maqe		= $_POST['cve_maqe'];
	// $egrupoe 		= $_POST['egrupoe'];
	$usuarioe 	= $_POST['usuarioe'];


   $sql 	= "	UPDATE 	cat_maquinas 
   				SET 	estatus_maq = 'DELETE',
   						eliminado_por = :usuarioe
   				WHERE 	cve_maq = :cve_maqe";

   	// $sql		= "CALL updateentradas(?, ?, ?)";

   $vquery = Conexion::conectar()->prepare($sql);

   $vquery->bindparam(':cve_maqe', $cve_maqe);
   // $vquery->bindparam(':egrupoe', $egrupoe);
   $vquery->bindparam(':usuarioe', $usuarioe);


   $vquery->execute();

   echo json_encode(["success"=>1]);
   exit();

}

if (isset($_GET["accion"]) && $_GET['accion'] == "verificar") {
	// die (json_encode($_REQUEST));
	$codigomaq = $_REQUEST["codigomaq"];

/*	$sql	= "	SELECT cve_alterna 
	 			FROM cat_maquinas
				WHERE cve_alterna = 'codigomaq'";*/

	$sql	= "	SELECT count(*) as existe 
				FROM cat_maquinas 
				WHERE cve_alterna ='".$codigomaq."'";
	// $sql	= "	SELECT * FROM seg_entradas ORDER BY fecha_registro DESC";

	$vquery = Conexion::conectar()->prepare($sql);
	$vquery ->execute();
	$lista = $vquery->fetchAll(PDO::FETCH_ASSOC);
	// echo json_encode($lista);
	$excodmaquina = $lista[0]['existe'];
	if ($excodmaquina > 0) {
		echo "correcto";
	}else{
		echo "error";
	}
	exit();

}

 ?>