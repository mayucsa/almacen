
$(document).ready(function (index){
    $('#p_usuario, #p_password').keypress(function(e) {
        if (e.which == 13) { 
            iniciarSesion(); 
        }
    });
});

function iniciarSesion() {
	var usuario = $('#p_usuario').val();
	var password = $('#p_password').val();
	var msj = "";

	if (usuario == "") {
		msj += "<li>Ingrese el nombre de usuario</li>";
	}
	if (password == "") {
		msj += "<li>Ingrese su contraseña</li>";
	}
	if (msj.length != 0) {
		$('#encabezadoModal').html('Validación de datos');
		$('#cuerpoModal').html('Los siguientes campos son obligatorios:<ul>'+msj+'</ul>');
        $('#modalMensajes').modal('toggle');
	}else{
		validacionDatos(usuario,password);
	}
}

function validacionDatos(pusuario,ppassword){
    $.post('modulos/seguridad/login/ctrl_operaciones.php', { 
        usuario: pusuario, 
        contrasenia: ppassword
    }).then(function (data) {
        console.log('data', data);
        data = JSON.parse(data);
        if(data.success){
            $('#myLoading').modal('show');
            setTimeout(function(){location.href='modulos/dashboard/dashboard/dashboard.php';},2000);
            // setTimeout(function(){location.href='modulos/inventario/bloquera/inventario_bloquera.php';},2000);
        } else {
            console.log('error');
            $('#encabezadoModal').html('Validación de datos');
            // $('#cuerpoModal').html('El usuario y/o la contraseña son incorrrectos');
            $('#cuerpoModal').html(data.message);
            $('#modalMensajes').modal('toggle');
        }
    }, function(error){
        console.log('Error en controlador', error);
    });
}
