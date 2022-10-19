<?php
class Datos_usuario{
	// var $usuario;
	var $clave_usuario;
	var $nombre_usuario;
	var $nombre_persona;
	var $apellido_persona;
	var $puesto_persona;
	var $rol_persona;

	var $vista_dashboardalma;

	var $vista_catalogo;

	var $vista_movimiento;

	var $vista_autorizacion;

	var $vista_seguridad;


	function set_clave_usuario($clave_usuario){
            $this->clave_usuario = $clave_usuario;
	}
	function get_clave_usuario(){
            return $this->clave_usuario;
	}

	function set_nombre_usuario($nombre_usuario){
            $this->nombre_usuario = $nombre_usuario;
	}
	function get_nombre_usuario(){
            return $this->nombre_usuario;
	}

	function set_nombre_persona($nombre_persona){
            $this->nombre_persona = $nombre_persona;
	}
	function get_nombre_persona(){
            return $this->nombre_persona;
	}
	function set_apellido_persona($apellido_persona){
            $this->apellido_persona = $apellido_persona;
	}
	function get_apellido_persona(){
            return $this->apellido_persona;
	}

	function set_puesto_persona($puesto_persona){
            $this->puesto_persona = $puesto_persona;
	}
	function get_puesto_persona(){
            return $this->puesto_persona;
	}

	function set_rol_persona($rol_persona){
            $this->rol_persona = $rol_persona;
	}
	function get_rol_persona(){
            return $this->rol_persona;
	}


	/*Permisos Dashboard Almacen*/
	function set_vista_dashboardalma($vista_dashboardalma){
            $this->vista_dashboardalma = $vista_dashboardalma;
	}
	function get_vista_dashboardalma(){
            return $this->vista_dashboardalma;
	}

	/*Permisos Catalogo*/
	function set_vista_catalogo($vista_catalogo){
            $this->vista_catalogo = $vista_catalogo;
	}
	function get_vista_catalogo(){
            return $this->vista_catalogo;
	}

	/*Permisos movimiento*/
	function set_vista_movimiento($vista_movimiento){
            $this->vista_movimiento = $vista_movimiento;
	}
	function get_vista_movimiento(){
            return $this->vista_movimiento;
	}

	/*Permisos autorización*/
	function set_vista_autorizacion($vista_autorizacion){
            $this->vista_autorizacion = $vista_autorizacion;
	}
	function get_vista_autorizacion(){
            return $this->vista_autorizacion;
	}

	/*Permisos seguridad*/
	function set_vista_seguridad($vista_seguridad){
            $this->vista_seguridad = $vista_seguridad;
	}
	function get_vista_seguridad(){
            return $this->vista_seguridad;
	}	

}
?>