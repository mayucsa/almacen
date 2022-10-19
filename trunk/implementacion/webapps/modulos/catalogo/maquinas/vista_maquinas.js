function consultar(){
        var table;
        $(document).ready(function() {
        table = $('#tablaMaquinas').DataTable( {
            // "dom": 'Bfrtip',
            // "buttons": [
            //      {"extend": 'excel',"exportOptions": { columns: [0,1,2] }, "text": '<i class="far fa-file-excel"> Exportar en Excel</i>', "title": 'Catalogo de Grupos'}, 
            //      {"extend": 'pdf',"exportOptions": { columns: [0,1,2] },  "text": '<i class="far fa-file-pdf"> Exportar en PDF</i>', "title": 'Catalogo de Grupos'}, 
            //      {"extend": 'print',"exportOptions": { columns: [0,1,2] },  "text": '<i class="fas fa-print"> Imprimir</i>', "title": 'Catalogo de Grupos'},
            //      "pageLength",
            // ],
            "processing": true,
            "serverSide": true,
            "ajax": "serverSideMaquinas.php",
            "lengthMenu": [[30, 50, 100], [30, 50, 100]],
            "pageLength": 30,
            "order": [3, 'desc'],
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

function obtenerDatos(cve_maq) {
    $.getJSON("modelo_maquinas.php?consultar="+cve_maq, function(registros){
        // console.log(registros);

        $('#inputid').val(registros[0]['cve_maq']);
        $('#selectdeptoedit').val(registros[0]['cve_depto']);
        $('#inputnombremaqedit').val(registros[0]['nombre_maq']);
    });
}

function obtenerDatosE(cve_maq) {
    $.getJSON("modelo_maquinas.php?consultar="+cve_maq, function(registros){
        // console.log(registros);

        $('#inputide').val(registros[0]['cve_maq']);
        $('#inputnombremaqe').val(registros[0]['nombre_maq']);
    });
}

function limpiarCampos(){
    $('#inputcodmaq').val("");
    $('#selectmaq').val(0);
    $('#inputnombremaq').val("");
}

function validacionCampos() {
    var codmaq = $('#inputcodmaq').val();
    var depto = $('#selectmaq').val();
    var codnombre = $('#inputnombremaq').val();
    var msj = "";
  
    if (codmaq == "") {
        msj += '<li>Código de máquina</li>';
    }
    if (depto == 0) {
        msj += '<li>Departamento</li>';
    }
    if (codnombre == "") {
        msj += '<li>Nombre de máquina</li>';
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
    var codigomaq = $('#inputcodmaq').val();
    var msj = "";

    var datos   = new FormData();

    datos.append('codigomaq', $('#inputcodmaq').val());

        $.ajax({
                type:"POST",
                url:"modelo_maquinas.php?accion=verificar&codigomaq=" + codigomaq,
                data: codigomaq,
                processData:false,
                contentType:false,
        success:function(data){
                    if (data == 'correcto') {
                        Swal.fire({
                                        icon: 'warning',
                                        title: '¡Error!',
                                        text: 'El código de Máquina ya existe',
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
    var codmaq = $('#inputcodmaq').val();
    var depto = $('#selectmaq').val();
    var codnombre = $('#inputnombremaq').val();

    datos.append('codmaq',      $('#inputcodmaq').val());
    datos.append('depto',       $('#selectmaq').val());
    datos.append('codnombre',   $('#inputnombremaq').val());
    datos.append('usuario',     $('#spanusuario').text());

    // console.log(datos.get('codmaq'));
    // console.log(datos.get('depto'));
    // console.log(datos.get('codnombre'));

    // console.log(datos.get('usuario'));


    Swal.fire({
                title: '¿Deseas agregar una Máquina?',
                html:   'Nombre: <b>' +  datos.get('codnombre'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Agregar',
    }).then((result) => {

    if (result.isConfirmed) {    

        $.ajax({
                type:"POST",
                url:"modelo_maquinas.php?accion=insertar",
                data: datos,
                processData:false,
                contentType:false,
        success:function(data){
                    consultar();
                    limpiarCampos();
                    Swal.fire(
                                '¡Agregado!',
                                'Se ha agregado una Máquina nueva !!',
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

function editarMaquina(){
    var edepto = $('#selectdeptoedit').val();
    var enommbre = $('#inputnombremaqedit').val();
    var msj = "";
   
    if (edepto == 0) {
        // console.log(cantidad);
        msj += 'Departamento <br>';
    }
    if (enommbre == "") {
        // console.log(cantidad);
        msj += 'Nombre de máquina <br>';
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
    var txtdeptoedit    = $('#selectdeptoedit').find('option:selected').text()

    datos.append('cve_maq', $('#inputid').val());
    datos.append('edepto', $('#selectdeptoedit').val());
    datos.append('enommbre', $('#inputnombremaqedit').val());
    datos.append('usuario', $('#spanusuario').text());
    // console.log(datos.get('cve_maq'));
    // console.log(datos.get('edepto'));
    // console.log(datos.get('enommbre'));
    // console.log(datos.get('usuario'));

        Swal.fire({
                title: '¿Desea modificar los datos de la Maquina?',
                html: 'Departamento: <b>' + txtdeptoedit + '</b><br> Nombre: <b>' + datos.get('enommbre'),
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
                url:"modelo_maquinas.php?actualizar=1",
                data: datos,
                processData:false,
                contentType:false,
        success:function(r){
            // console.log(r);
            consultar();
            cerrarModalEditar();
            
                    Swal.fire(
                                '¡Modificación!',
                                'Se ha cambiado los datos de la Maquina!!',
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

function eliminarMaquina(){
    var enombremaq = $('#inputnombremaqe').val();
    var msj = "";
   
    if (enombremaq == "") {
        // console.log(cantidad);
        msj += 'Nombre de Maquina <br>';
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
    datos.append('cve_maqe', $('#inputide').val());
    datos.append('nombre_maqe', $('#inputnombremaqe').val());
    datos.append('usuarioe', $('#spanusuarioe').text());
    // console.log(datos.get('cve_maqe'));
    // console.log(datos.get('nombre_maqe'));
    // console.log(datos.get('usuarioe'));
        Swal.fire({
                title: '¿Esta de acuerdo con la Baja de la siguiente Maquina?',
                html: 'Nombre: <b>' + datos.get('nombre_maqe'),
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
                url:"modelo_maquinas.php?eliminar=1",
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