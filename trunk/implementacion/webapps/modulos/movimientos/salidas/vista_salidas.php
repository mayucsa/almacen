<?php
include_once "../../superior.php";
include_once "../../../dbconexion/conexion.php";
include_once "modelo_salidas.php";
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
            .borderedMe{
                border-radius: 10px; border: solid;
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
    <div ng-controller="vistaSalidas">
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
                  <h1><i class="fas fa-pen-square"></i> Salidas</h1>
                  <!-- <p>Mayucsa / Mayamat</p> -->
                </div>
                <ul class="app-breadcrumb breadcrumb">
                  <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                  <li class="breadcrumb-item"><a href="vista_salidas.php">Salidas</a></li>
                </ul>
            </div>

            <div class="row" style="position: fixed; z-index: 9; background-color: white; width: 70%; margin-left: 5%;  border-radius: 15px; padding: 5vH; border: solid;" ng-show="modalArticulos == true">
                <div class="col-lg-12 col-md-12" style="max-height: 50vH; overflow-y: auto;">
                    <h3>Mis requisiciones</h3>
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>cve_alterna</th>
                                <th>Nombre</th>
                                <th>Unidad medida</th>
                                <th>Existencia</th>
                                <th>Agregar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="(i, obj) in Articulos track by i">
                                <td>{{obj.cve_req}}</td>
                                <td>{{obj.cve_alterna}}</td>
                                <td>{{obj.nombre_articulo}}</td>
                                <td>{{obj.cantidad}}</td>
                                <td><button class= "btn btn-success" title="Borrar">Agregar</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-12 col-md-12 text-right">
                    <button class="btn btn-danger" ng-click="setModalArticulos()">Cerrar</button>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="tile" id="captura_entrada">
                        <div class="card card-info">
                            <div class="card-header">
                                 <h3 class="card-title">CAPTURA DE SALIDAS</h3>
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
                                            <input type="text" id="nextFocusHeader0" ng-model="foliovale" class="form-control form-control-md validanumericos" maxlength="100" ng-keyup="$event.keyCode == 13 ? inputCharacters(0, 'h') : null">
                                            <label>Folio de Vale</label>
                                        </div>
                                        <div style="width: 25%;" class="form-floating mx-1">
                                            <input type="text" id="nextFocusHeader1" ng-model="concepto" class="form-control form-control-md UpperCase" maxlength="100" ng-keyup="$event.keyCode == 13 ? inputCharacters(1, 'h') : null">
                                            <label>Concepto</label>
                                        </div>
                                        <div style="width: 25%;" class="form-floating mx-1">
                                            <select class="form-control form-group-md" id="nextFocusHeader2" ng-model="departamento" id="departamento" name="departamento" ng-change="getMaquinas()" ng-change="inputCharacters(2, 'h')">
                                                <option selected="selected" value="" disabled>[Seleccione una opción..]</option>
                                                <?php foreach (ModeloSalidas::ShowDepartamentos() as $value) { ?>
                                                <option value="<?=$value['cve_depto']?>"><?=$value['cve_alterna']?> <?=$value['nombre_depto']?></option>
                                                <?php } ?>
                                            </select>
                                            <label>Departamentos</label>
                                        </div>
                                        <div style="width: 25%;" class="form-floating mx-1">
                                            <select class="form-control form-group-md" id="nextFocusHeader3" ng-model="maquinas" name="maquinas" ng-disabled="arrayMaquinas.length==0" ng-change="inputCharacters(3, 'h'); setMaquina()">
                                                <option selected="selected" value="" disabled>[Seleccione una opción..]</option>
                                                <option ng-repeat="(i,obj) in arrayMaquinas track by i" value="{{obj.cve_maq}}">{{obj.cve_alterna}}-{{obj.nombre_maq}}</option>
                                            </select>
                                            <label>Máquinas</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group form-group-sm">
                                    <div class="col-lg-12 d-lg-flex">
                                        <div style="width: 25%;" class="form-floating mx-1">
                                            <input type="text" id="nextFocusHeader4" ng-model="horometro" class="form-control form-control-md validanumericos" maxlength="100" ng-keyup="$event.keyCode == 13 ? inputCharacters(4, 'h') : null">
                                            <label>Hor&oacute;metro</label>
                                        </div>
                                        <div style="width: 75%;" class="form-floating mx-1">
                                            <input type="text" id="nextFocusHeader5" ng-model="comentarios" class="form-control form-control-md UpperCase" maxlength="100" onchange="$('#nextFocus0').focus()">
                                            <label>Comentarios</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group form-group-sm border-top">
                                    <div class="col-sm-12" align="center">
                                        <button ng-click="validacionCampos()"class="btn btn-primary" style="margin-bottom: -25px !important">
                                            Generar Salida
                                        </button>
                                        <input type="submit" value="Limpiar" href="#" ng-click="limpiarCampos()" id="btnLimpiar" class="btn btn-warning" style="margin-bottom: -25px !important">
                                        <input type="submit" value="Ver salidas" onclick ="location.href='salidas_global.php'; " class="btn btn-info" style="margin-bottom: -25px !important">
                                        <!-- <input type="button" onclick="imprSelec('paraImprimir')" value="Imprimir"> -->

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
                                 <h3 class="card-title">Articulos</h3>
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
                                            <input type="text" ng-model="codarticulo" class="form-control form-control-md UpperCase" ng-change="getArticulos()" id="dropDownSearch" role="button" data-bs-toggle="dropdown" aria-expanded="false" ng-click="clickInputArticulos()">
                                            <label>Articulo</label>
                                        </div>
                                        <!-- <button class= "btn btn-info btn-sm" ng-click="setModalArticulos()" title="Articulos">
                                            <i class="fas fa-eye"></i>
                                        </button> -->
                                        <ul class="dropdown-menu" aria-labelledby="dropDownSearch" style="width: 40%; display: block" ng-show="findArticulos.length > 0">
                                            <li ng-repeat="(i, obj) in findArticulos track by i">
                                              <a class="dropdown-item" href="javascript:void(0)" ng-click="setArticulo(i)">
                                                <span class="p-2">{{obj.cve_alterna}} - {{obj.nombre_articulo}}</span>
                                              </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row form-group form-group-sm">
                                    <div class="col-lg-12 d-lg-flex ">
                                        <table class="table table-striped table-bordered table-hover table-responsive">
                                            <thead>
                                                <tr>
                                                    <th>cve_alterna</th>
                                                    <th>Nombre de articulo</th>
                                                    <th>Unidad medida</th>
                                                    <th>Existencia</th>
                                                    <th>Cantidad a salir</th>
                                                    <th>Centro de costo</th>
                                                    <th>Quitar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="(key, obj) in articulos track by key">
                                                    <td>{{obj.cve_alterna}}</td>
                                                    <td>{{obj.nombre_articulo}}</td>
                                                    <td>{{obj.unidad_medida}}</td>
                                                    <td>{{obj.existencia}}</td>
                                                    <td>
                                                        <input type="text" class="form-control text-right" ng-model="obj.cantidad" ng-change="validarCantidad(key)">
                                                    </td>
                                                    <td style="width:auto;">
                                                        <input type="text" class="form-control" ng-model="obj.centroCosto" id="dropDownCC" role="button" data-bs-toggle="dropdown" aria-expanded="false" ng-keyup="getCcostos(key)">
                                                        <ul class="dropdown-menu" aria-labelledby="dropDownCC" style=" position: relative; display: block" ng-show="arrayCcostos.length > 0">
                                                            <li ng-repeat="(w, obj) in arrayCcostos track by w">
                                                              <a ng-click="setCcosto(key, w)" class="dropdown-item" href="javascript:void(0)">
                                                                <span class="p-2">{{obj.cve_alterna}} - {{obj.nombre_cc}}</span>
                                                              </a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                    <td>
                                                        <div class="div">
                                                            <div class="col-md-4 offset-md-5 text-center">
                                                                <button class= "btn btn-danger" title="Borrar" ng-click="quitarArticulo(key)"><i class="fas fa-trash-alt"></i>
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


            <?php include_once "../../footer.php" ?>

        </main>
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
                                    {{folioSalida}}
                                </div>
                            </div>
                        </div>
                        <div class="" style="position: absolute; margin-left: 35%; width: 65%;">
                            <div class="row" style="border-radius: 10px; border: solid;">
                                <div class="col-md-12 p-2" style="border-bottom: solid;">
                                    <h3>FECHA</h3>
                                </div>
                                <div class="col-md-12 p-2" style="text-align: center; margin-top: 5px; margin-bottom: 5px;">
                                    <?=date('Y-m-d')?>
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
                            {{maquinaSeleccionada}}
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-2" style=" margin-top: 10px;">
                    <div class="row" style="border-radius: 10px; border: solid;">
                        <div class="col-md-12 p-2">
                            <h3>REALIZADO POR</h3>
                        </div>
                        <div class="col-md-12 p-2" style="text-align: center; margin-top: 5px; margin-bottom: 5px;">
                            <?=$creadoPor?>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-2" style="border-radius: 10px; border: solid; margin-top: 10px; padding: 3px;">
                    <table class="table table-striped">
                        <tr>
                            <th style="text-align: left;">Clave Art.</th>
                            <th>Descripción / sección</th>
                            <th>Cantidad</th>
                            <th>Unidad</th>
                        </tr>
                        <tr ng-repeat="(key, obj) in articulos track by key">
                            <td style="text-align: left;">{{obj.cve_alterna}}</td>
                            <td>{{obj.nombre_articulo}} / {{obj.seccion}}</td>
                            <td style="text-align: right;">{{obj.cantidad}}</td>
                            <td style="text-align: right;">{{obj.unidad_medida}}</td>
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
                            {{concepto}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../../../includes/js/adminlte.min.js"></script>

    <script src="../../../includes/js/jquery351.min.js"></script>


<?php 
include_once "../../inferior.php";
// include_once "modales.php";
?>

    <script src="vista_salidas_ajs.js"></script>

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
<!--     <script>
        $('.date-picker').datepicker({
        closeText: 'Cerrar',
        prevText: '<Ant',
        nextText: 'Sig>',
        currentText: 'Hoy',
        monthNamesShort: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        // changeDay: true,
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'yy-mm-dd',
        showDays: false,
    });
    </script> -->