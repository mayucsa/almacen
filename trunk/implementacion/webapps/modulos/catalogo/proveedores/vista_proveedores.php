<?php
    include_once "../../superior.php";
    include_once "../../../dbconexion/conexion.php";
    include_once "modelo_proveedores.php";
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

#resultado {
    background-color: red;
    color: white;
    font-weight: bold;
}

/*pre {
    display: block;
    font-family: monospace;
    white-space: pre;
    margin: 1em 0px;
}*/

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
          <h1><i class="fas fa-boxes"></i> Proveedores</h1>
          <!-- <p>Mayucsa / Mayamat</p> -->
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="vista_proveedores.php">Proveedores</a></li>
        </ul>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="card card-info">
                <div class="card-header">
                     <h3 class="card-title">CAPTURA DE DATOS</h3>
                     <div class="card-tools">
                         <button type="button" class="btn btn-tool" data-card-widget="collapse">
                             <i class="fas fa-minus"></i>
                         </button>
                     </div>
                </div>
                <div class="card-body">
                    <div class="row form-group form-group-sm">
                        <div class="col-lg-12 d-lg-flex">
                            <div style="width: 25%;" class="form-floating mx-1">
                                <input type="text" id="inputcodigo" name="inputcodigo" class="form-control form-control-md UpperCase">
                                <label>Código</label>
                            </div>
                            <div style="width: 25%;" class="form-floating mx-1">
                                <input type="text" id="inputnombre" name="inputnombre" class="form-control form-control-md UpperCase">
                                <label>Nombre de proveedor</label>
                            </div>
                            <div style="width: 25%;" class="form-floating mx-1">
                                <input type="text" id="inputrazonsocial" name="inputrazonsocial" class="form-control form-control-md UpperCase">
                                <label>Razón social</label>
                            </div>
                            <div style="width: 25%;" class="form-floating mx-1">
                                <input type="text" oninput="validarInput(this)" id="inputrfc" name="inputrfc" class="form-control form-control-md UpperCase">
                                <pre id="resultado"></pre>
                                <label>RFC</label>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group form-group-sm">
                        <div class="col-lg-12 d-lg-flex">
                            <div style="width: 50%;" class="form-floating mx-1">
                                <input type="text" id="inputdireccion" name="inputdireccion" class="form-control form-control-md UpperCase">
                                <label>Dirección</label>
                            </div>
                            <div style="width: 25%;" class="form-floating mx-1">
                                <input type="text" id="inputcolonia" name="inputcolonia" class="form-control form-control-md UpperCase">
                                <label>Colonia</label>
                            </div>
                            <div style="width: 25%;" class="form-floating mx-1">
                                <input type="text" id="inputcp" name="inputcp" class="form-control form-control-md validanumericos" maxlength="5">
                                <label>Código postal</label>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group form-group-sm">
                        <div class="col-lg-12 d-lg-flex">
<!--                             <div style="width: 25%;" class="form-floating mx-1">
                                <input type="text" id="inputcontacto" name="inputcontacto" class="form-control form-control-md UpperCase">
                                <label>Nombre de contacto</label>
                            </div>
                            <div style="width: 25%;" class="form-floating mx-1">
                                <input type="text" id="inputcorreo" name="inputcorreo" class="form-control form-control-md">
                                <label>Correo</label>
                            </div>
                            <div style="width: 25%;" class="form-floating mx-1">
                                <input type="text" id="inputtelefono" name="inputtelefono" class="form-control form-control-md validanumericos" minlength="10" maxlength="10">
                                <label>Teléfono</label>
                            </div> -->
                            <div style="width: 25%;" class="form-floating mx-1">
                                <input type="text" id="inputciudadestado" name="inputciudadestado" class="form-control form-control-md UpperCase">
                                <label>Ciudad, Estado</label>
                            </div>
                            <div style="width: 25%;" class="form-floating mx-1">
                                <input type="text" id="inputcredito" name="inputcredito" class="form-control form-control-md validanumericos" maxlength="2">
                                <label>Días de crédito</label>
                            </div>
                        </div>
                    </div>
                        <span hidden id="spanusuario" name="spanusuario" class="form-control form-control-sm" style="background-color: #E9ECEF;"><?php echo $nombre." ".$apellido?></span>
                    <div class="row form-group form-group-sm border-top">
                        <div class="col-sm-12" align="center">
                            <input type="submit" value="Guardar" href="#" onclick="validacionCampos()" class="btn btn-primary" style="margin-bottom: -25px !important">
                            <input type="submit" value="Limpiar" href="#" onclick="limpiarCampos()" class="btn btn-warning" style="margin-bottom: -25px !important">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">CRITERIOS DE BÚSQUEDA</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 d-lg-flex" style="display: flex; justify-content: flex-end">
                            <div style="width: 20%;" class="form-floating mx-1">
                                <input 
                                        type="text" 
                                        id="iptCodigo"
                                        class="form-control"
                                        data-index="0">
                                <label for="iptCodigo">Codigo</label>
                            </div>
                            <div style="width: 20%;" class="form-floating mx-1">
                                <input 
                                        type="text" 
                                        id="iptNombre"
                                        class="form-control"
                                        data-index="1">
                                <label for="iptNombre">Nombre</label>
                            </div>
                        </div>
                    </div>
                </div> <!-- ./ end card-body -->
            </div> <!-- ./ end card-info -->

            <div class="card card-info">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover w-100 shadow" id="tablaProvedores">
                            <thead>
                                <tr>
                                    <th class="text-center">Código</th>
                                    <th class="text-center">Nombre</th>
                                    <!-- <th class="text-center">Contacto</th> -->
                                    <!-- <th class="text-center">Teléfono</th> -->
                                    <!-- <th class="text-center">Email</th> -->
                                    <!-- <th class="text-center">Dias de crédito</th> -->
                                    <th class="text-center">Fecha de Alta</th>
                                    <th class="text-center">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <!-- <td></td> -->
                                    <!-- <td></td> -->
                                    <!-- <td></td> -->
                                    <!-- <td></td> -->
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
    </div> <!--FIN DE DIV ROW--->


        <?php include_once "../../footer.php" ?>

    </main>

<script src="../../../includes/js/adminlte.min.js"></script>

<script src="../../../includes/js/jquery351.min.js"></script>

<script src="vista_proveedores.js"></script>

<?php 
include_once "../../inferior.php";
include_once "modales.php";
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

    <script>
  
        function rfcValido(rfc, aceptarGenerico = true) {
            const re       = /^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/;
            var   validado = rfc.match(re);

            if (!validado)
                return false;

            //Separar el dígito verificador del resto del RFC
            const digitoVerificador = validado.pop(),
                  rfcSinDigito      = validado.slice(1).join(''),
                  len               = rfcSinDigito.length,

            //Obtener el digito esperado
                  diccionario       = "0123456789ABCDEFGHIJKLMN&OPQRSTUVWXYZ Ñ",
                  indice            = len + 1;
            var   suma,
                  digitoEsperado;

            if (len == 12) suma = 0
            else suma = 481; //Ajuste para persona moral

            for(var i=0; i<len; i++)
                suma += diccionario.indexOf(rfcSinDigito.charAt(i)) * (indice - i);
            digitoEsperado = 11 - suma % 11;
            if (digitoEsperado == 11) digitoEsperado = 0;
            else if (digitoEsperado == 10) digitoEsperado = "A";

            //El dígito verificador coincide con el esperado?
            // o es un RFC Genérico (ventas a público general)?
            if ((digitoVerificador != digitoEsperado)
             && (!aceptarGenerico || rfcSinDigito + digitoVerificador != "XAXX010101000"))
                return false;
            else if (!aceptarGenerico && rfcSinDigito + digitoVerificador == "XEXX010101000")
                return false;
            return rfcSinDigito + digitoVerificador;
        }


        //Handler para el evento cuando cambia el input
        // -Lleva la RFC a mayúsculas para validarlo
        // -Elimina los espacios que pueda tener antes o después
        function validarInput(input) {
            var rfc         = input.value.trim().toUpperCase(),
                resultado   = document.getElementById("resultado"),
                valido;
                
            var rfcCorrecto = rfcValido(rfc);   // ⬅️ Acá se comprueba
          
            if (rfcCorrecto) {
              valido = "RFC VÁLIDO";
              resultado.classList.add("ok");
            } else {
              valido = "RFC NO VÁLIDO"
              resultado.classList.remove("ok");
              // remover_rfc();
            }
                
            resultado.innerText = /*"RFC: " + rfc 
                                + "\nResultado: " + rfcCorrecto
                                + "Formato: " + */valido;
        }

        function remover_rfc(){
          var rfc = $("#inputrfc").fadeTo(7000, 1, function(){
            var rfc = $('#inputrfc').val('');
          });
        }

    </script>