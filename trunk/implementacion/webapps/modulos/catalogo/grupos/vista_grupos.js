function consultar(){
        var table;
        $(document).ready(function() {
        table = $('#tablaGrupos').DataTable( {
            "dom": 'Bfrtip',
            "buttons": [
                 {"extend": 'excel',"exportOptions": { columns: [0,1,2] }, "text": '<i class="far fa-file-excel"> Exportar en Excel</i>', "title": 'Catalogo de Grupos'}, 
                 {"extend": 'pdf',"exportOptions": { columns: [0,1,2] },  "text": '<i class="far fa-file-pdf"> Exportar en PDF</i>', "title": 'Catalogo de Grupos'}, 
                 {"extend": 'print',"exportOptions": { columns: [0,1,2] },  "text": '<i class="fas fa-print"> Imprimir</i>', "title": 'Catalogo de Grupos'},
                 "pageLength",
            ],
            "processing": true,
            "serverSide": true,
            "ajax": "serverSideGrupo.php",
            "lengthMenu": [[30, 50, 100], [30, 50, 100]],
            "pageLength": 30,
            "order": [0, 'asc'],
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
                                    return  '<span class= "btn btn-warning" onclick= "obtenerDatos('+row[3]+')" title="Editar" data-toggle="modal" data-target="#modalEditar" data-whatever="@getbootstrap"><i class="fas fa-edit"></i> </span>' + ' ' + 
                                            '<span class= "btn btn-danger" onclick= "obtenerDatosE('+row[3]+')" title="Eliminar" data-toggle="modal" data-target="#modalEliminar" data-whatever="@getbootstrap"><i class="fas fa-trash-alt"></i> </span>';
                                }
                                // "data": null,
                                // "defaultContent": '<span class= "btn btn-warning" onclick= "obtenerDatos(".$value["cve_entrada"].")" data-toggle="modal" data-target="#modalMatPrimaUpdate" data-whatever="@getbootstrap"><i class="fas fa-edit"></i> </span>'
                            },
                            {
                                "targets": 1,
                                "render": function(data, type, row, meta){
                                    // const primaryKey = data;
                                    // "data": 'cve_entrada',
                                    if (row[1] == 'VIG') {
                                        return '<span class= "badge badge-success">Activo</span>';
                                    }else{
                                        return '<span class= "badge badge-danger">Inactivo</span>';
                                    }
                                }
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

function obtenerDatos(cve_gpo) {
    $.getJSON("modelo_grupos.php?consultar="+cve_gpo, function(registros){
        console.log(registros);

        $('#inputid').val(registros[0]['cve_gpo']);
        $('#inputnombregpo').val(registros[0]['nombre_gpo']);
    });
}

function obtenerDatosE(cve_gpo) {
    $.getJSON("modelo_grupos.php?consultar="+cve_gpo, function(registros){
        console.log(registros);

        $('#inputide').val(registros[0]['cve_gpo']);
        $('#inputnombregpoe').val(registros[0]['nombre_gpo']);
    });
}

function limpiarCampos(){
    $('#inputnamegpo').val("");
}

function validacionCampos() {
    var grupo = $('#inputnamegpo').val();
    var msj = "";
  
    if (grupo == 0) {
        msj += '<li>Nombre de grupo</li>';
    }
    if (msj.length != 0) {
        $('#encabezadoModal').html('Validación de datos');
        $('#cuerpoModal').html('Los siguientes campos son obligatorios:<ul>'+msj+'</ul>');
        $('#modalMensajes').modal('toggle');

    } else{
        insertCaptura();
    }
}

function existenciaGrupo(){
    var grupo = $('#inputnamegpo').val();
    var msj = "";

    var datos   = new FormData();

    datos.append('grupo', $('#inputnamegpo').val());

        $.ajax({
                type:"POST",
                url:"modelo_grupos.php?accion=consultar&grupo=" + grupo,
                data: grupo,
                processData:false,
                contentType:false,
        success:function(data){

                    // console.log(data);
                    // $('#myLoading').modal('show');
                    // mostrar();
                    // consultar();
                    // limpiarCampos();
                    // consultarDatos();
                    // cerrarModal();
                    // $('#modalMatPrima').modal('hide');
                    if (data == 'correcto') {
                        Swal.fire({
                                        icon: 'info',
                                        title: '¡Error!',
                                        text: 'El grupo ya existe',
                                        footer: 'Revisar el catalogo de grupos',
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
    var mgs = "";
    var grupo        = $('#inputnamegpo').val();

    datos.append('grupo',   $('#inputnamegpo').val());
    datos.append('usuario', $('#spanusuario').text());

    console.log(datos.get('grupo'));
    // console.log($(this).data(nombre));
    console.log(datos.get('usuario'));
    // grupo.charAt(0).toUpperCase();

    Swal.fire({
                title: '¿Deseas agregar un grupo nuevo?',
                html:   'Grupo: <b>' +  datos.get('grupo'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Agregar',
    }).then((result) => {

    if (result.isConfirmed) {    

        $.ajax({
                type:"POST",
                url:"modelo_grupos.php?accion=insertar",
                data: datos,
                processData:false,
                contentType:false,
        success:function(data){
                    consultar();
                    limpiarCampos();
                    Swal.fire(
                                '¡Agregado!',
                                'Se ha agregado un grupos Nuevo !!',
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

function editarGrupo(){
    var egrupo = $('#inputnombregpo').val();
    var msj = "";
   
    if (egrupo == "") {
        // console.log(cantidad);
        msj += 'Nombre <br>';
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
    datos.append('cve_gpo', $('#inputid').val());
    datos.append('egrupo', $('#inputnombregpo').val());
    datos.append('usuario', $('#spanusuario').text());
    console.log(datos.get('cve_gpo'));
    console.log(datos.get('egrupo'));
    console.log(datos.get('usuario'));
        Swal.fire({
                title: '¿Desea cambiar el nombre de la Categoria?',
                html: 'Nombre nuevo: <b>' + datos.get('egrupo'),
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
                url:"modelo_grupos.php?actualizar=1",
                data: datos,
                processData:false,
                contentType:false,
        success:function(r){
            // console.log(r);
            consultar();
            cerrarModalEditar();
            
                    Swal.fire(
                                '¡Modificación!',
                                'Se ha cambiado el nombre del Grupos !!',
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

function eliminarGrupo(){
    var egrupo = $('#inputnombregpoe').val();
    var msj = "";
   
    if (egrupo == "") {
        // console.log(cantidad);
        msj += 'Nombre <br>';
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
    datos.append('cve_gpoe', $('#inputide').val());
    datos.append('egrupoe', $('#inputnombregpoe').val());
    datos.append('usuarioe', $('#spanusuarioe').text());
    console.log(datos.get('cve_gpoe'));
    console.log(datos.get('egrupoe'));
    console.log(datos.get('usuarioe'));
        Swal.fire({
                title: '¿Estas seguro de eliminar el Grupo?',
                html: 'Nombre: <b>' + datos.get('egrupoe'),
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
                url:"modelo_grupos.php?eliminar=1",
                data: datos,
                processData:false,
                contentType:false,
        success:function(r){
            // console.log(r);
            consultar();
            cerrarModalEliminar();
            
                    Swal.fire(
                                '¡Eliminación!',
                                'Se ha elimnado el grupo !!',
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