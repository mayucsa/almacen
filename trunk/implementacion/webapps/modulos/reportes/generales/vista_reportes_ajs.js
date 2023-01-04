app.controller('vistaReportes', function(BASEURL, ID, $scope, $http){
	$scope.articulos = [];

	$scope.getArticulos = function(i){
		// console.log('getCcostos', i);
		// if ($scope.departamento == undefined || $scope.departamento == '') {
		// 	Swal.fire('Sin departamento','Es necesario seleccionar un departamento','warning');
			$scope.articulos[i].arti = '';
		// 	return;
		// }
		$http.post('Controller.php', {
			'task': 'getArticulos',
			'arti': $scope.articulos[i].arti,
		}).then(function (response){
			response = response.data;
			console.log(response);
			$scope.keySeleccionado = i;
			$scope.arrayCcostos = response;
			
		},function(error){
			console.log('error', error);
		});
	}

	// $scope.setCcosto = function(key, w){
	// 	key = $scope.keySeleccionado;
	// 	// console.log('setCcosto', key, w);
	// 	$scope.articulos[key].centroCosto = $scope.arrayCcostos[w].cve_alterna+'-'+$scope.arrayCcostos[w].nombre_articulo;
	// 	$scope.articulos[key].cve_articulo = $scope.arrayCcostos[w].cve_articulo;
	// 	$scope.arrayCcostos = [];
	// }

})