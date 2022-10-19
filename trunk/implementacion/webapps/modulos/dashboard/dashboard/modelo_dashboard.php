<?php 
	include_once "../../../dbconexion/conexion.php";
	// include_once "ctrl_dashboard.php";

class modeloDashboard{

	function ProduccionBloqueras($fecha_inicio, $fecha_fin){
		$sql = "	SELECT area, nombre_producto, presentacion, num_celdas, SUM(piezas_totales) AS piezas_totales
					FROM captura_produccionbloquera
					WHERE fecha_registro BETWEEN DATE_ADD('".$fecha_inicio."', INTERVAL 13 HOUR) AND DATE_ADD('".$fecha_fin."', INTERVAL 35 HOUR)  AND estatus_registro = 'VIG' AND num_celdas >0
					GROUP BY area, nombre_producto, presentacion, num_celdas";
		$vquery = Conexion::conectar()->prepare($sql);
        $vquery->execute();
		// die($sql);
		return $vquery->fetchAll();
		$vquery->close();
		$vquery = null;
	}

	function ProduccionMorteros($fecha_inicio, $fecha_fin){
		$sql = "	SELECT cve_producto, valor_presentacion, SUM(kg_real) as KGReal
					FROM captura_produccion
					WHERE DATE(fecha_registro) BETWEEN '".$fecha_inicio."' AND '".$fecha_fin."'
					GROUP BY cve_producto, valor_presentacion";
		$vquery = Conexion::conectar()->prepare($sql);
        $vquery->execute();
		// die($sql);
		return $vquery->fetchAll();
		$vquery->close();
		$vquery = null;
	}

	function VentasBloqueras($fecha_inicio, $fecha_fin){
		$sql = "	SELECT area, nombre_producto, presentacion, num_celdas, SUM(cantidad_salida) as cantidad_total
					FROM seg_salidas_bloquera
					WHERE DATE(fecha_registro) BETWEEN '".$fecha_inicio."' AND '".$fecha_fin."' AND estatus_salida = 'VIG'
					GROUP BY area, nombre_producto, presentacion, num_celdas";
		$vquery = Conexion::conectar()->prepare($sql);
        $vquery->execute();
		// die($sql);
		return $vquery->fetchAll();
		$vquery->close();
		$vquery = null;
	}

	function VentasMorteros($fecha_inicio, $fecha_fin){
		$sql = "	SELECT nombre_salida, presentacion_salida, SUM(cantidad_salida) AS cantidad_salida
					FROM seg_salidas
					WHERE DATE(fecha_registro) BETWEEN '".$fecha_inicio."' AND '".$fecha_fin."' AND categoria = 'PF' AND motivo_salida = 'Ventas' AND estatus_salida = 'VIG'
					GROUP BY nombre_salida, presentacion_salida";
		$vquery = Conexion::conectar()->prepare($sql);
        $vquery->execute();
		// die($sql);
		return $vquery->fetchAll();
		$vquery->close();
		$vquery = null;
	}



// PRODUCCIONES TOTALES
	function ProduccionTotalBloqueras(){
		$sql = "	SELECT area, nombre_producto, presentacion, num_celdas, SUM(piezas_totales) AS piezas_totales
					FROM captura_produccionbloquera
					WHERE DATE(fecha_registro) BETWEEN '2022-01-01' AND '2022-12-31' AND estatus_registro = 'VIG' AND num_celdas > 0
					GROUP BY area, nombre_producto, presentacion, num_celdas";
		$vquery = Conexion::conectar()->prepare($sql);
        $vquery->execute();
		// die($sql);
		return $vquery->fetchAll();
		$vquery->close();
		$vquery = null;
	}

	function ProduccionTotalMorteros(){
		$sql = "	SELECT cve_producto, valor_presentacion, SUM(kg_real) as KGReal
					FROM captura_produccion
					WHERE DATE(fecha_registro) BETWEEN '2022-01-01' AND '2022-12-31'
					GROUP BY cve_producto, valor_presentacion";
		$vquery = Conexion::conectar()->prepare($sql);
        $vquery->execute();
		// die($sql);
		return $vquery->fetchAll();
		$vquery->close();
		$vquery = null;
	}

	function VentasTotalBloqueras(){
		$sql = "	SELECT area, nombre_producto, presentacion, num_celdas, SUM(cantidad_salida) as cantidad_total
					FROM seg_salidas_bloquera
					WHERE DATE(fecha_registro) BETWEEN '2022-01-01' AND '2022-12-31' AND estatus_salida = 'VIG'
					GROUP BY area, nombre_producto, presentacion, num_celdas";
		$vquery = Conexion::conectar()->prepare($sql);
        $vquery->execute();
		// die($sql);
		return $vquery->fetchAll();
		$vquery->close();
		$vquery = null;
	}

	function VentasTotalMorteros(){
		$sql = "	SELECT nombre_salida, presentacion_salida, SUM(cantidad_salida) AS cantidad_salida
					FROM seg_salidas
					WHERE DATE(fecha_registro) BETWEEN '2022-01-01' AND '2022-12-31' AND categoria = 'PF' AND motivo_salida = 'Ventas' AND estatus_salida = 'VIG'
					GROUP BY nombre_salida, presentacion_salida";
		$vquery = Conexion::conectar()->prepare($sql);
        $vquery->execute();
		// die($sql);
		return $vquery->fetchAll();
		$vquery->close();
		$vquery = null;
	}
}
?>