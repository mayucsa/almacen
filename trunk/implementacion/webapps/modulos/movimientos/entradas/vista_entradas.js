function consultar(){
        var table;
        $(document).ready(function() {
        table = $('#tablaEntradas').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "ssEntradas.php",
            "lengthMenu": [[15, 30, 50, 100], [15, 30, 50, 100]],
            "pageLength": 15,
            "order": [0, 'desc'],
            // "destroy": true,
            "searching": true,
            // bSort: false,
            // "paging": false,
            // "searching": false,
            "bDestroy": true,
            "columnDefs":[
                {
                    "targets": [1, 2, 3, 4, 5],
                    "className": 'dt-body-center' /*alineacion al centro th de tbody de la table*/
                },
                {
                    "targets": 5,
                    "render": function(data, type, row, meta){
                        return  '<span class= "btn btn-info" onclick= "Verentradas('+row[0]+')" title="Ver" data-toggle="modal" data-target="#modalVer" data-whatever="@getbootstrap"><i class="fas fa-eye"></i> </span>' + ' ' +
                                '<span class= "btn btn-warning" title="Ver pdf" "><i class="fas fa-file-pdf"></i> </span>' + ' ' +
                                '<span class= "btn btn-danger" title="Cancelar" "><i class="fas fa-window-close"></i> </span>';
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

}

function Verentradas(cve_mov) {
    $.getJSON("modelo_entradas.php?consultar="+cve_mov, function(registros){
        console.log(registros);

        $('#inputname').val(registros[0]['cve_mov']);
        $('#tipo_documento').val(registros[0]['tipo_documento']);
        $('#folio_documento').val(registros[0]['folio_documento']);
        $('#fecha_documento').val(registros[0]['fecha_documento']);

        $("#tablaModal").html( '<thead> <tr>  <th class="text-center">Cve req</th>' +
                                                '<th class="text-center">Cve articulo</th>'+
                                                '<th class="text-center">Descripcion</th>'+
                                                '<th class="text-center">Cantidad</th>'+
                                                '<th class="text-center">Unidad medida</th>'+
                                                '<th class="text-center">Precio unitario</th>'+
                                                '<th class="text-center">Importe</th>'+
                                    '</thead>');
        for (i = 0; i < registros.length; i++){
            // txt += $('#inputcantidad').val(registros[i]['Cantidad']);
            // $('#inputmp').text(registros[i]['MateriaPrima']) + $('#inputcantidad').val(registros[i]['Cantidad']);
             $("#tablaModal").append('<tr>' + 
                '<td style="dislay: none;">' + registros[i].cve_req + '</td>'+
                '<td style="dislay: none;">' + registros[i].cve_articulo + '</td>'+
                '<td style="dislay: none;">' + registros[i].nombre_articulo + '</td>'+
                '<td style="dislay: none;">' + registros[i].cantidad_entrada + '</td>'+
                '<td style="dislay: none;">' + registros[i].unidad_medida + 
                '<td style="dislay: none;">' + registros[i].precio_unidad + 
                '<td style="dislay: none;">' + registros[i].precio_total + 
                '</td>'
                +'</tr>');
        }
    });
}