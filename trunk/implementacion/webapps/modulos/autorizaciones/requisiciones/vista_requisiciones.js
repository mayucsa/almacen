function consultarF(){
        var table;
        $(document).ready(function() {
        table = $('#tablaAutoReq').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "ssAutoReq.php",
            "lengthMenu": [[30, 50, 100], [30, 50, 100]],
            "pageLength": 30,
            "order": [0, 'desc'],
            // "destroy": true,
            "searching": true,
            // bSort: false,
            // "paging": false,
            // "searching": false,
            "bDestroy": true,
            "columnDefs":[
                            {
                                "targets": [0, 1, 2, 3, 4],
                                "className": 'dt-body-center' /*alineacion al centro th de tbody de la table*/
                            },
                            {
                                "targets": 2,
                                "render": function(data, type, row, meta){
                                    // "data": 'precio_total',
                                    return row[2];
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

        $("#iptFolio").keyup(function(){
            table.column($(this).data('index')).search(this.value).draw();
            })
}

function consultar(){
        $(document).ready(function() {
            $('#tablaAutoReq').DataTable( {
                "processing": true,
                "ajax": {
                    "url": "ssAutoReq.php",
                    "dataSrc": ""
                },
                "lengthMenu": [[30, 50, 100], [30, 50, 100]],
                "pageLength": 30,
                "order": [0, 'desc'],
                "searching": true,
                "bDestroy": true,
                "columnDefs": [
                            {
                                "targets": [0, 1, 2, 3, 4],
                                "className": 'dt-body-center' /*alineacion al centro th de tbody de la table*/
                            },
                            {
                                "targets": 4,
                                "render": function (data, type, row, meta) {
                                    return  '<span class= "btn btn-info" onclick= "obtenerDatos('+row["cve_odc"]+')" title="Ver detalle" data-toggle="modal" data-target="#modalVerMP" data-whatever="@getbootstrap"><i class="fas fa-eye"></i> </span>' + " " +
                                            '<span class= "btn btn-secondary" onclick="descargaArchivos('+row["cve_odc"]+')" title="Descargar archivo"><i class="fas fa-download"></i> </span>' + " " +
                                            '<span class= "btn btn-success" onclick= "Autorizacion('+row["cve_odc"]+')" title="Autorizar"><i class="fas fa-check"></i> </span>' + " " +
                                            '<span class= "btn btn-danger" onclick= "NoAutorizado('+row["cve_odc"]+')" title="No autorizar" data-toggle="modal" data-target="#modalNoAutorizado" data-whatever="@getbootstrap"><i class="fas fa-window-close"></i> </span>';
                                }                                
                            }
                    ],
                "columns":[
                            {"data": "cve_odc"},
                            {"data": "proveedor"},
                            {"data": "total"},
                            {"data": "fecha"}
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

        $("#iptFolio").keyup(function(){
            table.column($(this).data('cve_odc')).search(this.value).draw();
            })
}

function obtenerDatos(cve_odc) {
    $.getJSON("modelo_reqauto.php?consultar="+cve_odc, function(registros){
        console.log(registros);

        $('#inputname').val(registros[0]['cve_odc']);

        $("#tablaModal").html( '<thead> <tr>  <th class="text-center">Folio req</th>' +
                                                '<th class="text-center">Articulo</th>'+
                                                '<th class="text-center">Comentario</th>'+
                                                '<th class="text-center">Cantidad</th>'+
                                                '<th class="text-center">Precio unitario</th>'+
                                                '<th class="text-center">Precio total</th></tr>'+
                                    '</thead>');
    for (i = 0; i < registros.length; i++){
         $("#tablaModal").append('<tr>' + 
            '<td style="dislay: none;">' + registros[i].req + '</td>'+
            '<td style="dislay: none;">' + registros[i].articulo + '</td>'+
            '<td style="dislay: none;">' + registros[i].comentario + '</td>'+
            '<td style="dislay: none;">' + registros[i].cantidad + '</td>'+
            '<td style="dislay: none;">' + registros[i].unitario + '</td>'+
            '<td align="center" style="dislay: none;">' + registros[i].total + '</td>'+'</tr>');
    }

    });
}
function descargaArchivos(cve_odc){
    $.ajax({
        method: "POST",
        url: "controller.php",
        data: { task: 'descargaArchivos', cve_odc: cve_odc }
    })
    .done(function( result ) {
        result = JSON.parse(result);
        for (var i = 0; i < result.length; i++) {
            download(result[i].nombreOriginal, result[i].ruta+result[i].nombre);
        }
    });
}
function download(filename, textInput) {
    var element = document.createElement('a');
    element.setAttribute('href',textInput);
    element.setAttribute('download', filename);
    document.body.appendChild(element);
    element.click();
    //document.body.removeChild(element);
}
function NoAutorizado(cve_odc) {
    document.getElementById('flexCheckIndeterminate').checked = false;
    $('#motivo').val('');
    $.getJSON("modelo_reqauto.php?consultar="+cve_odc, function(registros){
        console.log(registros);

        $('#inputfolio').val(registros[0]['cve_odc']);

    });
}
function enviarCorreoAutorizacion(folio){
    $.ajax({
        type:"POST",
        url:"../../movimientos/requisicion/Controller.php?task=envioCorreo&folio="+folio+"&aprobacion=ok",
        processData:false,
        contentType:false,
        success:function(data){
            consultar();
            jsRemoveWindowLoad();
            if (data == 200) {
                console.log('enviarCorreoAutorizacion', 'Envío correcto.');
            }else{
                console.log('Error enviarCorreoAutorizacion', data);
            }
        }
    })
}
function Autorizacion(cve_odc){
    $.getJSON("modelo_reqauto.php?consultar="+cve_odc, function(registros){
        console.log(registros);

        // var datos   = new FormData();

        // datos.append('cve_odc', registros[0]['cve_odc'];
        // console.log(datos.get('cve_odc'));
    // });
        Swal.fire({
            title: 'Autorización',
            html: '¿Deseas autorizar la orden de compra con folio <b>#'+  registros[0]['cve_odc'] + '</b>?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'green',
            cancelButtonColor: 'orange',
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Revisar'
        }).then((result) => {
            if (result.isConfirmed) {
                jsShowWindowLoad('Autorizando orden de compra...');

                $.ajax({
                    type:"POST",
                    url:"modelo_reqauto.php?actualizar=1&cve_odc="+registros[0]['cve_odc'],
                    data: registros[0]['cve_odc'],
                    processData:false,
                    contentType:false,
                    success:function(data){
                        enviarCorreoAutorizacion(registros[0]['cve_odc']);
                        consultar();
                        jsRemoveWindowLoad();
                        console.log(data);
                        Swal.fire(
                            'Autorizacion!',
                            'Usted ha autorizado la orden de compra con el folio #'+ registros[0]['cve_odc'] +' !!',
                            'success'
                        )
                    }
                })
            }
        });

    });
}
function cerrarModal(){
    $('#modalNoAutorizado').modal('hide');
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
}
 function noautorizado() {
    var motivo = $('#motivo').val();
    var msj = "";

    if (motivo == "") {
        // console.log(cantidad);
        msj += 'Motivo <br>';
    }

    if (msj.length > 0) {
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
    }else{
        var datos   = new FormData();
        datos.append('id', $('#inputfolio').val());
        datos.append('motivo', $('#motivo').val());
        datos.append('usuario', $('#spanusuario').text());
        datos.append('sinReCotizar', document.getElementById('flexCheckIndeterminate').checked);
        console.log(datos.get('id'));
        Swal.fire({
            title: '¿Esta seguro de no autorizar la orden de compra?',
            html: 'Orden de compra: <b>' + datos.get('id'),
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) =>{
            if (result.isConfirmed) {
                jsShowWindowLoad('Generando folio...');
                $.ajax({
                    type:"POST",
                    url:"modelo_reqauto.php?eliminar=1",
                    data: datos,
                    processData:false,
                    contentType:false,
                    success:function(r){
                        console.log(r);
                        jsRemoveWindowLoad();
                        if (r == 'ok') {
                            consultar();
                            cerrarModal();
                            Swal.fire(
                                'No autorizado!',
                                'Orden de compra no autorizada !!',
                                'success'
                            )
                        }else{
                            Swal.fire(
                                'Error!',
                                'Error en controlador!',
                                'error'
                            )
                        }
                        
                    }
                })
            } else if (result.dismiss === Swal.DismissReason.cancel) {

            }
        });
    }
 }