<?php   
    include_once "../../superior.php";
    include_once "../../../dbconexion/conexion.php";
    // include_once "modelo_entradas.php";
?>        
        <head>
        <link rel="stylesheet" type="text/css" href="../../../includes/css/adminlte.min.css">
            <title>Entradas</title>

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
<div class="modal fade" id="myLoadingGral" tabindex="-3" data-backdrop="static" data-keyboard="false" style="padding-top:20%; overflow-y:visible;" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div align="center"><img src="../../../includes/imagenes/loading_gral.gif" width="140px"></div>
    <div id="divtextloading" align="center" style="font-weight:bold; font-size:20px; color:#FFFFFF">Espere un momento...</div>
</div>
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
          <h1><i class="fas fa-user-cog"></i> Cambio de Contrase&ntilde;a</h1>
          <!-- <p>Start a beautiful journey here</p> -->
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="vista_password.php">Cambio de Contrase&ntilde;a</a></li>
        </ul>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="card">
                <div class="card-header">
                    <div align="right" class="form-group form-group-sm" style="margin-bottom: 0px !important">
                        <button id="btnsave" type="button" class="btn btn-warning" onclick="validacion()"><span class="fas fa-edit"></span> Guardar cambios</button>
                        <button id="btnsave" type="button" class="btn btn-warning" onclick="actualizaPasswordUsuario()"><span class="fas fa-edit"></span> Modal</button>
                        <!-- <input type="submit" value="Guardar cambios" href="#" onclick="comprobacion()" class="btn btn-warning" style="margin-bottom: -25px !important"> -->
                    </div>
                </div>
                <div class="card-body">


                    <div class="row form-group form-group-sm">
                        <div class="col-lg-12 d-lg-flex">
                            <div style="width: 25%;" class="form-floating mx-1">
                                <input type="password" id="inputnueva" name="inputnueva" class="form-control form-control-md">
                                <label>Nueva Contrase&ntilde;a</label>
                            </div>
                            <div style="width: 25%;" >
                                <input type="checkbox" id="mostrar_contrasena" title="clic para mostrar contraseña"/>
                                <label>&nbsp;&nbsp;Mostrar Contraseña</label>
                            </div>
                            <div style="width: 25%;" class="form-floating mx-1">
                                <input type="password" id="inputconfirmar" name="inputconfirmar" class="form-control form-control-md">
                                <label>Confirmar contrase&ntilde;a</label>
                            </div>
                            <div style="width: 25%;" >
                                <input type="checkbox" id="mostrar_contrasenados" title="clic para mostrar contraseña"/>
                                <label>&nbsp;&nbsp;Mostrar Contraseña</label>
                            </div>
                        </div>
                    </div>
                <span hidden id="spaniduser" name="spaniduser" class="form-control" style="background-color: #E9ECEF;"><?php echo $id?></span>
                <span hidden id="spanuser" name="spanuser" class="form-control" style="background-color: #E9ECEF;"><?php echo $nombre." ".$apellido?></span>
                </div>
                </div>
            </div>
          </div>
        </div>
      </div>
      <?php include_once "../../footer.php" ?>
    </main>

    <script src="../../../includes/js/adminlte.min.js"></script>

    <script src="../../../includes/js/jquery351.min.js"></script>

    <script src="vista_password.js"></script>

<?php include_once "../../inferior.php" ?>

    <!-- <script src="vista_entradas.js"></script> -->

    <script src="../../../includes/js/jquery331.min.js"></script>

    <script src="../../../includes/js/sweetalert2.min.js"></script>

    <script src="../../../includes/bootstrap/js/bootstrap.js"></script>

    <script src="../../../includes/bootstrap/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="../../../includes/css/datatables.min.css"/>

    <script type="text/javascript" src="../../../includes/js/datatables.min.js"></script>
<script>
$(document).ready(function () {
  $('#mostrar_contrasena').click(function () {
    if ($('#mostrar_contrasena').is(':checked')) {
      $('#inputnueva').attr('type', 'text');
    } else {
      $('#inputnueva').attr('type', 'password');
    }
  });
});

$(document).ready(function () {
  $('#mostrar_contrasenados').click(function () {
    if ($('#mostrar_contrasenados').is(':checked')) {
      $('#inputconfirmar').attr('type', 'text');
    } else {
      $('#inputconfirmar').attr('type', 'password');
    }
  });
});
</script>