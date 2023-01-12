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
    <div ng-controller="vistaSalidasGlobal">

        <!-- MODAL VER ENTRADAS -->
        <div id="modalDevoluciones" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel">Devoluciones</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <div class=" row form-group form-group-sm">
                    <div class="col-lg-12 d-lg-flex">
                      <div style="width: 25%;" class="form-floating mx-1">
                        <input type="text" class="form-control" id="inputnamed" name="inputnamed" disabled>
                        <label>Folio de salida:</label>
                      </div>
                    </div>
                  </div>
                  <div class=" row form-group form-group-sm">
                    <div class="col-lg-12 d-lg-flex">
                      <div style="width: 25%;" class="form-floating mx-1">
                        <input type="text" class="form-control" id="folio_valed" name="folio_valed" disabled>
                        <label>Folio vale:</label>
                      </div>
                      <div style="width: 25%;" class="form-floating mx-1">
                        <input type="text" class="form-control" id="conceptod" name="conceptod" disabled>
                        <label>Concepto:</label>
                      </div>
                      <div style="width: 25%;" class="form-floating mx-1">
                        <input type="text" class="form-control" id="deptod" name="deptod" disabled>
                        <label>Departamento:</label>
                      </div>
                      <div style="width: 25%;" class="form-floating mx-1">
                        <input type="text" class="form-control" id="maquinad" name="maquinad" disabled>
                        <label>M&aacute;quina:</label>
                      </div>
                  </div>
              </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover w-100 shadow" id="">
                        <thead>
                            <tr>
                                <th class="text-center">Cve articulo</th>
                                <th class="text-center">Descripcion</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-center">Unidad medida</th>
                                <th class="text-center">Centro de costo</th>
                                <th class="text-center">Cantidad a devolver</th>
                                <th class="text-center">Comentario</th>
                                <th class="text-center">Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="(i, obj) in tBodyModalDev track by i">
                                <td class="text-center">{{obj.cve_articulo}}</td>
                                <td class="text-center">{{obj.nombre_articulo}}</td>
                                <td class="text-center">{{obj.cantidad_salida}}</td>
                                <td class="text-center">{{obj.unidad_medida}}</td>
                                <td class="text-center">{{obj.cve_cc}}</td>
                                <td class="text-center">
                                    <input type="text" ng-model="obj.cantidadDevolver" class="form-control form-control-md validanumericos" ng-keyup="validaCantidadDevolucion(i)">
                                </td>
                                <td class="text-center">
                                    <input type="text" ng-model="obj.comentario" maxlength="250" class="form-control form-control-md UpperCase">
                                </td>
                                <td class="text-center">
                                    <button type="button" ng-click="validaDevolucion(i)" class="btn btn-info">Devolver</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>
        <!-- MODAL VER ENTRADAS -->
        <div id="modalVer" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel">Cancelación de Salidas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <div class=" row form-group form-group-sm">
                    <div class="col-lg-12 d-lg-flex">
                      <div style="width: 25%;" class="form-floating mx-1">
                        <input type="text" class="form-control" id="inputname" name="inputname" disabled>
                        <label>Folio de salida:</label>
                      </div>
                    </div>
                  </div>
                  <div class=" row form-group form-group-sm">
                    <div class="col-lg-12 d-lg-flex">
                      <div style="width: 25%;" class="form-floating mx-1">
                        <input type="text" class="form-control" id="folio_vale" name="folio_vale" disabled>
                        <label>Folio vale:</label>
                      </div>
                      <div style="width: 25%;" class="form-floating mx-1">
                        <input type="text" class="form-control" id="concepto" name="concepto" disabled>
                        <label>Concepto:</label>
                      </div>
                      <div style="width: 25%;" class="form-floating mx-1">
                        <input type="text" class="form-control" id="depto" name="depto" disabled>
                        <label>Departamento:</label>
                      </div>
                      <div style="width: 25%;" class="form-floating mx-1">
                        <input type="text" class="form-control" id="maquina" name="maquina" disabled>
                        <label>M&aacute;quina:</label>
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
                  <h1><i class="fas fa-pen-square"></i> Salidas</h1>
                  <!-- <p>Mayucsa / Mayamat</p> -->
                </div>
                <ul class="app-breadcrumb breadcrumb">
                  <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                  <li class="breadcrumb-item"><a href="salidas_global.php">salidas</a></li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="tile" id="captura_entrada">
                        <div class="card card-info">
                            <div class="card-header">
                                 <h3 class="card-title">SALIDAS GLOBALES</h3>
                                 <div class="card-tools">
                                     <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                         <i class="fas fa-minus"></i>
                                     </button>
                                 </div>
                            </div>
                            <div class="card-body">
                                <div class="row form-group form-group-sm">
                                    <div class="col-lg-12 d-lg-flex ">
                                        <table class="table table-striped table-bordered table-hover table-responsive" id="tableSalidasGlobales">
                                            <thead>
                                                <tr>
                                                    <th>Folio</th>
                                                    <th>Realizado por:</th>
                                                    <th>Folio vale</th>
                                                    <th>Departamento</th>
                                                    <th>Maquina</th>
                                                    <th>Fecha</th>
                                                    <th>Opciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="(i,obj) in salidas track by i">
                                                    <td class="text-center">{{obj[0]}}</td>
                                                    <td class="text-center">{{obj[1]}}</td>
                                                    <td class="text-center">{{obj[2]}}</td>
                                                    <td class="text-center">{{obj[3]}}</td>
                                                    <td class="text-center">{{obj[4]}}</td>
                                                    <td class="text-center">{{obj[5]}}</td>
                                                    <td class="text-center" nowrap="nowrap">
                                                        <button class="btn btn-info btn-sm" title="Ver" ng-click= "Versalidas(obj[0])" data-toggle="modal" data-target="#modalVer" data-whatever="@getbootstrap">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                        <button class="btn btn-warning btn-sm" title="Imprimir PDF" ng-click="startImprSelec(i, 'paraImprimir')">
                                                            <i class="fas fa-file-pdf"></i>
                                                        </button>
                                                        <button class="btn btn-info btn-sm" ng-show="perfilUsu.salidas_edit == 1" title="Devoluciones" ng-click= "Verdevoluciones(obj[0])" data-toggle="modal" data-target="#modalDevoluciones" data-whatever="@getbootstrap">
                                                            <i class="fas fa-undo-alt"></i>
                                                        </button>
                                                        <button class="btn btn-danger btn-sm" ng-show="perfilUsu.salidas_edit == 1" title="Cancelar" ng-click="cancelar(i)">
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
            <div class="container-fluid" id="paraImprimir" style="display: none;">
                <div class="row p-2" style="width:100%;">
                    <div class="col-md-12">
                        <center>
                            <h4>FORMATO DE SALIDA - SAM</h4>
                        </center>
                    </div>
                    <div class="col-md-12 mb-4">
                        <center>
                            <img src="../../../includees/imagenes/Mayucsa.png" style="width: 80%;">
                        </center>
                    </div>
                    <div style="height: 110px;">
                      <div style="position:relative;">
                            <div class="" style="position: absolute; width: 33%;">
                                <div class="row" style="border-radius: 10px; border: solid;">
                                    <div class="col-md-12 p-1" style="border-bottom: solid;">
                                        <h3>FOLIO</h3>
                                    </div>
                                    <div class="col-md-12 p-1" style="text-align: center; margin-top: 5px; margin-bottom: 5px;">
                                        {{datosImprimir.SALIDA.cve_mov}}
                                    </div>
                                </div>
                            </div>
                            <div class="" style="position: absolute; margin-left: 35%; width: 65%;">
                                <div class="row" style="border-radius: 10px; border: solid;">
                                    <div class="col-md-12 p-2" style="border-bottom: solid;">
                                        <h3>FECHA</h3>
                                    </div>
                                    <div class="col-md-12 p-2" style="text-align: center; margin-top: 5px; margin-bottom: 5px;">
                                        {{datosImprimir.SALIDA.fecha_registro}}
                                    </div>
                                </div>
                            </div>
                      </div>
                    </div>

                    <div class="col-md-12 mt-2">
                        <div class="row" style="border-radius: 10px; border: solid;">
                            <div class="col-md-12 p-2">
                                <h3>MAQUINA</h3>
                            </div>
                            <div class="col-md-12 p-2" style="text-align: center; margin-top: 5px; margin-bottom: 5px;">
                                {{datosImprimir.SALIDA.nombre_maq}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-2" style=" margin-top: 10px;">
                        <div class="row" style="border-radius: 10px; border: solid;">
                            <div class="col-md-12 p-2">
                                <h3>REALIZADO POR</h3>
                            </div>
                            <div class="col-md-12 p-2" style="text-align: center; margin-top: 5px; margin-bottom: 5px;">
                                {{datosImprimir.SALIDA.creadoPor}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-2" style="border-radius: 10px; border: solid; margin-top: 10px; padding: 3px;">
                        <table class="table table-striped" style="width:100%">
                            <tr>
                                <th style="text-align: left;">Clave Art.</th>
                                <th>Descripción</th>
                                <th>Cantidad</th>
                                <th>Unidad</th>
                            </tr>
                            <tr ng-repeat="(key, obj) in datosImprimir.DETALLE track by key">
                                <td style="text-align: center;">{{obj.cve_alterna}}</td>
                                <td>{{obj.nombre_articulo}}</td>
                                <td style="text-align: right;">{{obj.cantidad_salida | number:4}}</td>
                                <td style="text-align: center;">{{obj.unidad_medida}}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-12 mt-2" style="border-radius: 10px; border: solid; margin-top: 10px;">
                        <div class="row ">
                            <div class="col-md-12 p-2 mb-4" style="border-bottom:solid; margin-top: 5px; margin-bottom: 5px;">
                                Firma:
                            </div>
                            <div class="col-md-12 mt-4 pb-4 pt-4" style="border-bottom:solid; margin-top: 35px; padding-bottom: 35px;">
                                
                            </div>
                            <div class="col-md-12 p-2" style="text-align: center; margin-top: 5px; margin-bottom: 5px;">
                                {{datosImprimir.SALIDA.concepto}}
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

    <script src="vista_salidas.js"></script>
    <!-- <script src="vista_salidas_ajs.js"></script> -->

    <script src="vista_salidas_global_ajs.js"></script>

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