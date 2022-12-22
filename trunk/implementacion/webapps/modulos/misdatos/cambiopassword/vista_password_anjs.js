app.controller('cambioPssCtrl', function(BASEURL, ID, $scope, $http){
	$scope.inputnueva = '';
	$scope.inputconfirmar = '';
	$scope.bloquear = true;
	$scope.msj = [];
	$scope.comparaPasswords = function(){
		if ($scope.inputnueva === $scope.inputconfirmar) {
			$scope.msj = {
				'msj':'Las contraseñas coinciden',
				'code': 200
			};
			$scope.bloquear = false;
		}else{
			$scope.msj = {
				'msj':'Las contraseñas no coinciden',
				'code': 300
			};
			$scope.bloquear = true;
		}
	}
	$scope.validacion = function(){
		jsShowWindowLoad('Validando...');
		$http.post('Controller.php', {
			'task': 'validaPass'
			,'id': ID,
			'pass': $scope.inputnueva
		}).then(function (response) {
			jsRemoveWindowLoad();
			var aux = 0;
			if (response.data.validaPass > 0) {
				$scope.msj = {
					'msj':'La contraseña no puede ser la misma que la actual contraseña',
					'code': 300
				};
				$scope.bloquear = true;
			}else{
				aux++;
			}
			if (response.data.validaUser > 0) {
				$scope.msj = {
					'msj':'La contraseña no puede ser igual a su usuario',
					'code': 300
				};
				$scope.bloquear = true;
			}else{
				aux++;
			}
			if (aux == 2) {
				$scope.msj = {
					'msj':'Contraseña correcta',
					'code': 200
				};
				$scope.bloquear = false;
				jsShowWindowLoad('Actualizando...');
				$http.post('Controller.php', {
					'task': 'setPass',
					'user': ID,
					'pass': $scope.inputnueva
				}).then(function (res) {
					jsRemoveWindowLoad();
					console.log(res.data);
					if (res.data.code == 200) {
						if(res.data){
							Swal.fire({
							  title: '¡Éxito!',
							  text: 'Su contraseña se ha actualizado satisfactoriamente.',
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
						}
					}else{
						Swal.fire({
						  	title: 'No fue posible actualizar',
						  	text: 'Intente más tarde.',
						  	icon: 'warning',
						  	showConfirmButton: true
						})
					}
				}, function(error){
					jsRemoveWindowLoad();
					console.log('error', error);
				});
			}
		}, function(error){
			jsRemoveWindowLoad();
			console.log('error', error);
		});
	}
	$scope.fnPassword = function(id){
		if ($('#'+id).prop("type") == 'text') {
			$('#'+id).prop("type", "password");
			$('#i_'+id).removeClass('fa fa-eye-slash');
			$('#i_'+id).addClass('fa fa-eye');
		}else{
			$('#'+id).prop("type", "text");
			$('#i_'+id).removeClass('fa fa-eye');
			$('#i_'+id).addClass('fa fa-eye-slash');
		}
	}
});