app.controller('vistaCentroCostos', function (BASEURL, ID, $scope, $http){
	$scope.codcc = '';
	// $scope.nombrecc = '';
	$scope.concepto = '';
	$scope.area = '';

	$scope.limpiarCampos = function (){
		$scope.codcc = '';
		// $scope.nombrecc = '';
		$scope.concepto = '';
		$scope.tipo = '';
	}

	$scope.validacionCampos = function(){
		if ($scope.codcc == '' || $scope.codcc == null) {
			Swal.fire(
			  'Campo faltante',
			  'Es necesario escribir el código del centro del costo',
			  'warning'
			);
			return;
		}
		// if ($scope.nombrecc == '' || $scope.nombrecc == null) {
		// 	Swal.fire(
		// 	  'Campo faltante',
		// 	  'Es necesario escribir el nombre del centro del costo',
		// 	  'warning'
		// 	);
		// 	return;
		// }
		if ($scope.concepto == '' || $scope.concepto == null) {
			Swal.fire(
			  'Campo faltante',
			  'Es necesario seleccionar un concepto',
			  'warning'
			);
			return;
		}
		if ($scope.tipo == '' || $scope.tipo == null) {
			Swal.fire(
			  'Campo faltante',
			  'Es necesario seleccionar un tipo',
			  'warning'
			);
			return;
		}

		Swal.fire({
		  title: 'Estás a punto de crear un centro de costos.',
		  text: '¿Es correcta la información agregada?',
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: 'green',
		  cancelButtonColor: 'red',
		  confirmButtonText: 'Aceptar',
		  cancelButtonText: 'Cancelar'
		}).then((result) => {
			if (result.isConfirmed) {
				jsShowWindowLoad('Creando centro de costo...');
				$http.post('Controller.php', {
					'task': 'guardarCentroCostos',
					'codcc': $scope.codcc,
					// 'nombrecc': $scope.nombrecc,
					'concepto': $scope.concepto,
					'tipo': $scope.tipo,
					'id': ID,
				}).then(function (response) {
					response = response.data;
					console.log('response', response);
					jsRemoveWindowLoad();
					// if (response.code == 200) {
						Swal.fire({
							  title: '¡Éxito!',
							  html: 'Se he creado el centro de costo correctamente.',
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
					// }
					// else{
					// 	alert('Error en controlador. \nFavor de ponerse en contacto con el administrador del sitio.');
					// }
				}, function(error){
					console.log('error', error);
					jsRemoveWindowLoad();
				});
			}
		})

	}


})