app.controller('vistaCotizacion', function(BASEURL, ID, $scope, $http){
	$scope.proveedor = '';
	$scope.subircotizacion = '';
	$scope.fechaentrega = '';
	$scope.q_autoriza = '';
	$scope.usocfdi = '';
	$scope.formapago = '';
	$scope.metodopago = '';
	$scope.seleccionados = [];
	$scope.limpiarCampos = function () {
		jsShowWindowLoad('Limpiando campos...');
		$scope.proveedor = '';
		$scope.fechaentrega = '';
		$scope.usocfdi = '';
		$scope.formapago = '';
		$scope.metodopago = '';
		$scope.subircotizacion = '';
		$('#fileProductos').val([]);
		$http.post('serverSideCot.php').then(function (response) {
			// console.log('response', response.data.query);
			response = response.data.data;
			$scope.arrayRequisiciones = response;
			jsRemoveWindowLoad();
		}, function(error){
			console.log('error', error);
			jsRemoveWindowLoad();
		});
	}
	$scope.validacionCampos = function () {
		if ($scope.proveedor == '' || $scope.proveedor == null) {
			Swal.fire(
			  'Campo faltante',
			  'Es necesario seleccionar el proveedor',
			  'warning'
			);
			return;
		}
		$scope.fechaentrega = $('#fechaentrega').val();
		console.log('fecha', $scope.fechaentrega);
		if ($scope.fechaentrega == '' || $scope.fechaentrega == null) {
			Swal.fire(
			  'Campo faltante',
			  'Es necesario seleccionar una fecha de entrega',
			  'warning'
			);
			return;
		}
		if ($scope.usocfdi == '' || $scope.usocfdi == null) {
			Swal.fire(
			  'Campo faltante',
			  'Es necesario seleccionar un uso de CFDI',
			  'warning'
			);
			return;
		}
		if ($scope.formapago == '' || $scope.formapago == null) {
			Swal.fire(
			  'Campo faltante',
			  'Es necesario seleccionar una forma de pago',
			  'warning'
			);
			return;
		}
		if ($scope.metodopago == '' || $scope.metodopago == null) {
			Swal.fire(
			  'Campo faltante',
			  'Es necesario seleccionar un método de pago',
			  'warning'
			);
			return;
		}
		$scope.arrayCveReqDets = [];
		if ($scope.seleccionados.length == 0) {
			Swal.fire(
			  'Sin selecciones',
			  'No ha seleccionada ningún artículo.',
			  'warning'
			);
			return;
		}
		for (var i = 0; i < $scope.seleccionados.length; i++) {
			const index = $scope.seleccionados[i];
			const cantidad = $scope.arrayRequisiciones[index][13];
			const precioU = $scope.arrayRequisiciones[index][14];
			if (cantidad == undefined || parseFloat(cantidad) === 0 
				||precioU == undefined || parseFloat(precioU) === 0) {
				Swal.fire(
				  'Campo faltante',
				  'Es necesario agregar cantidad cotizada y precio unitario.',
				  'warning'
				);
				return;
			}
			$scope.arrayCveReqDets.push({
				'cve_req': $scope.arrayRequisiciones[index][0],
				'cve_req_det': $scope.arrayRequisiciones[index][12],
				'cve_art': $scope.arrayRequisiciones[index][6],
				'cantidad_solicitada': $scope.arrayRequisiciones[index][5],
				'cantidad': cantidad,
				'precioU': precioU,
				'total': $scope.arrayRequisiciones[index][8],
				'tipo': $scope.arrayRequisiciones[index][1],
			});
		}
		Swal.fire({
		  title: 'Estas a punto de generar una orden de compra',
		  text: '¿Es correcta la información agregada?',
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: 'green',
		  cancelButtonColor: 'orange',
		  confirmButtonText: 'Aceptar',
		  cancelButtonText: 'Revisar'
		}).then((result) => {
		  	if (result.isConfirmed) {
				jsShowWindowLoad('Generando orden de compra...');
				$http.post('Controller.php',{
					'requisiciones_det': $scope.arrayCveReqDets,
					'cve_proveedor': $scope.proveedor,
					'fechaentrega': $scope.fechaentrega,
					'cve_cfdi': $scope.usocfdi,
					'formapago': $scope.formapago,
					'metodopago': $scope.metodopago,
					'cve_usuario': ID,
					'q_autoriza': $scope.q_autoriza,
					'task': 'generaOrdenCompra'
				}).then(function (response) {
					console.log('response', response.data);
					// 'cve_odc': response.cve_odc;
					response = response.data;
					if (response.code == 200) {
						const input = document.getElementById('fileProductos');
						if (input.files.length == 0) {
							// Si no hay archivos seleccionados termina la función
							jsRemoveWindowLoad();
							console.log('response.cve_odc', response.cve_odc, response);
							Swal.fire({
							  title: '¡Éxito!',
							  html: 'Orden de compra generada correctamente.\n <b>Folio: ' +response.cve_odc+ '</b>' ,
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
						   	return;
						}
						jsShowWindowLoad('Guardando archivos...');
				        const formData = new FormData();
				        for (var i = 0; i < input.files.length; i++) {
				            formData.append("archivos[]", input.files[i]); 
				        }
				        formData.append('cve_odc', response.cve_odc);
				        formData.append('task', 'guardaArchivos');
				        $http({ 
				            method: 'post', 
				            url: 'Controller.php', 
				            data: formData, 
				            headers: {'Content-Type': undefined}, 
				        }).then(function successCallback(response) {
				            jsRemoveWindowLoad();
				            console.log('response.data', response.data);
				            if (response.data.code == 200) {
				            	Swal.fire(
								  '¡Éxito!',
								  'Orden de compra generada y archivos guardados satisfactoriamente.',
								  'success'
								);
								Swal.fire({
								  title: '¡Éxito!',
								  text: 'Orden de compra generada y archivos guardados satisfactoriamente.\n Folio: '+response.data.cve_odc,
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
							   	return;
				            }else{
								console.log(response.data);
				            	Swal.fire(
								  'Error',
								  'Error al guardar los archivos.',
								  'error'
								);
				            }
				        }, function(error){
				        	jsRemoveWindowLoad();
				        	console.log('error', error);
				        });
					}else{
						jsRemoveWindowLoad();
						Swal.fire(
						  'Error',
						  'Error en el controlador.',
						  'warning'
						);
					}
				}, function(error){
					console.log('error', error);
				});
				return;
		  	}
		});
	}
	$scope.checkRequisicion = function(i){
		if ($scope.q_autoriza != '' && $scope.q_autoriza != $scope.arrayRequisiciones[i][2]) {
			console.log($scope.q_autoriza , $scope.arrayRequisiciones[i][2]);
			Swal.fire(
			  'Autorización diferente',
			  'La selección no corresponde al código de autorizador de las selección(es) anteriores.',
			  'warning'
			);
			$scope.arrayRequisiciones[i][16] = false;
			return;
		}
		if ($scope.arrayRequisiciones[i][16] == true) { //Si el checkbox está seleccionado
			// si la posicion seleccionada no se ha guardado en el arreglo de seleccionados, entonces se agregará al arreglo de seleccionados
			if ($scope.seleccionados.indexOf(i) < 0) {
				$scope.seleccionados.push(i);
				$scope.q_autoriza = $scope.arrayRequisiciones[i][2];

			}
		}else{
			// Si el checkbox esta des seleccionado entonces se quitará la posicion del arreglo de seleccionados
			$scope.seleccionados = $scope.seleccionados.filter((item) => item !== i);
		}
		// obtenemos el tipo de la posicion seleccionada
		const tipo = $scope.arrayRequisiciones[i][1];
		// iteramos el arreglo de requisiciones
		for (var i = 0; i < $scope.arrayRequisiciones.length; i++) {
			// Si no hay ningún checkbox seleccionado la propiedad disabled de todos se inhabilitara
			if ($scope.seleccionados.length == 0) {
				$scope.arrayRequisiciones[i][15] = false;
			}else{
				if ($scope.arrayRequisiciones[i][1] != tipo) {
					// el disabled de lo que no sean del mismo tipo se habilitara
					$scope.arrayRequisiciones[i][15] = true;
				}else{
					// el disabled de lo que sean del mismo tipo se inhabilitara
					$scope.arrayRequisiciones[i][15] = false;
				}
			}
		}
		if ($scope.seleccionados.length == 0) {
			$scope.q_autoriza = '';
		}
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
	$scope.setFixed = function(i){
		if ($scope.arrayRequisiciones[i][13]) {
			$scope.arrayRequisiciones[i][13] = parseFloat($scope.arrayRequisiciones[i][13]).toFixed(4);
		}
	}
	$scope.setCantidad = function(i){
		const cantidad = $scope.setNumerico($scope.arrayRequisiciones[i][13]);
		if (parseFloat(cantidad) > parseFloat($scope.arrayRequisiciones[i][5])) {
			// console.log(parseFloat(cantidad) , );
			Swal.fire(
			  'Cantidad incorrecta',
			  'La cantidad máxima es '+ $scope.arrayRequisiciones[i][5],
			  'warning'
			);
			$scope.arrayRequisiciones[i][13] = $scope.arrayRequisiciones[i][5];
			return;
		}
		$scope.arrayRequisiciones[i][13] = cantidad;
		$scope.setPrecioU(i);
	}
	$scope.setPrecioU = function(i){
		const cantidad = parseFloat($scope.arrayRequisiciones[i][13]);
		const setPrecioU = parseFloat($scope.arrayRequisiciones[i][14]);
		if (cantidad > 0 && setPrecioU > 0) {
			const multiplica = cantidad * setPrecioU;
			$scope.arrayRequisiciones[i][8] = multiplica;//campo total
		}else{
			$scope.arrayRequisiciones[i][8] = 0;
		}
	}
	$http.post('serverSideCot.php').then(function (response) {
		response = response.data.data;
		// console.log('response', response);
		$scope.arrayRequisiciones = response;
	}, function(error){
		console.log('error', error);
	});
});