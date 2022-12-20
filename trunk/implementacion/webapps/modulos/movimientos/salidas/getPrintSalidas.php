<?php
/**
 * HTML2PDF Library
 * HTML => PDF convertor
 * @package   Html2pdf
 * @author    Ismael López ilopez@lcdevelopers.com.mx
 *
 */
date_default_timezone_set('America/Mexico_City');
	function getPDF_odc($datos){
		$estilos ='<style>
		.p-4{
			padding:10vH;
		}
		.p-2{
			padding:10vH;
		}
		.table{
			width:95%;
		}
		.th-8{
			width:66.66%;
		}
		.th-7{
			width:58.33%;
		}
		.th-5{
			width:41.66%;
		}
		.th-4{
			width:33.33%;
		}
		.text-right{
			text-align: right;
		}
		.tabulado{
			width: 100%;
			position:relative;
		}
		.tabulado table {
		  border-collapse: collapse;
		  border-spacing: 0;
		  width: 100%;
		  border: 1px solid #ddd;
		}
		.tabulado-thead tr{
			background-color: #3374FF;
			color: white;
		}
		.tabulado-thead th {
		  text-align: left;
		  padding: 10px;
		  border: solid 1 white;
		}
		.tabulado-thead td {
		  text-align: left;
		  text-align: justify;
		}

		.tdSize{
			font-size:11px;
		}
		.borderedMe{
		    		border-radius: 10px; border: solid;
		    	}
		</style>';
		$myHtml = $estilos.'<div>';
		$myHtml .= '<!doctype html>
		<html lang="es">
		  <head>

		    <meta charset="utf-8">
		    <meta name="viewport" content="width=device-width, initial-scale=1">

		    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
		  </head>
		  <body>
		    <div class="container-fluid">
		    	<div class="row p-2" style="width:40%;">
		    		<div class="col-md-12 text-center">
		    			<h2>FORMATO DE SALIDA - SAM</h2>
		    		</div>
		    		<div class="col-md-12 mb-4 text-center">
		    			<img src="../../../includees/imagenes/Mayucsa.png" style="width: 80%;">
		    		</div>
		    		<div class="col-md-4">
		    			<div class="row borderedMe">
		    				<div class="col-md-12 p-2" style="border-bottom: solid;">
		    					<h3>FOLIO</h3>
		    				</div>
		    				<div class="col-md-12 p-2 text-center">
		    					123
		    				</div>
		    			</div>
		    		</div>
		    		<div class="col-md-8">
		    			<div class="row borderedMe">
		    				<div class="col-md-12 p-2" style="border-bottom: solid;">
		    					<h3>FECHA</h3>
		    				</div>
		    				<div class="col-md-12 p-2 text-center">
		    					'.date('Y-m-d').'
		    				</div>
		    			</div>
		    		</div>
		    		<div class="col-md-12 mt-2">
		    			<div class="row borderedMe">
		    				<div class="col-md-12 p-2">
		    					<h3>MAQUINA</h3>
		    				</div>
		    				<div class="col-md-12 p-2 text-center">
		    					456
		    				</div>
		    			</div>
		    		</div>
		    		<div class="col-md-12 mt-2">
		    			<div class="row borderedMe">
		    				<div class="col-md-12 p-2">
		    					<h3>REALIZADO POR</h3>
		    				</div>
		    				<div class="col-md-12 p-2 text-center">
		    					456
		    				</div>
		    			</div>
		    		</div>
		    		<div class="col-md-12 mt-2 borderedMe">
		    			<table class="table table-striped">
		    				<tr>
		    					<th>Clave Art.</th>
		    					<th>Descripción</th>
		    					<th>Cantidad</th>
		    					<th>Unidad</th>
		    				</tr>
		    				<tr>
		    					<td>0420</td>
		    					<td>Tornillo</td>
		    					<td>10.0000</td>
		    					<td>PZA</td>
		    				</tr>
		    			</table>
		    		</div>
		    		<div class="col-md-12 mt-2 borderedMe">
		    			<div class="row ">
		    				<div class="col-md-12 p-2 mb-4" style="border-bottom:solid;">
		    					<h3>Firma:</h3>
		    				</div>
		    				<div class="col-md-12 mt-4 pb-4 pt-4" style="border-bottom:solid;">
		    					
		    				</div>
		    				<div class="col-md-12 p-2 text-center">
		    					456
		    				</div>
		    			</div>
		    		</div>
		    	</div>
		    </div>

		    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
		  </body>
		</html>';
		return $myHtml;
	}
    // convert in PDF
    require_once('../../../includes/librerias/html2pdf/html2pdf.class.php');
    try
    {
    	include_once "../../../dbconexion/conn.php";
		$dbcon	= 	new MysqlConn;
    	$datos = [];
		$myHtml = getPDF_odc($datos);
		// die($myHtml);
        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
		//      $html2pdf->setModeDebug();
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($myHtml);
        $path = '../../../includees/archivos/odc/';
        if (!file_exists($path)) {
	        mkdir($path,0755,true);
	    }
	    if(!file_exists($path)){
	        mkdir($path, 0777) or die("No se puede crear el directorio de extracción");    
	    }
        $archivo = $path.'odc_'.$cve_odc.'.pdf';
        if (isset($_REQUEST['tipo'])) {
        	$pdfContent = $html2pdf->output('', 'S');
        	$f =fopen($archivo, 'a');
            fwrite($f, $pdfContent);
            fclose($f);
            echo $archivo;
        }else{
        	$html2pdf->Output($archivo);
        }
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>
