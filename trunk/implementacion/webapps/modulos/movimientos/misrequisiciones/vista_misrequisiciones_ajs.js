app.controller('vistaMisRequisiciones', function(BASEURL, ID, $scope, $http) {
	$scope.modalMisRequ = false;

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

	$scope.setModalMisRequ = function(cve_req){
		if ($scope.modalMisRequ == true) {
			$scope.modalMisRequ = false;
		}else{
			$scope.modalMisRequ = true;
			$scope.editarRequi(cve_req);
		}
	}
	$scope.editarRequi = function(cve_req){
		$http.post('Controller.php', {
			'task': 'datosRequi',
			'cvereq': cve_req,
		}).then(function(response){
			response = response.data;
			console.log('ssMisRequis', response);
			$scope.folio = response[0].cve_req;
			$scope.ssMiReqDet = response;
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