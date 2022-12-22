<?php

	class Conexion{
		// public static function conectar(){
		public static function conectar(){
		 	// $host			='mysql:dbname=produccionmayucsa;host=localhost';
			// $usuario		='root';
			// $contrasenia	='';
		 	// $host			='mysql:dbname=mayucsac_produccionmayucsa;host=162.241.62.122';
			// $usuario		='mayucsac_root';
			// $contrasenia	='$oportemys#1';
			// $host			='mysql:dbname=produccionmayucsa;host=192.168.1.6';
			$host			='mysql:dbname=mayucsademo;host=mayucsa.synology.me';
			$usuario		='ismael';
			$contrasenia	='Sistemas$1';
			// $dbname			='produccionmayucsa';
			try {
				$database =  new PDO($host, $usuario, $contrasenia);
				// echo "Conexion Exitosa <br>";
				return $database;
			} catch (PDOException $e) {
				echo "Falló de Conexion". $e->getMessage();
			}
		}
	}
	$stmt = Conexion::conectar();

?>