<?php 
function dd($var){
    if (is_array($var) || is_object($var)) {
        die(json_encode($var));
    }else{
        die($var);
    }
}
function getMaquinas($dbcon, $cve_depto){
	$sql = "SELECT * FROM cat_maquinas WHERE estatus_maq = 'VIG' AND cve_depto = ".$cve_depto;
	dd($dbcon->qBuilder($dbcon->conn(), 'all', $sql));
}
function getArticulos($dbcon, $codarticulo){
	$sql = "SELECT cve_articulo, cve_alterna, nombre_articulo, existencia, unidad_medida FROM cat_articulos WHERE cve_alterna = '".$codarticulo."'";
	$articulo = $dbcon->qBuilder($dbcon->conn(), 'all', $sql);
	if (count($articulo)) {
		dd(['tipo'=>1, 'datos'=>$articulo]);
	}
	$sql = "SELECT cve_articulo, cve_alterna, nombre_articulo, existencia, unidad_medida FROM cat_articulos WHERE cve_alterna LIKE '%".$codarticulo."%' AND existencia > 0
		OR nombre_articulo LIKE '%".$codarticulo."%' AND existencia > 0 ORDER BY nombre_articulo LIMIT 20";
	$articulos = $dbcon->qBuilder($dbcon->conn(), 'all', $sql);
	dd(['tipo'=>2, 'datos'=>$articulos]);
}
function guardarMovimiento($dbcon, $Datos){
	$tipo_mov = 'S';
	$status = '1';
	$fecha = date('Y-m-d H:i:s');
	$conn = $dbcon->conn();
	$sql = " INSERT INTO movtos_salidas (tipo_mov, creado_por, folio_vale, concepto, cve_depto, cve_maq, horometro, comentario, estatus_mov, fecha_registro) VALUES ('".$tipo_mov."', ".$Datos->id.", ".$Datos->foliovale.", '".$Datos->concepto."', ".$Datos->departamento.", ".$Datos->maquinas.", ".intval($Datos->horometro).", '".$Datos->comentarios."', '".$status."', '".$fecha."' ) ";
	$qBuilder = $dbcon->qBuilder($conn, 'do', $sql);

	if ($qBuilder) {
		$sql = "SELECT max(cve_mov) cve_mov FROM movtos_salidas WHERE 
		fecha_registro = '".$fecha."'
		AND creado_por = ".$Datos->id."
		AND tipo_mov = '".$tipo_mov."'
		AND folio_vale = ".$Datos->foliovale."
		AND concepto = '".$Datos->concepto."'
		AND cve_depto = ".$Datos->departamento."
		AND cve_maq = ".$Datos->maquinas."
		AND estatus_mov = '".$status."'";
		$getId = $dbcon->qBuilder($conn, 'first', $sql);
		// detalle
		$articulos = $Datos->articulos;
		foreach ($articulos as $i => $val) {
			$sql = "INSERT INTO movtos_salidas_detalle 
			(cve_mov, cve_articulo, existencia, cantidad_salida, estatus_mov, fecha_registro)
			VALUES(
				".$getId->cve_mov.",
				".$val->cve_articulo.",
				".$val->existencia.",
				".$val->cantidad.",
				1, '".$fecha."'
			)";
			if (!$dbcon->qBuilder($dbcon->conn(),'do',$sql)) {
				dd(['code'=>300, 'msj'=>'error al insertar detalle.', 'sql'=>$sql]);
			}
			// Restamos el stock en catalogo de articulos
			$sql = "UPDATE cat_articulos set existencia = existencia - ".$val->cantidad." WHERE cve_articulo = ".$val->cve_articulo;
			if (!$dbcon->qBuilder($dbcon->conn(), 'do', $sql)) {
				dd(['code'=>400, 'msj'=>'error al restar existencia.', 'sql'=>$sql]);
			}
		}
		dd(['code'=>200,'msj'=>'Carga ok', 'folio'=>$getId->cve_mov]);
	} else {
		dd(['code'=>300, 'msj'=>'error al crear folio.', 'sql'=>$sql]);
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
switch ($tarea){
	case 'guardarMovimiento':
		guardarMovimiento($dbcon, $objDatos);
		break;
	case 'getArticulos':
		getArticulos($dbcon, $objDatos->codarticulo);
		break;
	case 'getMaquinas':
		getMaquinas($dbcon, $objDatos->cve_depto);
		break;
}

?>