<!-- Reporte existencia global de articulos -->
<div id="modalKDX" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="exampleModalLabel">Kardex</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row form-group form-group-sm">
          <div class="col-lg-12 d-lg-flex">
            <div style="width: 50%;" class="form-floating mx-1">
              <input type="text" class="form-control" ng-model="obj.arti" id="dropDownCC" role="button" data-bs-toggle="dropdown" aria-expanded="false" ng-keyup="getArticulos(key)">
                <ul class="dropdown-menu" aria-labelledby="dropDownCC" style=" position: relative; display: block" ng-show="arrayCcostos.length > 0">
                    <li ng-repeat="(w, obj) in arrayCcostos track by w">
                      <a ng-click="setCcosto(key, w)" class="dropdown-item" href="javascript:void(0)">
                        <span class="p-2">{{obj.cve_alterna}} - {{obj.nombre_articulo}}</span>
                      </a>
                    </li>
                </ul>
              <label>Artículo</label>
            </div>
          </div>
        </div>
        <div class="row form-group form-group-sm">
          <div class="col-lg-12 d-lg-flex">
            <div style="width: 50%;" class="form-floating mx-1">
              <input class="date-picker form-control" min="2022-11-27" ng-model="fechainicio" id="fechainicio" autocomplete="off">
              <label>Fecha inicio</label>
            </div>
            <div style="width: 50%;" class="form-floating mx-1">
              <input class="date-picker form-control" min="2022-11-27" ng-model="fechafin" id="fechafin" autocomplete="off">
              <label>Fecha fin</label>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Imprimir <i class="fas fa-print"></i></button>
        <button type="button" class="btn btn-success">Descargar <i class="fas fa-file-excel"></i></button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!-- Reporte existencia global de articulos -->
<div id="modalExisteArt" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="exampleModalLabel">Reporte de existencia</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <a>Reporte de todos los articulos de almacen, obtenemos existencia, minimo, maximo, costo unitario y costo promedio</a>
        <!-- SQL -->
        <!-- SELECT cve_alterna, nombre_articulo, existencia, min, max, precio_unitario, costo_promedio FROM cat_articulos ca  -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" ng-click="getPDF('existencias')">
          Imprimir <i class="fas fa-print"></i>
        </button>
        <button type="button" class="btn btn-success" ng-click="getExcel('existencias')">
          Descargar <i class="fas fa-file-excel"></i>
        </button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!-- Reporte de movimientos entradas y salidas-->
<div id="modalMovtosES" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="exampleModalLabel">Reporte de movimientos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row form-group form-group-sm">
          <div class="col-lg-12 d-lg-flex">
            <div style="width: 100%;">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <input type="checkbox" aria-label="Checkbox for following text input" checked>
                  </div>
                </div>
                <input type="text" placeholder="Entradas" class="form-control" aria-label="Text input with checkbox" disabled>
              </div>
            </div>

            <div style="width: 100%;">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <input type="checkbox" aria-label="Checkbox for following text input" checked>
                  </div>
                </div>
                <input type="text" placeholder="Salidas" class="form-control" aria-label="Text input with checkbox" disabled>
              </div>
            </div>
          </div>
        </div>
        <div class="row form-group form-group-sm">
          <div class="col-lg-12 d-lg-flex">
            <div style="width: 100%;" class="form-floating mx-1">
              <input class="date-picker form-control" ng-model="fechainicioMov" id="fechainicioMov">
              <label>Fecha inicio</label>
            </div>
            <div style="width: 100%;" class="form-floating mx-1">
              <input class="date-picker form-control" ng-model="fechafinMov" id="fechafinMov">
              <label>Fecha fin</label>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Imprimir <i class="fas fa-print"></i></button>
        <button type="button" class="btn btn-success">Descargar <i class="fas fa-file-excel"></i></button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!-- Reporte Requisiciones Automáticas -->
<div id="modalMovtosReqsAuto" class="modal fade" tabindex="-1" aria-labelledby="modalMovtosReqsAutoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalMovtosReqsAutoLabel">Requisiciones</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row form-group form-group-sm">
          <div class="col-lg-12 d-lg-flex">
            <div style="width: 100%;">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <input type="checkbox" aria-label="Checkbox for following text input" checked>
                  </div>
                </div>
                <input type="text" placeholder="Normales" class="form-control" aria-label="Text input with checkbox" disabled>
              </div>
            </div>
            <div style="width: 100%;">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <input type="checkbox" aria-label="Checkbox for following text input" checked>
                  </div>
                </div>
                <input type="text" placeholder="Automáticas" class="form-control" aria-label="Text input with checkbox" disabled>
              </div>
            </div>
          </div>
        </div>
        <div class="row form-group form-group-sm">
          <div class="col-lg-12 d-lg-flex">
            <div style="width: 100%;" class="form-floating mx-1">
              <input class="date-picker form-control" ng-model="fechainicioRA" id="fechainicioRA">
              <label>Fecha inicio</label>
            </div>
            <div style="width: 100%;" class="form-floating mx-1">
              <input class="date-picker form-control" ng-model="fechafinRA" id="fechafinRA">
              <label>Fecha fin</label>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-primary">Imprimir <i class="fas fa-print"></i></button> -->
        <button type="button" class="btn btn-primary" ng-click="getPDF('RequisicionesAuto')">Imprimir <i class="fas fas fa-print"></i></button>
        <button type="button" class="btn btn-success" ng-click="getExcel('RequisicionesAuto')">Descargar <i class="fas fa-file-excel"></i></button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>