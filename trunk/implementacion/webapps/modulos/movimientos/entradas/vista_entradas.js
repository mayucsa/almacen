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
                    "targets": [1, 2, 3, 4],
                    "className": 'dt-body-center' /*alineacion al centro th de tbody de la table*/
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