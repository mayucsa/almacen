<?php 
	session_start();

	include_once "../../../dbconexion/conexion.php";

	$dbcon	= 	new Conexion;
	$con 	= 	$dbcon->conectar();

	$usuario 		= (isset($_POST['seg_usuario'])) ? $_POST['seg_usuario'] : '';
	$contrasenia	= (isset($_POST['contrasenia'])) ? $_POST['contraseña'] : '';

	$pass = md5($contrasenia);

	$consulta 	= "SELECT seg_usuario FROM seg_usuarios WHERE usuario = '$usuario' AND contrasenia = '$pass' ";
	$resultado 	= $con->prepare($consulta);
	$resultado	->execute();

	if ($resultado->rowCount() >= 1) {
	 	$data = $resultado->fetchAll(PDO::FETCH_ASSOC);
	 	$_SESSION['seg_usuario'] = $usuario;
	 } else {
	 	$_SESSION['seg_usuario'] = $null;
	 	$data=null;
	 }

	 print json_encode($data);
	 $con=null;
	  
 ?>