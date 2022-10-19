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




            </style>
        </head>
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

<!--             <section class="content">
                <div class="row">
                    <div class="col-lg-5 col-xs-12">
                        <div class="box box-success">
                            <div class="box-header with-border"></div>
                                <div class="box-body">
                                    <div class="box">
                                        <div class="form-group">
                                          <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                                            <input type="text" class="form-control" id="nuevoVendedor" name="nuevoVendedor" value="<?php //echo $nombre." ".$apellido?>" readonly>
                                          </div>
                                        </div> 
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </section> -->

    <div class="row">
        <div class="col-md-6">
            <div class="tile">
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
                        <div class="row form-group form-group-sm">
                            <div class="col-lg-12 d-lg-flex">
                                <span id="spanusuario" name="spanusuario" class="form-control form-control-sm" style="background-color: #E9ECEF;"><?php echo $id?></span>
                                <span id="spanusuario" name="spanusuario" class="form-control form-control-sm" style="background-color: #E9ECEF;"><?php echo $nombre." ".$apellido?></span>
                            </div>
                        </div>
                        <div class="row form-group form-group-sm border-top">
                            <div class="col-sm-12" align="center">
                                <input type="submit" value="Guardar" href="#" onclick="validacionCampos()" class="btn btn-primary" style="margin-bottom: -25px !important">
                                <input type="submit" value="Limpiar" href="#" onclick="limpiarCampos()" class="btn btn-warning" style="margin-bottom: -25px !important">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="tile">
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
                            <div class="col-lg-12 d-lg-flex" style="display: flex; justify-content: flex-end">
                                <div style="width: 30%;" class="form-floating mx-1">
                                    <input 
                                            type="text" 
                                            id="iptCodigo"
                                            class="form-control"
                                            data-index="0">
                                    <label for="iptCodigo">Código</label>
                                </div>
                                <div style="width: 30%;" class="form-floating mx-1">
                                    <input 
                                            type="text" 
                                            id="iptNombre"
                                            class="form-control"
                                            data-index="1">
                                    <label for="iptNombre">Nombre</label>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="card card-info">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover w-100 shadow" id="tablaArticulos">
                                <thead>
                                    <tr>
                                        <th class="text-center">Código</th>
                                        <th class="text-center">Nombre</th>
                                        <th class="text-center">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- ./ end card-body -->
                </div> <!-- ./ end card-info -->

                </div>
            </div>
        </div>
    </div>


        <?php include_once "../../footer.php" ?>

    </main>

<script src="../../../includes/js/adminlte.min.js"></script>

<script src="../../../includes/js/jquery351.min.js"></script>

<script src="vista_requisicion.js"></script>

<?php 
include_once "../../inferior.php";
// include_once "modales.php";
?>

<!-- <script src="vista_grupos.js"></script> -->

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