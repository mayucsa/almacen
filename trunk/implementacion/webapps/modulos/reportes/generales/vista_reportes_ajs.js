app.controller('vistaReportes', function(BASEURL, ID, $scope, $http){
	$scope.articulos = [];
	var fechaActual = new Date();
	$scope.fechaActual = fechaActual.toLocaleDateString('en-ZA');
	$scope.fechainicioRA = $scope.fechaActual;
	$scope.fechafinRA = $scope.fechaActual;
	$scope.fechainicioMov = $scope.fechaActual;
	$scope.fechafinMov = $scope.fechaActual;
	$scope.tipoRANorm = true;
	$scope.tipoRAAuto = true;
	$scope.entradas = true;
	$scope.salidas = true;
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
	$scope.getPDF = function(tipo){
		if (tipo == 'existencias') {
			jsShowWindowLoad('Generando...');
			$http.post('Controller.php', {
				'task': 'catArticulos'
			}).then(function (response){
				response = response.data;
				$scope.catArticulos = response;
				setTimeout(function(){
					imprSelec('pdfExistencias');
					jsRemoveWindowLoad();
				}, 700);
			},function(error){
				console.log('error', error);
				jsRemoveWindowLoad();
			});
		}
		if (tipo == 'Requisiciones') {
			if (!$scope.tipoRANorm && !$scope.tipoRAAuto) {
				Swal.fire('','Es necesario seleccionar normales, automáticas o ambas','warning');
				return;
			}
			jsShowWindowLoad('Generando...');
			$http.post('Controller.php', {
				'task': 'Requisiciones',
				'fechainicio': $('#fechainicioRA').val(),
				'fechafin': $('#fechafinRA').val(),
				'tipoRANorm': $scope.tipoRANorm,
				'tipoRAAuto': $scope.tipoRAAuto
			}).then(function (response){
				response = response.data;
				$scope.requAutomaticas = response;
				setTimeout(function(){
					imprSelec('Requisiciones');
					jsRemoveWindowLoad();
				}, 700);
			},function(error){
				console.log('error', error);
				jsRemoveWindowLoad();
			});
		}
		if (tipo == 'entradasSalidas') {
			if (!$scope.entradas && !$scope.salidas) {
				Swal.fire('','Es necesario seleccionar entradas, salidas o ambas','warning');
				return;
			}
			jsShowWindowLoad('Generando...');
			$http.post('Controller.php', {
				'task': 'entradasSalidas',
				'f_ini': $('#fechainicioMov').val(),
				'f_fin': $('#fechafinMov').val(),
				'entradas': $scope.entradas,
				'salidas': $scope.salidas
			}).then(function (response){
				response = response.data;
				$scope.entradasSalidas = response;
				setTimeout(function(){
					imprSelec('entradasSalidas');
					jsRemoveWindowLoad();
				}, 700);
			},function(error){
				console.log('error', error);
				jsRemoveWindowLoad();
			});
		}
	}
	$scope.getExcel = function(tipo){
		if ( tipo == 'existencias' ) {
			jsShowWindowLoad('Generando...');
			$http.post('Controller.php', {
				'task': 'getExcel',
				'tipo': tipo,
				'datos': ''
			}).then(function (response){
				response = response.data;
				jsRemoveWindowLoad();
				location.href=response;
			},function(error){
				console.log('error', error);
				jsRemoveWindowLoad();
			});
		}
		if ( tipo == 'Requisiciones' ) {
			if (!$scope.tipoRANorm && !$scope.tipoRAAuto) {
				Swal.fire('','Es necesario seleccionar normales, automáticas o ambas','warning');
				return;
			}
			jsShowWindowLoad('Generando...');
			$http.post('Controller.php', {
				'task': 'getExcel',
				'tipo': tipo,
				'datos': {
					'f_ini':$('#fechainicioRA').val(), 
					'f_fin':$('#fechafinRA').val(),
					'tipoRANorm': $scope.tipoRANorm,
					'tipoRAAuto': $scope.tipoRAAuto
				}
			}).then(function (response){
				response = response.data;
				jsRemoveWindowLoad();
				location.href=response;
			},function(error){
				console.log('error', error);
				jsRemoveWindowLoad();
			});
		}
		if ( tipo == 'entradasSalidas') {
			if (!$scope.entradas && !$scope.salidas) {
				Swal.fire('','Es necesario seleccionar entradas, salidas o ambas','warning');
				return;
			}
			jsShowWindowLoad('Generando...');
			$http.post('Controller.php', {
				'task': 'getExcel',
				'tipo': tipo,
				'datos': {
					'f_ini':$('#fechainicioMov').val(), 
					'f_fin':$('#fechafinMov').val(),
					'entradas': $scope.entradas,
					'salidas': $scope.salidas
				}
			}).then(function (response){
				response = response.data;
				jsRemoveWindowLoad();
				location.href=response;
			},function(error){
				console.log('error', error);
				jsRemoveWindowLoad();
			});
		}
	}
	$scope.resetFechas = function(){
		$scope.fechainicio = $scope.fechaActual;
		$('#fechainicioRA').val($scope.fechainicio);
		$scope.fechafin = $scope.fechaActual;
		$('#fechafinRA').val($scope.fechafin);
	}
	$scope.resetFechasM = function(){
		$scope.fechainicio = $scope.fechaActual;
		$('#fechainicioMov').val($scope.fechainicio);
		$scope.fechafin = $scope.fechaActual;
		$('#fechafinMov').val($scope.fechafin);
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
