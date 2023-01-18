app.controller('vistaReportes', function(BASEURL, ID, $scope, $http){
	$scope.articulos = [];
	var fechaActual = new Date();
	$scope.fechaActual = fechaActual.toLocaleDateString('en-ZA');
	$scope.fechainicioRA = $scope.fechaActual;
	$scope.fechafinRA = $scope.fechaActual;
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
	$scope.getPDF = function(tipo){
		if (tipo == 'existencias') {
			jsShowWindowLoad('Generando...');
			$http.post('Controller.php', {
				'task': 'catArticulos'
			}).then(function (response){
				response = response.data;
				console.log('catArticulos', response);
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
		if (tipo == 'RequisicionesAuto') {
			jsShowWindowLoad('Generando...');
			$http.post('Controller.php', {
				'task': 'RequisicionesAuto',
				'fechainicio': $('#fechainicioRA').val(),
				'fechafin': $('#fechafinRA').val()
			}).then(function (response){
				response = response.data;
				console.log('RequisicionesAuto', response);
				$scope.requAutomaticas = response;
				setTimeout(function(){
					imprSelec('RequisicionesAuto');
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
				console.log('catArticulos Excel', response);
				jsRemoveWindowLoad();
				location.href=response;
			},function(error){
				console.log('error', error);
				jsRemoveWindowLoad();
			});
		}
		if ( tipo == 'RequisicionesAuto' ) {
			jsShowWindowLoad('Generando...');
			$http.post('Controller.php', {
				'task': 'getExcel',
				'tipo': tipo,
				'datos': {
					'f_ini':$('#fechainicioRA').val(), 
					'f_fin':$('#fechafinRA').val()
				}
			}).then(function (response){
				response = response.data;
				console.log('catArticulos Excel', response);
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
});
function imprSelec(id) {
	var div = document.getElementById(id);
    var ventimp = window.open(' ', 'popimpr');
    ventimp.document.write( div.innerHTML );
    ventimp.document.close();
    ventimp.print( );
    ventimp.close();
}
