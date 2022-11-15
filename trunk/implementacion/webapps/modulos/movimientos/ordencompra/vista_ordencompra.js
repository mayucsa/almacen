function getOdcPDFformat(cve_odc){
    const odcPDFformat = {
        'fecha':'01/02/1999',
        'cve_odc': cve_odc,
    }
    $.ajax({
        method: "POST",
        url: "odcPDFformato.php",
        data: { datos: odcPDFformat }
    })
    .done(function( result ) {
        console.log( result );
    });
}
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
function imprimirPDF(cve_odc){
    console.log('asd');
    $.getJSON("modelo_ordencompra.php?consultar="+cve_odc, function(registros){
        var div = document.getElementById('modalVerMP');
        var ventimp = window.open(' ', 'popimpr');
        ventimp.document.write( '<html lang="en">');
        ventimp.document.write( '<head>');
        ventimp.document.write( '<meta charset="utf-8">');
        ventimp.document.write( '<meta name="description" content="Mayucsa - Materiales de Yucatan">');
        ventimp.document.write( '<meta http-equiv="X-UA-Compatible" content="IE=edge">');
        ventimp.document.write( '<meta name="viewport" content="width=device-width, initial-scale=1">');
        ventimp.document.write( '<meta name="author" content="Ing. Alfredo Fidel Chan Chuc">');
        ventimp.document.write( '<link rel="icon" href="../../../includes/imagenes/favicon.png">');
        ventimp.document.write( '<title>Almac&eacute;n</title>');
        ventimp.document.write( '<link rel="stylesheet" type="text/css" href="../../../includees/css/main.css">');
        ventimp.document.write( '<script src="../../../includes/js/jquery351.min.js"></script>');
        ventimp.document.write( '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>  ');
        ventimp.document.write( '<script src="../../../includes/js/popper.js"></script>');
        ventimp.document.write( '<script src="../../../includes/js/popper.min.js"></script>');
        ventimp.document.write( '<script src="../../../includes/bootstrap/js/bootstrap.js"></script>');
        ventimp.document.write( '<script src="../../../includes/bootstrap/js/bootstrap.min.js"></script>');
        ventimp.document.write( '<link rel="stylesheet" href="../../../includes/css/alertify.min.css"/>');
        ventimp.document.write( '<link rel="stylesheet" href="../../../includes/css/default.min.css"/>');
        ventimp.document.write( '<link rel="stylesheet" href="../../../includes/css/font.css" >');
        ventimp.document.write( '<script type="text/javascript" src="../../../includes/js/angular.js"></script>');
        ventimp.document.write( '<script type="text/javascript" src="../../../includes/js/angularinit.js"></script>');
        ventimp.document.write( '<script type="text/javascript" src="../../../includes/js/isloading.js"></script>');
        ventimp.document.write( '<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">');
        ventimp.document.write( '<script src="../../../includes/js/fontawesome.js"></script>');
        ventimp.document.write( '</head>' );
        ventimp.document.write( '<div class="form-group form-group-sm">');
        ventimp.document.write( '<div class="col-lg-12 d-lg-flex">');
        ventimp.document.write( '<div style="width: 50%;">');
        ventimp.document.write( '<label for="message-text" class="col-form-label">Folio Orden de compra:</label>');
        ventimp.document.write( '<span> <b>'+cve_odc+' </span>');
        ventimp.document.write( '</div>');
        ventimp.document.write( '</div>');
        ventimp.document.write( '</div>');
        ventimp.document.write( '<div class="table-responsive">' );
        ventimp.document.write( '<table class="table table-striped table-bordered table-hover w-100 shadow" id="tablaModal">' );
        ventimp.document.write( '<thead> <tr>  <th class="text-center">Folio req</th>');
        ventimp.document.write( '<th class="text-center">Articulo</th>');
        ventimp.document.write( '<th class="text-center">Cantidad</th>');
        ventimp.document.write( '<th class="text-center">Precio unitario</th>');
        ventimp.document.write( '<th class="text-center">Precio total</th></tr>');
        ventimp.document.write( '</thead> ');
        for (i = 0; i < registros.length; i++){
            ventimp.document.write( '<tr>'  );
            ventimp.document.write( '<td style="dislay: none;">' + registros[i].req + '</td>');
            ventimp.document.write( '<td style="dislay: none;">' + registros[i].articulo + '</td>');
            ventimp.document.write( '<td style="dislay: none;">' + registros[i].cantidad + '</td>');
            ventimp.document.write( '<td style="dislay: none;">' + registros[i].unitario + '</td>');
            ventimp.document.write( '<td align="center" style="dislay: none;">' + registros[i].total + '</td>'+'</tr>' );
        }
        ventimp.document.write( '</table> ');
        ventimp.document.write( '</div> ');
        ventimp.document.close();
        ventimp.print( );
        ventimp.close();

    });
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

    window.open('sendEmail.php?cve_odc='+cve_odc);
}
// 