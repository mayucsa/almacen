<?php

class MysqlConn{
	public static function conn(){
		$servername = 'mayucsa.synology.me';
		$username = 'ismael';
		$password = 'Sistemas$1';
		$db = "produccionmayucsa";
		// create connection
		$conn = new mysqli($servername, $username, $password, $db);
		//check connection
		if ($conn->connect_error){
			die("conexion fallida: " . $conn->connect_error);
		}
		mysqli_set_charset($conn,"utf8");
		return $conn;
	}
	function qBuilder($conn, $tipo, $qry){
		switch (strtoupper($tipo)) {
	        case 'GET':
		    	return mysqli_query($conn, $qry);
	        break;
	        case 'ALL':
	            $qry = mysqli_query($conn, $qry);
	            $retorno = []; 
	            $i = 0;
	            while ($row = mysqli_fetch_object($qry)) {
	                $retorno[$i] = $row;
	                $i++;
	            }
	            return $retorno;
	        break;
	        case 'FIRST':
		    	$mysqliQuery = mysqli_query($conn, $qry);
		        return mysqli_fetch_object($mysqliQuery);
	        break;
	        case 'DO':
	        	if (!mysqli_query($conn, $qry)) {
			        return false;
			    }else{
			        return true;
			    }
	    	break;
	    }
	}
}
?>