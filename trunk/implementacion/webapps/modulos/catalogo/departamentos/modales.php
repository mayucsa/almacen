<!-- MODAL EDITAR CATEGORIA -->
<div id="modalEditar" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="exampleModalLabel">Editar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <label hidden for="message-text" class="col-form-label">ID:</label>
          <input hidden type="text" class="form-control" id="inputid" name="inputid" required="" >
        <div class="form-group">
          <label for="message-text" class="col-form-label">Nombre:</label>
          <input type="text" class="form-control UpperCase" id="inputnombredepto" name="inputnombredepto" required="" >
        </div>
          <label hidden for="message-text" class="col-form-label">Usuario:</label>
          <span hidden id="spanusuario" name="spanusuario" class="form-control form-control-sm" style="background-color: #E9ECEF;"><?php echo $nombre." ".$apellido?></span>
        <!-- </form> -->
      </div>
      <div class="modal-footer">
        <input type="button" value="Actualizar" onclick="editarDepto()" class="btn btn-primary">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL ELIMINAR CATEGORIA -->
<div id="modalEliminar" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="exampleModalLabel">Eliminar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <label hidden for="message-text" class="col-form-label">ID:</label>
          <input hidden type="text" class="form-control" id="inputide" name="inputide" required="" >
        <div class="form-group">
          <label for="message-text" class="col-form-label">¿Desea dar de baja el siguiente Departamento?</label>
          <input type="text" class="form-control" id="inputnombredeptoe" name="inputnombredeptoe" required="" disabled>
        </div>
          <label hidden for="message-text" class="col-form-label">Usuario:</label>
          <span hidden id="spanusuarioe" name="spanusuarioe" class="form-control form-control-sm" style="background-color: #E9ECEF;"><?php echo $nombre." ".$apellido?></span>
        <!-- </form> -->
      </div>
      <div class="modal-footer">
        <input type="button" value="Eliminar" onclick="eliminarDepto()" class="btn btn-danger">
        <button type="button" class="btn btn-success" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>