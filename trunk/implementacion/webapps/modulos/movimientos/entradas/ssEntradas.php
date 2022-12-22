<?php
session_start();
include_once "../../../dbconexion/conexion.php";
// header('Content-Type: application/json');

// DB table to use
$table = 'movtos_entradas';
 
// Table's primary key
$primaryKey = 'cve_mov';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$var    = "estatus_mov = 1";
// $columns = array(
//     array( 'db' => 'cve_mov',          'dt' => 0 ),
//     array( 'db' => 'creado_por',          'dt' => 1 ),
//     array( 'db' => 'cve_odc',          'dt' => 2 ),
//     array( 'db' => 'folio_documento',       'dt' => 3),
//     array( 'db' => 'fecha_registro',       'dt' => 4, 'formatter' => function( $d, $row ) {
//                     return date( 'Y-m-d', strtotime($d));
//                 }, 'field' => 'fecha_registro'),
// );
        $columns = [
            ['db' => '`me`.`cve_mov`', 'dt' => 0, 'field' => 'cve_mov'],
            ['db' => '`user`.`nombre`', 'dt' => 1, 'field' => 'nombre'],
            ['db' => '`me`.`cve_odc`', 'dt' => 2, 'field' => 'cve_odc'],
            ['db' => '`me`.`folio_documento`', 'dt' => 3, 'field' => 'folio_documento'],
            ['db' => '`me`.`fecha_registro`', 'dt' => 4, 'formatter' => function( $d, $row ) {
                    return date( 'Y-m-d', strtotime($d));
                }, 'field' => 'fecha_registro'],
            ];
 
$joinQuery = " FROM `{$table}` AS `me` 
                INNER JOIN `cat_usuarios` AS `user` ON (`me`.`creado_por` = `user`.`cve_usuario`)
                ";


// SQL server connection information
include_once "../../../dbconexion/conexionServerSide.php";
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
 
require( '../../../includes/js/data_tables_js/sspjoin.php' );
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $var )
);
?>