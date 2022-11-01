function consultar(){
        var table;
        $(document).ready(function() {
        table = $('#tablaProvedores').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "serversideProveedores.php",
            "lengthMenu": [[30, 50, 100], [30, 50, 100]],
            "pageLength": 30,
            "order": [2, 'desc'],
            // "destroy": true,
            "searching": true,
            // bSort: false,
            // "paging": false,
            // "searching": false,
            "bDestroy": true,
            "columnDefs":[
                            {
                                "targets": [1, 2, 3],
                                "className": 'dt-body-center' /*alineacion al centro th de tbody de la table*/
                            },
                            {
                                "targets": 3,
                                "render": function(data, type, row, meta){
                                    // const primaryKey = data;
                                    // "data": 'cve_entrada',
                                    return  '<span class= "btn btn-success" onclick= "obtenerDatosA('+row[3]+')" title="Agregar contactos" data-toggle="modal" data-target="#modalAgregaContacto" data-whatever="@getbootstrap"><i class="fas fa-user-plus"></i> </span>' + ' ' +
                                            '<span class= "btn btn-success" onclick= "obtenerDatosVContactos('+row[3]+')" title="Ver contactos" data-toggle="modal" data-target="#modalVerContacto" data-whatever="@getbootstrap"><i class="fas fa-list-alt"></i> </span>' + ' ' +
                                            '<span class= "btn btn-info" onclick= "obtenerDatosV('+row[3]+')" title="Ver datos de proveedor" data-toggle="modal" data-target="#modalVer" data-whatever="@getbootstrap"><i class="fas fa-eye"></i> </span>' + ' ' +
                                            '<span class= "btn btn-warning" onclick= "obtenerDatos('+row[3]+')" title="Editar" data-toggle="modal" data-target="#modalEditar" data-whatever="@getbootstrap"><i class="fas fa-edit"></i> </span>' + ' ' + 
                                            '<span class= "btn btn-danger" onclick= "obtenerDatosE('+row[3]+')" title="Eliminar" data-toggle="modal" data-target="#modalEliminar" data-whatever="@getbootstrap"><i class="fas fa-trash-alt"></i> </span>';
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

        $("#iptCodigo").keyup(function(){
            table.column($(this).data('index')).search(this.value).draw();
            })
        $("#iptNombre").keyup(function(){
            table.column($(this).data('index')).search(this.value).draw();
            })
}

function obtenerDatosA(cve_proveedor) {
    $.getJSON("modelo_proveedores.php?consultar="+cve_proveedor, function(registros){
        // console.log(registros);

        $('#inputprov').val(registros[0]['cve_proveedor']);
        $('#inputnameprov').val(registros[0]['nombre_proveedor']);

    });
}

function obtenerDatosV(cve_proveedor) {
    $.getJSON("modelo_proveedores.php?consultar="+cve_proveedor, function(registros){
        // console.log(registros);

        $('#inputnombreprovv').val(registros[0]['nombre_proveedor']);
        $('#inputrazonsocialver').val(registros[0]['razon_social']);
        $('#inputrfcver').val(registros[0]['rfc']);
        $('#inputdireccionver').val(registros[0]['direccion']);
        $('#inputcoloniaver').val(registros[0]['colonia']);
        $('#inputcpver').val(registros[0]['colonia']);
        $('#inputcdestadover').val(registros[0]['ciudad_estado']);
        // $('#inputcontactover').val(registros[0]['nombre_contacto']);
        // $('#inputcorreover').val(registros[0]['correo']);
        // $('#inputtelver').val(registros[0]['telefono']);
        $('#inputcrediver').val(registros[0]['dias_credito']);
    });
}

function obtenerDatos(cve_proveedor) {
    $.getJSON("modelo_proveedores.php?consultar="+cve_proveedor, function(registros){
        // console.log(registros);

        $('#inputid').val(registros[0]['cve_proveedor']);
        $('#inputnombreprov').val(registros[0]['nombre_proveedor']);
        $('#inputrazonsocialedit').val(registros[0]['razon_social']);
        $('#inputrfcedit').val(registros[0]['rfc']);
        $('#inputdireccionedit').val(registros[0]['direccion']);
        $('#inputcoloniaedit').val(registros[0]['colonia']);
        $('#inputcpedit').val(registros[0]['cp']);
        $('#inputcdestadoedit').val(registros[0]['ciudad_estado']);
        // $('#inputcontactoedit').val(registros[0]['nombre_contacto']);
        // $('#inputcorreoedit').val(registros[0]['correo']);
        // $('#inputteledit').val(registros[0]['telefono']);
        $('#inputcreditoedit').val(registros[0]['dias_credito']);

    });
}

function obtenerDatosE(cve_proveedor) {
    $.getJSON("modelo_proveedores.php?consultar="+cve_proveedor, function(registros){
        // console.log(registros);

        $('#inputidel').val(registros[0]['cve_proveedor']);
        $('#inputcodigodel').val(registros[0]['cve_alterna']);
        $('#inputnombredel').val(registros[0]['nombre_proveedor']);
    });
}

function obtenerDatosVContactos(cve_proveedor) {
    $.getJSON("modelo_proveedores.php?consultarcontacto="+cve_proveedor, function(registros){
        // console.log(registros);

        $('#inputname').val(registros[0]['Proveedor']);

        $("#tablaModal").html( '<thead> <tr>  <th class="text-center">Nombre de contacto</th>' +
                                                '<th class="text-center">Correo</th>'+
                                                '<th class="text-center">Télefono</th></tr>'+
                                    '</thead>');
    for (i = 0; i < registros.length; i++){
         $("#tablaModal").append('<tr>' + 
            '<td style="dislay: none;">' + registros[i].Contacto + '</td>'+
            '<td style="dislay: none;">' + registros[i].Correo + '</td>'+
            '<td align="center" style="dislay: none;">' + registros[i].Telefono + '</td>'+'</tr>');
    }

    });
}

function limpiarCampos(){
    $('#inputcodigo').val("");
    $('#inputnombre').val("");
    $('#inputrazonsocial').val("");
    $('#inputrfc').val("");
    $('#inputdireccion').val("");
    $('#inputcolonia').val("");
    $('#inputcp').val("");
    $('#inputciudadestado').val("");
    // $('#inputcontacto').val("");
    // $('#inputcorreo').val("");
    // $('#inputtelefono').val("");
    $('#inputcredito').val("");
}

function limpiarCamposModalContacto(){
    $('#inputcontacto').val("");
    $('#inputcorreo').val("");
    $('#inputtel').val("");

}

function validacionCampos() {
    var codigo          = $('#inputcodigo').val();
    var nombre          = $('#inputnombre').val();
    var razonsocial     = $('#inputrazonsocial').val();
    var rfc             = $('#inputrfc').val();
    var direccion       = $('#inputdireccion').val();
    var colonia         = $('#inputcolonia').val();
    var cdestado        = $('#inputciudadestado').val();
    var codpostal        = $('#inputcp').val();
    // var contacto        = $('#inputcontacto').val();
    // var correo          = $('#inputcorreo').val();
    // var telefono        = $('#inputtelefono').val();
    var credito         = $('#inputcredito').val();
    var msj = "";
  
    if (codigo == "") {
        msj += '<li>Código</li>';
    }
    if (nombre == "") {
        msj += '<li>Nombre de proveedor</li>';
    }
    if (razonsocial == "") {
        msj += '<li>Razón social</li>';
    }
    if (rfc == 0) {
        msj += '<li>RFC</li>';
    }
    if (direccion == 0) {
        msj += '<li>Dirección</li>';
    }
    if (colonia == "") {
        msj += '<li>Colonia</li>';
    }
    if (codpostal == "") {
        msj += '<li>Código postal</li>';
    }
    if (cdestado == 0) {
        msj += '<li>Ciudad y Estado</li>';
    }
    // if (contacto == "") {
    //     msj += '<li>Nombre de contacto</li>';
    // }
    // if (correo == "") {
    //     msj += '<li>Correo</li>';
    // }
    // if (telefono == "") {
    //     msj += '<li>Teléfono</li>';
    // }
    if (credito == "") {
        msj += '<li>Días de crédito</li>';
    }
    if (msj.length != 0) {
        $('#encabezadoModal').html('Validación de datos');
        $('#cuerpoModal').html('Los siguientes campos son obligatorios:<ul>'+msj+'</ul>');
        $('#modalMensajes').modal('toggle');

    } else{
        existenciaCodigo();
    }
}

function existenciaCodigo(){
    var codigoprov = $('#inputcodigo').val();
    var msj = "";

    var datos   = new FormData();

    datos.append('codigoprov', $('#inputcodigo').val());

        $.ajax({
                type:"POST",
                url:"modelo_proveedores.php?accion=verificar&codigoprov=" + codigoprov,
                data: codigoprov,
                processData:false,
                contentType:false,
        success:function(data){
                    if (data == 'correcto') {
                        Swal.fire({
                                        icon: 'warning',
                                        title: '¡Error!',
                                        text: 'El código del Proveedor ya existe',
                                        // footer: 'Favor de ingresar un código nuevo',
                                        confirmButtonColor: '#1A4672'
                                    })
                    }else{
                        existenciaRFC();
                        }
                    }
            })
}

function existenciaRFC(){
    var rfc = $('#inputrfc').val();
    var msj = "";

    var datos   = new FormData();

    datos.append('rfc', $('#inputrfc').val());

        $.ajax({
                type:"POST",
                url:"modelo_proveedores.php?accion=verificarrfc&rfc=" + rfc,
                data: rfc,
                processData:false,
                contentType:false,
        success:function(data){
                    if (data == 'correcto') {
                        Swal.fire({
                                        icon: 'warning',
                                        title: '¡Error!',
                                        text: 'El RFC del Proveedor ya existe',
                                        // footer: 'Favor de ingresar un código nuevo',
                                        confirmButtonColor: '#1A4672'
                                    })
                    }else{
                        insertCaptura();
                        }
                    }
            })
}

function insertCaptura(){
    var datos   = new FormData();
    var codigo          = $('#inputcodigo').val();
    var nombre          = $('#inputnombre').val();
    var razonsocial     = $('#inputrazonsocial').val();
    var rfc             = $('#inputrfc').val();
    var direccion       = $('#inputdireccion').val();
    var colonia         = $('#inputcolonia').val();
    var codpostal       = $('#inputcp').val();
    var cdestado        = $('#inputciudadestado').val();
    // var contacto        = $('#inputcontacto').val();
    // var correo          = $('#inputcorreo').val();
    // var telefono        = $('#inputtelefono').val();
    var credito         = $('#inputcredito').val();

    datos.append('codigo',          $('#inputcodigo').val());
    datos.append('nombre',          $('#inputnombre').val());
    datos.append('razonsocial',     $('#inputrazonsocial').val());
    datos.append('rfc',             $('#inputrfc').val());
    datos.append('direccion',       $('#inputdireccion').val());
    datos.append('colonia',         $('#inputcolonia').val());
    datos.append('codpostal',         $('#inputcp').val());
    datos.append('cdestado',        $('#inputciudadestado').val());
    // datos.append('contacto',        $('#inputcontacto').val());
    // datos.append('correo',          $('#inputcorreo').val());
    // datos.append('telefono',        $('#inputtelefono').val());
    datos.append('credito',         $('#inputcredito').val());
    datos.append('usuario',         $('#spanusuario').text());

    console.log(datos.get('codigo'));
    console.log(datos.get('nombre'));
    console.log(datos.get('razonsocial'));
    console.log(datos.get('rfc'));
    console.log(datos.get('direccion'));
    console.log(datos.get('colonia'));
    console.log(datos.get('codpostal'));
    console.log(datos.get('cdestado'));
    // console.log(datos.get('contacto'));
    // console.log(datos.get('correo'));
    // console.log(datos.get('telefono'));
    console.log(datos.get('credito'));

    console.log(datos.get('usuario'));

    Swal.fire({
                title: '¿Deseas agregar un proveedor?',
                html:   'Nombre: <b>' +  datos.get('nombre'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Agregar',
    }).then((result) => {

    if (result.isConfirmed) {    

        $.ajax({
                type:"POST",
                url:"modelo_proveedores.php?accion=insertar",
                data: datos,
                processData:false,
                contentType:false,
        success:function(data){
                    consultar();
                    limpiarCampos();
                    Swal.fire(
                                '¡Agregado!',
                                'Se ha agregado un proveedor nuevo !!',
                                'success'
                            )
                    }

            })
        }
    });
    // }
}

function cerrarModalEliminar(){
    $('#modalEliminar').modal('hide');
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
}

function cerrarModalEditar(){
    $('#modalEditar').modal('hide');
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
}

function cerrarModalAgregar(){
    $('#modalAgregaContacto').modal('hide');
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
}

function editarProveedor(){
    // var ecodart         = $('#inputcodartedit').val();
    var enombreprov     = $('#inputnombreprov').val();
    var erazonsocial    = $('#inputrazonsocialedit').val();  
    var erfc            = $('#inputrfcedit').val();
    var edireccion      = $('#inputdireccionedit').val(); 
    var ecolonia        = $('#inputcoloniaedit').val();
    var ecp             = $('#inputcpedit').val();
    var ecdestado       = $('#inputcdestadoedit').val();
    // var econtacto       = $('#inputcontactoedit').val();
    // var ecorreo         = $('#inputcorreoedit').val();
    // var etelefono       = $('#inputteledit').val();
    var ecredito        = $('#inputcreditoedit').val();

    var msj = "";
   
    if (enombreprov == "") {
        // console.log(cantidad);
        msj += 'Nombre de proveedor <br>';
    }
    if (erazonsocial == "") {
        // console.log(cantidad);
        msj += 'Razón social <br>';
    }
    if (erfc == "") {
        // console.log(cantidad);
        msj += 'RFC <br>';
    }
    if (edireccion == "") {
        // console.log(cantidad);
        msj += 'Dirección <br>';
    }
    if (ecolonia == "") {
        // console.log(cantidad);
        msj += 'Colonia <br>';
    }
    if (ecp == "") {
        // console.log(cantidad);
        msj += 'Código postal <br>';
    }
    if (ecdestado == "") {
        // console.log(cantidad);
        msj += 'Ciudad, Estado <br>';
    }
    if (ecredito == "") {
        // console.log(cantidad);
        msj += 'Días de crédito <br>';
    }

    if (msj.length != 0) {
        Swal.fire({
                title: 'Los siguientes campos son obligatorios:',
                html: '<ul>'+msj+'</ul>',
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
    datos.append('cve_proveedor',            $('#inputid').val());
    datos.append('enombreprov',         $('#inputnombreprov').val());
    datos.append('erazonsocial',   $('#inputrazonsocialedit').val());
    datos.append('erfc',               $('#inputrfcedit').val());
    datos.append('edireccion',                   $('#inputdireccionedit').val());
    datos.append('ecolonia',             $('#inputcoloniaedit').val());
    datos.append('ecp',             $('#inputcpedit').val());
    datos.append('ecdestado',            $('#inputcdestadoedit').val());
    datos.append('ecredito',                     $('#inputcreditoedit').val());

    datos.append('usuario',                 $('#spanusuario').text());

    console.log(datos.get('cve_proveedor'));
    console.log(datos.get('enombreprov'));
    console.log(datos.get('erazonsocial'));
    console.log(datos.get('erfc'));
    console.log(datos.get('edireccion'));
    console.log(datos.get('ecolonia'));
    console.log(datos.get('ecp'));
    console.log(datos.get('ecdestado'));
    console.log(datos.get('ecredito'));
    console.log(datos.get('usuario'));

        Swal.fire({
                title: '¿Desea editar los datos del Proveedor?',
                html: 'Nombre: <b>' + datos.get('enombreprov'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
    }).then((result) => {

    if (result.isConfirmed) {
        $.ajax({
                type:"POST",
                url:"modelo_proveedores.php?actualizar=1",
                data: datos,
                processData:false,
                contentType:false,
        success:function(r){
            // console.log(r);
            consultar();
            cerrarModalEditar();
            
                    Swal.fire(
                                '¡Modificación!',
                                'Se ha cambiado los datos del Proveedor!!',
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

function eliminarProveedor(){
    var nombre = $('#inputnombredel').val();
    var msj = "";
   
    if (nombre == "") {
        // console.log(cantidad);
        msj += 'Nombre de proveedor <br>';
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
    datos.append('cve_proveedore', $('#inputidel').val());
    datos.append('nombre_proveedore', $('#inputnombredel').val());
    datos.append('usuarioe', $('#spanusuarioe').text());
    console.log(datos.get('cve_proveedore'));
    console.log(datos.get('nombre_proveedore'));
    console.log(datos.get('usuarioe'));
        Swal.fire({
                title: '¿Estas seguro de eliminar el Proveedor?',
                html: 'Nombre: <b>' + datos.get('nombre_proveedore'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
    }).then((result) => {

    if (result.isConfirmed) {
        $.ajax({
                type:"POST",
                url:"modelo_proveedores.php?eliminar=1",
                data: datos,
                processData:false,
                contentType:false,
        success:function(r){
            // console.log(r);
            consultar();
            cerrarModalEliminar();
            
                    Swal.fire(
                                '¡Eliminación!',
                                'Se ha elimnado el Proveedor !!',
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

function agregarContactos(){
    // var ecodart         = $('#inputcodartedit').val();
    var contacto       = $('#inputcontacto').val();
    var correo         = $('#inputcorreo').val();
    var telefono       = $('#inputtel').val();

    var msj = "";
   
    if (contacto == "") {
        // console.log(cantidad);
        msj += 'Nombre de contacto <br>';
    }
    if (correo == "") {
        // console.log(cantidad);
        msj += 'Correo <br>';
    }
    if (telefono == "") {
        // console.log(cantidad);
        msj += 'Teléfono <br>';
    }

    if (msj.length != 0) {
        Swal.fire({
                title: 'Los siguientes campos son obligatorios:',
                html: '<ul>'+msj+'</ul>',
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
    datos.append('cve_proveedor',       $('#inputprov').val());
    datos.append('nombre_proveedor',    $('#inputnameprov').val());
    datos.append('contacto',            $('#inputcontacto').val());
    datos.append('correo',              $('#inputcorreo').val());
    datos.append('telefono',            $('#inputtel').val());

    datos.append('usuario',             $('#spanusuario').text());

    console.log(datos.get('cve_proveedor'));
    console.log(datos.get('nombre_proveedor'));
    console.log(datos.get('contacto'));
    console.log(datos.get('correo'));
    console.log(datos.get('telefono'));

    console.log(datos.get('usuario'));

        Swal.fire({
                title: '¿Desea agregar contacto al Proveedor ' + datos.get('nombre_proveedor') + '?',
                html: 'Nombre: <b>' + datos.get('contacto'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
    }).then((result) => {

    if (result.isConfirmed) {
        $.ajax({
                type:"POST",
                url:"modelo_proveedores.php?accion=insertarContacto",
                data: datos,
                processData:false,
                contentType:false,
        success:function(r){
            // console.log(r);
            consultar();
            limpiarCamposModalContacto();
            cerrarModalAgregar();
            
                    Swal.fire(
                                '¡Agregado!',
                                'Se ha agregado un contacto al Proveedor!!',
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