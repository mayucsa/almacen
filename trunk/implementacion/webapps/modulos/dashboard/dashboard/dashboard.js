//VISUALIZACIÓN DE GRÁFICA PRODUCCIÓN BLOQUERAS
function ValCamposProducBloqueras() {
    var fecha_inicio = $("#fecha_produciniciob").val();
    var fecha_fin = $("#fecha_producfinb").val();

    var msj = "";

    if (fecha_inicio == 0) {
        msj += "<li>Fecha Inicio</li>"
    }
    if (fecha_fin == 0) {
        msj += "<li>Fecha Fin</li>"
    }
    if (msj.length != 0) {
        $('#encabezadoModal').html('Validación de datos');
        $('#cuerpoModal').html('Los siguientes campos son obligatorios:<ul>'+msj+'</ul>');
        $('#modalMensajes').modal('toggle');
    }else{
        ValCamposProducBloquerasSig();
    }
}
function ValCamposProducBloquerasSig() {
    var fecha_inicio = $("#fecha_produciniciob").val();
    var fecha_fin = $("#fecha_producfinb").val();

    var msg = "";

    if (fecha_inicio > fecha_fin) {
        msg += "<li>Fecha inicio debe ser menor a la Fecha final</li>"
    }
    if (msg.length != 0) {
        $('#encabezadoModal').html('Validación de datos');
        $('#cuerpoModal').html('Los siguientes campos no son correctos:<ul>'+msg+'</ul>');
        $('#modalMensajes').modal('toggle');
    }else{
        getDatosProducBloqueras();
    }
}
function getDatosProducBloqueras(){
        var fecha_inicio = $('#fecha_produciniciob').val();
        var fecha_fin = $('#fecha_producfinb').val();
        $.ajax({                
            url:"ctrl_dashboard_PBloqueras.php",
            method:"POST",  
            data:{
                fecha_inicio: fecha_inicio,
                fecha_fin: fecha_fin
            },  
            success:function(data)  
            {  
                data = JSON.parse(data);
                console.log('datos ', data);
                generaChartProducBloqueras(data);
            }  
        }); 
}
function generaChartProducBloqueras(varDatos){

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
                text: 'Producción Bloqueras'
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
                data: varDatos
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
}

//VISUALIZACIÓN DE GRÁFICA PRODUCCIÓN MORTEROS
function ValCamposProducMorteros() {
    var fecha_inicio = $("#fecha_produciniciom").val();
    var fecha_fin = $("#fecha_producfinm").val();

    var msj = "";

    if (fecha_inicio == 0) {
        msj += "<li>Fecha Inicio</li>"
    }
    if (fecha_fin == 0) {
        msj += "<li>Fecha Fin</li>"
    }
    if (msj.length != 0) {
        $('#encabezadoModal').html('Validación de datos');
        $('#cuerpoModal').html('Los siguientes campos son obligatorios:<ul>'+msj+'</ul>');
        $('#modalMensajes').modal('toggle');
    }else{
        ValCamposProducMorterosSig();
    }
}
function ValCamposProducMorterosSig() {
    var fecha_inicio = $("#fecha_produciniciom").val();
    var fecha_fin = $("#fecha_producfinm").val();

    var msg = "";

    if (fecha_inicio > fecha_fin) {
        msg += "<li>Fecha inicio debe ser menor a la Fecha final</li>"
    }
    if (msg.length != 0) {
        $('#encabezadoModal').html('Validación de datos');
        $('#cuerpoModal').html('Los siguientes campos no son correctos:<ul>'+msg+'</ul>');
        $('#modalMensajes').modal('toggle');
    }else{
        getDatosProducMorteros();
    }
}
function getDatosProducMorteros(){
        var fecha_inicio = $('#fecha_produciniciom').val();
        var fecha_fin = $('#fecha_producfinm').val();
        $.ajax({                
            url:"ctrl_dashboard_PMorteros.php",
            method:"POST",  
            data:{
                fecha_inicio: fecha_inicio,
                fecha_fin: fecha_fin
            },  
            success:function(data)  
            {  
                data = JSON.parse(data);
                // console.log('datos ', data);
                generaChartProducMorteros(data);
            }  
        }); 
}
function generaChartProducMorteros(varDatos){

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
                text: 'Producción Morteros'
            },
            tooltip: {
                pointFormat: '{series.name}= <b>{point.y:,.0f} Kg</b>',
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
                        format: '<b>{point.name}</b>= {point.y:,.0f}'
                    }
                }
            },
            series: [{
                name: 'Cantidad total',
                colorByPoint: true,
                data: varDatos
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
}


//VISUALIZACIÓN DE GRÁFICA VENTAS BLOQUERAS
function ValCamposBloqueras() {
    var fecha_inicio = $("#fecha_iniciob").val();
    var fecha_fin = $("#fecha_finb").val();

    var msj = "";

    if (fecha_inicio == 0) {
        msj += "<li>Fecha Inicio</li>"
    }
    if (fecha_fin == 0) {
        msj += "<li>Fecha Fin</li>"
    }
    if (msj.length != 0) {
        $('#encabezadoModal').html('Validación de datos');
        $('#cuerpoModal').html('Los siguientes campos son obligatorios:<ul>'+msj+'</ul>');
        $('#modalMensajes').modal('toggle');
    }else{
        ValCamposBloquerasSig();
    }
}
function ValCamposBloquerasSig() {
    var fecha_inicio = $("#fecha_iniciob").val();
    var fecha_fin = $("#fecha_finb").val();

    var msg = "";

    if (fecha_inicio > fecha_fin) {
        msg += "<li>Fecha inicio debe ser menor a la Fecha final</li>"
    }
    if (msg.length != 0) {
        $('#encabezadoModal').html('Validación de datos');
        $('#cuerpoModal').html('Los siguientes campos no son correctos:<ul>'+msg+'</ul>');
        $('#modalMensajes').modal('toggle');
    }else{
        getDatosBloqueras();
    }
}
function getDatosBloqueras(){
        var fecha_inicio = $('#fecha_iniciob').val();
        var fecha_fin = $('#fecha_finb').val();
        $.ajax({                
            url:"ctrl_dashboard_bloqueras.php",
            method:"POST",  
            data:{
                fecha_inicio: fecha_inicio,
                fecha_fin: fecha_fin
            },  
            success:function(data)  
            {  
                data = JSON.parse(data);
                // console.log('datos ', data);
                generaChartBloqueras(data);
            }  
        }); 
}
function generaChartBloqueras(varDatos){

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
                text: 'Venta Bloqueras'
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
                data: varDatos
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
}

// VISUALIZACIÓN DE GRÁFICA VENTAS MORTEROS
function ValCamposMorteros() {
    var fecha_inicio = $("#fecha_iniciom").val();
    var fecha_fin = $("#fecha_finm").val();

    var msj = "";

    if (fecha_inicio == 0) {
        msj += "<li>Fecha Inicio</li>"
    }
    if (fecha_fin == 0) {
        msj += "<li>Fecha Fin</li>"
    }
    if (msj.length != 0) {
        $('#encabezadoModal').html('Validación de datos');
        $('#cuerpoModal').html('Los siguientes campos son obligatorios:<ul>'+msj+'</ul>');
        $('#modalMensajes').modal('toggle');
    }else{
        ValCamposMorterosSig();
    }
}
function ValCamposMorterosSig() {
    var fecha_inicio = $("#fecha_iniciom").val();
    var fecha_fin = $("#fecha_finm").val();

    var msg = "";

    if (fecha_inicio > fecha_fin) {
        msg += "<li>Fecha inicio debe ser menor a la Fecha final</li>"
    }
    if (msg.length != 0) {
        $('#encabezadoModal').html('Validación de datos');
        $('#cuerpoModal').html('Los siguientes campos no son correctos:<ul>'+msg+'</ul>');
        $('#modalMensajes').modal('toggle');
    }else{
        getDatosMorteros();
    }
}
function getDatosMorteros(){
        var fecha_inicio = $('#fecha_iniciom').val();
        var fecha_fin = $('#fecha_finm').val();
        $.ajax({                
            url:"ctrl_dashboard_morteros.php",
            method:"POST",  
            data:{
                fecha_inicio: fecha_inicio,
                fecha_fin: fecha_fin
            },  
            success:function(data)  
            {  
                data = JSON.parse(data);
                // console.log('datos ', data);
                generaChartMorteros(data);
            }  
        }); 
}
function generaChartMorteros(varDatos){

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
                text: 'Venta Morteros'
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
                        format: '<b>{point.name}</b>= {point.y:,.0f}'
                    }
                }
            },
            series: [{
                name: 'Cantidad total',
                colorByPoint: true,
                data: varDatos
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
}