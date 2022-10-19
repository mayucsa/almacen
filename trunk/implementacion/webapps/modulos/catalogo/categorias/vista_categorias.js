function consultar(){
        var table;
        $(document).ready(function() {
        table = $('#tablaGrupos').DataTable( {
            "dom": 'Bfrtip',
            "buttons": [
                 {"extend": 'excel',"exportOptions": { columns: [0,1,2] }, "text": '<i class="far fa-file-excel"> Exportar en Excel</i>', "title": 'Catalogo de Categorias'}, 
                 {"extend": 'pdf',"exportOptions": { columns: [0,1,2] },  "text": '<i class="far fa-file-pdf"> Exportar en PDF</i>', "title": 'Catalogo de Categorias'}, 
                 {"extend": 'print',"exportOptions": { columns: [0,1,2] },  "text": '<i class="fas fa-print"> Imprimir</i>', "title": 'Catalogo de Categorias'},
                 "pageLength",
            ],
            "processing": true,
            "serverSide": true,
            "ajax": "serverSideCategorias.php",
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

function obtenerDatos(cve_ctg) {
    $.getJSON("modelo_categorias.php?consultar="+cve_ctg, function(registros){
        console.log(registros);

        $('#inputid').val(registros[0]['cve_ctg']);
        $('#inputnombrectg').val(registros[0]['nombre_ctg']);
    });
}

function obtenerDatosE(cve_ctg) {
    $.getJSON("modelo_categorias.php?consultar="+cve_ctg, function(registros){
        console.log(registros);

        $('#inputide').val(registros[0]['cve_ctg']);
        $('#inputnombrectge').val(registros[0]['nombre_ctg']);
    });
}

function limpiarCampos(){
    $('#inputnamectg').val("");
}

function validacionCampos() {
    var grupo = $('#inputnamectg').val();
    var msj = "";
  
    if (grupo == 0) {
        msj += '<li>Nombre de categoria</li>';
    }
    if (msj.length != 0) {
        $('#encabezadoModal').html('Validación de datos');
        $('#cuerpoModal').html('Los siguientes campos son obligatorios:<ul>'+msj+'</ul>');
        $('#modalMensajes').modal('toggle');

    } else{
        insertCaptura();
    }
}

function insertCaptura(){
    var datos   = new FormData();
    var mgs = "";
    var categoria        = $('#inputnamectg').val();

    datos.append('categoria',   $('#inputnamectg').val());
    datos.append('usuario', $('#spanusuario').text());

    console.log(datos.get('categoria'));
    // console.log($(this).data(nombre));
    console.log(datos.get('usuario'));
    // grupo.charAt(0).toUpperCase();

    Swal.fire({
                title: '¿Deseas agregar una categoria nueva?',
                html:   'Nombre: <b>' +  datos.get('categoria'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Agregar',
    }).then((result) => {

    if (result.isConfirmed) {    

        $.ajax({
                type:"POST",
                url:"modelo_categorias.php?accion=insertar",
                data: datos,
                processData:false,
                contentType:false,
        success:function(data){
                    consultar();
                    limpiarCampos();
                    Swal.fire(
                                '¡Agregado!',
                                'Se ha agregado una categoria Nueva !!',
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
    var ecategoria = $('#inputnombrectg').val();
    var msj = "";
   
    if (ecategoria == "") {
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
    datos.append('cve_ctg', $('#inputid').val());
    datos.append('ecategoria', $('#inputnombrectg').val());
    datos.append('usuario', $('#spanusuario').text());
    console.log(datos.get('cve_ctg'));
    console.log(datos.get('ecategoria'));
    console.log(datos.get('usuario'));
        Swal.fire({
                title: '¿Desea cambiar el nombre de la Categoria?',
                html: 'Nombre nuevo: <b>' + datos.get('ecategoria'),
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
                url:"modelo_categorias.php?actualizar=1",
                data: datos,
                processData:false,
                contentType:false,
        success:function(r){
            // console.log(r);
            consultar();
            cerrarModalEditar();
            
                    Swal.fire(
                                '¡Modificación!',
                                'Se ha cambiado el nombre de la Categoria !!',
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
    var ecategoria = $('#inputnombrectge').val();
    var msj = "";
   
    if (ecategoria == "") {
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
    datos.append('cve_ctge', $('#inputide').val());
    datos.append('ecategoria', $('#inputnombrectge').val());
    datos.append('usuarioe', $('#spanusuarioe').text());
    console.log(datos.get('cve_ctge'));
    console.log(datos.get('ecategoria'));
    console.log(datos.get('usuarioe'));
        Swal.fire({
                title: '¿Estas seguro de eliminar la Categoria?',
                html: 'Nombre: <b>' + datos.get('ecategoria'),
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
                url:"modelo_categorias.php?eliminar=1",
                data: datos,
                processData:false,
                contentType:false,
        success:function(r){
            // console.log(r);
            consultar();
            cerrarModalEliminar();
            
                    Swal.fire(
                                '¡Eliminación!',
                                'Se ha elimnado la Categoria !!',
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