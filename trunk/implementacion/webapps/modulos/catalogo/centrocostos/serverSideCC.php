<?php 
include_once "../../../dbconexion/conexion.php";

// DB table to use
$table = 'cat_centro_costos';
 
// Table's primary key
$primaryKey = 'cve_cc';

$columns = [
    ['db' => '`cc`.`cve_alterna`', 'dt' => 0, 'field' => 'cve_alterna'],
    ['db' => '`ncc`.`nombre`', 'dt' => 1, 'field' => 'nombre'],
    ['db' => '`cc`.`cuenta_cc`', 'dt' => 2, 'field' => 'cuenta_cc'],
    ['db' => '`cc`.`fecha_registro`', 'dt' => 3, 'formatter' => function( $d, $row ) {
            return date( 'Y-M-d', strtotime($d));
        }, 'field' => 'fecha_registro'],
    ['db' => '`cc`.`tipo`', 'dt' => 4, 'field' => 'tipo'],
    ['db' => '`area`.`abreviacion`', 'dt' => 5, 'field' => 'abreviacion'],
];

 $joinQuery = " FROM `{$table}` AS `cc` 
                INNER JOIN `cat_nombre_cc` AS `ncc` ON (`cc`.`cuenta_cc` = `ncc`.`cve_alterna`)
                INNER JOIN `cat_areas` AS `area` ON (`cc`.`tipo` = `area`.`cve_alterna`)
                ";

// SQL server connection information
include_once "../../../dbconexion/conexionServerSide.php";

require( '../../../includes/js/data_tables_js/sspjoin.php' );

echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery )
);

 ?>