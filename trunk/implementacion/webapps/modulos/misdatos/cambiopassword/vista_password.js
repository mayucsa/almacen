
function limpiarCampos() {
    $('#inputnueva').val("");
    $('#inputconfirmar').val("");
}
function validacion() {
    var nueva       = $('#inputnueva').val();
    var confirmar   = $('#inputconfirmar').val();
    var msj = "";

    if (nueva == "") {
        msj += '<li>Nueva contraseña</li>';
    }   
    if (confirmar == "") {
        msj += '<li>Confirmar contraseña</li>';
    }   
    if (msj.length != 0) {
        $('#encabezadoModal').html('Validación de datos');
        $('#cuerpoModal').html('Los siguientes campos son obligatorios:<ul>'+msj+'</ul>');
        $('#modalMensajes').modal('toggle');

    } else{
        comprobacion();
    }
}

function comprobacion(){
    var datos   = new FormData();
    var nueva       = $('#inputnueva').val();
    var confirmar   = $('#inputconfirmar').val();
    var msj = "";

    datos.append('nueva',   $('#inputnueva').val());
    datos.append('usuario',   $('#spaniduser').text());
    console.log(datos.get('nueva'));
    console.log(datos.get('usuario'));

    if (nueva != confirmar) {
                        Swal.fire({
                                        icon: 'warning',
                                        title: '¡Error!',
                                        text: 'La nueva contraseña y su confirmación no coinciden',
                                        // footer: 'Favor de ingresar un código nuevo',
                                        confirmButtonColor: '#1A4672'
                                    })
    }else{
    Swal.fire({
                title: '¿Deseas cambiar su contraseña?',
                // html:   'Nombre: <b>' +  datos.get('depto'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No'
    }).then((result) => {

    if (result.isConfirmed) {    

        $.ajax({
                type:"POST",
                url:"modelo_password.php?accion=insertar",
                data: datos,
                processData:false,
                contentType:false,
        success:function(data){
                    // consultar();
                    limpiarCampos();
                    Swal.fire(
                                'Nueva Contraseña!',
                                'Se ha cambiado su contraseña !!',
                                'success'
                            )
                    }

            })
        }
    });
    }

}

 //  function comprobacion() {
 //    var nueva       = $('#inputnueva').val();
 //    var confirmar   = $('#inputconfirmar').val();
 //    // arr = [];
 //    // var msj = "";

 //    if (nueva !== confirmar ) {
 //        // msj += '<li>La nueva contraseña y su confirmación no coinciden</li>';
 //        $('#encabezadoModal').html('Validación de datos');
 //        $('#cuerpoModal').html('La nueva contraseña y su confirmación no coinciden');
 //        $('#modalMensajes').modal('toggle');
 //    }      
 //    // if (msj.length != 0) {
 //    //     $('#encabezadoModal').html('Validación de datos');
 //    //     $('#cuerpoModal').html('Los siguientes campos son obligatorios:<ul>'+msj+'</ul>');
 //    //     $('#modalMensajes').modal('toggle');

 //    // }
 // }

 //   function comprobacion() {
 //    var divInp  = "[data-label]", lbl = "", arr = [], msg = "";

 //    if ( arr[1] !== arr[2] ) {//lbl = "<li>La nueva contraseña y su confirmación no coinciden.</li>"//
 //        $('#encabezadoModal').html('Validación de datos');
 //        $('#cuerpoModal').html('<li>La nueva contraseña y su confirmación no coinciden.</li>');
 //        $('#modalMensajes').modal('toggle');
 //   } else}
 //        actualizacionpassword();
 //    }
 // }