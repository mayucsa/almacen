<?php
include_once "../../superior.php";
include_once "../../../dbconexion/conexion.php";
?>
    <head>
            <!-- <title>Grupos</title> -->
        <link rel="stylesheet" type="text/css" href="../../../includes/css/adminlte.min.css">
        <link rel="stylesheet" href="../../../includes/css/data_tables_css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="../../../includes/css/data_tables_css/buttons.dataTables.min.css">
        <style type="text/css">
            body{
                background-color: #f7f6f6;
            }
            table thead{
                background-color: #1A4672;
                color:  white;
            }
            .input-group-addon {
                padding: 6px 12px;
                font-size: 14px;
                font-weight: 400;
                line-height: 1;
                color: #555;
                text-align: center;
                background-color: #eee;
                border: 1px solid #ccc;
                border-radius: 4px;
            }
            .box.box-success {
                border-top-color: #00a65a;
            }
            .box {
                position: relative;
                border-radius: 3px;
                background: #ffffff;
                border-top: 3px solid #d2d6de;
                margin-bottom: 20px;
                width: 100%;
                box-shadow: 0 1px 1px rgb(0 0 0 / 10%);
            }
            .col-lg-5 {
                width: 41.66666667%;
            }
            .box-header.with-border {
                border-bottom: 1px solid #f4f4f4;
            }
            .box-header {
                color: #444;
                display: block;
                padding: 10px;
                position: relative;
            }
            .fixedTable tbody{
                display: block;
                height:400px;
                overflow-y:auto;
            }
            .fixedTable thead, tbody, tr{
                display: table;
                width: 100%;
                table-layout: fixed;
            }
            .fixedTable thead{
                width: calc( 100% - 1em )
            }
        </style>
    </head>
<div ng-controller="vistaMisRequisiciones">

    <!-- MODAL DE CONFIRMACIÓN -->
    <div class="row" style="position: fixed; z-index: 9; background-color: white; width: 70%; margin-left: 20%;  border-radius: 15px; padding: 5vH; border: solid;" ng-show="modalMisRequ == true">
        <div class="col-lg-12 col-md-12" style="max-height: 50vH; overflow-y: auto;">
            <h3>Editar requisición</h3>
            <div class="row form-group form-group-sm">
                <div class="col-lg-12 d-lg-flex">
                    <div style="width: 50%;" class="form-floating mx-1">
                        <input type="text" ng-model="folio" id="inputfolio" name="inputfolio" class="form-control form-control-md validanumericos" disabled>
                        <label>Folio</label>
                    </div>
                    <div style="width: 50%;" class="form-floating mx-1">
                        <input type="text" ng-model="articulo" id="inputarticulo" name="inputarticulo" class="form-control form-control-md validanumericos">
                        <label>articulo</label>
                    </div>
                    <button class="btn btn-success btn-sm">Agregar</button>
                </div>
            </div>
                          <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover w-100 shadow" id="tablamisRequisDet">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Cve articulo</th>
                                                <th class="text-center">Articulo</th>
                                                <th class="text-center">Cantidad</th>
                                                <th class="text-center">Quitar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="(i, obj) in ssMiReqDet track by i">
                                                <td class="text-center">{{obj.cve_alterna}}</td>
                                                <td class="text-center">{{obj.nombre_articulo}}</td>
                                                <td class="text-center">
                                                    <input type="text" ng-model="obj.cantidad" class="form-control form-control-md validanumericos">
                                                </td>
                                                <td class="text-center">
                                                    <span class= "btn btn-danger btn-sm" title="Quitar"><i class="fas fa-trash-alt"></i> </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
        </div>
        <div class="col-lg-12 col-md-12 text-right">
            <button class="btn btn-primary" ng-click="editar()">Actualizar requisición</button>
            <button class="btn btn-danger" ng-click="setModalMisRequ()">Cerrar</button>
        </div>
    </div>

    <main class="app-content">
        <div class="app-title">
            <div>
              <h1><i class="fas fa-check"></i> Mis requisiciones</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
              <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
              <li class="breadcrumb-item"><a href="vista_misrequisiciones.php">Mis requisiciones</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile" id="captura_requ">
                    <div class="card card-info">
                        <div class="card-header">
                             <h3 class="card-title">Mis requisiciones</h3>
                             <div class="card-tools">
                                 <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                     <i class="fas fa-minus"></i>
                                 </button>
                             </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover w-100 shadow" id="tablamisRequis">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Folio req</th>
                                                <th class="text-center">Quien autoriza</th>
                                                <th class="text-center">Comentario General</th>
                                                <th class="text-center">Fecha</th>
                                                <th class="text-center">Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="(i, obj) in ssMisRequis track by i">
                                                <td class="text-center">{{obj.cve_req}}</td>
                                                <td class="text-center">{{obj.nombre}} {{obj.apellido}}</td>
                                                <td class="text-center">{{obj.comentarios}}</td>
                                                <td class="text-center">{{obj.fecha_registro}}</td>
                                                <td class="text-center">
                                                        <span ng-show="obj.estatus_req >= 1" class= "btn btn-info btn-sm" ng-click= "ver(obj.cve_req)" title="Ver requisicion" data-toggle="modal" data-target="#modalVer" data-whatever="@getbootstrap"><i class="fas fa-eye"></i> </span>
                                                        <span ng-show="obj.estatus_req == 1" class= "btn btn-warning btn-sm" ng-click="setModalMisRequ(obj.cve_req)" title="Editar"><i class="fas fa-edit"></i> </span>
                                                        <span ng-show="obj.estatus_req == 1" class= "btn btn-danger btn-sm" ng-click="cancelar(obj.cve_req)" title="Cancelar"><i class="fas fa-trash-alt"></i> </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <?php include_once "../../footer.php" ?>

    </main>
</div>

    <script src="../../../includes/js/adminlte.min.js"></script>

    <script src="../../../includes/js/jquery351.min.js"></script>


<?php 
include_once "../../inferior.php";
include_once "modales.php";
?>

    <!-- <script src="vista_requisicion_ajs.js"></script> -->

    <script src="vista_misrequisiciones_ajs.js"></script>

    <script src="../../../includes/js/jquery331.min.js"></script>

    <script src="../../../includes/js/sweetalert2.min.js"></script>

    <script src="../../../includes/bootstrap/js/bootstrap.js"></script>

    <script src="../../../includes/bootstrap/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="../../../includes/css/datatables.min.css"/>

    <script type="text/javascript" src="../../../includes/js/datatables.min.js"></script>
    <script src="../../../includes/js/data_tables_js/jquery.dataTables.min.js"></script>
    <script src="../../../includes/js/data_tables_js/dataTables.buttons.min.js"></script>
    <script src="../../../includes/js/data_tables_js/jszip.min.js"></script>
    <script src="../../../includes/js/data_tables_js/pdfmake.min.js"></script>
    <script src="../../../includes/js/data_tables_js/vfs_fonts.js"></script>
    <script src="../../../includes/js/data_tables_js/buttons.html5.min.js"></script>
    <script src="../../../includes/js/data_tables_js/buttons.print.min.js"></script>
    <script src="//cdn.datatables.net/plug-ins/1.13.1/dataRender/datetime.js"></script>
