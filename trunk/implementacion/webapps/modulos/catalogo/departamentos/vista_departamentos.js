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
            "ajax": "serverSideDepartamentos.php",
            "lengthMenu": [[30, 50, 100], [30, 50, 100]],
            "pageLength": 30,
            "order": [4, 'desc'],
            // "destroy": true,
            "searching": true,
            // bSort: false,
            // "paging": false,
            // "searching": false,
            "bDestroy": true,
            "columnDefs":[
                            {
                                "targets": [1, 2, 3, 4],
                                "className": 'dt-body-center' /*alineacion al centro th de tbody de la table*/
                            },
                            {
                                "targets": 4,
                                "render": function(data, type, row, meta){
                                    // const primaryKey = data;
                                    // "data": 'cve_entrada',
                                    return  '<span class= "btn btn-warning" onclick= "obtenerDatos('+row[4]+')" title="Editar" data-toggle="modal" data-target="#modalEditar" data-whatever="@getbootstrap"><i class="fas fa-edit"></i> </span>' + ' ' + 
                                            '<span class= "btn btn-danger" onclick= "obtenerDatosE('+row[4]+')" title="Baja de máquina" data-toggle="modal" data-target="#modalEliminar" data-whatever="@getbootstrap"><i class="fas fa-arrow-circle-down"></i> </span>';
                                }
                                // "data": null,
                                // "defaultContent": '<span class= "btn btn-warning" onclick= "obtenerDatos(".$value["cve_entrada"].")" data-toggle="modal" data-target="#modalMatPrimaUpdate" data-whatever="@getbootstrap"><i class="fas fa-edit"></i> </span>'
                            },
                            {
                                "targets": 2,
                                "render": function(data, type, row, meta){
                                    // const primaryKey = data;
                                    // "data": 'cve_entrada',
                                    if (row[2] == 'VIG') {
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

        $("#iptCodigo").keyup(function(){
            table.column($(this).data('index')).search(this.value).draw();
            })
        $("#iptNombre").keyup(function(){
            table.column($(this).data('index')).search(this.value).draw();
            })
}

function obtenerDatos(cve_depto) {
    $.getJSON("modelo_departamentos.php?consultar="+cve_depto, function(registros){
        console.log(registros);

        $('#inputid').val(registros[0]['cve_depto']);
        $('#inputnombredepto').val(registros[0]['nombre_depto']);
    });
}

function obtenerDatosE(cve_depto) {
    $.getJSON("modelo_departamentos.php?consultar="+cve_depto, function(registros){
        console.log(registros);

        $('#inputide').val(registros[0]['cve_depto']);
        $('#inputnombredeptoe').val(registros[0]['nombre_depto']);
    });
}

function limpiarCampos(){

    $('#inputcoddepto').val("");
    $('#inputnamedepto').val("");
    $('#selectareas').val(0);

}

function validacionCampos() {
    var coddepto = $('#inputcoddepto').val();
    var depto = $('#inputnamedepto').val();
    var area = $('#selectareas').val();
    var msj = "";
  
    if (coddepto == "") {
        msj += '<li>Código de departamento</li>';
    }
    if (depto == "") {
        msj += '<li>Nombre de departamento</li>';
    }
    if (area == 0) {
        msj += '<li>Área</li>';
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
    var codigodepto = $('#inputcoddepto').val();
    var msj = "";

    var datos   = new FormData();

    datos.append('codigodepto', $('#inputcoddepto').val());

        $.ajax({
                type:"POST",
                url:"modelo_departamentos.php?accion=verificar&codigodepto=" + codigodepto,
                data: codigodepto,
                processData:false,
                contentType:false,
        success:function(data){
                    if (data == 'correcto') {
                        Swal.fire({
                                        icon: 'warning',
                                        title: '¡Error!',
                                        text: 'El código de Departamento ya existe',
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
    var mgs = "";
    var coddepto = $('#inputcoddepto').val();
    var depto        = $('#inputnamedepto').val();
    var area        = $('#selectareas').val();

    datos.append('coddepto',   $('#inputcoddepto').val());
    datos.append('depto',   $('#inputnamedepto').val());
    datos.append('area',   $('#selectareas').val());
    datos.append('usuario', $('#spanusuario').text());

    // console.log(datos.get('coddepto'));
    // console.log(datos.get('depto'));
    // console.log($(this).data(nombre));
    // console.log(datos.get('usuario'));
    // grupo.charAt(0).toUpperCase();

    Swal.fire({
                title: '¿Deseas agregar un Departamento?',
                html:   'Nombre: <b>' +  datos.get('depto'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Agregar',
    }).then((result) => {

    if (result.isConfirmed) {    

        $.ajax({
                type:"POST",
                url:"modelo_departamentos.php?accion=insertar",
                data: datos,
                processData:false,
                contentType:false,
        success:function(data){
                    consultar();
                    limpiarCampos();
                    Swal.fire(
                                '¡Agregado!',
                                'Se ha agregado un Departamento Nuevo !!',
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

function editarDepto(){
    var edepto = $('#inputnombredepto').val();
    var msj = "";
   
    if (edepto == "") {
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
    datos.append('cve_depto', $('#inputid').val());
    datos.append('edepto', $('#inputnombredepto').val());
    datos.append('usuario', $('#spanusuario').text());
    // console.log(datos.get('cve_depto'));
    // console.log(datos.get('edepto'));
    // console.log(datos.get('usuario'));
        Swal.fire({
                title: '¿Desea cambiar el nombre del Departamento?',
                html: 'Nombre nuevo: <b>' + datos.get('edepto'),
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
                url:"modelo_departamentos.php?actualizar=1",
                data: datos,
                processData:false,
                contentType:false,
        success:function(r){
            // console.log(r);
            consultar();
            cerrarModalEditar();
            
                    Swal.fire(
                                '¡Modificación!',
                                'Se ha cambiado el nombre del Departamento !!',
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

function eliminarDepto(){
    var edepto = $('#inputnombredeptoe').val();
    var msj = "";
   
    if (edepto == "") {
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
    datos.append('cve_deptoe', $('#inputide').val());
    datos.append('edepto', $('#inputnombredeptoe').val());
    datos.append('usuarioe', $('#spanusuarioe').text());
    // console.log(datos.get('cve_deptoe'));
    // console.log(datos.get('edepto'));
    // console.log(datos.get('usuarioe'));
        Swal.fire({
                title: '¿Estas seguro de eliminar el Departamento?',
                html: 'Nombre: <b>' + datos.get('edepto'),
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
                url:"modelo_departamentos.php?eliminar=1",
                data: datos,
                processData:false,
                contentType:false,
        success:function(r){
            // console.log(r);
            consultar();
            cerrarModalEliminar();
            
                    Swal.fire(
                                '¡Eliminación!',
                                'Se ha elimnado el Departamento !!',
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