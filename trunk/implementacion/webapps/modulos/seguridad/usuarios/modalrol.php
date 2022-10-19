<head>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
    <script src="../../../includes/js/jquery351.min.js"></script>
    <script src="../../../includes/bootstrap/js/bootstrap.js"></script>
    <script src="../../../includes/bootstrap/js/bootstrap.min.js"></script>
    <script src="usuarios.js"></script>
</head>

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
<div class="modal fade" id="myLoading" tabindex="-3" data-backdrop="static" data-keyboard="false" style="padding-top:20%; overflow-y:visible;" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div align="center"><img src="../../../includes/imagenes/loading_gral.gif" width="140px"></div>
  <div id="divtextloading" align="center" style="font-weight:bold; font-size:20px; color:#FFFFFF">Espere un momento...</div>
</div>

<div id="modalrol" class="modal fade" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo rol</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formrol" name="formrol">
          <div class="form-group">
            <label class="control-label">Nombre</label>
            <input class="form-control" id="txtname" name="txtname" type="text" placeholder="Nombre del rol">
          </div>
          <div class="form-group">
            <label class="control-label">Descripción</label>
            <textarea class="form-control" id="txtdescripcion" name="txtdescripcion" rows="2" placeholder="Descripción del Rol" ></textarea>
          </div>
          <div class="form-group">
            <label class="control-label">Estatus</label> 
            <select class="form-control" id="selectStatus" name="selectStatus">
              <option value="1">Activo</option>
              <option value="2">Inactivo</option>                    
            </select>                 
          </div>
         
      </div>
        <div class="modal-footer">
          <input type="submit" value="Guardar" href="#" onclick="insertRol()" class="btn btn-primary">
          <button type="button" class="btn btn-danger"  data-dismiss="modal">Cerrar</button>
        </div>
        </form> 
    </div>
  </div>
</div>