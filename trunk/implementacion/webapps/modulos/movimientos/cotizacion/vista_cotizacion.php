<?php
include_once "../../superior.php";
include_once "../../../dbconexion/conexion.php";
include_once "modelo_cotizacion.php";
?>
    <head>
            <!-- <title>Grupos</title> -->
        <link rel="stylesheet" type="text/css" href="../../../includes/css/adminlte.min.css">
        <link rel="stylesheet" href="../../../includes/css/data_tables_css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="../../../includes/css/data_tables_css/buttons.dataTables.min.css">

        <link rel="stylesheet" type="text/css" href="../../../includes/datapicker/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="../../../includes/datapicker/jquery-ui.min.css">

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
        </style>
    </head>
<div ng-controller="vistaCotizacion">
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
              <h1><i class="fas fa-pen-square"></i> Cotizaci&oacute;n</h1>
              <!-- <p>Mayucsa / Mayamat</p> -->
            </div>
            <ul class="app-breadcrumb breadcrumb">
              <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
              <li class="breadcrumb-item"><a href="vista_cotizacion.php">Cotizaci&oacute;n</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="card card-info">
                        <div class="card-header">
                             <h3 class="card-title">CAPTURA DE COTIZACI&Oacute;N</h3>
                             <div class="card-tools">
                                 <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                     <i class="fas fa-minus"></i>
                                 </button>
                             </div>
                        </div>
                        <div class="card-body">
                            <div class="row form-group form-group-sm">
                                <div class="col-lg-12 d-lg-flex">
                                    <div style="width: 30%;" class="form-floating mx-1">
                                        <select class="form-control form-group-md" ng-model="proveedor" id="selectproveedor" name="selectproveedor">
                                            <option selected="selected" value="" disabled>[Seleccione una opción..]</option>
                                            <?php foreach (ModeloCot::ShowProveedores() as $value) { ?>
                                            <option value="<?=$value['cve_proveedor']?>"><?=$value['cve_alterna']?> <?=$value['nombre_proveedor']?></option>
                                            <?php } ?>
                                        </select>
                                        <label>Proveedor</label>
                                    </div>
                                    <div style="width: 30%;" class="form-floating mx-1">
                                        <input type="file" ng-model="subircotizacion" name="fileProductos" id="fileProductos" class="form-control"
                                            accept=".xls, .xlsx, .doc, .docx, .pdf" multiple="multiple">
                                        <label>Subir cotización</label>
                                    </div>
                                    <div style="width: 30%;" class="form-floating mx-1">
                                        <input class="date-picker form-control" min="2022-11-27" ng-model="fechaentrega" id="fechaentrega">
                                        <label>Fecha de entrega</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group form-group-sm">
                                <div class="col-lg-12 d-lg-flex">
                                    <div style="width: 30%;" class="form-floating mx-1">
                                        <select class="form-control form-group-md" ng-model="usocfdi" id="selectusocfdi" name="selectusocfdi">
                                            <option selected="selected" value="" disabled>[Seleccione una opción..]</option>
                                            <?php foreach (ModeloCot::ShowCFDI() as $value) { ?>
                                            <option value="<?=$value['cve_cfdi']?>"><?=$value['cve_cfdi']?> <?=$value['descripcion']?></option>
                                            <?php } ?>
                                        </select>
                                        <label>Uso de CFDI</label>
                                    </div>
                                    <div style="width: 30%;" class="form-floating mx-1">
                                        <select class="form-control form-group-md" ng-model="formapago" id="selectusocfdi" name="selectusocfdi">
                                            <option selected="selected" value="" disabled>[Seleccione una opción..]</option>
                                            <option value="Efectivo">Efectivo</option>
                                            <option value="Transferencia">Transferencia</option>
                                            <option value="Cheque">Cheque</option>
                                        </select>
                                        <label>Forma de pago</label>
                                    </div>
                                    <div style="width: 30%;" class="form-floating mx-1">
                                        <select class="form-control form-group-md" ng-model="metodopago" id="selectusocfdi" name="selectusocfdi">
                                            <option selected="selected" value="" disabled>[Seleccione una opción..]</option>
                                            <option value="PUE">PUE - Pago en una sola Exhibici&oacute;n</option>
                                            <option value="PPD">PPD - Pago diferido</option>
                                        </select>
                                        <label>M&eacute;todo de pago</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group form-group-sm border-top">
                                <div class="col-sm-12" align="center">
                                    <input type="submit" value="Generar Orden de Compra" href="#" ng-click="validacionCampos()"class="btn btn-primary" style="margin-bottom: -25px !important">
                                    <input type="submit" value="Limpiar" href="#" ng-click="limpiarCampos()" class="btn btn-warning" style="margin-bottom: -25px !important">
                                </div>
                            </div>
                        </div>
                    </div>

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">CRITERIOS DE BÚSQUEDA</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row" ng-show="false">
                        <div class="col-lg-12 d-lg-flex" style="display: flex; justify-content: flex-end">
                            <div style="width: 20%;" class="form-floating mx-1">
                                <input 
                                        type="text" 
                                        id="iptNombre"
                                        class="form-control"
                                        data-index="1">
                                <label for="iptNombre">Nombre</label>
                            </div>
                        </div>
                    </div>
                </div> <!-- ./ end card-body -->
            </div> <!-- ./ end card-info -->

            <div class="card card-info">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover w-100 shadow">
                            <thead>
                                <tr>
                                    <th class="text-center">Cod Req</th>
                                    <th class="text-center">Tipo</th>
                                    <th class="text-center">Autoriza</th>
                                    <th class="text-center">Cod Art</th>
                                    <th class="text-center">Nombre árticulo</th>
                                    <th class="text-center">Cantidad solicitada</th>
                                    <th class="text-center">Cantidad cotizada</th>
                                    <th class="text-center">Precio unitario</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Check</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="(i, obj) in arrayRequisiciones track by i">
                                    <td class="align-middle text-center">{{obj[0]}}</td>
                                    <td class="align-middle text-center">
                                        <span class= "badge badge-success" ng-show="obj[1] == 'N'">Normal</span>
                                        <span class= "badge badge-primary" ng-show="obj[1] == 'A'">Automatica</span>
                                    </td>
                                    <td class="text-center align-middle" nowrap="nowrap">{{obj[10]}} {{obj[11]}}</td>
                                    <td class="align-middle text-center">{{obj[3]}}</td>
                                    <td class="align-middle text-center">{{obj[4]}}</td>
                                    <td class="align-middle text-center">{{obj[5]|number:4}}</td>
                                    <td>
                                        <input type="text" class="form-control input_{{obj[1]}}" ng-model="obj[13]" ng-keyup="setCantidad(i)" ng-blur="setFixed(i)" ng-disabled="obj[15]">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control input_{{obj[1]}}" ng-model="obj[14]" ng-keyup="setPrecioU(i)" ng-disabled="obj[15]">
                                    </td>
                                    <td class="align-middle text-center">{{obj[8] | currency}}</td>
                                    <td class="align-middle text-center">
                                        <div class="div">
                                            <div class="col-md-4 offset-md-5 text-center">
                                                <input class="form-check-input check_{{obj[1]}}" type="checkbox" ng-model="obj[16]" ng-checked="obj[16]" ng-change="checkRequisicion(i)" ng-disabled="obj[15]">
                                            </div>
                                        </div>
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

        <?php include_once "../../footer.php" ?>
    </main>
</div>

    <script src="../../../includes/js/adminlte.min.js"></script>

    <script src="../../../includes/js/jquery351.min.js"></script>


<?php 
include_once "../../inferior.php";
// include_once "modales.php";
?>
    <script src="vista_cotizacion_ajs.js"></script>

    <script src="vista_cotizacion.js"></script>

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

    <script type="text/javascript" src="../../../includes/datapicker/jquery-ui.min.js"></script>

    <script type="text/javascript">
        consultar();
    </script>
    <script>
        const tomorrow = new Date()
        tomorrow.setDate(tomorrow.getDate() + 1)
        $('.date-picker').datepicker({
        closeText: 'Cerrar',
        prevText: '<Ant',
        nextText: 'Sig>',
        currentText: 'Hoy',
        monthNamesShort: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        minDate: tomorrow,
        // changeDay: true,
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'yy-mm-dd',
        showDays: false,
    });
    </script>