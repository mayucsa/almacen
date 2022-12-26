app.controller('vistaEntradas', function(BASEURL, ID, $scope, $http) {
	$scope.folioodc = '';
	$scope.tipo = '';
	$scope.foliofactura = '';
	$scope.fechafactura = '';
	$scope.totalFact = 0;
	$scope.limpiarCampos = function() {
		$scope.folioodc = '';
		$scope.tipo = '';
		$scope.foliofactura = '';
		$scope.fechafactura = '';
	}
	$scope.validacionCampos = function() {
		if ($scope.folioodc == '' || $scope.folioodc == null) {
			Swal.fire(
			  'Campo faltante',
			  'Es necesario ingresar el folio de la orden de compra',
			  'warning'
			);
			return;
		}
		if ($scope.tipo == '' || $scope.tipo == null) {
			Swal.fire(
			  'Campo faltante',
			  'Es necesario ingresar el tipo de documento',
			  'warning'
			);
			return;
		}
		if ($scope.foliofactura == '' || $scope.foliofactura == null) {
			Swal.fire(
			  'Campo faltante',
			  'Es necesario ingresar el folio del documento',
			  'warning'
			);
			return;
		}
		$scope.fechafactura = $('#nextFocusHeader3').val();
		// console.log('fecha', $scope.fechafactura);
		if ($scope.fechafactura == '' || $scope.fechafactura == null) {
			Swal.fire(
			  'Campo faltante',
			  'Es necesario ingresar la fecha de la factura/remisión',
			  'warning'
			);
			return;
		}
		var aux = 0;
		var auxCantidades = 0;
		var auxSinChec = 0;
		var auxSincantidad = 0;
		var auxIncongruencias = 0;
		for (var i = 0; i < $scope.ordenCompraDetalle.length; i++) {
			if ($scope.ordenCompraDetalle[i].cantidad > 0) {
				auxCantidades++;
			}
			if ( $scope.ordenCompraDetalle[i].chkd == true ) {
				aux++;
				if ($scope.ordenCompraDetalle[i].cantidad > 0) {
					// ok
				}else{
					// Si tiene el check activo pero no se ha agregado cantidad alguna
					auxSincantidad++;
					auxIncongruencias++;
				}

			}
			if ($scope.ordenCompraDetalle[i].chkd != true 
				&& $scope.ordenCompraDetalle[i].cantidad > 0) {
				// Si no está checado pero la cantidad agergada es mayor a cero
				auxSinChec++;
				auxIncongruencias++;
			}
		}
		if (aux == 0) {
			Swal.fire(
			  'Sin selecciones',
			  'Es necesario seleccionar almenos una requisición',
			  'warning'
			);
			return;
		}
		if (auxCantidades == 0) {
			Swal.fire(
			  'Cantidades incorrectas',
			  'Es necesario que las cantidades a recibir de los artículos seleccionados sean mayor a cero',
			  'warning'
			);
			return;
		}
		if (auxIncongruencias == $scope.ordenCompraDetalle.length) {
			Swal.fire(
			  'Incongruencia encontrada',
			  'La información agregada es incorrecta, no se tiene ningún campo correcto.',
			  'warning'
			);
			return;
		}
		if (auxSincantidad > 0) {
			$scope.mostrarInconsistencia('Cantidad incorrecta',
			'Se ha encontrado al menos un artículo seleccionado pero con cantidad incorrecta. \n'+
			'¿Desea continuar o revisar la información?'
			);
			return;
		}
		if (auxSinChec > 0) {
			$scope.mostrarInconsistencia('Artículo no seleccionado',
			'Se ha encontrado al menos un artículo sin seleccionar pero con cantidad agregada. \n'+
			'¿Desea continuar o revisar la información?'
			);
			return;
		}
		$scope.generarEntrada();
	}
	$scope.mostrarInconsistencia = function(titulo, texto){
		Swal.fire({
			title: titulo,
			text: texto,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: 'green',
			cancelButtonColor: 'orange',
			confirmButtonText: 'Aceptar',
			cancelButtonText: 'Revisar'
		}).then((result) => {
			if (result.isConfirmed) {
				$scope.generarEntrada();
			}
		});
	}
	$scope.generarEntrada = function(){
		Swal.fire({
			title: 'Estás a punto de generar una entrada.',
			text: '¿Es correcta la información agregada?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: 'green',
			cancelButtonColor: 'red',
			confirmButtonText: 'Aceptar',
			cancelButtonText: 'Cancelar'
		}).then((result) => {
			if (result.isConfirmed) {
				jsShowWindowLoad('Generando folio...');
				$http.post('Controller.php', {
					'task': 'guardarMovimiento',
					'folioodc': $scope.folioodc,
					'tipo': $scope.tipo,
					'foliofactura': $scope.foliofactura,
					'fechafactura': $scope.fechafactura,
					'id': ID,
					'ordenCompraDetalle': $scope.ordenCompraDetalle
				}).then(function (response){
					response = response.data;
					// console.log('response', response);
					jsRemoveWindowLoad();
					if (response.code == 200) {
						$scope.folioEntrada = response.folio;
						for (var i = 0; i < $scope.ordenCompraDetalle.length; i++) {
							$scope.totalFact += parseFloat($scope.ordenCompraDetalle[i].total);
						}
						Swal.fire({
						  title: '¡Éxito!',
						  html: 'La entrada se generó correctamente.\n <b>Folio: ' +response.folio + '</b>',
						  icon: 'success',
						  showCancelButton: false,
						  confirmButtonColor: 'green',
						  confirmButtonText: 'Aceptar'
						}).then((result) => {
							if (result.isConfirmed) {
								imprSelec('inicial_container');
								location.reload();
							}else{
								imprSelec('inicial_container')
								location.reload();
							}
						})
					}else{
						Swal.fire('Error','Error en el controlador, revisar consola.','error');
					}
				})
			}
		})
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
	$scope.calculaTotal = function(i){
		const requisicion = $scope.ordenCompraDetalle[i];
		$scope.ordenCompraDetalle[i].cantidad = $scope.setNumerico(requisicion.cantidad);
		if (requisicion.cantidad > requisicion.cantidad_cotizada) {
			Swal.fire('Cantidad incorrecta','La cantidad seleccionada debe ser menor a la cantidad cotizada. ','error');
			$scope.ordenCompraDetalle[i].cantidad = requisicion.cantidad_cotizada;
		}
		if (parseFloat(requisicion.cantidad) > 0) {
			// console.log('cantidad: ', parseFloat(requisicion.cantidad));
			$scope.ordenCompraDetalle[i].total = (parseFloat(requisicion.cantidad)
						* parseFloat(requisicion.precio_unidad)).toFixed(2);
		}else{
			$scope.ordenCompraDetalle[i].total = 0;
		}
	}
	$scope.checkEntrada = function(i){
		// console.log($scope.ordenCompraDetalle[i].chkd);
	}
	$scope.validaFolio = function(folio){
		if (folio == '' || folio == undefined) {
			return;
		}
		jsShowWindowLoad('Validando folio...');
		$http.post('Controller.php', {
			'task': 'validaFolio',
			'folio': folio
		}).then(function (response) {
			jsRemoveWindowLoad();
			console.log('ordenCompraDetalle: ',response.data);
			$scope.ordenCompraDetalle = response.data;
			if (response.data.length == 0) {
				Swal.fire('Sin información','No existe información asociada al folio ingresado. ','error');
			}else{
				for (var i = 0; i < $scope.ordenCompraDetalle.length; i++) {
					$scope.ordenCompraDetalle[i].cantidad = $scope.ordenCompraDetalle[i].cantidad_cotizada;
					$scope.ordenCompraDetalle[i].chkd = true;
					$scope.ordenCompraDetalle[i].total = parseFloat($scope.ordenCompraDetalle[i].cantidad) * parseFloat($scope.ordenCompraDetalle[i].precio_unidad)
				}
				console.log('$scope.ordenCompraDetalle', $scope.ordenCompraDetalle);
				$http.post('Controller.php', {
					'task': 'getProveedor',
					'cve_odc': response.data[0].cve_odc
				}).then(function (result) {
					$scope.cve_odc = response.data[0].cve_odc;
					$scope.proveedor = result.data.nombre_proveedor;
				}, function(error){
					console.log('error', error);
				});
				$('#nextFocusHeader1').focus();
				$('#nextFocusHeader1').click();
			}
		}, function(error){
			console.log('error', error);
			jsRemoveWindowLoad();
		});
	}

	$scope.inputCharacters = function(i, tipo = '') {
		i++;
		if (tipo != '') {
			if (i == 1) {
				$('#nextFocusHeader1').focus();
				$('#nextFocusHeader1').click();
			}else{
				$('#nextFocusHeader'+i).focus();
			}
			return;
		}
		if (i == $scope.ordenCompraDetalle.length ) {
			$('#nextFocusHeader0').focus();
		}else{
			$('#nextFocus'+i).focus();
		}
	}
})

function imprSelec(id) {
	var div = document.getElementById(id);
    var ventimp = window.open(' ', 'popimpr');
    ventimp.document.write( div.innerHTML );
    ventimp.document.close();
    ventimp.print( );
    ventimp.close();
}

