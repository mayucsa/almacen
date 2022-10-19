<?php
    /** $direccion_actual = getcwd();
    $direccion_origen = dirname(__FILE__);
    $direccion_raiz = dirname($direccion_origen);

    $comparacion =  str_replace($direccion_raiz,'',$direccion_actual);
    $comparacion = str_replace("\\","/",$comparacion);

    $base_url = "";
    $dato = explode('/',$comparacion);

    for($i = 1; $i < count($dato); $i++){
            $base_url .= "../";
    } **/
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>Mensaje de Procesos</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <br/>
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-body">
              <?php if($type=='ok'){ ?>
                    <div class="callout callout-success">
                        <h4>Proceso realizado correctamente.</h4>
                        <p><?php if(isset($detalle)) echo $detalle;?></p>
                    </div>
                <?php } else if($type == 'personalizado'){ } else { ?>
                    <div class="callout callout-danger">
                        <h4>Ups, tenemos un problema</h4>
                        <p><?php if(isset($detalle)) echo $detalle;?></p>
                    </div>
                <?php } ?>
            </div>
            <div class="box-footer text-center">
                <div class="col-md-8">&nbsp;</div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-block btn-primary btn-lg" onclick="validaFuncion(this)" url="<?php echo $url_continuar;?>">Continuar...</button>    
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function validaFuncion(elem) {
            if ( typeof abrePagina === "function" ) { abrePagina(elem); }
            else { abrePagina2(elem); }
        }
        
        function abrePagina2(object){
            window.location.href = "../../../index.php";
        }
    </script>
</body>
</html>