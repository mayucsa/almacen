<?php
/**
 * HTML2PDF Library
 * HTML => PDF convertor
 * @package   Html2pdf
 * @author    Ismael López ilopez@lcdevelopers.com.mx
 *
 */
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
		.tabulado table {
		  border-collapse: collapse;
		  border-spacing: 0;
		  width: 90%;
		  border: 1px solid #ddd;
		}
		.tabulado-thead tr{
			background-color: #3374FF;
			color: white;
		}
		.tabulado-thead th, td {
		  text-align: left;
		  padding: 14px;
		}
		</style>';
		$myHtml = $estilos.'<div>';
		$myHtml .='<div class="container-fluid" style="width: 85%;">';
		$myHtml .='<table class="table">';
		$myHtml .='<tr>';
		$myHtml .='<th class="th-7">';
		$myHtml .='<img src="../../../includees/imagenes/Mayucsa.png" style="width: 80%;">';
		$myHtml .='<br><br><br>';
		$myHtml .='<span>MATERIALES DE YUCATAL S.A. DE C.V.</span>';
		$myHtml .='<br>';
		$myHtml .='<span>RFC: MYU7407096Q9</span>';
		$myHtml .='<br>';
		$myHtml .='<span>DIRECCIÓN: CARRETERA MÉRIDA - TIXKOKOB KM 10.5</span>';
		$myHtml .='<br>';
		$myHtml .='<span>TELÉFONO: 9992-77-26-43</span>';
		$myHtml .='</th>';
		$myHtml .='<th class="th-5 text-right">';
		$myHtml .='<br>';
		$myHtml .='<span>Fecha: '.$datos['fecha'].'</span>';
		$myHtml .='<br>';
		$myHtml .='<span>Orden de compra: '.$datos['cve_odc'].'</span>';
		$myHtml .='<br><br>';
		$myHtml .= '<span style="margin-left:100px">'.$datos['odc_bar'].'</span>';
		$myHtml .='<br><br>';
		$myHtml .='<span>PROVEEDOR: '.$datos['proveedor']->nombre_proveedor.'</span>';
		$myHtml .='<br>';
		$myHtml .='<span>RFC: '.$datos['proveedor']->rfc.'</span>';
		$myHtml .='<br>';
		$myHtml .='<span>FECHA ENTREGA: dd/mm/yyyy</span>';
		$myHtml .='</th>';
		$myHtml .='</tr>';
		$myHtml .='</table>';
		$myHtml .='<div class="col-md-12">';
		$myHtml .='<hr>';
		$myHtml .='</div>';
		$myHtml .='<div class="col-md-12 p-4">';
		$myHtml .='<div class="row m-4 tabulado">';
		$myHtml .='<table class="table table-bordered table-striped" style="width:80%;">';
		$myHtml .='<thead class="tabulado-thead">';
		$myHtml .='<tr>';
		$myHtml .='<th>Folio Req</th>';
		$myHtml .='<th>Cod. Artículo</th>';
		$myHtml .='<th>Nombre artículo</th>';
		$myHtml .='<th>Unidad medida</th>';
		$myHtml .='<th>Cantidad</th>';
		$myHtml .='<th>Precio unitario</th>';
		$myHtml .='<th>Subtotal</th>';
		$myHtml .='</tr>';
		$myHtml .='</thead>';
		$myHtml .='<tbody>';
		$total = 0;
		for ($i=0; $i < count($datos['tabla']); $i++) { 
			$estilo = $i%2==0?'':'style="background-color:#f2f2f2"';
			$myHtml .='<tr '.$estilo.'>';
			$myHtml .='<td>'.$datos['tabla'][$i]->cve_req.'</td>';
			$myHtml .='<td>'.$datos['tabla'][$i]->cve_art.'</td>';
			$myHtml .='<td>'.$datos['tabla'][$i]->nombre_articulo.'</td>';
			$myHtml .='<td>'.$datos['tabla'][$i]->unidadMedida.'</td>';
			$myHtml .='<td>'.$datos['tabla'][$i]->cantidad_cotizada.'</td>';
			$myHtml .='<td style="text-align:right;">$'.number_format($datos['tabla'][$i]->precio_unidad, 2).'</td>';
			$precio = floatval($datos['tabla'][$i]->precio_unidad) * floatval($datos['tabla'][$i]->cantidad_cotizada);
			$myHtml .='<td style="text-align:right;">$'.number_format($precio, 2).'</td>';
			$total += $precio;
			$myHtml .='</tr>';
		}
		$myHtml .='</tbody>';
		$myHtml .='<tfoot>';
		$myHtml .='<tr>';
		$myHtml .='<td></td>';
		$myHtml .='<td></td>';
		$myHtml .='<td></td>';
		$myHtml .='<td></td>';
		$myHtml .='<td></td>';
		$myHtml .='<td class="text-right">';
		$myHtml .='<strong>Total:</strong>';
		$myHtml .='</td>';
		$myHtml .='<td class="text-right">';
		$myHtml .='<strong>$'.number_format($total, 2).'</strong>';
		$myHtml .='</td>';
		$myHtml .='</tr>';
		$myHtml .='</tfoot>';
		$myHtml .='</table>';
		$myHtml .='</div>';
		$myHtml .='</div>';
		$myHtml .='<div class="col-md-12 pl-4 pr-4">';
		$myHtml .='<div class="row pl-4 pr-4">';
		$myHtml .='<div class="col-md-12">';
		$myHtml .='<h2>Observaciones:</h2>';
		$myHtml .='<br>';
		$myHtml .='<hr style="border: solid 1px;">';
		$myHtml .='</div>';
		$myHtml .='<div class="col-md-12 p-4">';
		$myHtml .='<div class="row">';
		$myHtml .='<div class="col-md-12">';
		$myHtml .='<span>Uso CFDI:</span>';
		$myHtml .='</div>';
		$myHtml .='<div class="col-md-12">';
		$myHtml .='<span>Forma de pago:</span>';
		$myHtml .='</div>';
		$myHtml .='<div class="col-md-12">';
		$myHtml .='<span>Método de pago:</span>';
		$myHtml .='</div>';
		$myHtml .='</div>';
		$myHtml .='</div>';
		$myHtml .='<div class="col-md-12">';
		$myHtml .='<h2>Nota:</h2>';
		$myHtml .='<br>';
		$myHtml .='<hr style="border: solid 1px;">';
		$myHtml .='</div>';
		$myHtml .='<div class="col-md-12">';
		$myHtml .='<span>';
		$myHtml .='Favor de presentar ésta Orden de Compra impresa para la recepción de los materiales en nuestro almacén.';
		$myHtml .='<br>';
		$myHtml .='Indispensable presentar ésta Orden de compra con factura y/o remisión sellada y firmada por almacén para la revisión de facturas.';
		$myHtml .='</span>';
		$myHtml .='</div>';
		$myHtml .='<div class="col-md-12 mt-4">';
		$myHtml .='<p>';
		$myHtml .='Horarios de almacén: lunes a viernes de 08:00 a 16:00 hrs y sábados de 08:00 a 12:00 hrs.';
		$myHtml .='</p>';
		$myHtml .='<p>';
		$myHtml .='Días de revisión y entrega de contra-recibos: martes y jueves de 09:00 a 12:00 hrs y de 14:00 a 16:00 hrs.';
		$myHtml .='</p>';
		$myHtml .='<p>';
		$myHtml .='Días de pago lunes de 09:00 a 12:00 hrs y de 14:00 a 16:00 hrs.';
		$myHtml .='</p>';
		$myHtml .='</div>';
		$myHtml .='</div>';
		$myHtml .='</div>';
		$myHtml .='<div style="margin-top: 100px; margin-left:">';
		$myHtml .='<table style="width:100%;">';
		$myHtml .='<tr>';
		$myHtml .='<th style="width:15%;">';
		$myHtml .='</th>';
		$myHtml .='<th style="width:25%;text-align:center">';
		$myHtml .='_________________________';
		$myHtml .='<br>Orden de compra<br>Creado por<br>'.$datos['usuario']->nombre.' '.$datos['usuario']->apellido;
		$myHtml .='</th>';
		$myHtml .='<th style="width:20%;">';
		$myHtml .='</th>';
		$myHtml .='<th style="width:25%;text-align:center">';
		$myHtml .='_________________________';
		$myHtml .='<br>Vo. Bo. Jefe de compras';
		$myHtml .='</th>';
		$myHtml .='<th style="width:15%;">';
		$myHtml .='</th>';
		$myHtml .='</tr>';
		$myHtml .='</table>';
		$myHtml .='</div>';
		$myHtml .='</div>';
		$myHtml .='</div>';
		return $myHtml;
	}
    // convert in PDF
    require_once('../../../includes/librerias/html2pdf/html2pdf.class.php');
    try
    {
    	include_once "../../../dbconexion/conn.php";
		$dbcon	= 	new MysqlConn;
    	$cve_odc = $_REQUEST['cve_odc'];
    	$sql = "SELECT odcd.cve_req, odcd.cve_art, ca.nombre_articulo, '' unidadMedida, 
		odcd.cantidad_cotizada, odcd.precio_unidad 
		FROM orden_compra_detalle odcd 
		INNER JOIN cat_articulos ca ON ca.cve_articulo = odcd.cve_art
		WHERE odcd.cve_odc = ".$cve_odc;
		$tabla = $dbcon->qBuilder($dbcon->conn(), 'all', $sql);
		$sql = "SELECT p.cve_proveedor, p.nombre_proveedor, p.razon_social, p.rfc FROM orden_compra odc
		INNER JOIN cat_proveedores p ON odc.cve_proveedor = p.cve_proveedor
		WHERE odc.cve_odc = ".$cve_odc;
		$proveedor = $dbcon->qBuilder($dbcon->conn(), 'first', $sql);
		$sql = "SELECT u.nombre, u.apellido FROM orden_compra odc INNER JOIN cat_usuarios u ON u.cve_usuario = odc.cve_usuario
		WHERE odc.cve_odc = ".$cve_odc;
		$usuario = $dbcon->qBuilder($dbcon->conn(), 'first', $sql);
		require_once('../../../includes/librerias/barcode.php');
		$odc_bar = barcode($cve_odc);
		ob_start();
        imagepng($odc_bar);
        $imgData=ob_get_clean();
        imagedestroy($odc_bar);
        //Echo the data inline in an img tag with the common src-attribute
        $odc_bar = '<img src="data:image/png;base64,'.base64_encode($imgData).'" style="width:60%;" />';
		$datos = [
			'fecha' => date('d/m/Y'),
			'cve_odc' => $cve_odc,
			'tabla' => $tabla,
			'proveedor' => $proveedor,
			'usuario' => $usuario,
			'odc_bar' => $odc_bar
		];
		$myHtml = getPDF_odc($datos);
		// die($myHtml);
        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
		//      $html2pdf->setModeDebug();
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($myHtml);
        $html2pdf->Output('odc_'.$cve_odc.'.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>
