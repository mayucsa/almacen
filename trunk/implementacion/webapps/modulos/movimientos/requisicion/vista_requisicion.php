<?php
include_once "../../superior.php";
include_once "../../../dbconexion/conexion.php";
include_once "modelo_requisicion.php";
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
    <div ng-controller="vistaRequisicion">
       <!-- MODAL DE MENSAJES -->
        <div class="modal fade" id="modalMensajes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="padding-top:10%; overflow-y:visible;" >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header modal-danger">
                        <h5 class="modal-title" id="encabezadoModal"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="cuerpoModal"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>

        <main class="app-content">
            <div class="app-title">
                <div>
                  <h1><i class="fas fa-pen-square"></i> Requisici&oacute;n</h1>
                  <!-- <p>Mayucsa / Mayamat</p> -->
                </div>
                <ul class="app-breadcrumb breadcrumb">
                  <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                  <li class="breadcrumb-item"><a href="vista_requisicion.php">Requisici&oacute;n</a></li>
                </ul>
            </div>
            <div class="row" style="position: fixed; z-index: 9; background-color: white; width: 70%; margin-left: 5%;  border-radius: 15px; padding: 5vH; border: solid;" ng-show="modalMisRequ == true">
                <div class="col-lg-12 col-md-12" style="max-height: 50vH; overflow-y: auto;">
                    <h3>Mis requisiciones</h3>
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Cantidad</th>
                                <!-- <th>Máquina</th> -->
                                <th>fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="(i, obj) in misRequisitos track by i">
                                <td>{{obj.cve_req}}</td>
                                <td>{{obj.cve_alterna}}</td>
                                <td>{{obj.nombre_articulo}}</td>
                                <td>{{obj.cantidad}}</td>
                                <!-- <td>{{obj.nombre_maq}}</td> -->
                                <td>{{obj.fecha_registro}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-12 col-md-12 text-right">
                    <button class="btn btn-danger" ng-click="setModalMisRequ()">Cerrar</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="tile" id="captura_requ">
                        <div class="card card-info">
                            <div class="card-header">
                                 <h3 class="card-title">CAPTURA DE REQUISICI&Oacute;N</h3>
                                 <div class="card-tools">
                                     <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                         <i class="fas fa-minus"></i>
                                     </button>
                                 </div>
                            </div>
                            <div class="card-body">
                                <div class="row form-group form-group-sm" ng-show="false">
                                    <div class="col-lg-12 d-lg-flex">
                                        <span id="spanusuario" name="spanusuario" class="form-control form-control-sm" style="background-color: #E9ECEF;"><?= $id?></span>
                                        <span id="spanusuario" name="spanusuario" class="form-control form-control-sm" style="background-color: #E9ECEF;"><?= $nombre." ".$apellido?></span>
                                    </div>
                                </div>
                                <div class="row form-group form-group-sm" ng-show="false">
                                    <div class="col-lg-12 d-lg-flex">
                                         <div style="width: 100%;" class="form-floating mx-1">
                                            <input type="text" id="inputdescripcion" name="inputdescripcion" class="form-control form-control-md" disabled>
                                            <label>Código de requisici&oacute;n</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group form-group-sm">
                                    <div class="col-lg-12 d-lg-flex">
                                        <div style="width: 100%;" class="form-floating mx-1">
                                            <select class="form-control form-group-md" ng-model="autoriza" id="selectcategoria" name="selectcategoria">
                                                <option selected="selected" value="" disabled>[Seleccione una opción..]</option>
                                                <?php foreach (ModeloReq::showUserAutoriza() as $value) { ?>
                                                <option value="<?=$value['cve_usuario']?>"><?=$value['nombre']?> <?=$value['apellido']?></option>
                                                <?php } ?>
                                            </select>
                                            <label>Quien Autoriza</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group form-group-sm">
                                    <div class="col-lg-12 d-lg-flex">
                                         <div style="width: 100%;" class="form-floating mx-1">
                                            <input type="text" id="inputdescripcion" name="inputdescripcion" ng-model="comentario" class="form-control form-control-md UpperCase" maxlength="500">
                                            <label>Comentario general</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group form-group-sm">
                                    <div class="col-lg-12 d-lg-flex">
                                         <div style="width: 100%;" class="form-floating mx-1">
                                            <select class="form-control form-group-md" ng-model="depto" id="selectdepto" name="selectdepto" disabled>
                                                <option selected="selected" value="" disabled>[Seleccione una opción..]</option>
                                                <?php foreach (ModeloReq::showDepto() as $value) { ?>
                                                <option value="<?=$value['cve_depto']?>"><?=$value['cve_alterna']?> - <?=$value['nombre_depto']?></option>
                                                <?php } ?>
                                            </select>
                                            <label>Departamento</label>
                                        </div>
                                        <div style="width: 100%;" class="form-floating mx-1">
                                            <select class="form-control form-group-md" ng-model="cc" id="selectcc" name="selectcc" disabled>
                                                <option selected="selected" value="" disabled>[Seleccione una opción..]</option>
                                                <?php foreach (ModeloReq::showCC() as $value) { ?>
                                                <option value="<?=$value['cve_ncc']?>"><?=$value['cve_alterna']?> - <?=$value['nombre']?></option>
                                                <?php } ?>
                                            </select>
                                            <label>Centro de costo</label>
                                        </div>
                                        <div style="width: 100%;" class="form-floating mx-1">
                                            <select class="form-control form-group-md" ng-model="tgasto" id="selecttgasto" name="selecttgasto" disabled>
                                                <option selected="selected" value="" disabled>[Seleccione una opción..]</option>
                                                <?php foreach (ModeloReq::showTgasto() as $value) { ?>
                                                <option value="<?=$value['cve_area']?>"><?=$value['cve_alterna']?> - <?=$value['abreviacion']?> - <?=$value['nombre_area']?></option>
                                                <?php } ?>
                                            </select>
                                            <label>Tipo de gasto</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group form-group-sm border-top">
                                    <div class="col-sm-12" align="center">
                                        <input type="submit" value="Guardar" href="#" ng-click="validacionCampos()" class="btn btn-primary" style="margin-bottom: -25px !important">
                                        <input type="submit" value="Limpiar" href="#" ng-click="limpiarCampos()" class="btn btn-warning" style="margin-bottom: -25px !important">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Productos -->
                </div>
                <div class="col-md-6">
                    <div class="tile" id="articulos">
                        <div class="card card-info">
                            <div class="card-header">
                                 <h3 class="card-title">ART&Iacute;CULOS</h3>
                                 <div class="card-tools">
                                     <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                         <i class="fas fa-minus"></i>
                                     </button>
                                 </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <button class="btn btn-info btn-sm mt-1" onclick ="location.href='../misrequisiciones/vista_misrequisiciones.php'; ">
                                            Mis requisiciones
                                            <!-- <i class="fa fa-eye"></i> -->
                                        </button>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" id="iptCodigo" class="form-control" ng-model="cve_alterna" ng-change="getArticulos()" placeholder=" Código">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" id="iptNombre" class="form-control"
                                                ng-model="nombre_articulo" ng-change="getArticulos()" placeholder="Nombre">
                                    </div>
                                </div>
                            </div>
                        <div class="">
                            <div class="">
                                <div class="table-responsive fixedTable">
                                    <!-- <table class="table table-striped table-bordered table-hover w-100 shadow" id="tablaArticulos"> -->
                                    <table class="table table-striped table-bordered table-hover w-100 shadow">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Código</th>
                                                <th class="text-center">Nombre</th>
                                                <th class="text-center">Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbodyArticulos">
                                            <tr ng-repeat="(i,obj) in arrayProductos track by i">
                                                <td>{{obj.cve_alterna}}</td>
                                                <td>{{obj.nombre_articulo}}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-success btn-sm" ng-click="agregarProducto(i)">Agregar</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div> <!-- ./ end card-body -->
                        </div> <!-- ./ end card-info -->

                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="tile" ng-show="productosAgregados.length > 0">
                        <div class="card card-info">
                            <div class="card-header">
                                 <h3 class="card-title">PRODUCTOS</h3>
                                 <div class="card-tools">
                                     <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                         <i class="fas fa-minus"></i>
                                     </button>
                                 </div>
                            </div>
                            <div class="card-body">
                                <div class="row form-group form-group-sm">
                                    <div class="col-lg-12 d-lg-flex ">
                                        <table class="table table-striped table-bordered table-hover table-responsive">
                                            <thead>
                                                <tr>
                                                    <th>Código</th>
                                                    <th>Nombre</th>
                                                    <th>Cantidad</th>
                                                    <th>Unidad de medida</th>
                                                    <th>Comentario</th>
                                                    <th>Opciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="(i,obj) in productosAgregados track by i">
                                                    <td>{{obj.cve_alterna}}</td>
                                                    <td>{{obj.nombre_articulo}}</td>
                                                    <td>
                                                        <input type="number" ng-model="obj.cantidad" class="form-control text-right">
                                                    </td>
                                                    <td>{{obj.unidad_medida}}</td>
                                                    <td>
                                                        <!-- <select class="form-control" ng-model="obj.cve_maquina">
                                                            <option value="" disabled>Seleccione</option>
                                                            <option ng-repeat="obj in arrayMaquinas" value="{{obj.cve_maq}}">{{obj.nombre_maq}}</option>
                                                        </select> -->
                                                        <textarea ng-model="obj.comentario" maxlength="500" class="form-control"></textarea>
                                                    </td>
                                                    <td nowrap="nowrap" class="text-center">
                                                        <button class="btn btn-danger" ng-click="eliminarProductoAgregado(i)">
                                                            Eliminar 
                                                            <i class="fa fa-trash"></i>
                                                        </button>
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
// include_once "modales.php";
?>

    <script src="vista_requisicion_ajs.js"></script>

    <script src="vista_requisicion.js"></script>

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

    <script type="text/javascript">
        consultar();
    </script>