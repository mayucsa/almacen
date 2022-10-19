<?php 

	session_start();
	unset($_SESSION['seg_usuario']);
	session_destroy();
	header("Location: ../.././webapps/index.php");

 ?>