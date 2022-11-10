<?php
include_once "../../../dbconexion/conexion.php";

$objeto = new Conexion();
$conexion = $objeto->conectar();

$consulta = "   SELECT O.cve_odc AS cve_odc, P.nombre_proveedor AS proveedor, FORMAT(SUM(D.precio_total), 3) AS total, DATE_FORMAT(O.fecha_registro, '%Y-%b-%d') AS fecha
                FROM orden_compra O
                INNER JOIN orden_compra_detalle D ON (O.cve_odc = D.cve_odc)
                INNER JOIN cat_proveedores P ON (O.cve_proveedor = P.cve_proveedor)
                WHERE O.estatus_autorizado = 0 AND O.estatus_odc = 1
                GROUP BY O.cve_odc";
$resultado =  $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);

print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion=null;

?>