function consultar(){
        var table;
        $(document).ready(function() {
        table = $('#tablaGrupos').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "servesideArticulos.php",
            "lengthMenu": [[30, 50, 100], [30, 50, 100]],
            "pageLength": 30,
            "order": [7, 'desc'],
            // "destroy": true,
            "searching": true,
            // bSort: false,
            // "paging": false,
            // "searching": false,
            "bDestroy": true,
            "columnDefs":[
                            {
                                "targets": [1, 2, 3, 4, 5, 6],
                                "className": 'dt-body-center' /*alineacion al centro th de tbody de la table*/
                            },
                            {
                                "targets": 8,
                                "render": function(data, type, row, meta){
                                    return row[9];
                                    // return  '<span class= "btn btn-info" onclick= "obtenerDatosS('+row[5]+')" title="Scanner" data-toggle="modal" data-target="#modalScanner" data-whatever="@getbootstrap"><i class="fas fa-barcode"></i> </span>' + ' ' +
                                            // '<span class= "btn btn-info" onclick= "obtenerDatosV('+row[5]+')" title="Ver" data-toggle="modal" data-target="#modalVer" data-whatever="@getbootstrap"><i class="fas fa-eye"></i> </span>' + ' ' +
                                            // '<span class= "btn btn-warning" onclick= "obtenerDatos('+row[5]+')" title="Editar" data-toggle="modal" data-target="#modalEditar" data-whatever="@getbootstrap"><i class="fas fa-edit"></i> </span>' + ' ' +
                                            // '<span class= "btn btn-danger" onclick= "obtenerDatosE('+row[5]+')" title="Eliminar" data-toggle="modal" data-target="#modalEliminar" data-whatever="@getbootstrap"><i class="fas fa-trash-alt"></i> </span>';
                                }
                                // "data": null,
                                // "defaultContent": '<span class= "btn btn-warning" onclick= "obtenerDatos(".$value["cve_entrada"].")" data-toggle="modal" data-target="#modalMatPrimaUpdate" data-whatever="@getbootstrap"><i class="fas fa-edit"></i> </span>'
                            }
                        ],

         "language": {
            "buttons": {
                        "pageLength": {
                            '_': "Mostrar %d registros por página.",
                        }
                    },
             "lengthMenu": "Mostrar _MENU_ registros por página.",
             "zeroRecords": "No se encontró registro.",
             "info": "  _START_ de _END_ (_TOTAL_ registros totales).",
             "infoEmpty": "0 de 0 de 0 registros",
             "infoFiltered": "(Encontrado de _MAX_ registros)",
             "search": "Buscar: ",
             "processing": "Procesando...",
                      "paginate": {
                 "first": "Primero",
                 "previous": "Anterior",
                 "next": "Siguiente",
                 "last": "Último"
             }

         }

            } );
        } );

        /*===================================================================*/
        // EVENTOS PARA CRITERIOS DE BUSQUEDA (PRODUCTO Y PRESENTACIÓN)
        /*===================================================================*/

        $("#iptNombre").keyup(function(){
            table.column($(this).data('index')).search(this.value).draw();
            })
}
function imprSelec(id) {
    var div = document.getElementById(id);
    var ventimp = window.open(' ', 'popimpr');
    ventimp.document.write( div.innerHTML );
    ventimp.document.close();
    ventimp.print( );
    ventimp.close();
}
function obtenerDatosS(cve_articulo) {
    $('#modalBarCode').html(''); 
    $.getJSON("modelo_articulo.php?consultar="+cve_articulo, function(registros){
        // console.log('cve_alterna', registros[0]['cve_alterna']);
        if (registros[0]['cve_alterna'].indexOf("Ñ") >= 0 || registros[0]['cve_alterna'].indexOf("ñ") >= 0) {
            // En caso de que el código contenga la letra eñe se cerrará el modal y se avisará al usuario
            $('#modalScanner').modal('hide');
            $('.modal-backdrop').hide();
            Swal.fire({
                title: 'Código incorrecto',
                text: 'Favor de contactar al administrador.',
                icon: 'warning',
                showConfirmButton: true
            });
            return;
        }
        const imgBarCode = '<img class="codigo" id="imgcodigo" />';
        $('#modalBarCode').html(imgBarCode); 
        // actualizar el data-value de la imagen
        JsBarcode("#imgcodigo", registros[0]['cve_alterna']);
    });
}

function obtenerDatosV(cve_articulo) {
    $.getJSON("modelo_articulo.php?consultar="+cve_articulo, function(registros){
        // console.log(registros);

        $('#inputnombreartver').val(registros[0]['nombre_articulo']);
        // $('#inputexistenciaver').val(registros[0]['existencia']);
        $('#inputdescripart').val(registros[0]['descripcion']);
        $('#inputobservaart').val(registros[0]['observaciones']);
        $('#inputpreciover').val(registros[0]['precio_unitario']);
        $('#inputcostover').val(registros[0]['costo_promedio']);
    });
}

function obtenerDatos(cve_articulo) {
    $.getJSON("modelo_articulo.php?consultar="+cve_articulo, function(registros){
        // console.log(registros);

        $('#inputid').val(registros[0]['cve_articulo']);
        // $('#inputcodartedit').val(registros[0]['cve_alterna']);
        $('#inputnombreartedit').val(registros[0]['nombre_articulo']);
        // $('#inputnombrelargeedit').val(registros[0]['nombre_articulo_largo']);
        $('#selectcategoriaedit').val(registros[0]['cve_ctg']);
        $('#selectgrupoedit').val(registros[0]['cve_grupo']);
        $('#inputdescripcionedit').val(registros[0]['descripcion']);
        $('#selectunidadmedidaedit').val(registros[0]['unidad_medida']);
        $('#inputseccionedit').val(registros[0]['seccion']);
        $('#inputcasilleroedit').val(registros[0]['casillero']);
        $('#inputniveledit').val(registros[0]['nivel']);
        $('#inputmaxedit').val(registros[0]['max']);
        $('#inputminedit').val(registros[0]['min']);
        $('#inputobservacionedit').val(registros[0]['observaciones']);
        $('#inputempaqueedit').val(registros[0]['empaque']);
        // $('#inputptoreordenedit').val(registros[0]['punto_reorden']);
    });
}

function obtenerDatosE(cve_articulo) {
    $.getJSON("modelo_articulo.php?consultar="+cve_articulo, function(registros){
        // console.log(registros);

        $('#inputidel').val(registros[0]['cve_articulo']);
        $('#inputcodigodel').val(registros[0]['cve_alterna']);
        $('#inputnombredel').val(registros[0]['nombre_articulo']);
    });
}

function limpiarCampos(){
    $('#inputcodart').val("");
    $('#inputnombreart').val("");
    // $('#inputnombrelarge').val("");
    $('#selectgrupo').val(0);
    $('#selectcategoria').val(0);
    $('#inputdescripcion').val("");
    $('#inputobservacion').val("");
    $('#selectunidadmedida').val(0);
    $('#inputseccion').val("");
    $('#inputcasillero').val("");
    $('#inputnivel').val("");
    $('#inputmax').val("");
    $('#inputmin').val("");
    $('#inputempaque').val("");
}

function validacionCampos() {
    var codigo          = $('#inputcodart').val();
    var nombre          = $('#inputnombreart').val();
    // var nombrelargo     = $('#inputnombrelarge').val();
    var categoria       = $('#selectcategoria').val();
    var grupo           = $('#selectgrupo').val();
    var descripcion     = $('#inputdescripcion').val();
    var observacion     = $('#inputobservacion').val();
    var unidadmedida    = $('#selectunidadmedida').val();
    var seccion         = $('#inputseccion').val();
    // var casillero       = $('#inputcasillero').val();
    // var nivel           = $('#inputnivel').val();
    var max             = $('#inputmax').val();
    var min             = $('#inputmin').val();
    var empaque         = $('#inputempaque').val();
    var msj = "";
  
    if (codigo == "") {
        msj += '<li>Código de articulo</li>';
    }
    if (nombre == "") {
        msj += '<li>Nombre de artículo</li>';
    }
    // if (nombrelargo == "") {
    //     msj += '<li>Nombre de artículo - Largo</li>';
    // }
    if (categoria == 0) {
        msj += '<li>Categoría</li>';
    }
    if (grupo == 0) {
        msj += '<li>Grupo</li>';
    }
    if (descripcion == "") {
        msj += '<li>Descripción</li>';
    }
    if (max == "") {
        msj += '<li>Maximo</li>';
    }
    if (min == "") {
        msj += '<li>Minimo</li>';
    }
    if (observacion == "") {
        msj += '<li>Observación</li>';
    }
    if (unidadmedida == 0) {
        msj += '<li>Unidad de medida</li>';
    }
    if (seccion == "") {
        msj += '<li>Sección</li>';
    }
    // if (casillero == "") {
    //     msj += '<li>Casillero</li>';
    // }
    // if (nivel == "") {
    //     msj += '<li>Nivel</li>';
    // }
    if (empaque == "") {
        msj += '<li>Empaque</li>';
    }
    if (msj.length != 0) {
        $('#encabezadoModal').html('Validación de datos');
        $('#cuerpoModal').html('Los siguientes campos son obligatorios:<ul>'+msj+'</ul>');
        $('#modalMensajes').modal('toggle');

    } else{
        existenciaCod();
    }
}

function existenciaCod(){
    var codigoart = $('#inputcodart').val();
    var msj = "";

    var datos   = new FormData();

    datos.append('codigoart', $('#inputcodart').val());

        $.ajax({
                type:"POST",
                url:"modelo_articulo.php?accion=verificar&codigoart=" + codigoart,
                data: codigoart,
                processData:false,
                contentType:false,
        success:function(data){
                    if (data == 'correcto') {
                        Swal.fire({
                                        icon: 'warning',
                                        title: '¡Error!',
                                        text: 'El código de articulo esta vigente',
                                        // footer: 'Favor de ingresar un código nuevo',
                                        confirmButtonColor: '#1A4672'
                                    })
                    }else{
                        insertCaptura();
                        }
                    }
            })
}

function existenciaCodigo(){
    var codigoart = $('#inputcodart').val();
    var msj = "";

    var datos   = new FormData();

    datos.append('codigoart', $('#inputcodart').val());

        $.ajax({
                type:"POST",
                url:"modelo_articulo.php?accion=verificar&codigoart=" + codigoart,
                data: codigoart,
                processData:false,
                contentType:false,
        success:function(data){
                    if (data == 'correcto') {
                        Swal.fire({
                                        icon: 'warning',
                                        title: '¡Error!',
                                        text: 'El código de articulo esta vigente',
                                        // footer: 'Favor de ingresar un código nuevo',
                                        confirmButtonColor: '#1A4672'
                                    })
                    }
                    // else{
                    //     insertCaptura();
                    //     }
                    }
            })
}

function insertCaptura(){
    var datos   = new FormData();
    // var codigo          = $('#inputcodart').val();
    // var nombre          = $('#inputnombreart').val();
    // var nombrelargo     = $('#inputnombrelarge').val();
    // var categoria       = $('#selectcategoria').val();
    // var grupo           = $('#selectgrupo').val();
    // var descripcion     = $('#inputdescripcion').val();
    // var observacion     = $('#inputobservacion').val();
    // var unidadmedida    = $('#selectunidadmedida').val();
    // var precio    = [0];
    // var costo    = [0];
    // var existencia    = [0];
    // var seccion         = $('#inputseccion').val();
    // var casillero       = $('#inputcasillero').val();
    // var nivel           = $('#inputnivel').val();
    // var max             = $('#inputmax').val();
    // var min             = $('#inputmin').val();
    // var reorden         = $('#inputptoreorden').val();

    datos.append('codigo',          $('#inputcodart').val());
    datos.append('nombre',          $('#inputnombreart').val());
    // datos.append('nombrelargo',     $('#inputnombrelarge').val());
    datos.append('categoria',       $('#selectcategoria').val());
    datos.append('grupo',           $('#selectgrupo').val());
    datos.append('descripcion',     $('#inputdescripcion').val());
    datos.append('observacion',     $('#inputobservacion').val());
    datos.append('unidadmedida',    $('#selectunidadmedida').val());
    datos.append('precio',       0);
    datos.append('costo',        0);
    datos.append('existencia',   0);
    datos.append('seccion',         $('#inputseccion').val());
    datos.append('casillero',    0);
    // datos.append('casillero',       $('#inputcasillero').val());
    datos.append('nivel',        0);
    // datos.append('nivel',           $('#inputnivel').val());
    datos.append('max',             $('#inputmax').val());
    datos.append('min',             $('#inputmin').val());
    datos.append('empaque',         $('#inputempaque').val());
    datos.append('usuario',         $('#spanusuario').text());

    // console.log(datos.get('codigo'));
    // console.log(datos.get('nombre'));
    // console.log(datos.get('nombrelargo'));
    // console.log(datos.get('categoria'));
    // console.log(datos.get('grupo'));
    // console.log(datos.get('descripcion'));
    // console.log(datos.get('unidadmedida'));
    // console.log(datos.get('precio'));
    // console.log(datos.get('costo'));
    // console.log(datos.get('existencia'));
    // console.log(datos.get('seccion'));
    // console.log(datos.get('casillero'));
    // console.log(datos.get('nivel'));
    // console.log(datos.get('max'));
    // console.log(datos.get('min'));

    // console.log(datos.get('usuario'));
    // grupo.charAt(0).toUpperCase();

    Swal.fire({
                title: '¿Deseas crear un artículo?',
                html:   'Código: <b>' +  datos.get('codigo') +
                        '</b><br> Artículo: <b>' +  datos.get('nombre'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Agregar',
    }).then((result) => {

    if (result.isConfirmed) {    
        jsShowWindowLoad('Creando articulo...');
        $.ajax({
                type:"POST",
                url:"modelo_articulo.php?accion=insertar",
                data: datos,
                processData:false,
                contentType:false,
        success:function(data){
                    consultar();
                    limpiarCampos();
                    jsRemoveWindowLoad();
                    Swal.fire(
                                '¡Agregado!',
                                'Se ha agregado un artículo nuevo !!',
                                'success'
                            )
                    }

            })
        }
    });
    // }
}

function cerrarModalEditar(){
    $('#modalEditar').modal('hide');
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
}

function cerrarModalEliminar(){
    $('#modalEliminar').modal('hide');
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
}

function sinacceso(){

    Swal.fire({
        // confirmButtonColor: '#3085d6',
        title: 'Usuario Sin Privilegios',
        html: 'Pongase en contacto con el Administrador',
        confirmButtonColor: '#1A4672'
        });
}

function editarArticulo(){
    // var ecodart         = $('#inputcodartedit').val();
    var enombre         = $('#inputnombreartedit').val();
    // var enombrelargo    = $('#inputnombrelargeedit').val(); 
    var ecategoria      = $('#selectcategoriaedit').val();
    var egrupo          = $('#selectgrupoedit').val(); 
    var edescripcion    = $('#inputdescripcionedit').val();
    var eobservacion    = $('#inputobservacionedit').val();
    var eunidadmedida   = $('#selectunidadmedidaedit').val();
    var eseccion        = $('#inputseccionedit').val();
    // var ecasillero      = $('#inputcasilleroedit').val();
    // var enivel          = $('#inputniveledit').val();
    var emax            = $('#inputmaxedit').val();
    var emix            = $('#inputminedit').val();
    var empaque         = $('#inputempaqueedit').val();
    // var epuntoreorden   = $('#inputptoreordenedit').val();

    var msj = "";
   
    if (enombre == "") {
        // console.log(cantidad);
        msj += 'Nombre de artículo <br>';
    }
    if (ecategoria == 0) {
        // console.log(cantidad);
        msj += 'Categoría <br>';
    }
    if (egrupo == 0) {
        // console.log(cantidad);
        msj += 'Grupo <br>';
    }
    if (edescripcion == "") {
        // console.log(cantidad);
        msj += 'Descripción <br>';
    }
    if (emax == "") {
        // console.log(cantidad);
        msj += 'Maximo <br>';
    }
    if (emix == "") {
        // console.log(cantidad);
        msj += 'Minimo <br>';
    }
    if (eobservacion == "") {
        // console.log(cantidad);
        msj += 'Observación <br>';
    }
    if (eunidadmedida == 0) {
        // console.log(cantidad);
        msj += 'Unidad de medida <br>';
    }
    if (eseccion == "") {
        // console.log(cantidad);
        msj += 'Sección <br>';
    }
    // if (ecasillero == "") {
    //     // console.log(cantidad);
    //     msj += 'Casillero <br>';
    // }
    // if (enivel == "") {
    //     // console.log(cantidad);
    //     msj += 'Nivel <br>';
    // }
    if (empaque == "") {
        // console.log(cantidad);
        msj += 'Punto de reorden <br>';
    }
    // if (epuntoreorden == "") {
    //     // console.log(cantidad);
    //     msj += 'Punto de reorden <br>';
    // }

    if (msj.length != 0) {
        Swal.fire({
                title: 'Los siguientes campos son obligatorios:',
                html: msj,
                icon: 'warning',
                iconColor: '#d33',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ok!'
                }).then((result) => {
                if (result.isConfirmed) {
                    // Swal.fire(
                    // 'Deleted!',
                    // 'Your file has been deleted.',
                    // 'success'
                    // )
                }
                });
    } else{
    var datos   = new FormData();
    datos.append('cve_articulo',            $('#inputid').val());
    datos.append('nombre_articulo',         $('#inputnombreartedit').val());
    // datos.append('nombre_articulo_largo',   $('#inputnombrelargeedit').val());
    datos.append('categoria',               $('#selectcategoriaedit').val());
    datos.append('grupo',                   $('#selectgrupoedit').val());
    datos.append('descripcion',             $('#inputdescripcionedit').val());
    datos.append('observacion',             $('#inputobservacionedit').val());
    datos.append('unidadmedida',            $('#selectunidadmedidaedit').val());
    datos.append('seccion',                 $('#inputseccionedit').val());
    datos.append('casillero',               $('#inputcasilleroedit').val());
    datos.append('nivel',                   $('#inputniveledit').val());
    datos.append('max',                     $('#inputmaxedit').val());
    datos.append('min',                     $('#inputminedit').val());
    datos.append('empaque',                 $('#inputempaqueedit').val());

    datos.append('usuario',                 $('#spanusuario').text());

    // console.log(datos.get('cve_articulo'));
    // console.log(datos.get('nombre_articulo'));
    // console.log(datos.get('observacion'));
    // console.log(datos.get('categoria'));
    // console.log(datos.get('grupo'));
    // console.log(datos.get('descripcion'));
    // console.log(datos.get('max'));
    // console.log(datos.get('min'));
    // console.log(datos.get('reorden'));
    // console.log(datos.get('unidadmedida'));
    // console.log(datos.get('seccion'));
    // console.log(datos.get('casillero'));
    // console.log(datos.get('nivel'));
    // console.log(datos.get('usuario'));

        Swal.fire({
                title: '¿Desea editar el Articulo?',
                html: 'Nombre: <b>' + datos.get('nombre_articulo'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
    }).then((result) => {

    if (result.isConfirmed) {
        jsShowWindowLoad('Editando articulo...');
        $.ajax({
                type:"POST",
                url:"modelo_articulo.php?actualizar=1",
                data: datos,
                processData:false,
                contentType:false,
        success:function(r){
            // console.log(r);
            jsRemoveWindowLoad();
            consultar();
            cerrarModalEditar();
                    Swal.fire(
                                '¡Modificación!',
                                'Se ha cambiado los datos del Articulo !!',
                                'success'
                            )
            
        }
    })
        } else if (
    /* Read more about handling dismissals below */
    result.dismiss === Swal.DismissReason.cancel
  ) {
    // Swal.fire(
    //   '¡Entrada Cancelada!',
    //   'El registro de entrada de Quimico no fue registrado',
    //   'error'
    // )
  }
    });
    }
}

function eliminarArticulo(){
    var articulo = $('#inputnombredel').val();
    var msj = "";
   
    if (articulo == "") {
        // console.log(cantidad);
        msj += 'Articulo <br>';
    }

    if (msj.length != 0) {
        Swal.fire({
                title: 'Los siguientes campos son obligatorios:',
                html: msj,
                icon: 'warning',
                iconColor: '#d33',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ok!'
                }).then((result) => {
                if (result.isConfirmed) {
                    // Swal.fire(
                    // 'Deleted!',
                    // 'Your file has been deleted.',
                    // 'success'
                    // )
                }
                });
    } else{
    var datos   = new FormData();
    datos.append('cve_articuloe', $('#inputidel').val());
    datos.append('articulo', $('#inputnombredel').val());
    datos.append('usuarioe', $('#spanusuarioe').text());
    // console.log(datos.get('cve_articuloe'));
    // console.log(datos.get('articulo'));
    // console.log(datos.get('usuarioe'));
        Swal.fire({
                title: '¿Estas seguro de eliminar el Artículo?',
                html: 'Nombre: <b>' + datos.get('articulo'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
    }).then((result) => {

    if (result.isConfirmed) {
        jsShowWindowLoad('Eliminando articulo...');
        $.ajax({
                type:"POST",
                url:"modelo_articulo.php?eliminar=1",
                data: datos,
                processData:false,
                contentType:false,
        success:function(r){
            // console.log(r);
            jsRemoveWindowLoad();
            consultar();
            cerrarModalEliminar();
            
                    Swal.fire(
                                '¡Eliminación!',
                                'Se ha elimnado el Articulo !!',
                                'success'
                            )
            
        }
    })
        } else if (
    /* Read more about handling dismissals below */
    result.dismiss === Swal.DismissReason.cancel
  ) {
    // Swal.fire(
    //   '¡Entrada Cancelada!',
    //   'El registro de entrada de Quimico no fue registrado',
    //   'error'
    // )
  }
    });
    }
}
app.controller('vistaArticulosCtrl', function(BASEURL, ID, $scope, $http){

})
