<?php
include_once "../../superior.php";
include_once "../../../dbconexion/conexion.php";
$creadoPor = '';
foreach (unserialize($_SESSION['usuario']) as $key => $value) {
    if ($key == 'nombre_persona' || $key == 'apellido_persona') {
        $creadoPor .= $value. ' ';
    }
}
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
    <div ng-controller="vistaEntradas">
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
                  <h1><i class="fas fa-pen-square"></i> Entradas</h1>
                  <!-- <p>Mayucsa / Mayamat</p> -->
                </div>
                <ul class="app-breadcrumb breadcrumb">
                  <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                  <li class="breadcrumb-item"><a href="vista_entradas.php">Entradas</a></li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="tile" id="captura_entrada">
                        <div class="card card-info">
                            <div class="card-header">
                                 <h3 class="card-title">CAPTURA DE ENTRADA</h3>
                                 <div class="card-tools">
                                     <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                         <i class="fas fa-minus"></i>
                                     </button>
                                 </div>
                            </div>
                            <div class="card-body">
                                <div class="row form-group form-group-sm">
                                    <div class="col-lg-12 d-lg-flex">
                                         <div style="width: 25%;" class="form-floating mx-1">
                                            <input type="text" ng-model="folioodc" class="form-control form-control-md validanumericos" maxlength="500" ng-blur="validaFolio(folioodc)">
                                            <label>Folio de Orden de Compra</label>
                                        </div>
                                        <div style="width: 25%;" class="form-floating mx-1">
                                            <select class="form-control form-group-md" ng-model="tipo">
                                                <option selected="selected" value="" disabled>[Seleccione una opción..]</option>
                                                <option value="Factura">Factura</option>
                                                <option value="Remision">Remisi&oacute;n</option>
                                            </select>
                                            <label>Tipo de documento</label>
                                        </div>
                                        <div style="width: 25%;" class="form-floating mx-1">
                                            <input type="text" ng-model="foliofactura" class="form-control form-control-md UpperCase" maxlength="500">
                                            <label>Folio de Factura/Remisi&oacute;n</label>
                                        </div>
                                        <div style="width: 25%;" class="form-floating mx-1">
                                            <input class="date-picker form-control" ng-model="fechafactura" id="fechafactura">
                                            <label>Fecha de Factura/Remisi&oacute;n</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group form-group-sm border-top">
                                    <div class="col-sm-12" align="center">
                                        <input type="submit" value="Generar Entrada" href="#" ng-click="validacionCampos()"class="btn btn-primary" style="margin-bottom: -25px !important">
                                        <input type="submit" value="Limpiar" href="#" ng-click="limpiarCampos()" class="btn btn-warning" style="margin-bottom: -25px !important">
                                        <input type="submit" value="Ver entradas" onclick ="location.href='entradas_global.php'; " class="btn btn-info" style="margin-bottom: -25px !important">
                                        <!-- <input type="button" class="btn" value="imprimir" onclick="imprSelec('inicial_container')"> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="tile" id="captura_entrada">
                        <div class="card card-info">
                            <div class="card-header">
                                 <h3 class="card-title">ORDEN DE COMPRA</h3>
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
                                                    <th>Folio Req</th>
                                                    <th>Cve articulo</th>
                                                    <th>Nombre de articulo</th>
                                                    <th>Unidad medida</th>
                                                    <th>Cantidad original</th>
                                                    <th>Cantidad a recibir</th>
                                                    <th>Precio unidad</th>
                                                    <th>Precio total</th>
                                                    <th>Check</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="(i, obj) in ordenCompraDetalle track by i">
                                                    <td>{{obj.cve_odc}}</td>
                                                    <td>{{obj.cve_art}}</td>
                                                    <td>{{obj.nombre_articulo}}</td>
                                                    <td>{{obj.unidad_medida}}</td>
                                                    <td>{{obj.cantidad_cotizada}}</td>
                                                    <td>
                                                        <input type="text" id="nextFocus{{i}}" class="form-control text-right" ng-model="obj.cantidad" ng-keyup="$event.keyCode == 13 ? inputCharacters(i) : calculaTotal(i)">
                                                    </td>
                                                    <td>{{obj.precio_unidad | currency}}</td>
                                                    <td>{{obj.total}}</td>
                                                    <td>
                                                        <div class="div">
                                                            <div class="col-md-4 offset-md-5 text-center">
                                                                <input class="form-check-input" type="checkbox" ng-model="obj.chkd" ng-checked="obj.chkd" ng-change="checkEntrada(i)">
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
            </div>
            <div id="inicial_container" style="position: relative; height: 520px; display: none;">
                <div class="row" style="position: absolute; width: 48%;">
                    <table style="width: 49%;">
                        <header>
                            <tr>
                                <td nowrap="nowrap">
                                    <span style="font-size:10px;">
                                        <strong>FORMATO DE ENTRADAS - SAM</strong>
                                    </span>
                                    <br>
                                    <img src="../../../includees/imagenes/Mayucsa.png" style="width: 100%;">
                                </td>
                                <td nowrap="nowrap" style="padding-left: 2px;">
                                    <br><br>
                                    <span style="font-size:9px;">
                                        MATERIALES DE YUCATAN S.A DE CV<br>
                                        CARR. MERIDA-TIXKOKOB, KM. 10.5<br>
                                        YUCATAN<br><br>
                                        Tels: 9501057<br>
                                        RFC: MYU7407096Q9   
                                    </span>
                                </td>
                                <td nowrap="nowrap" style="padding-left: 2px;">
                                    <br>
                                    <span style="font-size:9px;">
                                        OFICINA:<br>
                                        CALLE 19 X 18 LOCAL 6<br>
                                        COL. MEXICO<br>
                                        TELS. 944-63-53 Y 944-63-77 FAX 944-63-69<br>
                                        MERIDA, YUC., CP 97128
                                    </span>
                                </td>
                            </tr>
                        </header>
                    </table>
                    <table>
                        <tr>
                            <th style="width: 20%;">
                                <div class="row" style="border-radius: 10px; border: solid 1px;">
                                    <div class="col-md-12 p-1" style="border-bottom: solid 1px;">
                                        <span style="font-size:9px;">FOLIO</span>
                                    </div>
                                    <div class="col-md-12 p-1" style="text-align: center; margin-top: 5px; margin-bottom: 5px;">
                                        <span style="font-size:9px;">
                                            {{folioEntrada}}
                                        </span>
                                    </div>
                                </div>
                            </th>
                            <th style="width: 20%;"></th>
                            <th style="width: 20%;">
                                <div class="row" style="border-radius: 10px; border: solid 1px;">
                                    <div class="col-md-12 p-2" style="border-bottom: solid 1px;">
                                        <span style="font-size:9px;">FOLIO DE LA FACTURA</span>
                                    </div>
                                    <div class="col-md-12 p-2" style="text-align: center; margin-top: 5px; margin-bottom: 5px;">
                                        <span style="font-size:9px;">
                                            {{foliofactura}}
                                        </span>
                                    </div>
                                </div>
                            </th>
                            <th style="width: 20%;">
                                <div class="row" style="border-radius: 10px; border: solid 1px;">
                                    <div class="col-md-12 p-2" style="border-bottom: solid 1px;">
                                        <span style="font-size:9px;">FECHA DE LA FACTURA</span>
                                    </div>
                                    <div class="col-md-12 p-2" style="text-align: center; margin-top: 5px; margin-bottom: 5px;">
                                        <span style="font-size:9px;">
                                            {{fechafactura}}
                                        </span>
                                    </div>
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th colspan="2" style="width: 20%;">
                                <div class="row" style="border-radius: 10px; border: solid 1px;">
                                    <div class="col-md-12 p-1" style="border-bottom: solid 1px;">
                                        <span style="font-size:9px;">PROVEEDOR</span>
                                    </div>
                                    <div class="col-md-12 p-1" style="text-align: center; margin-top: 5px; margin-bottom: 5px;">
                                        <span style="font-size:9px;">
                                            {{proveedor}}
                                        </span>
                                    </div>
                                </div>
                            </th>
                            <th style="width: 20%;">
                                <div class="row" style="border-radius: 10px; border: solid 1px;">
                                    <div class="col-md-12 p-2" style="border-bottom: solid 1px;">
                                        <span style="font-size:9px;">ORDEN DE COMPRA</span>
                                    </div>
                                    <div class="col-md-12 p-2" style="text-align: center; margin-top: 5px; margin-bottom: 5px;">
                                        <span style="font-size:9px;">
                                            {{cve_odc}}
                                        </span>
                                    </div>
                                </div>
                            </th>
                            <th style="width: 20%;">
                                <div class="row" style="border-radius: 10px; border: solid 1px;">
                                    <div class="col-md-12 p-2" style="border-bottom: solid 1px;">
                                        <span style="font-size:9px;">FECHA DE ENTREGA</span>
                                    </div>
                                    <div class="col-md-12 p-2" style="text-align: center; margin-top: 5px; margin-bottom: 5px;">
                                        <span style="font-size:9px;">
                                            <?=date('Y-m-d')?>
                                        </span>
                                    </div>
                                </div>
                            </th>
                        </tr>
                    </table>
                    <table style="width:100%">
                        <tr style="width:100%; border: solid 1px red; border-radius: 10px;">
                            <th style="border: solid 1px; border-radius: 10px; font-size: 9px;" nowrap="nowrap">Req. N°.</th>
                            <th style="border: solid 1px; border-radius: 10px; font-size: 9px;" nowrap="nowrap">Clave Art</th>
                            <th style="border: solid 1px; border-radius: 10px; font-size: 9px;">Descripción / sección</th>
                            <th style="border: solid 1px; border-radius: 10px; font-size: 9px;">Cantidad</th>
                            <th style="border: solid 1px; border-radius: 10px; font-size: 9px;">Unidad</th>
                            <th style="border: solid 1px; border-radius: 10px; font-size: 9px;">Importe</th>
                        </tr>
                        <tr ng-repeat="(i, obj) in ordenCompraDetalle track by i">
                            <td style="font-size: 9px; text-align: center;">{{obj.cve_req}}</td>
                            <td style="font-size: 9px; text-align: center;">{{obj.cve_art}}</td>
                            <td style="font-size: 9px;">{{obj.nombre_articulo}} / {{obj.seccion}}</td>
                            <td style="font-size: 9px; text-align: right;">{{obj.cantidad}}</td>
                            <td style="font-size: 9px; text-align: right;">{{obj.unidad_medida}}</td>
                            <td style="font-size: 9px; text-align: right;">{{obj.total | currency}}</td>
                        </tr>
                    </table>
                </div>
                <div style="margin-top: 650px; position: fixed; width: 45%; margin-left: 1%;">
                    <div style="position: relative; width: 100%">
                        <div style="position: absolute; width: 70%; margin-left: 2%;">
                            <div style="position:relative;">
                                <div style="position: absolute; width: 50%;">
                                    <div class="row" style="border-top-left-radius: 10px; border-bottom-left-radius: 10px; border-top: solid 1px; border-bottom: solid 1px; border-left: solid 1px;">
                                        <div class="col-md-12 p-1" style="border-bottom: solid 1px;">
                                            <span style="font-size:9px; padding: 10px;">Entregado por:</span>
                                        </div>
                                        <div class="col-md-12 p-1" style="text-align: center; margin-top: 5px; margin-bottom: 5px; border-bottom: solid 1px;">
                                            <br>
                                            <br>
                                            <br>
                                        </div>
                                        <div class="col-md-12 p-1" style="text-align: center; margin-top: 5px; margin-bottom: 5px;">
                                            <span style="font-size:9px;">
                                                &nbsp;
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div style="position: absolute; width: 50%; margin-left: 50%;">
                                    <div class="row" style="border-top-right-radius: 10px; border-bottom-right-radius: 10px; border: solid 1px;">
                                        <div class="col-md-12 p-1" style="border-bottom: solid 1px;">
                                            <span style="font-size:9px; padding: 10px;">Recibido por:</span>
                                        </div>
                                        <div class="col-md-12 p-1" style="text-align: center; margin-top: 5px; margin-bottom: 5px; border-bottom: solid 1px;">
                                            <br>
                                            <br>
                                            <br>
                                        </div>
                                        <div class="col-md-12 p-1" style="text-align: center; margin-top: 5px; margin-bottom: 5px;">
                                            <span style="font-size:9px;">
                                                <?=$creadoPor?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="position: absolute; width: 25%; margin-left: 75%;">
                            <div style="border-radius: 10px; border: solid 1px; padding: 20px; margin-top: 25px;">
                                <span style="font-size:10px;">
                                    <strong>Total: {{totalFact | number:4}}</strong>
                                </span>
                            </div>
                        </div>
                    </div>
                    <br><br>
                </div>
                <div class="row" style="position: absolute; width: 48%; margin-left: 51%;">
                    <table style="width: 49%;">
                        <header>
                            <tr>
                                <td nowrap="nowrap">
                                    <span style="font-size:10px;">
                                        <strong>FORMATO DE ENTRADAS - SAM</strong>
                                    </span>
                                    <br>
                                    <img src="../../../includees/imagenes/Mayucsa.png" style="width: 100%;">
                                </td>
                                <td nowrap="nowrap" style="padding-left: 2px;">
                                    <br><br>
                                    <span style="font-size:9px;">
                                        MATERIALES DE YUCATAN S.A DE CV<br>
                                        CARR. MERIDA-TIXKOKOB, KM. 10.5<br>
                                        YUCATAN<br><br>
                                        Tels: 9501057<br>
                                        RFC: MYU7407096Q9   
                                    </span>
                                </td>
                                <td nowrap="nowrap" style="padding-left: 2px;">
                                    <br>
                                    <span style="font-size:9px;">
                                        OFICINA:<br>
                                        CALLE 19 X 18 LOCAL 6<br>
                                        COL. MEXICO<br>
                                        TELS. 944-63-53 Y 944-63-77 FAX 944-63-69<br>
                                        MERIDA, YUC., CP 97128
                                    </span>
                                </td>
                            </tr>
                        </header>
                    </table>
                    <table>
                        <tr>
                            <th style="width: 20%;">
                                <div class="row" style="border-radius: 10px; border: solid 1px;">
                                    <div class="col-md-12 p-1" style="border-bottom: solid 1px;">
                                        <span style="font-size:9px;">FOLIO</span>
                                    </div>
                                    <div class="col-md-12 p-1" style="text-align: center; margin-top: 5px; margin-bottom: 5px;">
                                        <span style="font-size:9px;">
                                            {{folioEntrada}}
                                        </span>
                                    </div>
                                </div>
                            </th>
                            <th style="width: 20%;"></th>
                            <th style="width: 20%;">
                                <div class="row" style="border-radius: 10px; border: solid 1px;">
                                    <div class="col-md-12 p-2" style="border-bottom: solid 1px;">
                                        <span style="font-size:9px;">FOLIO DE LA FACTURA</span>
                                    </div>
                                    <div class="col-md-12 p-2" style="text-align: center; margin-top: 5px; margin-bottom: 5px;">
                                        <span style="font-size:9px;">
                                            {{foliofactura}}
                                        </span>
                                    </div>
                                </div>
                            </th>
                            <th style="width: 20%;">
                                <div class="row" style="border-radius: 10px; border: solid 1px;">
                                    <div class="col-md-12 p-2" style="border-bottom: solid 1px;">
                                        <span style="font-size:9px;">FECHA DE LA FACTURA</span>
                                    </div>
                                    <div class="col-md-12 p-2" style="text-align: center; margin-top: 5px; margin-bottom: 5px;">
                                        <span style="font-size:9px;">
                                            {{fechafactura}}
                                        </span>
                                    </div>
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th colspan="2" style="width: 20%;">
                                <div class="row" style="border-radius: 10px; border: solid 1px;">
                                    <div class="col-md-12 p-1" style="border-bottom: solid 1px;">
                                        <span style="font-size:9px;">PROVEEDOR</span>
                                    </div>
                                    <div class="col-md-12 p-1" style="text-align: center; margin-top: 5px; margin-bottom: 5px;">
                                        <span style="font-size:9px;">
                                            {{proveedor}}
                                        </span>
                                    </div>
                                </div>
                            </th>
                            <th style="width: 20%;">
                                <div class="row" style="border-radius: 10px; border: solid 1px;">
                                    <div class="col-md-12 p-2" style="border-bottom: solid 1px;">
                                        <span style="font-size:9px;">ORDEN DE COMPRA</span>
                                    </div>
                                    <div class="col-md-12 p-2" style="text-align: center; margin-top: 5px; margin-bottom: 5px;">
                                        <span style="font-size:9px;">
                                            {{cve_odc}}
                                        </span>
                                    </div>
                                </div>
                            </th>
                            <th style="width: 20%;">
                                <div class="row" style="border-radius: 10px; border: solid 1px;">
                                    <div class="col-md-12 p-2" style="border-bottom: solid 1px;">
                                        <span style="font-size:9px;">FECHA DE ENTREGA</span>
                                    </div>
                                    <div class="col-md-12 p-2" style="text-align: center; margin-top: 5px; margin-bottom: 5px;">
                                        <span style="font-size:9px;">
                                            <?=date('Y-m-d')?>
                                        </span>
                                    </div>
                                </div>
                            </th>
                        </tr>
                    </table>
                    <table style="width:100%">
                        <tr style="width:100%; border: solid 1px red; border-radius: 10px;">
                            <th style="border: solid 1px; border-radius: 10px; font-size: 9px;" nowrap="nowrap">Req. N°.</th>
                            <th style="border: solid 1px; border-radius: 10px; font-size: 9px;" nowrap="nowrap">Clave Art</th>
                            <th style="border: solid 1px; border-radius: 10px; font-size: 9px;">Descripción / sección</th>
                            <th style="border: solid 1px; border-radius: 10px; font-size: 9px;">Cantidad</th>
                            <th style="border: solid 1px; border-radius: 10px; font-size: 9px;">Unidad</th>
                            <th style="border: solid 1px; border-radius: 10px; font-size: 9px;">Importe</th>
                        </tr>
                        <tr ng-repeat="(i, obj) in ordenCompraDetalle track by i">
                            <td style="font-size: 9px; text-align: center;">{{obj.cve_req}}</td>
                            <td style="font-size: 9px; text-align: center;">{{obj.cve_art}}</td>
                            <td style="font-size: 9px;">{{obj.nombre_articulo}} / {{obj.seccion}}</td>
                            <td style="font-size: 9px; text-align: right;">{{obj.cantidad}}</td>
                            <td style="font-size: 9px; text-align: right;">{{obj.unidad_medida}}</td>
                            <td style="font-size: 9px; text-align: right;">{{obj.total | currency}}</td>
                        </tr>
                    </table>
                </div>
                <div style="margin-top: 650px; position: fixed; width: 45%; margin-left: 52%;">
                    <div style="position: relative; width: 100%">
                        <div style="position: absolute; width: 70%; margin-left: 2%;">
                            <div style="position:relative;">
                                <div style="position: absolute; width: 50%;">
                                    <div class="row" style="border-top-left-radius: 10px; border-bottom-left-radius: 10px; border-top: solid 1px; border-bottom: solid 1px; border-left: solid 1px;">
                                        <div class="col-md-12 p-1" style="border-bottom: solid 1px;">
                                            <span style="font-size:9px; padding: 10px;">Entregado por:</span>
                                        </div>
                                        <div class="col-md-12 p-1" style="text-align: center; margin-top: 5px; margin-bottom: 5px; border-bottom: solid 1px;">
                                            <br>
                                            <br>
                                            <br>
                                        </div>
                                        <div class="col-md-12 p-1" style="text-align: center; margin-top: 5px; margin-bottom: 5px;">
                                            <span style="font-size:9px;">
                                                &nbsp;
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div style="position: absolute; width: 50%; margin-left: 50%;">
                                    <div class="row" style="border-top-right-radius: 10px; border-bottom-right-radius: 10px; border: solid 1px;">
                                        <div class="col-md-12 p-1" style="border-bottom: solid 1px;">
                                            <span style="font-size:9px; padding: 10px;">Recibido por:</span>
                                        </div>
                                        <div class="col-md-12 p-1" style="text-align: center; margin-top: 5px; margin-bottom: 5px; border-bottom: solid 1px;">
                                            <br>
                                            <br>
                                            <br>
                                        </div>
                                        <div class="col-md-12 p-1" style="text-align: center; margin-top: 5px; margin-bottom: 5px;">
                                            <span style="font-size:9px;">
                                                <?=$creadoPor?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="position: absolute; width: 25%; margin-left: 75%;">
                            <div style="border-radius: 10px; border: solid 1px; padding: 20px; margin-top: 25px;">
                                <span style="font-size:10px;">
                                    <strong>Total: {{totalFact | number:4}}</strong>
                                </span>
                            </div>
                        </div>
                    </div>
                    <br><br>
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

    <script src="vista_entradas_ajs.js"></script>

    <!-- <script src="vista_requisicion.js"></script> -->

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

<!--     <script type="text/javascript">
        consultar();
    </script> -->
    <script>
        const yesterday = new Date()
        yesterday.setDate(yesterday.getDate() - 1)
        $('.date-picker').datepicker({
        closeText: 'Cerrar',
        prevText: '<Ant',
        nextText: 'Sig>',
        currentText: 'Hoy',
        monthNamesShort: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        // changeDay: true,
        maxDate: yesterday,
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'yy-mm-dd',
        showDays: false,
    });
    </script>