app.controller('vistaCotizacion', function(BASEURL, ID, $scope, $http){
	$scope.proveedor = '';
	$scope.subircotizacion = '';
	$scope.cve_req = '';
	$scope.seleccionados = [];
	$scope.limpiarCampos = function () {
		$scope.proveedor = '';
		$scope.subircotizacion = '';
		$('#fileProductos').val([]);
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
		jsShowWindowLoad('Generando orden de compra...');
		var arrayCveReqDets = [];
		for (var i = 0; i < $scope.seleccionados.length; i++) {
			const index = $scope.seleccionados[i];
			arrayCveReqDets.push({
				'cve_req': $scope.arrayRequisiciones[index][0],
				'cve_req_det': $scope.arrayRequisiciones[index][12],
				'cve_art': $scope.arrayRequisiciones[index][6],
				'cantidad': $scope.arrayRequisiciones[index][13],
				'precioU': $scope.arrayRequisiciones[index][14],
				'total': $scope.arrayRequisiciones[index][8],
				'tipo': $scope.arrayRequisiciones[index][1],
			});
		}
		$http.post('Controller.php',{
			'requisiciones_det': arrayCveReqDets,
			'cve_proveedor': $scope.proveedor,
			'cve_req': $scope.cve_req,
			'task': 'generaOrdenCompra'
		}).then(function (response) {
			console.log('response', response.data);
			response = response.data;
			if (response.code == 200) {
				const input = document.getElementById('fileProductos');
				if (input.files.length == 0) {
					// Si no hay archivos seleccionados termina la función
					jsRemoveWindowLoad();
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
						  'Archivos guardados satisfactoriamente.',
						  'success'
						);
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
		return
	}
	$scope.checkRequisicion = function(i){
		if ($scope.cve_req != '' && $scope.cve_req != $scope.arrayRequisiciones[i][0]) {
			Swal.fire(
			  'Requisición diferente',
			  'La selección no corresponde al código de requisición previamente seleccionado.',
			  'warning'
			);
			$scope.arrayRequisiciones[i][16] = false;
			return;
		}
		if ($scope.arrayRequisiciones[i][16] == true) { //Si el checkbox está seleccionado
			// si la posicion seleccionada no se ha guardado en el arreglo de seleccionados, entonces se agregará al arreglo de seleccionados
			if ($scope.seleccionados.indexOf(i) < 0) {
				$scope.seleccionados.push(i);
				$scope.cve_req = $scope.arrayRequisiciones[i][0];

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
			$scope.cve_req = '';
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
		if (cantidad > $scope.arrayRequisiciones[i][5]) {
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
		}
	}
	$http.post('serverSideCot.php').then(function (response) {
		// console.log('response', response.data.query);
		response = response.data.data;
		$scope.arrayRequisiciones = response;
	}, function(error){
		console.log('error', error);
	});
});