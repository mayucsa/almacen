<?php
include_once "../../../dbconexion/conexion.php";
include_once "modelo_dashboard.php";

        $fecha_inicio = $_POST['fecha_inicio'];
        $fecha_fin = $_POST['fecha_fin'];

        $objModelo	= new modeloDashboard;
        $consulta = $objModelo->VentasBloqueras($fecha_inicio, $fecha_fin);

        // echo '<div id="containerbloquera" style="min-width: 310px; height: 400px; margin: 0 auto"></div>';

        $dato = [];
        foreach ($consulta as $key => $value) {
            $dato[$key] = [
                                "name" => $value['area'].' - '.$value['nombre_producto'].' - '.$value['presentacion'].' - '.$value['num_celdas'],
                                "y" => floatval($value['cantidad_total'])
                            ];
        }

        echo json_encode($dato);

 ?>