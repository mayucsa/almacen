app.controller('vistaSalidas', function (BASEURL, ID, $scope, $http){
	$scope.foliovale = '';
	$scope.concepto = '';
	$scope.departamento = '';
	$scope.maquinas = '';
	$scope.horometro = '';
	$scope.comentarios = '';

	// Funciones
	$scope.setModalArticulos = function(){
		if ($scope.modalArticulos == false) {
			$scope.modalArticulos = true;
		}else{
			$scope.modalArticulos = false;
		}
	}

	$scope.limpiarCampos = function() {
		$scope.foliovale = '';
		$scope.concepto = '';
		$scope.departamento = '';
		$scope.maquinas = '';
		$scope.horometro = '';
		$scope.comentarios = '';
	}

	$scope.validacionCampos = function() {
		if ($scope.foliovale == '' || $scope.foliovale == null) {
			Swal.fire(
			  'Campo faltante',
			  'Es necesario ingresar el folio del vale',
			  'warning'
			);
			return;
		}
		if ($scope.concepto == '' || $scope.concepto == null) {
			Swal.fire(
			  'Campo faltante',
			  'Es necesario ingresar un concepto',
			  'warning'
			);
			return;
		}
		if ($scope.departamento == '' || $scope.departamento == null) {
			Swal.fire(
			  'Campo faltante',
			  'Es necesario seleccionar un departamento',
			  'warning'
			);
			return;
		}
		if ($scope.maquinas == '' || $scope.maquinas == null) {
			Swal.fire(
			  'Campo faltante',
			  'Es necesario seleccionar una máquina',
			  'warning'
			);
			return;
		}
		Swal.fire({
		  title: 'Estás a punto de generar una salida.',
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
					'foliovale': $scope.foliovale,
					'concepto': $scope.concepto,
					'departamento': $scope.departamento,
					'maquinas': $scope.maquinas,
					'horometro': $scope.horometro,
					'comentarios': $scope.comentarios,
					'id': ID
				}).then(function (response){
					response = response.data;
					console.log('response', response);
					jsRemoveWindowLoad();

					Swal.fire({
					  title: '¡Éxito!',
					  html: 'La salida se generó correctamente.\n <b>Folio: ' +response.folio + '</b>',
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