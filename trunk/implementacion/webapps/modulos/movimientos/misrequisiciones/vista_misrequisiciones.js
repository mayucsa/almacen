function consultar(){
        var table;
        $(document).ready(function() {
        table = $('#tablamisRequis').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "ssMisRequis.php",
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
                                "render": function (data, type, row, meta) {
                                    return row[1] + ' ' + row[6];
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

function Ver(cve_req) {
    $.getJSON("modelo_misrequisiciones.php?consultar="+cve_req, function(registros){
        console.log(registros);

        // var txt = 'Materia Prima ->';
        // var input = $('#inputcantidad').val();

        $('#inputname').val(registros[0]['cvereq']);
        // $('#comb_mat_primau').val(registros[0]['nombre']);
        // $('#comb_cantidadu').val(registros[0]['cantidad_entrada']);

        $("#tablaModal").html( '<thead> <tr>  <th class="text-center">Articulo</th>' +
                                                '<th class="text-center">Cantidad</th>'+
                                    '</thead>');
    for (i = 0; i < registros.length; i++){
        // txt += $('#inputcantidad').val(registros[i]['Cantidad']);
        // $('#inputmp').text(registros[i]['MateriaPrima']) + $('#inputcantidad').val(registros[i]['Cantidad']);
         $("#tablaModal").append('<tr>' + 
            '<td style="dislay: none;">' + registros[i].articulo + '</td>'+
            '<td style="dislay: none;">' + registros[i].cantidad + 
            '</td>'
            +'</tr>');
    }

    });
}

function Editar(){

    Swal.fire({
        // confirmButtonColor: '#3085d6',
        title: 'Modulo en elaboración',
        html: 'Disculpe las molestias estamos trabajando en este modulo',
        confirmButtonColor: '#1A4672'
        });
}

function Eliminar() {
    Swal.fire({
        // confirmButtonColor: '#3085d6',
        title: 'Modulo en elaboración',
        html: 'Disculpe las molestias estamos trabajando en este modulo',
        confirmButtonColor: '#1A4672'
        });
}