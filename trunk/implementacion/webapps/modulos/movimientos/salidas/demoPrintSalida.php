<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <style>
    	.borderedMe{
    		border-radius: 10px; border: solid;
    	}
    </style>
  </head>
  <body>
    <div class="container-fluid" id="inicial">
    	<div class="row p-2" style="width:40%;">
    		<div class="col-md-12">
    			<center>
    				<h4>FORMATO DE SALIDA - SAM</h4>
    			</center>
    		</div>
    		<div class="col-md-12 mb-4">
    			<center>
    				<img src="../../../includees/imagenes/Mayucsa.png" style="width: 80%;">
    			</center>
    		</div>
        <div style="height: 110px;">
          <div style="position:relative;">
        		<div class="" style="position: absolute; width: 30%;">
        			<div class="row borderedMe">
        				<div class="col-md-12 p-2" style="border-bottom: solid;">
        					<h3>FOLIO</h3>
        				</div>
        				<div class="col-md-12 p-2 text-center">
        					123
        				</div>
        			</div>
        		</div>
        		<div class="" style="position: absolute; margin-left: 35%; width: 65%;">
        			<div class="row borderedMe">
        				<div class="col-md-12 p-2" style="border-bottom: solid;">
        					<h3>FECHA</h3>
        				</div>
        				<div class="col-md-12 p-2 text-center">
        					<?=date('Y-m-d')?>
        				</div>
        			</div>
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
  <script>
  	function imprSelec(id) {
    	var div = document.getElementById(id);
	    var ventimp = window.open(' ', 'popimpr');
	    ventimp.document.write( div.innerHTML );
	    ventimp.document.close();
	    ventimp.print( );
	    ventimp.close();
	}
	$( document ).ready(function() {
		
	});
  </script>
</html>