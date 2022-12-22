
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Almac&eacute;n</title>

	<link rel="stylesheet" type="text/css" href="includes/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="includes/css/css-login.css">

	<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
	<script src="includes/js/jquery351.min.js"></script>

	<!-- <script src="includes/js/jquery.min.js"></script> -->
	<script src="includes/bootstrap/js/bootstrap.js"></script>
	<script src="includes/bootstrap/js/bootstrap.min.js"></script>
	<!-- <script src="includes/js/utileria.js"></script> -->
	<script src="index.js"></script>
	<link rel="icon" href="includes/imagenes/favicon.png">
</head>

<div class="modal fade" id="myLoading" tabindex="-3" data-backdrop="static" data-keyboard="false" style="padding-top:20%; overflow-y:visible;" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div align="center"><img src="includes/imagenes/loading3.gif" width="140px"></div>
	<div id="divtextloading" align="center" style="font-weight:bold; font-size:20px; color:#FFFFFF">Espere un momento...</div>
</div>

<div class="modal fade" id="modalMensajes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="padding-top:10%; overflow-y:visible;" >
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header modal-danger">
				<h5 class="modal-title" id="encabezadoModal"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="cuerpoModal"></div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Aceptar</button>
			</div>
		</div>
	</div>
</div>

<body>
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="card">
					<form class="box" onsubmit="return false" method="post" autocomplete="off">
						<h1>Almac&eacute;n</h1>
						<p class="text-muted"> Acceda con su usuario</p>
							<input type="text" name="p_usuario" id="p_usuario" placeholder="Usuario">
							<input type="password" name="p_password" id="p_password" placeholder="Contraseña">
							<!-- <a class="forgot text-muted" href="#">¿Has olvidado su contraseña?</a> -->
							<input type="submit" name="" value="Acceso" href="#" onclick="iniciarSesion()">
							<!-- <button class="btn btn-primary" onclick="iniciarSesion('p_usuario', 'p_password')"> Acceso</button> -->
							<img class="img-fluid" src="includes/imagenes/Mayucsap.png">
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>

<!--Start of Tawk.to Script-->
<!-- <script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/61ef09ab9bd1f31184d91df9/1fq6rrhl1';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script> -->
<!--End of Tawk.to Script-->