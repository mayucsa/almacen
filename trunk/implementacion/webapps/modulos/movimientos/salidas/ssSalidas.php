<?php
session_start();
include_once "../../../dbconexion/conexion.php";
// header('Content-Type: application/json');

// DB table to use
$table = 'movtos_salidas';
 
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
            ['db' => '`ms`.`cve_mov`', 'dt' => 0, 'field' => 'cve_mov'],
            ['db' => '`user`.`nombre`', 'dt' => 1, 'field' => 'nombre'],
            ['db' => '`ms`.`folio_vale`', 'dt' => 2, 'field' => 'folio_vale'],
            ['db' => '`depto`.`nombre_depto`', 'dt' => 3, 'field' => 'nombre_depto'],
            ['db' => '`maq`.`nombre_maq`', 'dt' => 4, 'field' => 'nombre_maq'],
            ['db' => '`ms`.`fecha_registro`', 'dt' => 5, 'formatter' => function( $d, $row ) {
                    return date( 'Y-m-d', strtotime($d));
                }, 'field' => 'fecha_registro'],
            ];
 
$joinQuery = " FROM `{$table}` AS `ms` 
                INNER JOIN `cat_usuarios` AS `user` ON (`ms`.`creado_por` = `user`.`cve_usuario`)
                INNER JOIN `cat_departamentos` AS `depto` ON (`ms`.`cve_depto` = `depto`.`cve_depto`)
                INNER JOIN `cat_maquinas` AS `maq` ON (`ms`.`cve_maq` = `maq`.`cve_maq`)
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