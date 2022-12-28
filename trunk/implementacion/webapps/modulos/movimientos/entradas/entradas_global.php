<?php
include_once "../../superior.php";
include_once "../../../dbconexion/conexion.php";
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
    <div ng-controller="vistaEntradasGlobal">

        <!-- MODAL VER ENTRADAS -->
        <div id="modalVer" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel">Materia prima por Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <div class=" row form-group form-group-sm">
                    <div class="col-lg-12 d-lg-flex">
                      <div style="width: 25%;" class="form-floating mx-1">
                        <input type="text" class="form-control" id="inputname" name="inputname" disabled>
                        <label>Folio de entrada:</label>
                      </div>
                    </div>
                  </div>
                  <div class=" row form-group form-group-sm">
                    <div class="col-lg-12 d-lg-flex">
                      <div style="width: 25%;" class="form-floating mx-1">
                        <input type="text" class="form-control" id="tipo_documento" name="tipo_documento" disabled>
                        <label>Tipo de documento:</label>
                      </div>
                      <div style="width: 25%;" class="form-floating mx-1">
                        <input type="text" class="form-control" id="folio_documento" name="folio_documento" disabled>
                        <label>Folio de documento:</label>
                      </div>
                      <div style="width: 25%;" class="form-floating mx-1">
                        <input type="text" class="form-control" id="fecha_documento" name="fecha_documento" disabled>
                        <label>Fecha de documento:</label>
                      </div>
                  </div>
              </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover w-100 shadow" id="tablaModal">

                    </table>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
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
                                 <h3 class="card-title">ENTRADAS</h3>
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
                                                    <th>Folio</th>
                                                    <th>Realizado por:</th>
                                                    <th>Folio ODC</th>
                                                    <th>Folio Factura</th>
                                                    <th>Fecha</th>
                                                    <th>Opciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="(i,obj) in entradas track by i">
                                                    <td>{{obj[0]}}</td>
                                                    <td>{{obj[1]}}</td>
                                                    <td>{{obj[2]}}</td>
                                                    <td>{{obj[3]}}</td>
                                                    <td>{{obj[4]}}</td>
                                                    <td>
                                                        <button class="btn btn-info" title="Ver" ng-click= "Verentradas(obj[0])" data-toggle="modal" data-target="#modalVer" data-whatever="@getbootstrap">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                        <button class="btn btn-warning" title="Imprimir PDF" ng-click="startImprSelec(i, 'inicial_container')">
                                                            <i class="fas fa-file-pdf"></i>
                                                        </button>
                                                        <button class="btn btn-danger" title="Cancelar" ng-click="cancelar(i)">
                                                            <i class="fas fa-window-close"></i>
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
                                        {{datosImprimir.ENTRADA.cve_mov}}
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
                                        {{datosImprimir.ENTRADA.folio_documento}}
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
                                        {{datosImprimir.ENTRADA.fecha_documento}}
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
                                        {{datosImprimir.ENTRADA.nombre_proveedor}}
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
                                        {{datosImprimir.ENTRADA.cve_odc}}
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
                                        {{datosImprimir.ENTRADA.fecha_entrega}}
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
                        <th nowrap="nowrap" style="border: solid 1px; border-radius: 10px; font-size: 9px;">Descripción / sección</th>
                        <th style="border: solid 1px; border-radius: 10px; font-size: 9px;">Cantidad</th>
                        <th style="border: solid 1px; border-radius: 10px; font-size: 9px;">Unidad</th>
                        <th style="border: solid 1px; border-radius: 10px; font-size: 9px;">Importe</th>
                    </tr>
                    <tr ng-repeat="(i, obj) in datosImprimir.DETALLE track by i">
                        <td style="font-size: 9px; text-align: center;">{{obj.cve_req}}</td>
                        <td style="font-size: 9px; text-align: center;">{{obj.cve_art}}</td>
                        <td style="font-size: 9px;">{{obj.nombre_articulo}} / {{obj.seccion}}</td>
                        <td style="font-size: 9px; text-align: right;">{{obj.cantidad_entrada}}</td>
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
                                            {{datosImprimir.ENTRADA.creadoPor}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="position: absolute; width: 25%; margin-left: 75%;">
                        <div style="border-radius: 10px; border: solid 1px; padding: 20px; margin-top: 25px;">
                            <span style="font-size:10px;">
                                <strong>Total: {{datosImprimir.totalFact | currency}}</strong>
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
                                        {{datosImprimir.ENTRADA.cve_mov}}
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
                                        {{datosImprimir.ENTRADA.folio_documento}}
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
                                        {{datosImprimir.ENTRADA.fecha_documento}}
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
                                        {{datosImprimir.ENTRADA.nombre_proveedor}}
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
                                        {{datosImprimir.ENTRADA.cve_odc}}
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
                                        {{datosImprimir.ENTRADA.fecha_entrega}}
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
                        <th nowrap="nowrap" style="border: solid 1px; border-radius: 10px; font-size: 9px;">Descripción / sección</th>
                        <th style="border: solid 1px; border-radius: 10px; font-size: 9px;">Cantidad</th>
                        <th style="border: solid 1px; border-radius: 10px; font-size: 9px;">Unidad</th>
                        <th style="border: solid 1px; border-radius: 10px; font-size: 9px;">Importe</th>
                    </tr>
                    <tr ng-repeat="(i, obj) in datosImprimir.DETALLE track by i">
                        <td style="font-size: 9px; text-align: center;">{{obj.cve_req}}</td>
                        <td style="font-size: 9px; text-align: center;">{{obj.cve_art}}</td>
                        <td style="font-size: 9px;">{{obj.nombre_articulo}} / {{obj.seccion}}</td>
                        <td style="font-size: 9px; text-align: right;">{{obj.cantidad_entrada}}</td>
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
                                            {{datosImprimir.ENTRADA.creadoPor}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="position: absolute; width: 25%; margin-left: 75%;">
                        <div style="border-radius: 10px; border: solid 1px; padding: 20px; margin-top: 25px;">
                            <span style="font-size:10px;">
                                <strong>Total: {{datosImprimir.totalFact | currency}}</strong>
                            </span>
                        </div>
                    </div>
                </div>
                <br><br>

            </div>
        </div>
    </div>

    <script src="../../../includes/js/adminlte.min.js"></script>

    <script src="../../../includes/js/jquery351.min.js"></script>


<?php 
include_once "../../inferior.php";
// include_once "modales.php";
?>

    <script src="vista_entradas.js"></script>
    <!-- <script src="vista_entradas_ajs.js"></script> -->
    <script src="vistaEntradasGlobal.js"></script>

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

    <script type="text/javascript">
        consultar();
    </script>
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