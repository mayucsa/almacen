<!-- MODAL AGREGAR CONTACTO -->
<div id="modalAgregaContacto" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="exampleModalLabel">Agregar contactos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="row form-group form-group-sm">
              <div class="col-lg-12 d-lg-flex">
                      <input hidden type="text" class="form-control" id="inputprov" name="inputprov" required="" disabled>
              </div>
              <div class="col-lg-12 d-lg-flex">
                      <input hidden type="text" class="form-control" id="inputnameprov" name="inputnameprov" required="" disabled>
              </div>
          </div>
          <div class="row form-group form-group-sm">
              <div class="col-lg-12 d-lg-flex">
                  <div style="width: 100%;" class="form-floating mx-1">
                      <input type="text" id="inputcontacto" name="inputcontacto" class="form-control form-control-md UpperCase">
                      <label>Nombre de contacto</label>
                  </div>
              </div>
          </div>
          <div class="row form-group form-group-sm">
              <div class="col-lg-12 d-lg-flex">
                  <div style="width: 100%;" class="form-floating mx-1">
                      <input type="text" id="inputcorreo" name="inputcorreo" class="form-control form-control-md">
                      <label>Correo</label>
                  </div>
              </div>
          </div>
          <div class="row form-group form-group-sm">
              <div class="col-lg-12 d-lg-flex">
                  <div style="width: 100%;" class="form-floating mx-1">
                      <input type="text" id="inputtel" name="inputtel" class="form-control form-control-md validanumericos" maxlength="10">
                      <label>Teléfono</label>
                  </div>
              </div>
          </div>
          <span hidden id="spanusuarioe" name="spanusuarioe" class="form-control form-control-sm" style="background-color: #E9ECEF;"><?php echo $nombre." ".$apellido?></span>
      </div>
      <div class="modal-footer">
        <input type="button" value="Agregar" onclick="agregarContactos()" class="btn btn-success">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL VER ARTICULO -->
<div id="modalVer" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="exampleModalLabel">Datos del Proveedor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="row form-group form-group-sm">
              <div class="col-lg-12 d-lg-flex">
                  <div style="width: 25%;" class="form-floating mx-1">
                      <input type="text" id="inputnombreprovv" name="inputnombreprovv" class="form-control form-control-md UpperCase" disabled>
                      <label>Nombre de proveedor</label>
                  </div>
                  <div style="width: 25%;" class="form-floating mx-1">
                      <input type="text" id="inputrazonsocialver" name="inputrazonsocialver" class="form-control form-control-md UpperCase" disabled>
                      <label>Razón social</label>
                  </div>
                  <div style="width: 25%;" class="form-floating mx-1">
                      <input type="text" id="inputrfcver" name="inputrfcver" class="form-control form-control-md UpperCase" disabled>
                      <label>RFC</label>
                  </div>
              </div>
          </div>

          <div class="row form-group form-group-sm">
              <div class="col-lg-12 d-lg-flex">
                  <div style="width: 50%;" class="form-floating mx-1">
                      <input type="text" id="inputdireccionver" name="inputdireccionver" class="form-control form-control-md UpperCase" disabled>
                      <label>Dirección</label>
                  </div>
                  <div style="width: 25%;" class="form-floating mx-1">
                      <input type="text" id="inputcoloniaver" name="inputcoloniaver" class="form-control form-control-md UpperCase" disabled>
                      <label>Colonia</label>
                  </div>
                  <div style="width: 25%;" class="form-floating mx-1">
                      <input type="text" id="inputcpver" name="inputcpver" class="form-control form-control-md validanumericos" maxlength="5" disabled>
                      <label>Código postal</label>
                  </div>
              </div>
          </div>

          <div class="row form-group form-group-sm">
              <div class="col-lg-12 d-lg-flex">
                  <div style="width: 25%;" class="form-floating mx-1">
                      <input type="text" id="inputcdestadover" name="inputcdestadover" class="form-control form-control-md UpperCase" disabled>
                      <label>Ciudad, Estado</label>
                  </div>
                  <div style="width: 25%;" class="form-floating mx-1">
                      <input type="text" id="inputcrediver" name="inputcrediver" class="form-control form-control-md validanumericos" maxlength="2" disabled>
                      <label>Días de crédito</label>
                  </div>
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL ELIMINAR ARTICULOS -->
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
          <input hidden type="text" class="form-control" id="inputidel" name="inputidel" required="" >
        <div class="form-group">
          <label for="message-text" class="col-form-label">¿Desea eliminar el siguiente Proveedor?</label>
        </div>
            <div class="row form-group form-group-sm">
                <div class="col-lg-12 d-lg-flex">
                    <div style="width: 50%;" class="form-floating mx-1">
                      <input type="text" class="form-control form-control form-control-md " id="inputcodigodel" name="inputcodigodel" required="" disabled>
                      <label>Código:</label>
                    </div>
                    <div style="width: 50%;" class="form-floating mx-1">
                      <input type="text" class="form-control form-control form-control-md " id="inputnombredel" name="inputnombredel" required="" disabled>
                      <label>Nombre:</label>
                    </div>
                </div>
              </div>
          <label hidden for="message-text" class="col-form-label">Usuario:</label>
          <span hidden id="spanusuarioe" name="spanusuarioe" class="form-control form-control-sm" style="background-color: #E9ECEF;"><?php echo $nombre." ".$apellido?></span>
        <!-- </form> -->
      </div>
      <div class="modal-footer">
        <input type="button" value="Eliminar" onclick="eliminarProveedor()" class="btn btn-danger">
        <button type="button" class="btn btn-success" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL EDITAR PROVEEDOR -->
<div id="modalEditar" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
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

          <div class="row form-group form-group-sm">
              <div class="col-lg-12 d-lg-flex">
                  <div style="width: 25%;" class="form-floating mx-1">
                      <input type="text" id="inputnombreprov" name="inputnombreprov" class="form-control form-control-md UpperCase">
                      <label>Nombre de proveedor</label>
                  </div>
                  <div style="width: 25%;" class="form-floating mx-1">
                      <input type="text" id="inputrazonsocialedit" name="inputrazonsocialedit" class="form-control form-control-md UpperCase">
                      <label>Razón social</label>
                  </div>
                  <div style="width: 25%;" class="form-floating mx-1">
                      <input type="text" id="inputrfcedit" name="inputrfcedit" class="form-control form-control-md UpperCase">
                      <label>RFC</label>
                  </div>
              </div>
          </div>

          <div class="row form-group form-group-sm">
              <div class="col-lg-12 d-lg-flex">
                  <div style="width: 50%;" class="form-floating mx-1">
                      <input type="text" id="inputdireccionedit" name="inputdireccionedit" class="form-control form-control-md UpperCase">
                      <label>Dirección</label>
                  </div>
                  <div style="width: 25%;" class="form-floating mx-1">
                      <input type="text" id="inputcoloniaedit" name="inputcoloniaedit" class="form-control form-control-md UpperCase">
                      <label>Colonia</label>
                  </div>
                   <div style="width: 25%;" class="form-floating mx-1">
                        <input type="text" id="inputcpedit" name="inputcpedit" class="form-control form-control-md validanumericos" maxlength="5">
                        <label>Código postal</label>
                    </div>
              </div>
          </div>

          <div class="row form-group form-group-sm">
              <div class="col-lg-12 d-lg-flex">
<!--                   <div style="width: 25%;" class="form-floating mx-1">
                      <input type="text" id="inputcontactoedit" name="inputcontactoedit" class="form-control form-control-md UpperCase">
                      <label>Nombre de contacto</label>
                  </div>
                  <div style="width: 25%;" class="form-floating mx-1">
                      <input type="text" id="inputcorreoedit" name="inputcorreoedit" class="form-control form-control-md">
                      <label>Correo</label>
                  </div>
                  <div style="width: 25%;" class="form-floating mx-1">
                      <input type="text" id="inputteledit" name="inputteledit" class="form-control form-control-md validanumericos" maxlength="10">
                      <label>Teléfono</label>
                  </div> -->
                  <div style="width: 25%;" class="form-floating mx-1">
                      <input type="text" id="inputcdestadoedit" name="inputcdestadoedit" class="form-control form-control-md UpperCase">
                      <label>Ciudad, Estado</label>
                  </div>
                  <div style="width: 25%;" class="form-floating mx-1">
                      <input type="text" id="inputcreditoedit" name="inputcreditoedit" class="form-control form-control-md validanumericos" maxlength="2">
                      <label>Días de crédito</label>
                  </div>
              </div>
          </div>

          <label hidden for="message-text" class="col-form-label">Usuario:</label>
          <span hidden id="spanusuario" name="spanusuario" class="form-control form-control-sm" style="background-color: #E9ECEF;"><?php echo $nombre." ".$apellido?></span>
        <!-- </form> -->
      </div>
      <div class="modal-footer">
        <input type="button" value="Actualizar" onclick="editarProveedor()" class="btn btn-primary">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>