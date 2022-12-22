<?php
session_start();
include_once "../../../dbconexion/conexion.php";
include_once "../../../modulos/seguridad/login/datos_usuario.php";

// $objeto = unserialize($_SESSION['usuario']);
 // $edit_catalogo  = $objeto->edit_catalogo;

// header('Content-Type: application/json');

// DB table to use
$table = 'cat_articulos';
 
// Table's primary key
$primaryKey = 'cve_articulo';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$var    = "estatus_articulo = 'VIG'";
$columns = array(
    array( 'db' => 'cve_alterna',          'dt' => 0 ),
    array( 'db' => 'nombre_articulo',          'dt' => 1 ),
    array( 'db' => 'existencia',    'dt' => 2 ),
    array( 'db' => 'max',    'dt' => 3 ),
    array( 'db' => 'min',    'dt' => 4 ),
    array(
        'db'        => 'fecha_registro',
        'dt'        => 5,
        'formatter' => function( $d, $row ) {
            return date( 'Y-m-d', strtotime($d));
        }
    ),
    array( 'db' => 'cve_articulo',       'dt' => 6),
    array( 'db' => 'estatus_articulo',       'dt' => 7, 'formatter' => function($d, $row){
        if ($_SESSION['articulo_edit'] == 1) {
            return  '<span class= "btn btn-info" onclick= "obtenerDatosS('.$row[6].')" title="Scanner" data-toggle="modal" data-target="#modalScanner" data-whatever="@getbootstrap"><i class="fas fa-barcode"></i> </span>'. ' '.
                    '<span class= "btn btn-info" onclick= "obtenerDatosV('.$row[6].')" title="Ver" data-toggle="modal" data-target="#modalVer" data-whatever="@getbootstrap"><i class="fas fa-eye"></i> </span>'. ' '.
                    '<span class= "btn btn-warning" onclick= "obtenerDatos('.$row[6].')" title="Editar" data-toggle="modal" data-target="#modalEditar" data-whatever="@getbootstrap"><i class="fas fa-edit"></i> </span>'.' '.
                    '<span class= "btn btn-danger" onclick= "obtenerDatosE('.$row[6].')" title="Eliminar" data-toggle="modal" data-target="#modalEliminar" data-whatever="@getbootstrap"><i class="fas fa-trash-alt"></i> </span>';

        }else{
            return '<span class= "btn btn-info" onclick= "obtenerDatosV('.$row[6].')" title="Ver" data-toggle="modal" data-target="#modalVer" data-whatever="@getbootstrap"><i class="fas fa-eye"></i> </span>';
        }
    })
);
 
// SQL server connection information


include_once "../../../dbconexion/conexionServerSide.php";
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
 
require( '../../../includes/js/data_tables_js/ssp.class.php' );
 
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $var )
);
?>