<div id="modalVerMP" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="exampleModalLabel">Materia prima por Producto</h5>
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