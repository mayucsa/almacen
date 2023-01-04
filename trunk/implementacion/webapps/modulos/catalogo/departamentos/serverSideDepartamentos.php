<?php
include_once "../../../dbconexion/conexion.php";
// header('Content-Type: application/json');

// DB table to use
$table = 'cat_departamentos';
 
// Table's primary key
$primaryKey = 'cve_depto';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$var    = "estatus_depto = 'VIG'";
$columns = array(
    array( 'db' => 'cve_alterna',          'dt' => 0 ),
    array( 'db' => 'nombre_depto',          'dt' => 1 ),
    array(
        'db'        => 'fecha_registro',
        'dt'        => 2,
        'formatter' => function( $d, $row ) {
            return date( 'Y-m-d', strtotime($d));
        }
    ),
    array( 'db' => 'cve_depto',       'dt' => 3),
);

// $columns = [
//     ['db' => '`depto`.`cve_alterna`', 'dt' => 0, 'field' => 'cve_alterna'],
//     // ['db' => '`area`.`nombre_area`', 'dt' => 1, 'field' => 'nombre_area'],
//     ['db' => '`depto`.`nombre_depto`', 'dt' => 1, 'field' => 'nombre_depto'],
//     // ['db' => '`depto`.`estatus_depto`', 'dt' => 2, 'field' => 'estatus_depto'],
//     ['db' => '`depto`.`fecha_registro`', 'dt' => 2, 'formatter' => function( $d, $row ) {
//             return date( 'Y-M-d', strtotime($d));
//         }, 'field' => 'fecha_registro'],
//     ['db' => '`depto`.`cve_depto`', 'dt' => 3, 'field' => 'cve_depto'],
// ];

//  $joinQuery = " FROM `{$table}` AS `depto` 
//                 INNER JOIN `cat_areas` AS `area` ON (`depto`.`cve_area` = `area`.`cve_area`)
//                 ";

// SQL server connection information


include_once "../../../dbconexion/conexionServerSide.php";
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
 
require( '../../../includes/js/data_tables_js/ssp.class.php' );
// require( '../../../includes/js/data_tables_js/sspjoin.php' );
 
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $var )
);
?>