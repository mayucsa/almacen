function consultar(){
        var table;
        $(document).ready(function() {
        table = $('#tablaArticulos').DataTable( {
            // "dom": 'Bfrtip',
            // "buttons": [
            //      {"extend": 'excel',"exportOptions": { columns: [0,1,2] }, "text": '<i class="far fa-file-excel"> Exportar en Excel</i>', "title": 'Catalogo de Grupos'}, 
            //      {"extend": 'pdf',"exportOptions": { columns: [0,1,2] },  "text": '<i class="far fa-file-pdf"> Exportar en PDF</i>', "title": 'Catalogo de Grupos'}, 
            //      {"extend": 'print',"exportOptions": { columns: [0,1,2] },  "text": '<i class="fas fa-print"> Imprimir</i>', "title": 'Catalogo de Grupos'},
            //      "pageLength",
            // ],
            "processing": true,
            "serverSide": true,
            "ajax": "serversideArticulos.php",
            "lengthMenu": [[15, 30, 50, 100], [15, 30, 50, 100]],
            "pageLength": 15,
            "order": [1, 'asc'],
            // "destroy": true,
            "searching": true,
            // bSort: false,
            // "paging": false,
            // "searching": false,
            "bDestroy": true,
            "columnDefs":[
                {
                    "targets": [1, 2],
                    "className": 'dt-body-center' /*alineacion al centro th de tbody de la table*/
                },
                {
                    "targets": 2,
                    "render": function(data, type, row, meta){
                        // const primaryKey = data;
                        // "data": 'cve_entrada',
                        return  '<span class= "btn btn-success" onclick="obtenerDatos(\''+row[0]+'\',\''+row[1]+'\',\''+row[2]+'\')" title="Agregar" data-toggle="modal" data-target="#modalEditar" data-whatever="@getbootstrap">Agregar </span>';
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
function obtenerDatos(dato1,dato2,dato3){
    console.log(dato1,dato2,dato3);
}