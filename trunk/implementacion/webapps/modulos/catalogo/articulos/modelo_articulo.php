<?php 
include_once "../../../dbconexion/conexion.php";

class ModeloArticulo{
	function showGrupo(){
		$sql = "	SELECT  	cve_gpo,
								nombre_gpo
					FROM cat_grupos
					WHERE estatus_gpo = 'VIG'";

			 $vquery = Conexion::conectar()->prepare($sql);
          $vquery->execute();
			 return $vquery->fetchAll();
			 $vquery->close();
			 $vquery = null;
	}
	function showcategoria(){
		$sql = "	SELECT  	cve_ctg,
								nombre_ctg
					FROM cat_categorias
					WHERE estatus_ctg = 'VIG'";

			 $vquery = Conexion::conectar()->prepare($sql);
          $vquery->execute();
			 return $vquery->fetchAll();
			 $vquery->close();
			 $vquery = null;
	}
}

if ( isset($_GET['accion']) && $_GET['accion'] == "insertar") {
	// die (json_encode($_REQUEST));
	$codigo 		= $_POST['codigo'];
	$nombre 		= $_POST['nombre'];
	$nombrelargo 	= $_POST['nombrelargo'];
	$categoria 		= $_POST['categoria'];
	$grupo 			= $_POST['grupo'];
	$descripcion 	= $_POST['descripcion'];
	$unidadmedida	= $_POST['unidadmedida'];
	$precio			= $_POST['precio'];
	$costo			= $_POST['costo'];
	$existencia		= $_POST['existencia'];
	$seccion 		= $_POST['seccion'];
	$casillero 		= $_POST['casillero'];
	$nivel 			= $_POST['nivel'];
	$max 			= $_POST['max'];
	$min 			= $_POST['min'];
	// $reorden 		= $_POST['reorden'];
	$usuario 		= $_POST['usuario'];

    $sql		= "INSERT INTO cat_articulos(cve_alterna, nombre_articulo, nombre_articulo_largo, cve_ctg, cve_grupo, descripcion, unidad_medida, precio_unitario, costo_promedio, existencia, seccion, casillero, nivel, max, min, punto_reorden, creado_por, eliminado_por, estatus_articulo, fecha_registro, fecha_eliminado) VALUES(:codigo, :nombre, :nombrelargo, :categoria, :grupo, :descripcion, :unidadmedida, :precio, :costo, :existencia, :seccion, :casillero, :nivel, :max, :min, 0, :usuario, '', 'VIG', NOW(), 0);";

   $vquery = Conexion::conectar()->prepare($sql);

   $vquery->bindparam(':codigo', 		$codigo);
   $vquery->bindparam(':nombre', 		$nombre);
   $vquery->bindparam(':nombrelargo', 	$nombrelargo);
   $vquery->bindparam(':categoria', 	$categoria);
   $vquery->bindparam(':grupo', 		$grupo);
   $vquery->bindparam(':descripcion', 	$descripcion);
   $vquery->bindparam(':unidadmedida',	$unidadmedida);
   $vquery->bindparam(':precio',		$precio);
   $vquery->bindparam(':costo',			$costo);
   $vquery->bindparam(':existencia',	$existencia);
   $vquery->bindparam(':seccion', 		$seccion);
   $vquery->bindparam(':casillero', 	$casillero);
   $vquery->bindparam(':nivel', 		$nivel);
   $vquery->bindparam(':max', 			$max);
   $vquery->bindparam(':min', 			$min);
   // $vquery->bindparam(':reorden', 		$reorden);
   $vquery->bindparam(':usuario', 		$usuario);

   $vquery->execute();

   exit();

}

if (isset($_GET["consultar"])) {
	$cve_articulo = $_GET["consultar"];

	$sql	= "	SELECT * FROM cat_articulos WHERE cve_articulo =" .$cve_articulo;

	$vquery = Conexion::conectar()->prepare($sql);
	$vquery ->execute();
	$lista = $vquery->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($lista);
	exit();
}

if (isset($_GET['eliminar']) ) {
	$cve_articuloe	= $_POST['cve_articuloe'];
	// $egrupoe 		= $_POST['egrupoe'];
	$usuarioe 		= $_POST['usuarioe'];


   $sql 	= "	UPDATE 	cat_articulos 
   				SET 	estatus_articulo = 'DELETE',
   						eliminado_por = :usuarioe,
   						fecha_eliminado = NOW()
   				WHERE 	cve_articulo = :cve_articuloe";

   	// $sql		= "CALL updateentradas(?, ?, ?)";

   $vquery = Conexion::conectar()->prepare($sql);

   $vquery->bindparam(':cve_articuloe', $cve_articuloe);
   // $vquery->bindparam(':egrupoe', $egrupoe);
   $vquery->bindparam(':usuarioe', $usuarioe);


   $vquery->execute();

   echo json_encode(["success"=>1]);
   exit();

}

if (isset($_GET['actualizar']) ) {
	$cve_articulo 			= $_POST['cve_articulo'];
	$nombre_articulo 		= $_POST['nombre_articulo'];
	$nombre_articulo_largo	= $_POST['nombre_articulo_largo'];
	$categoria 				= $_POST['categoria'];
	$grupo 					= $_POST['grupo'];
	$descripcion 			= $_POST['descripcion'];
	$unidadmedida 			= $_POST['unidadmedida'];
	$seccion 				= $_POST['seccion'];
	$casillero 				= $_POST['casillero'];
	$nivel 					= $_POST['nivel'];
	$max 					= $_POST['max'];
	$min 					= $_POST['min'];
	$usuario 				= $_POST['usuario'];

   	$sql		= "CALL editarArticulo(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

   	$vquery = Conexion::conectar()->prepare($sql);

   	$vquery->bindparam(1, $cve_articulo);
   	$vquery->bindparam(2, $nombre_articulo);
   	$vquery->bindparam(3, $nombre_articulo_largo);
   	$vquery->bindparam(4, $categoria);
   	$vquery->bindparam(5, $grupo);
   	$vquery->bindparam(6, $descripcion);
   	$vquery->bindparam(7, $unidadmedida);
   	$vquery->bindparam(8, $seccion);
   	$vquery->bindparam(9, $casillero);
   	$vquery->bindparam(10, $nivel);
   	$vquery->bindparam(11, $max);
   	$vquery->bindparam(12, $min);
   	$vquery->bindparam(13, $usuario);

   	$vquery->execute();

   	echo json_encode(["success"=>1]);
   	exit();

}

if (isset($_GET["accion"]) && $_GET['accion'] == "verificar") {
	// die (json_encode($_REQUEST));
	$codigoart = $_REQUEST["codigoart"];

	$sql	= "	SELECT count(*) as existe 
				FROM cat_articulos 
				WHERE cve_alterna ='".$codigoart."'";

	$vquery = Conexion::conectar()->prepare($sql);
	$vquery ->execute();
	$lista = $vquery->fetchAll(PDO::FETCH_ASSOC);
	// echo json_encode($lista);
	$existenciacodart = $lista[0]['existe'];
	if ($existenciacodart > 0) {
		echo "correcto";
	}else{
		echo "error";
	}
	exit();

}

 ?>