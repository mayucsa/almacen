app.controller('vistaSalidas', function (BASEURL, ID, $scope, $http){
	$scope.foliovale = '';
	$scope.concepto = '';
	$scope.departamento = '';
	$scope.maquinas = '';
	$scope.horometro = '';
	$scope.comentarios = '';
	$scope.articulos = [];
	$scope.auxArticulos = [];
	$scope.arrayMaquinas = [];
	// Funciones
	$scope.getArticulos = function(){
		if ($scope.codarticulo == '' || $scope.codarticulo == undefined) {
			$scope.findArticulos = [];
			return;
		}
		$http.post('Controller.php', {
			'task': 'getArticulos',
			'codarticulo': $scope.codarticulo
		}).then(function (response){
			response = response.data;
			if (response.tipo == 1) {
				// console.log('response.datos', response.datos);
				$scope.setArticulos = response.datos;
				$scope.setArticulo(0, 1);
				return;
			}
			if (response.tipo == 0) {
				Swal.fire('Sin existencia',
					'El artículo '+response.datos+' No tiene existencias',
					'warning'
				);
				return
			}
			$scope.findArticulos = response.datos;
			
		},function(error){
			console.log('error', error);
		});
	}
	$scope.getMaquinas = function(){
		if ($scope.departamento == undefined) {return;}
		jsShowWindowLoad('Buscando Máquinas...');
		$http.post('Controller.php', {
			'task': 'getMaquinas',
			'cve_depto': $scope.departamento
		}).then(function (response){
			response = response.data;
			if (response.length == 0) {
				Swal.fire('Sin resultados','','warning');
			}
			$scope.arrayMaquinas = response;
			jsRemoveWindowLoad();
		},function(error){
			console.log('error', error);
			jsRemoveWindowLoad();
		});
	}
	$scope.setArticulo = function(i, scaneo = 0){
		if (scaneo == 1) {
			$scope.findArticulos = $scope.setArticulos;
		}
		if ($scope.auxArticulos.indexOf($scope.findArticulos[i].cve_articulo) < 0) {
			$scope.findArticulos[i].cantidad = 1;
			// console.log('$scope.findArticulos[i]', $scope.findArticulos[i]);
			$scope.articulos.push(
				$scope.findArticulos[i]
			);
			$scope.auxArticulos.push($scope.findArticulos[i].cve_articulo);
		}else{
			// Swal.fire(
			//   'Artículo agregado previamente',
			//   '',
			//   'warning'
			// );
			for (var w = 0; w < $scope.articulos.length; w++) {
				if ($scope.articulos[w].cve_articulo == $scope.findArticulos[i].cve_articulo) {
					$scope.articulos[w].cantidad++;
					$scope.validarCantidad(w, 1);
				}
			}
		}
		$scope.findArticulos = [];
		$scope.codarticulo = '';
	}
	$scope.quitarArticulo = function(i){
		$scope.auxArticulos.splice(i, 1);
		$scope.articulos.splice(i, 1);
	}
	$scope.setNumerico = function(numero){
		if (numero == undefined) return numero;
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
	$scope.validarCantidad = function(i, scaneo = 0){
		if (scaneo == 0) {
			$scope.articulos[i].cantidad = $scope.setNumerico($scope.articulos[i].cantidad);
		}
		if (parseFloat($scope.articulos[i].existencia) < parseFloat($scope.articulos[i].cantidad)) {
			Swal.fire(
			  'Cantidad incorrecta',
			  'La cantidad a salir debe de ser igual o menor que la existencia.',
			  'warning'
			);
			$scope.articulos[i].cantidad = $scope.articulos[i].existencia;
		}
	}
	$scope.limpiarCampos = function() {
		$scope.foliovale = '';
		$scope.concepto = '';
		$scope.departamento = '';
		$scope.maquinas = '';
		$scope.horometro = '';
		$scope.comentarios = '';
		$scope.articulos = [];
		$scope.auxArticulos = [];
		$scope.findArticulos = [];
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
		if ($scope.articulos.length < 1) {
			Swal.fire(
			  'Sin artículos',
			  'Es necesario seleccionar al menos un artículo',
			  'warning'
			);
			return;
		}
		for (var i = 0; i < $scope.articulos.length; i++) {
			// console.log('$scope.articulos[i].cve_cc '+i, $scope.articulos[i]);
			if ($scope.articulos[i].cve_cc == undefined || $scope.articulos[i].cve_cc == '') {
				Swal.fire(
				  'Sin centro de costo seleccionado',
				  'Es necesario seleccionar centro de costo por artículo.',
				  'warning'
				);
				return;
			}
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
					'id': ID,
					'articulos': $scope.articulos
				}).then(function (response){
					response = response.data;
					// console.log('response', response);
					jsRemoveWindowLoad();
					if (response.code == 200) {
						$scope.folioSalida = response.folio;
						Swal.fire({
						  title: '¡Éxito!',
						  html: 'La salida se generó correctamente.\n <b>Folio: ' +response.folio + '</b>',
						  icon: 'success',
						  showCancelButton: false,
						  confirmButtonColor: 'green',
						  confirmButtonText: 'Aceptar'
						}).then((result) => {
							if (result.isConfirmed) {
								// location.reload();
								imprSelec('paraImprimir');
								$('#btnLimpiar').click();
							}else{
								// location.reload();
								imprSelec('paraImprimir');
								$('#btnLimpiar').click();
							}
						})
					}else{
						Swal.fire('Error en controlador','','error');
					}
				})
			}
		})
	}
	$scope.setMaquina = function(){
		$scope.maquinaSeleccionada = $('#nextFocusHeader3 option:selected').html();
		$scope.deptoseleccionado = $('#nextFocusHeader2 option:selected').html();
	}
	$scope.getCcostos = function(i){
		// console.log('getCcostos', i);
		// if ($scope.departamento == undefined || $scope.departamento == '') {
		// 	Swal.fire('Sin departamento','Es necesario seleccionar un departamento','warning');
		// 	$scope.articulos[i].centroCosto = '';
		// 	return;
		// }
		$http.post('Controller.php', {
			'task': 'getCcostos',
			'centroCosto': $scope.articulos[i].centroCosto,
			'cve_depto': $scope.departamento
		}).then(function (response){
			response = response.data;
			// console.log(response);
			$scope.keySeleccionado = i;
			$scope.arrayCcostos = response;
			
		},function(error){
			console.log('error', error);
		});
	}
	$scope.setCcosto = function(key, w){
		key = $scope.keySeleccionado;
		// console.log('setCcosto', key, w);
		$scope.articulos[key].centroCosto = $scope.arrayCcostos[w].cve_alterna+'-'+$scope.arrayCcostos[w].name;
		$scope.articulos[key].cve_cc = $scope.arrayCcostos[w].cve_cc;
		$scope.arrayCcostos = [];
	}

	$scope.inputCharacters = function(i, tipo = '') {
		i++;
		if (tipo != '') {
			if (i == 1) {
				$('#nextFocusHeader1').focus();
				$('#nextFocusHeader1').click();
			}else{
				$('#nextFocusHeader'+i).focus();
			}
			return;
		}
		if (i == $scope.ordenCompraDetalle.length ) {
			$('#nextFocusHeader0').focus();
		}else{
			$('#nextFocus'+i).focus();
		}
	}
})
function imprSelec(id) {
	var div = document.getElementById(id);
    var ventimp = window.open(' ', 'popimpr');
    ventimp.document.write( div.innerHTML );
    ventimp.document.close();
    ventimp.print( );
    ventimp.close();
}
