app.controller('vistaMisRequisiciones', function(BASEURL, ID, $scope, $http) {
	$scope.modalMisRequ = false;
	$scope.codarticulo = undefined;
	$http.post('Controller.php', {
		'task': 'ssMisRequis',
		'id': ID,
	}).then(function (response){
		response = response.data;
		console.log('ssMisRequis', response);
		$scope.ssMisRequis = response;
		setTimeout(function(){
			$('#tablamisRequis').DataTable({
		        "processing": true,
		        "bDestroy": true,
				"order": [0, 'desc'],
				"lengthMenu": [[30, 50, 75], [30, 50, 75]],
			     "language": {
			         "lengthMenu": "Mostrar _MENU_ registros por página.",
			         "zeroRecords": "No se encontró registro.",
			         "info": "  _START_ de _END_ (_TOTAL_ registros totales).",
			         "infoEmpty": "0 de 0 de 0 registros",
			         "infoFiltered": "(Encontrado de _MAX_ registros)",
			         "search": "Buscar: ",
			         "processing": "Procesando...",
			                  "paginate": {
			             "first": "Primero",
			             "previous": "Anterior",
			             "next": "Siguiente",
			             "last": "Último"
			         }
			     }
			});
		},800);
	},function(error){
		console.log('error', error);
	});
	$scope.actualizarRequ = function(){
		for (var i = 0; i < $scope.ssMiReqDet.length; i++) {
			if (parseFloat($scope.ssMiReqDet[i].cantidad) <= 0) {
				Swal.fire('Cantidad incorrecta', 'La cantidad de los artículos debe ser mayor a cero', 'warning');
				return;
			}
		}
		Swal.fire({
			title: 'Actualizar requisición',
			html: '¿Realmente desea actualizar la requisión con <b>folio '+ $scope.folio +'</b>?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: 'green',
			confirmButtonText: 'Aceptar',
			cancelButtonColor: 'red',
			cancelButtonText: 'Cancelar'
		}).then((result) => {
			if (result.isConfirmed) {
				jsShowWindowLoad('Actualizando...');
				$http.post('Controller.php', {
					'task': 'actualizar',
					'folio': $scope.folio,
					'articulos': $scope.ssMiReqDet
				}).then(function (response){
					console.log('response', response.data);
					jsRemoveWindowLoad();
					if (response.data.code === 200) {
						Swal.fire({
							title: 'Actualizado',
							icon: 'success',
							showCancelButton: false,
							confirmButtonColor: 'green',
							confirmButtonText: 'Aceptar',
						}).then((result) => {
							location.reload();
						});
					}else{
						Swal.fire('Error', '', 'warning');
					}
				}, function(er){
					console.log('error', er.data);
					jsRemoveWindowLoad();
				});
			}
		});
	}
	$scope.quitar = function(i){
		$scope.ssMiReqDet.splice(i, 1);
	}
	$scope.setArticulo = function(w, scaneo = 0){
		if (scaneo == 1) {
			$scope.findArticulos = $scope.setArticulos;
		}
		var aux = 0;
		for (var i = 0; i < $scope.ssMiReqDet.length; i++) {
			if ($scope.ssMiReqDet[i].cve_alterna == $scope.findArticulos[w].cve_alterna) {
				aux++;
				w = i;
			}
		}
		if ( aux > 0 ) {
			$scope.ssMiReqDet[w].cantidad ++;
		}else{
			$scope.findArticulos[w].cantidad = 1;
			$scope.ssMiReqDet.push( $scope.findArticulos[w] );
		}
		$scope.findArticulos = [];
		$scope.codarticulo = '';
	}
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
				console.log('response.datos', response.datos);
			if (response.tipo == 1) {
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
	$scope.setModalMisRequ = function(cve_req){
		if ($scope.modalMisRequ == true) {
			$scope.modalMisRequ = false;
		}else{
			$scope.modalMisRequ = true;
			$scope.editarRequi(cve_req);
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
	$scope.editarRequi = function(cve_req){
		$scope.ssMiReqDet = [];
		$http.post('Controller.php', {
			'task': 'datosRequi',
			'cvereq': cve_req,
		}).then(function(response){
			response = response.data;
			console.log('ssMisRequis', response);
			if (response.length > 0) {
				$scope.folio = response[0].cve_req;
				$scope.ssMiReqDet = response;
			}
		})
	}

	$scope.ver = function(cve_req){
		    $.getJSON("modelo_misrequisiciones.php?consultar="+cve_req, function(registros){
        // console.log(registros);
	        $('#inputname').val(registros[0]['cvereq']);

	        $("#tablaModal").html( '<thead> <tr>  <th class="text-center">Articulo</th>' +
	                                                '<th class="text-center">Cantidad</th>'+
	                                    '</thead>');
	    for (i = 0; i < registros.length; i++){
	        // txt += $('#inputcantidad').val(registros[i]['Cantidad']);
	        // $('#inputmp').text(registros[i]['MateriaPrima']) + $('#inputcantidad').val(registros[i]['Cantidad']);
	         $("#tablaModal").append('<tr>' + 
	            '<td style="dislay: none;">' + registros[i].articulo + '</td>'+
	            '<td style="dislay: none;">' + registros[i].cantidad + 
	            '</td>'
	            +'</tr>');
	    }

	    });
	}
	$scope.cancelar = function(cve_req){
		Swal.fire({
			title: 'Cancelar requisición',
			html: '¿Realmente desea cancelar la requisión con <b>folio '+ cve_req +'</b>?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: 'green',
			confirmButtonText: 'Aceptar',
			cancelButtonColor: 'red',
			cancelButtonText: 'Cancelar'
		}).then((result) => {
			if (result.isConfirmed) {
				jsShowWindowLoad('Eliminando requisión...');
				$http.post('Controller.php', {
					'task': 'CancelarRequi',
					'cvereq': cve_req,
				}).then(function(response) {
					response = response.data;
					console.log('response', response);
					jsRemoveWindowLoad();
					Swal.fire({
					  title: '¡Éxito!',
					  html: 'Se elimino la requisión con folio <b> ' + cve_req + '</b> correctamente',
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
				}, function(error){
					console.log('error', error);
	    			jsRemoveWindowLoad();
				})
			}
		})
	}


})