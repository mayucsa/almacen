<?php
include_once "../../../dbconexion/conexion.php";
include_once "modelo_dashboard.php";

        $fecha_inicio = $_POST['fecha_inicio'];
        $fecha_fin = $_POST['fecha_fin'];

        $objModelo	= new modeloDashboard;
        $consulta = $objModelo->VentasMorteros($fecha_inicio, $fecha_fin);

        // echo '<div id="containerbloquera" style="min-width: 310px; height: 400px; margin: 0 auto"></div>';

        $dato = [];
        foreach ($consulta as $key => $value) {
            $dato[$key] = [
                                "name" => $value['nombre_salida'].' / '.$value['presentacion_salida'].' KG',
                                "y" => floatval($value['cantidad_salida'])
                            ];
        }

        echo json_encode($dato);

 ?>