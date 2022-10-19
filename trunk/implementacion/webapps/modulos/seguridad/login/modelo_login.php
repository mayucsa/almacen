<?php 

include_once "../../../dbconexion/conexion.php";

class Modelo_login{
	function consulta_usuario_existencia($usuario){
		$resultado 	= false;
		try {
			$dbcon	= 	new Conexion;
			$con 	= 	$dbcon->conectar();

			$sql 	= 	"SELECT nombre_usuario FROM cat_usuarios WHERE nombre_usuario = '$usuario'";

			$vquery =	$con->prepare($sql);
			$vquery	->execute();

			foreach ($vquery as $d) {
			 	$resultado = true;
			 } 
		} catch (Exception $ex) {
			echo $ex->getMessage();
		}
		return $resultado;
	}

	function consulta_contrasenia_correcta($usuario, $contrasenia){
		$resultado = false;
		try {
			$dbcon	= 	new Conexion;
			$con 	= 	$dbcon->conectar();

			$sql	=	"SELECT nombre_usuario FROM cat_usuarios WHERE nombre_usuario = '$usuario' AND contrasenia = '$contrasenia'";

			$vquery	= $con->prepare($sql);
			$vquery->execute();

			foreach ($vquery as $d) {
				$resultado = true;
			}
		} catch (Exception $ex) {
			echo $ex->getMessage();
		}
		return $resultado;
	}

    // function consulta_usuario_persona($usuario, $contrasenia) {
    //     try {
    //         $dbcon = new Conexion;
    //         $con = $dbcon->conectar();
    //         $sql = "SELECT lower(vs.nombre) nl, lower(vs.paterno) pl, vs.* from view_usuarios vs where vs.nombre_usuario='$usuario' and vs.contrasenia='$contrasenia'";

    //         $vquery = $con->prepare($sql);
    //         $vquery->execute();

    //         if ($vquery) {
    //             return $vquery;
    //         } else {
    //             return false;
    //         }
    //     } catch (excepcion $e) {
    //         echo $e->getMenssage();
    //         return false;
    //     }
    // }
        function consulta_usuario_persona($usuario, $contrasenia) {
        try {
            $dbcon = new Conexion;
            $con = $dbcon->conectar();
            $sql = "SELECT 	*
            		FROM 	cat_usuarios
            		WHERE 	nombre_usuario = '$usuario' AND contrasenia = '$contrasenia'";

            $vquery = $con->prepare($sql);
            $vquery->execute();

            if ($vquery) {
                return $vquery;
            } else {
                return false;
            }
        } catch (excepcion $e) {
            echo $e->getMenssage();
            return false;
        }
    }

}


 ?>