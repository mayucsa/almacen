app.controller('vistaCotizacion', function(BASEURL, ID, $scope, $http){
	$scope.proveedor = '';
	$scope.subircotizacion = '';

	$scope.limpiarCampos = function () {
		$scope.proveedor = '';
		$scope.subircotizacion = '';
	}
	$scope.validacionCampos = function () {
		if ($scope.proveedor == '' || $scope.proveedor == null) {
			Swal.fire(
			  'Campo faltante',
			  'Es necesario seleccionar el proveedor',
			  'warning'
			);
			return;
		} if ($scope.subircotizacion == '') {
			Swal.fire(
			  'Campo faltante',
			  'Es necesario subir una cotización',
			  'warning'
			);
			return;
		}
	}
});