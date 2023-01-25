<?php 

include_once "../../../dbconexion/conn.php";

class Modelo_login{
	function consulta_usuario_existencia($usuario){
		$resultado 	= false;
		try {
			$dbcon	= 	new MysqlConn;
			$con 	= 	$dbcon->conn();
			$sql 	= 	"SELECT nombre_usuario FROM cat_usuarios WHERE nombre_usuario = '".$usuario."'";
            $usuario = $dbcon->qBuilder($con, 'first', $sql);
            if ($usuario) {
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
			$dbcon	= 	new MysqlConn;
			$con 	= 	$dbcon->conn();
			$sql	=	"SELECT nombre_usuario FROM cat_usuarios WHERE nombre_usuario = '".$usuario."' AND contrasenia = '".$contrasenia."'";
            $pass = $dbcon->qBuilder($con, 'first', $sql);
            if ($pass) {
                $resultado = true;
            }
		} catch (Exception $ex) {
			echo $ex->getMessage();
		}
		return $resultado;
	}

    function consulta_vigencia_persona($usuario) {
        $resultado = false;
        try {
            $dbcon = new MysqlConn;
            $con = $dbcon->conn();
            $sql = "SELECT  *
                    FROM    cat_usuarios
                    WHERE   nombre_usuario = '".$usuario."' AND estatus_usuario = 1";
            $vig = $dbcon->qBuilder($con, 'first', $sql);
            // dd($sql);
            // echo ('$vig');
            if ($vig) {
                $resultado = true;
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        return $resultado;
    }
    
    function consulta_usuario_persona($usuario, $contrasenia) {
        try {
            $dbcon = new MysqlConn;
            $con = $dbcon->conn();
            $sql = "SELECT 	*
            		FROM cat_usuarios cu
                    INNER JOIN permisos_almacen pa ON pa.cve_usuario =cu.cve_usuario
            		WHERE 	nombre_usuario = '".$usuario."' AND contrasenia = '".$contrasenia."'";
            $persona = $dbcon->qBuilder($con, 'first', $sql);
            if ($persona) {
                return $persona;
            }else{
                return false;
            }
        } catch (excepcion $e) {
            echo $e->getMenssage();
            return false;
        }
    }
}
?>
