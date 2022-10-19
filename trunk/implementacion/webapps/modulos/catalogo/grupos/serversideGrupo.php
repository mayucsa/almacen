<?php
include_once "../../../dbconexion/conexion.php";
// header('Content-Type: application/json');

// DB table to use
$table = 'cat_grupos';
 
// Table's primary key
$primaryKey = 'cve_gpo';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
// $var    = "estatus_gpo = 'VIG'";
$columns = array(
    array( 'db' => 'nombre_gpo',          'dt' => 0 ),
    array( 'db' => 'estatus_gpo',    'dt' => 1 ),
    array(
        'db'        => 'fecha_registro',
        'dt'        => 2,
        'formatter' => function( $d, $row ) {
            return date( 'Y-m-d', strtotime($d));
        }
    ),
    array( 'db' => 'cve_gpo',       'dt' => 3),
);
 
// SQL server connection information


include_once "../../../dbconexion/conexionServerSide.php";
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
 
require( '../../../includes/js/data_tables_js/ssp.class.php' );
 
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns )
);
?>