<?php
function dd($var){
    if (is_array($var) || is_object($var)) {
        die(json_encode($var));
    }else{
        die($var);
    }
}
function guardaArchivos($dbcon){
	$cve_odc = $_REQUEST['cve_odc'];
	$archivos = $_FILES['archivos']["name"];
	for ($i=0; $i < count($archivos); $i++) { 
		$name = $_FILES['archivos']["name"][$i];
    	$source = $_FILES['archivos']["tmp_name"][$i];
    	$directorio = '../../../includees/archivos/';
	    if (!file_exists($directorio)) {
	        mkdir($directorio,0755,true);
	    }
	    if(!file_exists($directorio)){
	        mkdir($directorio, 0777) or die("No se puede crear el directorio de extracción");    
	    }
	    $directorio.='cotizaciones/';
	    if (!file_exists($directorio)) {
	        mkdir($directorio,0755,true);
	    }
	    if(!file_exists($directorio)){
	        mkdir($directorio, 0777) or die("No se puede crear el directorio de extracción");    
	    }
	    $dir=opendir($directorio);
	    $chk_ext = explode(".",$name);
	    $ext = strtolower(end($chk_ext));
	    $nombre = $cve_odc.date('YmdHis').$i.'.'.$ext;
	    if(!move_uploaded_file($source, $directorio.$nombre)) { 
	        dd('error al subir el archivo.');        
	    }
    	$insert = "INSERT INTO orden_compra_archivos (cve_odc, nombre, extension, ruta, nombreOriginal, fecha) values 
    	(
    		".$cve_odc.",
    		'".$nombre."',
    		'".$ext."',
    		'".$directorio."',
    		'".$name."',
    		'".date('Y-m-d H:i:s')."'
    	)";
    	if (!$dbcon->qBuilder($dbcon->conn(), 'do', $insert)) {
    		dd(['code'=>400, 'insert'=>$insert]);
    	}
	}
	dd(['code'=>200]);
}
function generaOrdenCompra($dbcon, $datos){
	$requisiciones_det = $datos->requisiciones_det;
	$cve_proveedor = $datos->cve_proveedor;
	$cve_req = $datos->cve_req;
	$sql = "SELECT cve_usuario, q_autoriza FROM requisicion WHERE cve_req = ".$cve_req;
	$requisicion = $dbcon->qBuilder($dbcon->conn(), 'first', $sql);
	$fecha = date('Y-m-d H:i:s');
	$sql = "INSERT INTO orden_compra (cve_usuario, cve_proveedor, q_autoriza, estatus_autorizado, estatus_odc, fecha_registro)
		VALUES(
			".$requisicion->cve_usuario.",
			".$cve_proveedor.",
			".$requisicion->q_autoriza.",
			1,
			1,
			'".$fecha."'
		)
	";
	$insert = $dbcon->qBuilder($dbcon->conn(), 'do', $sql);
	if ($insert) {
		$sql = "SELECT cve_odc FROM orden_compra WHERE cve_usuario = ".$requisicion->cve_usuario." AND cve_proveedor = ".$cve_proveedor." 
		AND q_autoriza = ".$requisicion->q_autoriza." AND fecha_registro = '".$fecha."'";
		$cve_odc = $dbcon->qBuilder($dbcon->conn(), 'first', $sql);
		foreach ($requisiciones_det as $i => $row) {
			$sql = "INSERT INTO orden_compra_detalle (cve_odc, cve_req, cve_art, cantidad_cotizada, precio_unidad, precio_total, estatus_req_det, fecha_registro) values(
				".$cve_odc->cve_odc.",
				".$cve_req.",
				".$row->cve_art.",
				".$row->cantidad.",
				".$row->precioU.",
				".$row->total.",
				1,
				'".$fecha."'
			)";
			if (!$dbcon->qBuilder($dbcon->conn(), 'do', $sql)) {
				dd(['code'=>400, 'qry'=>$sql]);
			}
		}
		dd(['code' => 200, 'cve_odc' => $cve_odc->cve_odc]);
	}else{
		dd(['code' => 400, 'qry'=>$sql]);
	}
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
	case 'generaOrdenCompra':
		generaOrdenCompra($dbcon, $objDatos);
		break;
	case 'guardaArchivos':
		guardaArchivos($dbcon);
		break;
}
?>
