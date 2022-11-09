function consultar(){
        var table;
        $(document).ready(function() {
        table = $('#tablaOrdenCompra').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "serversideODC.php",
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
                                "targets": 1,
                                "render": function(data, type, row, meta){
                                    return row[1] + ' ' + row[4];
                                }
                            },
                            {
                                "targets": 2,
                                "render": function(data, type, row, meta){
                                    // const primaryKey = data;
                                    // "data": 'cve_entrada',
                                    if (row[2] == 1) {
                                        return '<span class= "badge badge-success">Autorizado</span>';
                                    }else{
                                        return '<span class= "badge badge-danger">No Autorizado</span>';
                                    }
                                }
                            },
                            {
                                "targets": 4,
                                "render": function(data, type, row, meta){
                                    return row[5];
                                    // return  '<span class= "btn btn-info" onclick= "obtenerDatosA('+row[3]+')" title="Ver detalle" data-toggle="modal" data-target="#modalAgregaContacto" data-whatever="@getbootstrap"><i class="fas fa-eye"></i> </span>' + ' ' +
                                            // '<span class= "btn btn-secondary" onclick="imprSelec('+modalBarCode+')" title="Imprimir" data-toggle="modal" data-target="#modalVerContacto" data-whatever="@getbootstrap"><i class="fas fa-print"></i> </span>' + ' ' +
                                            // '<span class= "btn btn-danger" onclick= "obtenerDatosV('+row[3]+')" title="Descargar" data-toggle="modal" data-target="#modalVer" data-whatever="@getbootstrap"><i class="fas fa-file-pdf"></i> </span>' + ' ' +
                                            // '<span class= "btn btn-warning" onclick= "obtenerDatos('+row[3]+')" title="Enviar correo" data-toggle="modal" data-target="#modalEditar" data-whatever="@getbootstrap"><i class="fas fa-envelope"></i> </span>';
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

function imprSelec(id) {
    var div = document.getElementById(id);
    var ventimp = window.open(' ', 'popimpr');
    ventimp.document.write( div.innerHTML );
    ventimp.document.close();
    ventimp.print( );
    ventimp.close();
}

function obtenerDatos(cve_odc) {
    $.getJSON("modelo_ordencompra.php?consultar="+cve_odc, function(registros){
        console.log(registros);

        // var txt = 'Materia Prima ->';
        // var input = $('#inputcantidad').val();

        $('#inputname').val(registros[0]['cveodc']);
        // $('#comb_mat_primau').val(registros[0]['nombre']);
        // $('#comb_cantidadu').val(registros[0]['cantidad_entrada']);

        $("#tablaModal").html( '<thead> <tr>  <th class="text-center">Folio req</th>' +
                                                '<th class="text-center">Articulo</th>'+
                                                '<th class="text-center">Cantidad</th>'+
                                                '<th class="text-center">Precio unitario</th>'+
                                                '<th class="text-center">Precio total</th></tr>'+
                                    '</thead>');
    for (i = 0; i < registros.length; i++){
        // txt += $('#inputcantidad').val(registros[i]['Cantidad']);
        // $('#inputmp').text(registros[i]['MateriaPrima']) + $('#inputcantidad').val(registros[i]['Cantidad']);
         $("#tablaModal").append('<tr>' + 
            '<td style="dislay: none;">' + registros[i].req + '</td>'+
            '<td style="dislay: none;">' + registros[i].articulo + '</td>'+
            '<td style="dislay: none;">' + registros[i].cantidad + '</td>'+
            '<td style="dislay: none;">' + registros[i].unitario + '</td>'+
            '<td align="center" style="dislay: none;">' + registros[i].total + '</td>'+'</tr>');
    }

    });
}

function descargaPDF(){


    window.open('reporte_pdf.php');
}

function EnviarCorreo(cve_odc){
    $.getJSON("modelo_ordencompra.php?consultar="+cve_odc, function (registros) {
        console.log(registros);
        // console.log(registros[0]);
        // console.log(registros[1]);
    });

    window.open('sendEmail.php');
}