<!-- MODAL VER COTIZACION -->
<div id="modalVerMP" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="exampleModalLabel">Orden de compra</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="form-group form-group-sm">
            <div class="col-lg-12 d-lg-flex">
              <div style="width: 50%;">
                <label for="message-text" class="col-form-label">Folio Orden de compra:</label>
                <input type="text" class="form-control" id="inputname" name="inputname" disabled>
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

<!-- MODAL CANCELAR AUTORIZARION -->
<div id="modalNoAutorizado" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="exampleModalLabel">NO AUTORIZADO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="row form-group form-group-sm">
              <div class="col-lg-12 d-lg-flex">
                  <div style="width: 50%;" class="form-floating mx-1">
                      <input type="text" class="form-control form-control-md" id="inputfolio" name="inputfolio" disabled>
                      <label>Folio Orden de compra:</label>
                  </div>
              </div>
          </div>
          <div class="row form-group form-group-sm">
            <div class="col-lg-12 d-lg-flex">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckIndeterminate">
                <label class="form-check-label" for="flexCheckIndeterminate">
                  Cancelar orden de comprar sin volver a cotizar
                </label>
              </div>
            </div>
          </div>
          <div class="row form-group form-group-sm">
              <div class="col-lg-12 d-lg-flex">
                  <div style="width: 100%;" >
                      <!-- <input type="text" class="form-control form-control-md" id="inputcomentario" name="inputcomentario" disabled> -->
                      <label>Motivo:</label>
                      <textarea style="width: 100%;" name="motivo" id="motivo"></textarea>
                  </div>
              </div>
          </div>
          <span hidden id="spanusuario" name="spanusuario" class="form-control form-control-sm" style="background-color: #E9ECEF;"><?php echo $id?></span>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-success" data-dismiss="modal">No autorizar</button> -->
        <input type="button" value="No autorizar" onclick="noautorizado()" class="btn btn-success">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>