<?php   include_once "../../superior.php";
        // include_once "../../../dbconexion/conexion.php";
        // include_once"modelo_captura.php";
        // include_once"enviar_mail.php";
?>
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fas fa-user-tag"></i> Roles de usuario</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="roles.php"> Roles de usuario</a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                  <div align="right" class="form-group form-group-sm" style="margin-bottom: 0px !important">
                      <button id="btnrol" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalrol" data-whatever="@getbootstrap"><span class="fas fa-plus-circle"></span> Nuevo</button>
                  </div>
              </div>
              <div class="card-body">
                  <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover" style="width: 100%;" id="tablarol">
                          <thead>
                              <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Descipcion</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Acciones</th>
                              </tr>
                          </thead>
                          <tbody>
                              <tr>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                              </tr>
                          </tbody>
                      </table>
                  </div>
              </div>
            </div>
        </div>
      </div>
    </main>

    <!-- <script src="../../../includes/js/jquery351.min.js"></script> -->
<script src="usuarios.js"></script>

<?php include_once "modalrol.php" ?>
<?php include_once "../../inferior.php" ?>

    <script src="../../../includes/js/jquery331.min.js"></script>

<script type="text/javascript">
    consultarrol();  
</script> 

    <!-- <script src="../../../includes/bootstrap/js/bootstrap.js"></script> -->

    <!-- <script src="../../../includes/bootstrap/js/bootstrap.min.js"></script> -->

    <link rel="stylesheet" type="text/css" href="../../../includes/css/datatables.min.css"/>

    <script type="text/javascript" src="../../../includes/js/datatables.min.js"></script>