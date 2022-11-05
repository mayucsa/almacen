<?php
include_once "../../../dbconexion/conexion.php";
// header('Content-Type: application/json');

// DB table to use
$table = 'requisicion_detalle';
 
// Table's primary key
$primaryKey = 'cve_req_det';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$var    = "estatus_req_det = '1' ";
// $columns = array(
//     array( 'db' => 'cve_maq',          'dt' => 0 ),
//     array( 'db' => 'cve_fallo',    'dt' => 1 ),
//     array( 'db' => 'hora_inicio',          'dt' => 2),
//     array( 'db' => 'hora_fin',          'dt' => 3),
//     array(
//         'db'        => 'fecha_registro',
//         'dt'        => 4,
        // 'formatter' => function( $d, $row ) {
        //     return date( 'Y-m-d', strtotime($d));
        // }
//     ),
//     array( 'db' => 'cve_tpbesser',       'dt' => 5),
//     array(
//         'db'        => 'fecha_registro',
//         'dt'        => 6,
        // 'formatter' => function( $d, $row ) {
        //     return date( 'H:i:s', strtotime($d));
        // }
//     ),
// );

            // ['db' => '`tp`.`fecha_registro`', 'dt' => 4, 'formatter' => function( $d, $row ) {
                // if ($_SESSION['rol'] == '1') {
                    // return con html de botones para editar y eliminar
                // } else {
                    // return con html de botones para solo editar
                // }
                // return date( 'Y-m-d', strtotime($d));
            // }, 'field' => 'fecha_registro'],
        $columns = [
            ['db' => '`req`.`cve_req`', 'dt' => 0, 'field' => 'cve_req'],
            ['db' => '`r`.`tipo`', 'dt' => 1, 'field' => 'tipo'],
            ['db' => '`r`.`q_autoriza`', 'dt' => 2, 'field' => 'q_autoriza'],
            ['db' => '`art`.`cve_alterna`', 'dt' => 3, 'field' => 'cve_alterna'],
            ['db' => '`art`.`nombre_articulo`', 'dt' => 4, 'field' => 'nombre_articulo'],
            ['db' => '`req`.`cantidad`', 'dt' => 5,
                        'formatter' => function($d, $row){
                            return number_format($d - $row[7], 4,'.',',');
                        }, 'field' => 'cantidad'],
            ['db' => '`req`.`cve_art`', 'dt' => 6, 'field' => 'cve_art'],
            ['db' => '`req`.`cantidad_cotizado`', 'dt' => 7, 'field' => 'cantidad_cotizado'],
            ['db' => '`req`.`cantidad`', 'dt' => 8, 'field' => 'cantidad'],
            ['db' => '`art`.`cve_articulo`', 'dt' => 9, 'field' => 'cve_articulo'],
            ['db' => '`u`.`nombre`', 'dt' => 10, 'field' => 'nombre'],
            ['db' => '`u`.`apellido`', 'dt' => 11, 'field' => 'apellido'],
            ['db' => '`req`.`cve_req_det`', 'dt' => 12, 'field' => 'cve_req_det'],

            ];
        // $columns = [
        //     ['db' => '`req`.`cve_req`', 'dt' => 0, 'field' => 'cve_req'],
        //     ['db' => '`art`.`cve_articulo`', 'dt' => 1, 'field' => 'cve_articulo'],
        //     ['db' => '`req`.`cve_art`', 'dt' => 2, 'field' => 'cve_art'],
        //     ['db' => '`req`.`cantidad`', 'dt' => 3, 'field' => 'cantidad'],
        //     ['db' => '`art`.`cve_alterna`', 'dt' => 4, 'field' => 'cve_alterna'],
        //     ['db' => '`art`.`nombre_articulo`', 'dt' => 5, 'field' => 'nombre_articulo'],
        //     ['db' => '`req`.`cantidad_cotizado`', 'dt' => 6, 'field' => 'cantidad_cotizado'],
        //     ['db' => '`req`.`cantidad`', 'dt' => 7,
        //                 'formatter' => function($d, $row){
        //                     return number_format($d - $row[6], 4,'.',',');
        //                 }, 'field' => 'cantidad'],
        //     ['db' => '`r`.`tipo`', 'dt' => 8, 'field' => 'tipo'],
        //     ];

 
 $joinQuery = " FROM `{$table}` AS `req` 
                INNER JOIN `cat_articulos` AS `art` ON (`req`.`cve_art` = `art`.`cve_articulo`)
                INNER JOIN `requisicion` AS `r` ON (`req`.`cve_req` = `r`.`cve_req`)
                INNER JOIN `cat_usuarios` AS `u` ON (`r`.`q_autoriza` = `u`.`cve_usuario`)";

// SQL server connection information


include_once "../../../dbconexion/conexionServerSide.php";
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
 
// require( '../../../includes/js/data_tables_js/ssp.class.php' );
require( '../../../includes/js/data_tables_js/sspjoin.php' );
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $var )
);
?>