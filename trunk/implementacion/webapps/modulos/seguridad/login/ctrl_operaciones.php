<?php
session_start();
	include_once "modelo_login.php";
	include_once "datos_usuario.php";
	// require_once ("modelo_login.php");

	$objetoModelo	= new Modelo_login;
	set_time_limit(0);
	$usuario 		= 	$_POST["usuario"];
	$contrasenia	= 	md5($_POST["contrasenia"]);
	// die(json_encode($objetoModelo->consulta_usuario_persona($usuario, $contrasenia)));
	$response	= array();
	if ($objetoModelo->consulta_usuario_existencia($usuario) == true) {
		if ($objetoModelo->consulta_contrasenia_correcta($usuario, $contrasenia) == true) {
			if ($objetoModelo->consulta_vigencia_persona($usuario) ) {
				if (($d = $objetoModelo->consulta_usuario_persona($usuario, $contrasenia)) == true) {
					$objeto_datos_usuario = new Datos_usuario;
					$objeto_datos_usuario->set_clave_usuario($d->cve_usuario);
					$objeto_datos_usuario->set_nombre_usuario($d->nombre_usuario);
					$objeto_datos_usuario->set_nombre_persona($d->nombre);
					$objeto_datos_usuario->set_apellido_persona($d->apellido);
					$objeto_datos_usuario->set_puesto_persona($d->puesto);

					$_SESSION['loggedin'] = true;
					$_SESSION['id'] = $d->cve_usuario;
					// $_SESSION['dashboardalma_vista'] = $d->dashboardalma_vista;
					// $_SESSION['catalogo_vista'] = $d->catalogo_vista;
					// $_SESSION['movimientos_vista'] = $d->movimientos_vista;
					// $_SESSION['autorizacion_vista'] = $d->autorizacion_vista;
					// $_SESSION['seguridad_vista'] = $d->seguridad_vista;
					// $_SESSION['almacenes_vista'] = $d->almacenes_vista;
					$_SESSION['articulo_edit'] = $d->articulo_edit;
					$_SESSION['usuario'] = serialize($objeto_datos_usuario);
					$_SESSION['start'] = time();
					$_SESSION['expire'] = $_SESSION['start'] + (2 * 3600);//expira en 2 horas
					// $_SESSION['usuario'] = $objeto_datos_usuario;
					// $_SESSION['usuario'] = $usuario;
	                $response['success'] = TRUE;
	                $response['error'] = 0;
	                $response['message'] = "Acceso permitido.";
				}
		}else{
			$response['success'] = FALSE;
            $response['error'] = 1;
            $response['message'] = "<div style='color: red'><center>Usuario sin privilegios, contacte al administrador del sistema.</center></div>";
            $_SESSION['usuario'] = null;
			}
		} else {
			$response['success'] = FALSE;
            $response['error'] = 3;
            $response['message'] = "<div style='color: red'><center>La contraseña no coincide, intente nuevamente.</center></div>";
            $_SESSION['usuario'] = null;
		}
	} else {
		$response['success'] = FALSE;
        $response['error'] = 4;
        $response['message'] = "<div style='color: red'><center>El nombre de usuario no existe, verifique con su administrador de sistema.</center></div>";
        $_SESSION['usuario'] = null;
	}
	// die(json_encode(['success'=>NULL, 'info'=>'ok 123']));
	// header('Content-Type: application/json');
	die(json_encode($response));
	
 ?>