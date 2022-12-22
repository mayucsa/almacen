<?php
    // include_once "../../superior.php";
    // include_once "../../../dbconexion/conexion.php";
    include_once "modelo_articulo.php";
?>

<!-- MODAL VER SCANNER -->
<div id="modalScanner" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="exampleModalLabel">Código de Barras</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center" id="modalBarCode">
        <!-- <img class="codigo" id="imgcodigo" name="imgcodigo"/> -->
      </div>
      <div class="modal-footer">
        <input type="button" value="Imprimir" onclick="imprSelec('modalBarCode')" class="btn btn-primary">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL VER ARTICULO -->
<div id="modalVer" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="exampleModalLabel">Datos del Artículo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="row form-group form-group-sm">
              <div class="col-lg-12 d-lg-flex">
                  <div style="width: 100%;" class="form-floating mx-1">
                      <input type="text" id="inputnombreartver" name="inputnombreartver" class="form-control form-control-md UpperCase" disabled>
                      <label>Nombre de articulo</label>
                  </div>
                  <!-- <div style="width: 50%;" class="form-floating mx-1">
                      <input type="text" id="inputexistenciaver" name="inputexistenciaver" class="form-control form-control-md UpperCase" disabled>
                      <label>Empaque</label>
                  </div> -->
              </div>
          </div>
          <div class="row form-group form-group-sm">
              <div class="col-lg-12 d-lg-flex">
                  <div style="width: 100%;" class="form-floating mx-1">
                      <input type="text" id="inputdescripart" name="inputdescripart" class="form-control form-control-md UpperCase" disabled>
                      <label>Descripcion</label>
                  </div>
              </div>
          </div>
          <div class="row form-group form-group-sm">
              <div class="col-lg-12 d-lg-flex">
                  <div style="width: 100%;" class="form-floating mx-1">
                      <input type="text" id="inputobservaart" name="inputobservaart" class="form-control form-control-md UpperCase" disabled>
                      <label>Observaciones</label>
                  </div>
              </div>
          </div>
          <div class="row form-group form-group-sm">
              <div class="col-lg-12 d-lg-flex">
                  <div style="width: 50%;" class="form-floating mx-1">
                      <input type="text" id="inputpreciover" name="inputpreciover" class="form-control form-control-md UpperCase" disabled>
                      <label>Precio</label>
                  </div>
                  <div style="width: 50%;" class="form-floating mx-1">
                      <input type="text" id="inputcostover" name="inputcostover" class="form-control form-control-md UpperCase" disabled>
                      <label>Costo</label>
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

<!-- MODAL EDITAR ARTICULOS -->
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
                        <input type="text" id="inputnombreartedit" name="inputnombreartedit" class="form-control form-control-md UpperCase">
                        <label>Nombre de articulo</label>
                    </div>
                    <!-- <div style="width: 25%;" class="form-floating mx-1">
                        <input type="text" id="inputnombrelargeedit" name="inputnombrelargeedit" class="form-control form-control-md UpperCase">
                        <label>Nombre de articulo - Largo</label>
                    </div> -->
                    <div style="width: 50%;" class="form-floating mx-1">
                        <input type="text" id="inputobservacionedit" name="inputobservacionedit" class="form-control form-control-md UpperCase">
                        <label>Observaciones</label>
                    </div>
                </div>
            </div>
            <div class="row form-group form-group-sm">
                <div class="col-lg-12 d-lg-flex">
                    <div style="width: 25%;" class="form-floating mx-1">
                        <select class="form-control form-group-md" id="selectcategoriaedit" name="selectcategoriaedit">
                            <!-- <option selected="selected" value="0">[Seleccione una opción..]</option> -->
                            <?php   
                                $sql        = ModeloArticulo::showcategoria();
                                    echo  '   <option value="0">[Seleccione una opción..]</option>';
                                    foreach ($sql as $value) {
                                    echo '<option value="'.$value["cve_ctg"].'">'.$value["nombre_ctg"].'</option>';
                                    }
                                ?>
                        </select>
                        <label>Categoria</label>
                    </div>
                    <div style="width: 25%;" class="form-floating mx-1">
                        <select class="form-control form-group-md" id="selectgrupoedit" name="selectgrupoedit">
                            <!-- <option selected="selected" value="0">[Seleccione una opción..]</option> -->
                            <?php   
                                  $sql        = ModeloArticulo::showGrupo();
                                  echo  '   <option value="0">[Seleccione una opción..]</option>';
                                    foreach ($sql as $value) {
                                    echo '<option value="'.$value["cve_gpo"].'">'.$value["nombre_gpo"].'</option>';
                                    }
                                ?>
                        </select>
                        <label>Grupo</label>
                    </div>
                     <div style="width: 50%;" class="form-floating mx-1">
                        <input type="text" id="inputdescripcionedit" name="inputdescripcionedit" class="form-control form-control-md UpperCase">
                        <label>Descripción</label>
                    </div>
                </div>
            </div>
            <div class="row form-group form-group-sm">
                <div class="col-lg-12 d-lg-flex">
                    <div style="width: 25%;" class="form-floating mx-1">
                        <input type="text" id="inputmaxedit" name="inputmaxedit" class="form-control form-control-md validanumericos">
                        <label>Maximo</label>
                    </div>
                    <div style="width: 23%;" class="form-floating mx-1">
                        <input type="text" id="inputminedit" name="inputminedit" class="form-control form-control-md validanumericos">
                        <label>Minimo</label>
                    </div>
                    <div style="width: 23%;" class="form-floating mx-1">
                        <input type="text" id="inputempaqueedit" name="inputempaqueedit" class="form-control form-control-md validanumericos">
                        <label>Empaque</label>
                    </div>
                     <!-- <div style="width: 50%;" class="form-floating mx-1">
                        <input type="text" id="inputobservacionedit" name="inputobservacionedit" class="form-control form-control-md UpperCase">
                        <label>Observaciones</label>
                    </div> -->
                </div>
            </div>
            <div class="row form-group form-group-sm">
                <div class="col-lg-12 d-lg-flex">
                    <div style="width: 25%;" class="form-floating mx-1">
                        <select class="form-control form-group-md" id="selectunidadmedidaedit" name="selectunidadmedidaedit">
                            <option selected="selected" value="0">[Seleccione una opción..]</option>
                            <option value="KG">KG</option>
                            <option value="LTS">LTS</option>
                            <option value="PZA">PZA</option>
                            <option value="SACO">SACO</option>
                        </select>
                        <label>Unidad de medida</label>
                    </div>
                     <div style="width: 25%;" class="form-floating mx-1">
                        <input type="text" id="inputseccionedit" name="inputseccionedit" class="form-control form-control-md UpperCase">
                        <label>Sección</label>
                    </div>
                    <div style="width: 25%;" class="form-floating mx-1">
                        <input type="text" id="inputcasilleroedit" name="inputcasilleroedit" class="form-control form-control-md UpperCase">
                        <label>Casillero</label>
                    </div>
                    <div style="width: 25%;" class="form-floating mx-1">
                        <input type="text" id="inputniveledit" name="inputniveledit" class="form-control form-control-md UpperCase">
                        <label>Nivel</label>
                    </div>
                </div>
            </div>
        <label hidden for="message-text" class="col-form-label">Usuario:</label>
        <span hidden id="spanusuario" name="spanusuario" class="form-control form-control-sm" style="background-color: #E9ECEF;"><?php echo $nombre." ".$apellido?></span>
      </div>
      <div class="modal-footer">
        <input type="button" value="Actualizar" onclick="editarArticulo()" class="btn btn-primary">
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
          <label for="message-text" class="col-form-label">¿Desea eliminar el siguiente Artículo?</label>
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
        <input type="button" value="Eliminar" onclick="eliminarArticulo()" class="btn btn-danger">
        <button type="button" class="btn btn-success" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>