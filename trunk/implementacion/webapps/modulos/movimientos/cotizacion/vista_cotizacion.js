function consultar(){
        var table;
        $(document).ready(function() {
        table = $('#tablaGrupos').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "serverSideCot.php",
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
                                "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                                "className": 'dt-body-center' /*alineacion al centro th de tbody de la table*/
                            },
                            {
                                "targets": 1,
                                "render": function (data, type, row, meta) {
                                    if (row[1] == 'N') {
                                        return '<span class= "badge badge-success">Normal</span>';
                                    }else{
                                        return '<span class= "badge badge-primary">Automatica</span>';
                                    }
                                }
                            },
                            {
                                "targets": 2,
                                "render": function (data, type, row, meta) {
                                    return row[10] + ' ' + row[11];
                                }
                            },
                            {
                                "targets": 5,
                                "render": function (data, type, row, meta) {
                                    return '<input type="text" class="form-control form-control-sm validanumericos" disabled>';
                                }
                            },
                            {
                                "targets": 6,
                                "render": function (data, type, row, meta) {
                                    return '<input type="text" class="form-control form-control-sm validanumericos" disabled>';
                                }
                            },
                            {
                                "targets": 9,
                                "render": function (data, type, row, meta) {
                                    return '<input type="checkbox" aria-label="Checkbox for following text input">';
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