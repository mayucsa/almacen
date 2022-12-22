<?php 
include_once "../../../dbconexion/conexion.php";

if ( isset($_GET['accion']) && $_GET['accion'] == "insertar") {
	// die (json_encode($_REQUEST));
	$codigo 		= $_POST['codigo'];
	$nombre 		= $_POST['nombre'];
	$razonsocial 	= $_POST['razonsocial'];
	$rfc 			= $_POST['rfc'];
	$direccion 		= $_POST['direccion'];
	$colonia 		= $_POST['colonia'];
    $codpostal        = $_POST['codpostal'];
	$cdestado		= $_POST['cdestado'];
	// $contacto		= $_POST['contacto'];
	// $correo			= $_POST['correo'];
	// $telefono		= $_POST['telefono'];
	$credito 		= $_POST['credito'];
	$usuario 		= $_POST['usuario'];

    $sql		= "INSERT INTO cat_proveedores(cve_alterna, nombre_proveedor, razon_social, rfc, direccion, colonia, cp, ciudad_estado, dias_credito, creado_por, eliminado_por, estatus_proveedor, fecha_registro, fecha_eliminado) VALUES(:codigo, :nombre, :razonsocial, :rfc, :direccion, :colonia, :codpostal, :cdestado, :credito, :usuario, '', 'VIG', NOW(), 0);";

   $vquery = Conexion::conectar()->prepare($sql);

   $vquery->bindparam(':codigo', 		$codigo);
   $vquery->bindparam(':nombre', 		$nombre);
   $vquery->bindparam(':razonsocial', 	$razonsocial);
   $vquery->bindparam(':rfc', 			$rfc);
   $vquery->bindparam(':direccion', 	$direccion);
   $vquery->bindparam(':colonia', 		$colonia);
   $vquery->bindparam(':codpostal',       $codpostal);
   $vquery->bindparam(':cdestado',		$cdestado);
   // $vquery->bindparam(':contacto',		$contacto);
   // $vquery->bindparam(':correo',		$correo);
   // $vquery->bindparam(':telefono',		$telefono);
   $vquery->bindparam(':credito', 		$credito);
   $vquery->bindparam(':usuario', 		$usuario);

   $vquery->execute();

   exit();

}

if (isset($_GET["consultar"])) {
    $cve_proveedor = $_GET["consultar"];

    $sql    = " SELECT * FROM cat_proveedores WHERE cve_proveedor =" .$cve_proveedor;

    $vquery = Conexion::conectar()->prepare($sql);
    $vquery ->execute();
    $lista = $vquery->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($lista);
    exit();
}

if (isset($_GET['eliminar']) ) {
    $cve_proveedore  = $_POST['cve_proveedore'];
    // $egrupoe         = $_POST['egrupoe'];
    $usuarioe       = $_POST['usuarioe'];


   $sql     = " UPDATE  cat_proveedores 
                SET     estatus_proveedor = 'DELETE',
                        eliminado_por = :usuarioe,
                        fecha_eliminado = NOW()
                WHERE   cve_proveedor = :cve_proveedore";

    // $sql     = "CALL updateentradas(?, ?, ?)";

   $vquery = Conexion::conectar()->prepare($sql);

   $vquery->bindparam(':cve_proveedore', $cve_proveedore);
   // $vquery->bindparam(':egrupoe', $egrupoe);
   $vquery->bindparam(':usuarioe', $usuarioe);


   $vquery->execute();

   echo json_encode(["success"=>1]);
   exit();

}

if (isset($_GET['actualizar']) ) {
    $cve_proveedor  = $_POST['cve_proveedor'];
    $enombreprov    = $_POST['enombreprov'];
    $erazonsocial   = $_POST['erazonsocial'];
    $erfc           = $_POST['erfc'];
    $edireccion     = $_POST['edireccion'];
    $ecolonia       = $_POST['ecolonia'];
    $ecp            = $_POST['ecp'];
    $ecdestado      = $_POST['ecdestado'];
    $ecredito       = $_POST['ecredito'];
    $usuario        = $_POST['usuario'];

    $sql        = "CALL editarProveedor(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $vquery = Conexion::conectar()->prepare($sql);

    $vquery->bindparam(1, $cve_proveedor);
    $vquery->bindparam(2, $enombreprov);
    $vquery->bindparam(3, $erazonsocial);
    $vquery->bindparam(4, $erfc);
    $vquery->bindparam(5, $edireccion);
    $vquery->bindparam(6, $ecolonia);
    $vquery->bindparam(7, $ecp);
    $vquery->bindparam(8, $ecdestado);
    $vquery->bindparam(9, $ecredito);
    $vquery->bindparam(10, $usuario);

    $vquery->execute();

    echo json_encode(["success"=>1]);
    exit();

}

if (isset($_GET["accion"]) && $_GET['accion'] == "verificar") {
    // die (json_encode($_REQUEST));
    $codigoprov = $_REQUEST["codigoprov"];

    $sql    = " SELECT count(*) as existe 
                FROM cat_proveedores 
                WHERE cve_alterna ='".$codigoprov."'";
    // $sql = " SELECT * FROM seg_entradas ORDER BY fecha_registro DESC";

    $vquery = Conexion::conectar()->prepare($sql);
    $vquery ->execute();
    $lista = $vquery->fetchAll(PDO::FETCH_ASSOC);
    // echo json_encode($lista);
    $existenciacodprov = $lista[0]['existe'];
    if ($existenciacodprov > 0) {
        echo "correcto";
    }else{
        echo "error";
    }
    exit();

}

if (isset($_GET["accion"]) && $_GET['accion'] == "verificarrfc") {
    // die (json_encode($_REQUEST));
    $rfc = $_REQUEST["rfc"];

    $sql    = " SELECT count(*) as existe 
                FROM cat_proveedores 
                WHERE rfc ='".$rfc."'";
    // $sql = " SELECT * FROM seg_entradas ORDER BY fecha_registro DESC";

    $vquery = Conexion::conectar()->prepare($sql);
    $vquery ->execute();
    $lista = $vquery->fetchAll(PDO::FETCH_ASSOC);
    // echo json_encode($lista);
    $existenciarfc = $lista[0]['existe'];
    if ($existenciarfc > 0) {
        echo "correcto";
    }else{
        echo "error";
    }
    exit();

}

if ( isset($_GET['accion']) && $_GET['accion'] == "insertarContacto") {
    // die (json_encode($_REQUEST));
    $cve_proveedor  = $_POST['cve_proveedor'];
    $contacto       = $_POST['contacto'];
    $correo         = $_POST['correo'];
    $telefono       = $_POST['telefono'];
    $usuario        = $_POST['usuario'];

    $sql        = "INSERT INTO contacto_proveedores(cve_proveedor, nombre_contacto, correo, telefono, agregado_por, estatus_contacto, fecha_registro) VALUES(:cve_proveedor, :contacto, :correo, :telefono,  :usuario, 'VIG', NOW());";

   $vquery = Conexion::conectar()->prepare($sql);

   $vquery->bindparam(':cve_proveedor',        $cve_proveedor);
   $vquery->bindparam(':contacto',       $contacto);
   $vquery->bindparam(':correo',     $correo);
   $vquery->bindparam(':telefono',       $telefono);
   $vquery->bindparam(':usuario',       $usuario);

   $vquery->execute();

   exit();

}

if (isset($_GET["consultarcontacto"])) {
    $cve_proveedor = $_GET["consultarcontacto"];

    $sql    = " SELECT P.nombre_proveedor AS Proveedor, C.nombre_contacto AS Contacto, C.correo AS Correo, C.telefono AS Telefono
                FROM contacto_proveedores C
                INNER JOIN cat_proveedores P ON P.cve_proveedor = C.cve_proveedor
                WHERE C.cve_proveedor =" .$cve_proveedor;
    // $sql = " SELECT * FROM seg_entradas ORDER BY fecha_registro DESC";

    $vquery = Conexion::conectar()->prepare($sql);
    $vquery ->execute();
    $lista = $vquery->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($lista);
    exit();

}

 ?>