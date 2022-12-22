app.controller('vistaEntradasGlobal', function(BASEURL, ID, $scope, $http) {
	$http.post('ssEntradas.php', {}).then(function (result) {
		$scope.entradas = result.data.data;
		console.log('result', result.data.data);
	}, function(error){
		console.log('error', error);
	});
	$scope.Verentradas = function(cve_mov) {
		$("#tablaModal").html('');
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
	$scope.cancelar = function(i){
		Swal.fire({
			title: 'Cancelar entrada',
			html: '¿Realmente desea cancelar la entrada?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: 'green',
			confirmButtonText: 'Aceptar',
			cancelButtonColor: 'red',
			cancelButtonText: 'Cancelar'
		}).then((cancelar) => {
			if (cancelar.isConfirmed) {
				jsShowWindowLoad('Cancelando...');
				console.log(i, $scope.entradas[i]);
				$http.post('Controller.php', {
					'task': 'cancelar',
					'cve_mov': $scope.entradas[i][0],
					'ID': ID
				}).then(function (result) {
					jsRemoveWindowLoad();
					console.log('result', result.data);
					if (result.data.code == 200) {
						Swal.fire({
							title: '¡Éxito!',
							html: 'La entrada se canceló correctamente.\n <b>Folio de cancelación: ' +result.data.folio + '</b>',
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
		console.log('cve_mov', $scope.entradas[i][0]);
		$http.post('Controller.php', {
			'task': 'getDatosImprimir',
			'cve_mov': $scope.entradas[i][0]
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

