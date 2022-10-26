<?php
function dd($var){
    if (is_array($var) || is_object($var)) {
        die(json_encode($var));
    }else{
        die($var);
    }
}
function getMisRequisiciones($dbcon, $cve_usuario){
	$sql = "SELECT cve_req FROM requisicion WHERE cve_usuario = ".$cve_usuario." ORDER BY fecha_registro desc LIMIT 10";
	$misRequisiciones = [];
	$cont = 0;
	$array = $dbcon->qBuilder($dbcon->conn(), 'all', $sql);
	foreach ($array as $i => $val) {
		$sql = "SELECT m.nombre_maq, a.nombre_articulo, a.cve_alterna, d.cve_req, d.cantidad, d.cve_req_det, d.fecha_registro FROM requisicion_detalle d
		INNER JOIN cat_maquinas m ON d.cve_maquina = m.cve_maq
		INNER JOIN cat_articulos a ON d.cve_art = a.cve_articulo
		WHERE d.cve_req = ".$val->cve_req." ORDER BY d.cve_req_det desc";
		$articulos = $dbcon->qBuilder($dbcon->conn(), 'all', $sql);
		foreach ($articulos as $value) {
			$misRequisiciones[$cont] = $value;
			$cont ++;
		}	
	}
	dd($misRequisiciones);
}
function envioCorreo($dbcon, $folio){
	include_once "../../../correo/EnvioSMTP.php";
	$envioSMTP = new EnvioSMTP;
	$sql = "SELECT u.nombre_usuario FROM requisicion r INNER JOIN cat_usuarios u ON u.cve_usuario = r.cve_usuario WHERE cve_req = ".$folio;
	$requisicion = $dbcon->qBuilder($dbcon->conn(), 'first', $sql);
	$title = 'Prueba';
	$Subject = 'Correo demo';
	$Body = '<!doctype html>';
	$Body .= '<html lang="es" >';
	$Body .= '<head>';
	$Body .= '<meta charset="utf-8">';
	$Body .= '<meta name="viewport" content="width=device-width, initial-scale=1">';
	$Body .= '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">';
	$Body .= '<meta name="title" content="Mayucsa">';
	$Body .= '<title>Email Mayucsa</title>';
	$Body .= '</head>';
	$Body .= '<body style="background-color: white;">';
	$Body .= '<br><br>';
	$Body .= '<div class="container" style="border-radius: 15px; background-color: white; margin-top:2vH;margin-bottom:2vH; width:70%; margin-left:15%; text-align:center;">';
	$Body .= '<center>';
	$Body .= '<h1>Se ha creado una nueva requisición.</h1>';
	$Body .= '<br><hr style="width:30%;">';
	$Body .= '<br><p>Requisición #'.$folio.'</p>';
	$Body .= '<br><p>Creado por usuario: '.$requisicion->nombre_usuario.'</p>';
	$Body .= '<br><p>Acceda al sistema (SAM) para Generar cotizaciones.</p>';
	$Body .= '</center>';
	$Body .= '</div>';
	$Body .= '<br><br>';
	$Body .= '</body>';
	$Body .= '</html>';
	$correos = ['ilopez@lcdevelopers.com.mx'];
	$email = $envioSMTP->correo($title, $Subject, $Body, $correos);
	if ($email) {
		dd(['code'=>200]);
	}else{
		dd(['code'=>400, 'body'=>$Body]);
	}
}
function guardatRequisicion($dbcon, $Datos){
	$status = '0';
	$fecha = date('Y-m-d H:i:s');
	$conn = $dbcon->conn();
	$sql = "INSERT INTO requisicion (cve_usuario, q_autoriza, comentarios, estatus_req, fecha_registro)	VALUES ( ".$Datos->id.", ".$Datos->autoriza.", '".$Datos->comentario."', '".$status."', '".$fecha."')";
	$qBuilder = $dbcon->qBuilder($conn, 'do', $sql);
	if ($qBuilder) {
		$getId = "SELECT max(cve_req) cve_req FROM requisicion WHERE 
		fecha_registro = '".$fecha."' 
		AND cve_usuario = ".$Datos->id."
		AND comentarios = '".$Datos->comentario."'
		AND q_autoriza = ".$Datos->autoriza."
		AND estatus_req = '".$status."'";
		
		$getId = $dbcon->qBuilder($conn, 'first', $getId);
		foreach ($Datos->articulos as $i => $val) {
			$sql = "INSERT INTO requisicion_detalle (cve_req, cve_art, cve_maquina, cantidad, precio_total, surtido, prioridad, estatus_req_det, fecha_registro)
			VALUES (
				".$getId->cve_req.",
				".$val->cve_articulo.",
				".$val->cve_maquina.",
				".$val->cantidad.",
				0.0,
				0.0,
				'',
				'".$status."',
				'".$fecha."'
			)";
			$qBuilder = $dbcon->qBuilder($conn, 'do', $sql);
			if (!$qBuilder) {
				dd(['code'=>300, 'msj'=>'error al cargar detalle cve_articulo: '.$val->cve_articulo, 'sql'=>$sql]);
			}
		}
		dd(['code'=>200,'msj'=>'Carga ok', 'folio'=>$getId->cve_req]);
	}else{
		dd(['code'=>300, 'msj'=>'error al crear folio.', 'sql'=>$sql]);
	}
}
function getMaquinas($dbcon){
	$sql = "SELECT nombre_maq, cve_maq FROM cat_maquinas";
	$maquinas = $dbcon->qBuilder($dbcon->conn(), 'all', $sql);
	dd($maquinas);
}
function getArticulos($dbcon, $cve_alterna, $nombre_articulo){
	$sql = "SELECT cve_alterna, nombre_articulo, cve_articulo FROM cat_articulos WHERE estatus_articulo = 'VIG' ";
	if ($cve_alterna != '') {
		$sql .= " AND cve_alterna LIKE '%".$cve_alterna."%'";
	}
	if ($nombre_articulo != '') {
		$sql .= "AND nombre_articulo LIKE '%".$nombre_articulo."%'";
	}
	$articulos = $dbcon->qBuilder($dbcon->conn(), 'all', $sql);
	dd($articulos);
}
include_once "../../../dbconexion/conn.php";
$dbcon	= 	new MysqlConn;
$conn 	= 	$dbcon->conn();
// inicio
$tarea = isset($_REQUEST['task']) ? $_REQUEST['task'] : '';
if ($tarea == '') {
	// en caso de que el llamado al controlador haya sido por http post y no por formulario
	$objDatos = json_decode(file_get_contents("php://input"));
	$tarea = $objDatos->task;
}
switch ($tarea) {
	case 'getMaquinas':
		getMaquinas($dbcon);
		break;
	case 'getArticulos':
		getArticulos($dbcon, $objDatos->cve_alterna, $objDatos->nombre_articulo);
		break;
	case 'guardatRequisicion':
		guardatRequisicion($dbcon, $objDatos);
		break;
	case 'envioCorreo':
		envioCorreo($dbcon, $objDatos->folio);
		break;
	case 'getMisRequisiciones':
		getMisRequisiciones($dbcon, $objDatos->cve_usuario);
		break;
}
?>
