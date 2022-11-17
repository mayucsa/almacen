app.controller('vistaEntradas', function(BASEURL, ID, $scope, $http) {
	$scope.folioodc = '';
	$scope.tipo = '';
	$scope.foliofactura = '';
	$scope.fechafactura = '';

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
		$scope.fechafactura = $('#fechafactura').val();
		console.log('fecha', $scope.fechafactura);
		if ($scope.fechafactura == '' || $scope.fechafactura == null) {
			Swal.fire(
			  'Campo faltante',
			  'Es necesario ingresar la fecha de la factura/remisión',
			  'warning'
			);
			return;
		}
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
					'id': ID
				}).then(function (response){
					response = response.data;
					console.log('response', response);
					jsRemoveWindowLoad();

					Swal.fire({
					  title: '¡Éxito!',
					  html: 'La entrada se generó correctamente.\n <b>Folio: ' +response.folio + '</b>',
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
					})
				})
			}
		})
	}
})