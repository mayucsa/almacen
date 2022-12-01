<?php
session_start();
include_once "../../../dbconexion/conexion.php";

// $objeto = unserialize($_SESSION['usuario']);
 // $edit_catalogo  = $objeto->edit_catalogo;

// header('Content-Type: application/json');

// DB table to use
$table = 'requisicion';
 
// Table's primary key
$primaryKey = 'cve_req';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$var    = "req.tipo = 'N' AND req.cve_usuario = ".$_SESSION['id'];
$columns = [
    ['db' => '`req`.`cve_req`', 'dt' => 0, 'field' => 'cve_req'],
    ['db' => '`user`.`nombre`', 'dt' => 1, 'field' => 'nombre'],
    ['db' => '`req`.`comentarios`', 'dt' => 2, 'field' => 'comentarios'],
    ['db' => '`req`.`fecha_registro`', 'dt' => 3, 'formatter' => function($d, $row){
        return date('Y-M-d', strtotime($d));
    }, 'field' => 'fecha_registro'],
    ['db' => '`req`.`cve_usuario`', 'dt' => 4, 'formatter' => function($d, $row) {
        if ($row[5] == 1 /*AND $row[6] = 1*/) {
            return  '<span class= "btn btn-info" onclick= "Ver('.$row[0].')" title="Ver requisicion" data-toggle="modal" data-target="#modalVer" data-whatever="@getbootstrap"><i class="fas fa-eye"></i> </span>'. ' '.'<span class= "btn btn-warning" onclick= "Editar('.$row[0].')" title="Editar" data-toggle="modal" data-target="#modalEditar" data-whatever="@getbootstrap"><i class="fas fa-edit"></i> </span>'. ' ' .
                    '<span class= "btn btn-danger" onclick= "Eliminar('.$row[0].')" title="Eliminar" data-toggle="modal" data-target="#modalElimiinar" data-whatever="@getbootstrap"><i class="fas fa-trash-alt"></i> </span>';
        }else{
            return '<span class= "btn btn-info" onclick= "Ver('.$row[0].')" title="Ver requisicion" data-toggle="modal" data-target="#modalVer" data-whatever="@getbootstrap"><i class="fas fa-eye"></i> </span>';
        }
    }, 'field' => 'cve_usuario'],
    ['db' => '`req`.`estatus_req`', 'dt' => 5, 'field' => 'estatus_req'],
    // ['db' => '`reqdet`.`estatus_req_det`', 'dt' => 6, 'field' => 'estatus_req_det'],
    ['db' => '`user`.`apellido`', 'dt' => 6, 'field' => 'apellido'],
];

$joinQuery = "  FROM `{$table}` AS `req`
                INNER JOIN `cat_usuarios` AS `user` ON (`req`.`q_autoriza` = `user`.`cve_usuario`)
";

// $columns = array(
//     array( 'db' => 'cve_req',          'dt' => 0 ),
//     array( 'db' => 'q_autoriza',          'dt' => 1 ),
//     array( 'db' => 'comentarios',    'dt' => 2 ),
//     array(
//         'db'        => 'fecha_registro',
//         'dt'        => 3,
//         'formatter' => function( $d, $row ) {
//             return date( 'Y-m-d', strtotime($d));
//         }
//     ),
//     array( 
//         'db' => 'cve_usuario',
//         'dt' => 4,
//         'formatter' => function($d, $row){
//             if ($d == $_SESSION['id'] AND $row[5] == 1) {
//                 return '<span class= "badge badge-info">Servicio</span>';
//             }else{
//                 return '<span class= "badge badge-danger">Cotizado</span>';
//             }
//         } 
//     ),
//     array( 'db' => 'estatus_req',    'dt' => 5 )
// );
 
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