<?php   
    include_once "../../superior.php";
    include_once "../../../dbconexion/conexion.php";
    include_once "modelo_dashboard.php";
    // include_once "modelo_entradas.php";

?>        
        <head>
            <title>Dashboard</title>

    <link rel="stylesheet" type="text/css" href="../../../includes/datapicker/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="../../../includes/datapicker/jquery-ui.min.css">

    <!-- <link rel="stylesheet" type="text/css" href="../../../includes/css/style.css"> -->

            <style type="text/css">
                body{
                    background-color: #f7f6f6;
                }
                table thead{
                    background-color: #1A4672;
                    color:  white;
                }
                .dflex{
                        /*display: flex;*/  
                        justify-content: space-around;
                        /*align-items: center;*/
                        /*align-content: right;*/
                        text-align: right;
                        /*margin-center: auto;*/
                        /*float: right;*/
                    }
/*                .dflex{
                        justify-content: space-around;
                        align-items: center;
                        float: right;
                    }*/
/*                .ui-datepicker-calendar{
                    display: none;
                }*/
                .dflex input{
                    border: 1px solid #CCC;
                    padding: 4px;
                    border-radius: 6px;
                    margin-right: 5px;
                }
            </style>
        <!-- MDB -->
<!-- <link href="../../../includes/css/mdb.min.css" rel="stylesheet"/> -->
        </head>
<div class="modal fade" id="myLoadingGral" tabindex="-3" data-backdrop="static" data-keyboard="false" style="padding-top:20%; overflow-y:visible;" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div align="center"><img src="../../../includes/imagenes/loading_gral.gif" width="140px"></div>
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

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
          <!-- <p>Start a beautiful journey here</p> -->
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
        </ul>
      </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active border" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true"><strong>Morteros</strong> </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link border" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false"><strong>Bloqueras</strong></a>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="col-md-12">
                                <div class="tile">
                                    <div class="dflex">
                                        <input class="date-picker" name="fecha_produciniciom" id="fecha_produciniciom" placeholder="Fecha Inicio">
                                        <input class="date-picker" name="fecha_producfinm" id="fecha_producfinm" placeholder="Fecha Fin">
                                        <button type="button" class="btn btn-info btn-sm" onclick="ValCamposProducMorteros()"><i class="fas fa-search"></i></button>
                                    </div>
                                    <div id="produccionMorteros" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="tile">
                                    <div class="dflex">
                                        <input class="date-picker" name="fecha_iniciom" id="fecha_iniciom" placeholder="Fecha Inicio">
                                        <input class="date-picker" name="fecha_finm" id="fecha_finm" placeholder="Fecha Fin">
                                        <button type="button" class="btn btn-info btn-sm" onclick="ValCamposMorteros()"><i class="fas fa-search"></i></button>
                                    </div>
                                    <div id="containermorteros" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <div class="col-md-12">
                                <div class="tile">
                                    <div class="dflex">
                                        <input class="date-picker" name="fecha_produciniciob" id="fecha_produciniciob" placeholder="Fecha Inicio">
                                        <input class="date-picker" name="fecha_producfinb" id="fecha_producfinb" placeholder="Fecha Fin">
                                        <button type="button" class="btn btn-info btn-sm" onclick="ValCamposProducBloqueras()"><i class="fas fa-search"></i></button>
                                    </div>
                                    <div id="produccionBloqueras" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="tile">
                                    <div class="dflex">
                                        <input class="date-picker" name="fecha_iniciob" id="fecha_iniciob" placeholder="Fecha Inicio">
                                        <input class="date-picker" name="fecha_finb" id="fecha_finb" placeholder="Fecha Fin">
                                        <button type="button" class="btn btn-info btn-sm" onclick="ValCamposBloqueras()"><i class="fas fa-search"></i></button>
                                    </div>
                                    <div id="containerbloquera" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
      <?php include_once "../../footer.php" ?>
    </main>


    <script src="dashboard.js"></script>

<?php include_once "../../inferior.php" ?>

    <!-- <script src="dashboard.js"></script> -->

    <script src="../../../includes/js/jquery331.min.js"></script>

    <script src="../../../includes/js/sweetalert2.min.js"></script>

    <script src="../../../includes/bootstrap/js/bootstrap.js"></script>
    <script src="../../../includes/bootstrap/js/bootstrap.min.js"></script>

    <!-- <script type="text/javascript" src="http://code.highcharts.com/highcharts.js"></script> -->
    <script src="../../../includes/librerias/highcharts/highcharts.js"></script>
    <script src="../../../includes/librerias/highcharts/highcharts-3d.js"></script>
    <script src="../../../includes/librerias/highcharts/exporting.js"></script>
    <script src="../../../includes/librerias/highcharts/export-data.js"></script>
    <script src="../../../includes/librerias/highcharts/accessibility.js"></script>

<!--     <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-3d.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script> -->

    <!-- <link rel="stylesheet" type="text/css" href="../../../includes/css/datatables.min.css"/> -->

    <script type="text/javascript" src="../../../includes/js/datatables.min.js"></script>

    <script type="text/javascript" src="../../../includes/datapicker/jquery-ui.min.js"></script>

<!-- DATAPICKER -->
<script>
    $('.date-picker').datepicker({
    closeText: 'Cerrar',
    prevText: '<Ant',
    nextText: 'Sig>',
    currentText: 'Hoy',
    monthNamesShort: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    // changeDay: true,
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    dateFormat: 'yy-mm-dd',
    showDays: false,
});
</script>

<!-- GRAFICA DE BARRAS PRODUCCIÓN TOTAL DE BLOQUERAS ENERO-DICIEMBRE 2022 -->
<script>
    Highcharts.chart('produccionBloqueras', {
        lang: {
                viewFullscreen:"Ver en pantalla completa",
                printChart:"Imprimir Gráfica",

                downloadPNG:"Descarga en formato PNG",
                downloadJPEG:"Descarga en formato JPEG",
                downloadPDF:"Descarga en formato PDF",
                downloadSVG:"Descarga en formato SVG",

                downloadCSV:"Descarga en formato CSV",
                downloadXLS:"Descarga en formato XLS",
                viewData:"Ver tabla",
                hideData:"Ocultal tabla"
            },
        chart: {
            // plotBackgroundColor: null,
            // plotBorderWidth: null,
            // plotShadow: false,
            type: 'column',
            options3d: {
                enabled: true,
                alpha: 15,
                beta: 0
            }
        },
        title: {
            text: 'Producción Bloqueras 2022'
        },
        tooltip: {
            pointFormat: '{series.name}= <b>{point.y:,.0f}</b>',
            valueSuffix: ' Pzas'
        },
        accessibility: {
            // announceNewData: {
            //     enabled: true
            // }
        },
        xAxis:{
            type: 'category',
            // labels: {
            //   rotation: -45,
            //   style: {
            //     fontSize: '13px',
            //     fontFamily: 'Verdana, sans-serif'
            //   }
            // }
        },
        yAxis: {
            title: {
                text: 'Valor en Piezas'
            }

        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:,.0f} Pzas'
                }
            },
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                // colors: pieColors,
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>= {point.y:,.0f}'
                }
            }
        },



        series: [{
            name: 'Cantidad total',
            colorByPoint: true,
            data: 
                    <?php
                            $objModelo  = new modeloDashboard;
                            $consulta = $objModelo->ProduccionTotalBloqueras();

                            $dato = [];
                            foreach ($consulta as $key => $value) {
                                $dato[$key] = [
                                                    "name" => $value['area'].' - '.$value['nombre_producto'].' - '.$value['presentacion'].' - '.$value['num_celdas'].' celdas',
                                                    "y" => floatval($value['piezas_totales'])
                                                ];
                            }

                            echo json_encode($dato);

                     ?>
        }],

        credits: {
          enabled: false
        },
    });
</script>

<!-- GRAFICA DE BARRAS PRODUCCIÓN TOTAL DE MORTEROS ENERO-DICIEMBRE 2022 -->
<script>
        Highcharts.chart('produccionMorteros', {
            lang: {
                    viewFullscreen:"Ver en pantalla completa",
                    printChart:"Imprimir Gráfica",

                    downloadPNG:"Descarga en formato PNG",
                    downloadJPEG:"Descarga en formato JPEG",
                    downloadPDF:"Descarga en formato PDF",
                    downloadSVG:"Descarga en formato SVG",

                    downloadCSV:"Descarga en formato CSV",
                    downloadXLS:"Descarga en formato XLS",
                    viewData:"Ver tabla",
                    hideData:"Ocultal tabla"
                },
            chart: {
                // plotBackgroundColor: null,
                // plotBorderWidth: null,
                // plotShadow: false,
                type: 'column',
                options3d: {
                    enabled: true,
                    alpha: 15,
                    beta: 0
                }
            },
            title: {
                text: 'Producción Morteros 2022'
            },
            tooltip: {
                pointFormat: '{series.name}= <b>{point.y:,.0f} Kg</b> ',
                valueSuffix: ' Kg'
            },
            accessibility: {
                // announceNewData: {
                //     enabled: true
                // }
            },
            xAxis:{
                type: 'category',
                // labels: {
                //   rotation: -45,
                //   style: {
                //     fontSize: '13px',
                //     fontFamily: 'Verdana, sans-serif'
                //   }
                // }
            },
            yAxis: {
                title: {
                    text: 'Valor en Kilogramos'
                }

            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:,.0f} Kg'
                    }
                },
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    // colors: pieColors,
                    depth: 35,
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.y:,.0f}'
                    }
                }
            },
            series: [{
                name: 'Cantidad total',
                colorByPoint: true,
                data: 
                        <?php
                                $objModelo  = new modeloDashboard;
                                $consulta = $objModelo->ProduccionTotalMorteros();

                                $dato = [];
                                foreach ($consulta as $key => $value) {
                                    $dato[$key] = [
                                                        "name" => $value['cve_producto'].' - '.$value['valor_presentacion'].' kg',
                                                        "y" => floatval($value['KGReal']),
                                                        "drilldown" => $value['cve_producto'].' / '.$value['valor_presentacion']
                                                    ];
                                }

                                echo json_encode($dato);

                        ?>
            }],
            // colors: ['#00CD01', '#ACE600', '#FFFF00', '#FFF263', '#FFCC00', '#FF9900', '#FF6600', '#FF0000'],
            // colors: ['#1A4673', '#ACE600', '#FFFF00', '#FFF263', '#FFCC00', '#FF9900', '#FF6600', '#FF0000'],
            // exporting: true,
            credits: {
              enabled: false
            },
            // legend: {
            //   enabled: false
            // }
        });
</script>

<!-- GRAFICA DE PASTEL PRODUCCIÓN TOTAL DE BLOQUERAS ENERO-DICIEMBRE 2022 -->
<script>
        Highcharts.chart('containerbloquera', {
            lang: {
                    viewFullscreen:"Ver en pantalla completa",
                    printChart:"Imprimir Gráfica",

                    downloadPNG:"Descarga en formato PNG",
                    downloadJPEG:"Descarga en formato JPEG",
                    downloadPDF:"Descarga en formato PDF",
                    downloadSVG:"Descarga en formato SVG",

                    downloadCSV:"Descarga en formato CSV",
                    downloadXLS:"Descarga en formato XLS",
                    viewData:"Ver tabla",
                    hideData:"Ocultal tabla"
                },
            chart: {
                // plotBackgroundColor: null,
                // plotBorderWidth: null,
                // plotShadow: false,
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 45,
                    beta: 0
                }
            },
            title: {
                text: 'Venta Bloqueras 2022'
            },
            tooltip: {
                pointFormat: '{series.name}= <b>{point.y:,.0f}</b>',
                valueSuffix: ' Pzas'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    // colors: pieColors,
                    depth: 35,
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>= {point.y:,.0f} Pzas'
                    }
                }
            },
            series: [{
                name: 'Cantidad total',
                colorByPoint: true,
                data: 
                    <?php
                            $objModelo  = new modeloDashboard;
                            $consulta = $objModelo->VentasTotalBloqueras();

                            $dato = [];
                            foreach ($consulta as $key => $value) {
                                $dato[$key] = [
                                                    "name" => $value['area'].' - '.$value['nombre_producto'].' - '.$value['presentacion'].' - '.$value['num_celdas'],
                                                    "y" => floatval($value['cantidad_total'])
                                                ];
                            }

                            echo json_encode($dato);

                     ?>
            }],
            // colors: ['#00CD01', '#ACE600', '#FFFF00', '#FFF263', '#FFCC00', '#FF9900', '#FF6600', '#FF0000'],
            // colors: ['#1A4673', '#ACE600', '#FFFF00', '#FFF263', '#FFCC00', '#FF9900', '#FF6600', '#FF0000'],
            // exporting: true,
            credits: {
              enabled: false
            },
            // legend: {
            //   enabled: false
            // }
        });
</script>

<!-- GRAFICA DE PASTEL PRODUCCIÓN TOTAL DE MORTEROS ENERO-DICIEMBRE 2022 -->
<script>
        Highcharts.chart('containermorteros', {
            lang: {
                    viewFullscreen:"Ver en pantalla completa",
                    printChart:"Imprimir Gráfica",

                    downloadPNG:"Descarga en formato PNG",
                    downloadJPEG:"Descarga en formato JPEG",
                    downloadPDF:"Descarga en formato PDF",
                    downloadSVG:"Descarga en formato SVG",

                    downloadCSV:"Descarga en formato CSV",
                    downloadXLS:"Descarga en formato XLS",
                    viewData:"Ver tabla",
                    hideData:"Ocultal tabla"
                },
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 45,
                    beta: 0
                }
            },
            title: {
                text: 'Venta Morteros 2022'
            },
            tooltip: {
                pointFormat: '{series.name}= <b>{point.y:,.0f}</b>',
                valueSuffix: ' KG'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    // colors: pieColors,
                    depth: 35,
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>= {point.y:,.0f} Kg'
                    }
                }
            },
            series: [{
                name: 'Cantidad total',
                colorByPoint: true,
                data: 
                        <?php
                                $objModelo  = new modeloDashboard;
                                $consulta = $objModelo->VentasTotalMorteros();

                                $dato = [];
                                foreach ($consulta as $key => $value) {
                                    $dato[$key] = [
                                                        "name" => $value['nombre_salida'].' / '.$value['presentacion_salida'].' KG',
                                                        "y" => floatval($value['cantidad_salida'])
                                                    ];
                                }

                                echo json_encode($dato);

                         ?>
            }],
            // colors: ['#00CD01', '#ACE600', '#FFFF00', '#FFF263', '#FFCC00', '#FF9900', '#FF6600', '#FF0000'],
            // colors: ['#1A4673', '#ACE600', '#FFFF00', '#FFF263', '#FFCC00', '#FF9900', '#FF6600', '#FF0000'],
            // exporting: true,
            credits: {
              enabled: false
            },
            // legend: {
            //   enabled: false
            // }
        });
</script>


<!-- COLORES AZUL CORPORATIVO -->
<!-- 
<script>
    // Make monochrome colors
    var pieColors = (function () {
        var colors = [],
            base = Highcharts.getOptions().colors[0],
            i;

        for (i = 0; i < 10; i += 1) {
            // Start out with a darkened base color (negative brighten), and end
            // up with a much brighter color
            colors.push(Highcharts.color(base).brighten((i - 3) / 7).get());
        }
        return colors;
    }());

    // Build the chart
    Highcharts.chart('containerbloquera', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Browser market shares at a specific website, 2014'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                colors: pieColors,
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b><br>{point.percentage:.1f} %',
                    distance: -50,
                    filter: {
                        property: 'percentage',
                        operator: '>',
                        value: 4
                    }
                }
            }
        },
        series: [{
            name: 'Share',
            data: [
                { name: 'Chrome', y: 61.41 },
                { name: 'Internet Explorer', y: 11.84 },
                { name: 'Firefox', y: 10.85 },
                { name: 'Edge', y: 4.67 },
                { name: 'Safari', y: 4.18 },
                { name: 'Other', y: 7.05 },
                { name: '1', y: 61.41 },
                { name: '2', y: 11.84 },
                { name: '3', y: 10.85 },
                { name: '4', y: 4.67 },
                { name: '5', y: 4.18 },
                { name: '6', y: 7.05 }
            ]
        }],
        exporting: true
    });
</script> -->