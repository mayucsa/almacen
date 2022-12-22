app.controller('vistaSalidasGlobal', function (BASEURL, ID, $scope, $http){
	$http.post('ssSalidas.php', {}).then(function (result) {
		$scope.salidas = result.data.data;
		console.log('ssSalidas', result.data.data);
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

