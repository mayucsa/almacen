<?php
    include_once "../../superior.php";
    include_once "../../../dbconexion/conexion.php";
    include_once "modelo_centrocostos.php";
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
            </style>
        </head>
<div ng-controller="vistaCentroCostos">
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
          <h1><i class="fas fa-boxes"></i> Centro de costos</h1>
          <!-- <p>Mayucsa / Mayamat</p> -->
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="vista_centrocostos.php">Centro de costos</a></li>
        </ul>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="card card-info">
                <div class="card-header">
                     <h3 class="card-title">CAPTURA DE DATOS</h3>
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
                                <input type="text" id="inputcodcc" name="inputcodcc" ng-model="codcc" class="form-control form-control-md validanumericos">
                                <label>Código de centro de costo</label>
                            </div>
                            <div hidden style="width: 25%;" class="form-floating mx-1">
                                <input type="text" id="inputnombrecc" name="inputnombrecc" ng-model="nombrecc"  class="form-control form-control-md UpperCase">
                                <label>Nombre de centro de costo</label>
                            </div>
                            <div style="width: 25%;" class="form-floating mx-1">
                                <select class="form-control form-group-md" id="selectmaq" name="selectmaq" ng-model="concepto" >
                                        <option selected="selected" value="" disabled>[Seleccione una opción..]</option>
                                        <?php foreach (ModeloCC::showConcepto() as $value) { ?>
                                        <option value="<?=$value['cve_alterna']?>"><?=$value['cve_alterna']?> - <?=$value['nombre']?></option>
                                        <?php } ?>
                                </select>
                                <label>Concepto</label>
                            </div>
                            <div style="width: 25%;" class="form-floating mx-1">
                                <select class="form-control form-group-md" id="selectmaq" name="selectmaq" ng-model="tipo" >
                                        <option selected="selected" value="" disabled>[Seleccione una opción..]</option>
                                        <?php foreach (ModeloCC::showAreas() as $value) { ?>
                                        <option value="<?=$value['cve_alterna']?>"><?=$value['cve_alterna']?> - <?=$value['nombre_area']?></option>
                                        <?php } ?>
                                </select>
                                <label>Tipo</label>
                            </div>
<!--                             <div style="width: 25%;" class="form-floating mx-1">
                                <input type="text" id="inputcuentacc" name="inputcuentacc" ng-model="cuentacc"  class="form-control form-control-md validanumericos">
                                <label>Cuenta</label>
                            </div> -->
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
                    <div class="row">
                        <div class="col-lg-12 d-lg-flex" style="display: flex; justify-content: flex-end">
                            <div style="width: 20%;" class="form-floating mx-1">
                                <input 
                                        type="text" 
                                        id="iptNombre"
                                        class="form-control"
                                        data-index="0">
                                <label for="iptNombre">Nombre</label>
                            </div>
                        </div>
                    </div>
                </div> <!-- ./ end card-body -->
            </div> <!-- ./ end card-info -->

            <div class="card card-info">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover w-100 shadow" id="tablaGrupos">
                            <thead>
                                <tr>
                                    <th class="text-center">C&oacute;digo</th>
                                    <th class="text-center">Nombre</th>
                                    <!-- <th class="text-center">Departamento</th> -->
                                    <th class="text-center">Cuenta</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <!-- <td></td> -->
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div> <!-- ./ end card-body -->
            </div> <!-- ./ end card-info -->

          </div>
        </div>
    </div> <!--FIN DE DIV ROW--->


        <?php include_once "../../footer.php" ?>

    </main>

<script src="../../../includes/js/adminlte.min.js"></script>

<script src="../../../includes/js/jquery351.min.js"></script>

<!-- <script src="vista_categorias.js"></script> -->

<?php 
include_once "../../inferior.php";
// include_once "modales.php";
?>

    <script src="vista_centrocostos_ajs.js"></script>

    <script src="vista_centrocostos.js"></script>

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