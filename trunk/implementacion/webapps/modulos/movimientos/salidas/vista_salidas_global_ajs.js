app.controller('vistaSalidasGlobal', function (BASEURL, ID, $scope, $http){
	$scope.tBodyModalDev = [];
	$http.post('ssSalidas.php', {}).then(function (result) {
		$scope.salidas = result.data.data;
		console.log('ssSalidas', result.data.data);
		setTimeout(function(){
			$('#tableSalidasGlobales').DataTable({
		        "processing": true,
		        "bDestroy": true,
				"order": [0, 'desc'],
				"lengthMenu": [[15, 30, 45], [15, 30, 45]],
			     "language": {
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
			});
		},800);
	}, function(error){
		console.log('error', error);
	});
	$scope.Versalidas = function(cve_mov) {
		$("#tablaModal").html('');
	    $.getJSON("modelo_salidas.php?consultar="+cve_mov, function(registros){
	        console.log(registros);

	        $('#inputname').val(registros[0]['cve_mov']);
	        $('#folio_vale').val(registros[0]['folio_vale']);
	        $('#concepto').val(registros[0]['concepto']);
	        $('#depto').val(registros[0]['nombre_depto']);
	        $('#maquina').val(registros[0]['nombre_maq']);

	        $("#tablaModal").html( '<thead> <tr>     <th class="text-center">Cve articulo</th>'+
	                                                '<th class="text-center">Descripcion</th>'+
	                                                '<th class="text-center">Cantidad</th>'+
	                                                '<th class="text-center">Unidad medida</th>'+
	                                                '<th class="text-center">Centro de costo</th>'+
	                                    '</thead>');
	        for (i = 0; i < registros.length; i++){
	            // txt += $('#inputcantidad').val(registros[i]['Cantidad']);
	            // $('#inputmp').text(registros[i]['MateriaPrima']) + $('#inputcantidad').val(registros[i]['Cantidad']);
	             $("#tablaModal").append('<tr>' + 
	                '<td style="dislay: none;">' + registros[i].cve_articulo + '</td>'+
	                '<td style="dislay: none;">' + registros[i].nombre_articulo + '</td>'+
	                '<td style="dislay: none;">' + registros[i].cantidad_salida + '</td>'+
	                '<td style="dislay: none;">' + registros[i].unidad_medida + 
	                '<td style="dislay: none;">' + registros[i].cve_cc + 
	                '</td>'
	                +'</tr>');
	        }
	    });
	}
	$scope.Verdevoluciones = function (cve_mov) {
		$scope.tBodyModalDev = [];
		$('#inputnamed').val('');
		$('#folio_valed').val('');
		$('#conceptod').val('');
		$('#deptod').val('');
		$('#maquinad').val('');
		// $("#tablaModalDev").html('');
	    $.getJSON("modelo_salidas.php?consultar="+cve_mov, function(registros){
	        console.log('Verdevoluciones', registros);

	        $('#inputnamed').val(registros[0]['cve_mov']);
	        $('#folio_valed').val(registros[0]['folio_vale']);
	        $('#conceptod').val(registros[0]['concepto']);
	        $('#deptod').val(registros[0]['nombre_depto']);
	        $('#maquinad').val(registros[0]['nombre_maq']);
	        $scope.$apply(function(){
	        	$scope.tBodyModalDev = registros;
	        }, 500)
	        console.log('$scope.tBodyModalDev', $scope.tBodyModalDev);
	        // $("#tablaModalDev").html( '<thead> <tr>     <th class="text-center">Cve articulo</th>'+
	        //                                         '<th class="text-center">Descripcion</th>'+
	        //                                         '<th class="text-center">Cantidad</th>'+
	        //                                         '<th class="text-center">Unidad medida</th>'+
	        //                                         '<th class="text-center">Centro de costo</th>'+
	        //                                         '<th class="text-center">Cantidad a devolver</th>'+
	        //                                         '<th class="text-center">Comentario</th>'+
	        //                                         '<th class="text-center">Accion</th>'+
	        //                             '</thead>');
	        // for (i = 0; i < registros.length; i++){
	        //     // txt += $('#inputcantidad').val(registros[i]['Cantidad']);
	        //     // $('#inputmp').text(registros[i]['MateriaPrima']) + $('#inputcantidad').val(registros[i]['Cantidad']);
	        //      $("#tablaModalDev").append('<tr>' + 
	        //         '<td class="text-center" style="dislay: none;">' + registros[i].cve_articulo + '</td>'+
	        //         '<td class="text-center" style="dislay: none;">' + registros[i].nombre_articulo + '</td>'+
	        //         '<td class="text-center" style="dislay: none;">' + registros[i].cantidad_salida + '</td>'+
	        //         '<td class="text-center" style="dislay: none;">' + registros[i].unidad_medida + '</td>'+
	        //         '<td class="text-center" style="dislay: none;">' + registros[i].cve_cc +  '</td>' +
	        //         '<td class="text-center" style="dislay: none;">' + '<input type="text" class="form-control form-control-md validanumericos">' +  '</td>' +
	        //         '<td class="text-center" style="dislay: none;">' + '<input type="text" class="form-control form-control-md UpperCase">' +  '</td>' +
	        //         '<td class="text-center" style="dislay: none;">' + '<button type="button" class="btn btn-info">Devolver</button>' +  '</td>'
	        //         +'</tr>');
	        // }
	    });
	}
	$scope.setNumerico = function(numero){
		if (numero == undefined) return;
		var aux = '';
		for (var x = 0; x < numero.length; x++) {
			if (!isNaN(numero[x])) {
				aux = aux +''+numero[x];
			}else{
				if (numero[x] == '.') {
					if ((numero.substring(0, x+1)).split('.').length == 2) {
						aux = aux +''+numero[x];
					}
				}
			}
		}
		return aux;
	}
	$scope.validaCantidadDevolucion = function(i){
		const datos = $scope.tBodyModalDev[i];
		$scope.tBodyModalDev[i].cantidadDevolver = $scope.setNumerico(datos.cantidadDevolver);
		if (datos.cantidad_salida < datos.cantidadDevolver) {
			Swal.fire('Cantidad excedida','La cantidad a devolver debe ser igual o menor a la cantidad que se le dio salida','warning');
			$scope.tBodyModalDev[i].cantidadDevolver = datos.cantidad_salida;
		}
	}
	$scope.validaDevolucion = function(i){
		if ($scope.tBodyModalDev[i].comentario != '' && $scope.tBodyModalDev[i].comentario != undefined 
			&& $scope.tBodyModalDev[i].cantidadDevolver > 0 && $scope.tBodyModalDev[i].cantidadDevolver != undefined) {
			Swal.fire({
			  title: 'Estas a punto de generar una devolución',
			  text: '¿Es correcta la información agregada?',
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: 'green',
			  cancelButtonColor: 'orange',
			  confirmButtonText: 'Aceptar',
			  cancelButtonText: 'Revisar'
			}).then((result) => {
				if (result.isConfirmed) {
					$scope.devolverArticulos(i);
				}
			});
		}else{
			Swal.fire('Campos requeridos','Es necesario ingresar cantidad a devolver y comentario.','warning');
		}
	}
	$scope.devolverArticulos = function(i){
		jsShowWindowLoad('Generando devolución...');
		$http.post('Controller.php', {
			'task': 'devolucion',
			'datos': $scope.tBodyModalDev[i]
		}).then(function (result) {
			jsRemoveWindowLoad();
			result = result.data;
			console.log('devolucion', result);
			if (result.code == 200) {
				Swal.fire(
					'¡Éxito!',
					'Se ha generado la devolución. \n <b>Folio devolución: '+result.cve_ctrl_dev+'</b>', 
					'success'
				);
				$scope.Verdevoluciones($scope.tBodyModalDev[i].cve_mov);
			}else{
				Swal.fire('Error','Error en el controlador, revisar consola.','warning');
			}
		}, function(error){
			jsRemoveWindowLoad();
			console.log('error', error);
			Swal.fire('Error','Error en el controlador, revisar consola.','error');
		});	
	}
	$scope.cancelar = function(i){
		Swal.fire({
			title: 'Cancelar salida',
			html: '¿Realmente desea cancelar la salida?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: 'green',
			confirmButtonText: 'Aceptar',
			cancelButtonColor: 'red',
			cancelButtonText: 'Cancelar'
		}).then((cancelar) => {
			if (cancelar.isConfirmed) {
				jsShowWindowLoad('Cancelando...');
				console.log(i, $scope.salidas[i]);
				$http.post('Controller.php', {
					'task': 'cancelar',
					'cve_mov': $scope.salidas[i][0],
					'ID': ID
				}).then(function (result) {
					jsRemoveWindowLoad();
					console.log('result', result.data);
					if (result.data.code == 200) {
						Swal.fire({
							title: '¡Éxito!',
							html: 'La salida se canceló correctamente.\n <b>Folio de cancelación: ' +result.data.folio + '</b>',
							icon: 'success',
							showCancelButton: false,
							confirmButtonColor: 'green',
							confirmButtonText: 'Aceptar'
						}).then((result) => {
							if (result.isConfirmed) {
								location.reload();
							}else{
								location.reload();
							}
						});
					}else{
						Swal.fire('Error', result.data.msj, 'warning');
					}
				}, function(error){
					jsRemoveWindowLoad();
					console.log('error', error);
					Swal.fire('Error','Error en el controlador, revisar consola.','error');
				});	
			}
		});
	}
	$scope.startImprSelec = function(i, id){
		jsShowWindowLoad('Buscando información...');
		console.log('cve_mov', $scope.salidas[i][0]);
		$http.post('Controller.php', {
			'task': 'getDatosImprimir',
			'cve_mov': $scope.salidas[i][0]
		}).then(function (result) {
			console.log('result', result.data);
			$scope.datosImprimir = result.data;
			jsRemoveWindowLoad();
			setTimeout(function(){
				imprSelec(id);
			}, 500);
		}, function(error){
			console.log('error', error);
		});
	}
});

function imprSelec(id) {
	var div = document.getElementById(id);
    var ventimp = window.open(' ', 'popimpr');
    ventimp.document.write( div.innerHTML );
    ventimp.document.close();
    ventimp.print( );
    ventimp.close();
}

