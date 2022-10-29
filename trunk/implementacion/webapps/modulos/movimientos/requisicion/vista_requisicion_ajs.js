app.controller('vistaRequisicion', function(BASEURL, ID, $scope, $http){
	$scope.productosAgregados = [];
	$scope.arrayAgregados = [];
	$scope.cve_alterna = '';
	$scope.nombre_articulo = '';
	$scope.autoriza = '';
	$scope.comentario = '';
	$scope.modalMisRequ = false;
	$scope.misRequisitos = [];
	// 
	$http.post('Controller.php', {
		'task': 'getMaquinas'
	}).then(function (response) {
		response = response.data;
		$scope.arrayMaquinas = response;
	}, function(error){
		console.log('error', error);
	});
	$http.post('Controller.php', {
		'task': 'getMisRequisiciones',
		'cve_usuario': ID
	}).then(function (response) {
		response = response.data;
		$scope.misRequisitos = response;
	}, function(error){
		console.log('error', error);
	});
	// Funciones
	$scope.setModalMisRequ = function(){
		if ($scope.modalMisRequ == false) {
			$scope.modalMisRequ = true;
		}else{
			$scope.modalMisRequ = false;
		}
		// console.log($scope.modalMisRequ);
	}
	$scope.agregarProducto = function(i){
		if ($scope.arrayAgregados.indexOf($scope.arrayProductos[i].cve_alterna) < 0) {
			$scope.productosAgregados.push({
				'cve_alterna': $scope.arrayProductos[i].cve_alterna,
				'nombre_articulo': $scope.arrayProductos[i].nombre_articulo,
				'cve_articulo': $scope.arrayProductos[i].cve_articulo,
				'cantidad': 1
			});
			$scope.arrayAgregados.push($scope.arrayProductos[i].cve_alterna);
		}else{
			Swal.fire(
			  '',
			  'Producto agregado previamente',
			  'warning'
			)
		}
	}
	$scope.eliminarProductoAgregado = function(i){
		Swal.fire({
		  title: 'Eliminar Producto',
		  text: '¿Realmente deseas eliminar '+$scope.productosAgregados[i].nombre_articulo+'?',
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Eliminar',
		  cancelButtonText: 'Cancelar'
		}).then((result) => {
		  if (result.isConfirmed) {
			$scope.$apply(function(){
				$scope.quitarProducto(i);
			}, 2000)
		    
		  }
		})
	}
	$scope.quitarProducto = function(i){
		$scope.arrayAgregados.splice(i, 1);
		$scope.productosAgregados.splice(i, 1);
	}
	$scope.limpiarCampos = function(){
		$scope.autoriza = '';
		$scope.comentario = '';
		$scope.productosAgregados = [];
		$scope.arrayAgregados = [];
	}
	$scope.validacionCampos = function(){
		if ($scope.autoriza == '' || $scope.autoriza == null) {
			Swal.fire(
			  'Campo faltante',
			  'Es necesario seleccionar la persona que autoriza la requisición',
			  'warning'
			);
			return;
		}
		if ($scope.comentario == '' || $scope.comentario == null) {
			Swal.fire(
			  'Campo faltante',
			  'Es necesario escribir un comentario',
			  'warning'
			);
			return;
		}
		if ($scope.productosAgregados.length == 0) {
			Swal.fire(
			  'Sin articulos',
			  'No has seleccionado ningún artículo',
			  'warning'
			);
			return;
		}
		// validar que los articulos tengan maquina seleccionada
		for (var i = 0; i < $scope.productosAgregados.length; i++) {
			if (!$scope.productosAgregados[i].comentario || $scope.productosAgregados[i].comentario == '') {
				Swal.fire({
				  	title: 'Producto sin comentario añadido',
				  	text: 'El artículo: '+$scope.productosAgregados[i].nombre_articulo+' no tiene comentario.',
				  	icon: 'warning',
				  	showConfirmButton: true
				})
				return;
			}
			if ($scope.productosAgregados[i].cantidad <= 0) {
				Swal.fire({
				  	title: 'Cantidad menor no válida',
				  	text: 'El artículo: '+$scope.productosAgregados[i].nombre_articulo+' tiene una cantidad incorrecta.',
				  	icon: 'warning',
				  	showConfirmButton: true
				})
				return;
			}
		}
		Swal.fire({
		  title: 'Estás a punto de generar tu requisición.',
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
				'task': 'guardarRequisicion',
				'autoriza': $scope.autoriza,
				'comentario': $scope.comentario,
				'id': ID,
				'articulos': $scope.productosAgregados
			}).then(function (response) {
				response = response.data;
				// console.log('response', response);
				jsRemoveWindowLoad();
				if (response.code == 200) {
					$http.post('Controller.php', {
						'task': 'envioCorreo',
						'folio': response.folio
					}).then(function (res) {
						// console.log('res', res);
						console.log('Correo enviado');
					},function(error){
						console.log('Error', error);
					});
					Swal.fire({
					  title: '¡Éxito!',
					  text: 'Su requisición se generó correctamente.\n Folio: '+response.folio,
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
					alert('Error en controlador. \nFavor de ponerse en contacto con el administrador del sitio.');
				}
			}, function(error){
				console.log('error', error);
				jsRemoveWindowLoad();
			});
		  }
		})
	}
	$scope.getArticulos = function(){
		$http.post('Controller.php', {
			'task': 'getArticulos',
			'cve_alterna': $scope.cve_alterna,
			'nombre_articulo': $scope.nombre_articulo
		}).then(function (response) {
			$scope.arrayProductos = response.data;
			// console.log('generales...',response.data);
		}, function(error){
			console.log('error', error);
		});
	}
	$scope.getArticulos();
});