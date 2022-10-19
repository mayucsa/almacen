function loadingModal(id_Body,titulo,ruta){
	construyesimpleloadingModal(id_Body,titulo,ruta);
	$('#myModalLoading').modal('toggle');
}

function construyesimpleloadingModal(id_Body,titulo,ruta){
	var title = titulo;
	var url = ruta;
	$("#myModalLoading").remove();

	$("#"+id_Body+"").before(
	 '<div class="modal fade bs-example-modal-lg" data-backdrop="static" data-keyboard="false" style="padding-top:20%; overflow-y:visible;" id="myModalLoading">'+
	 '<div align="center"><img id="imagenloading" src="'+url+'/loading3.gif"/ width="140px"></div>'+
	 '<div id="divtextloading" align="center" style="font-weight:bold; font-size:20px; color:#FFFFFF">'+title+'</div>'+
	 '</div>');
}

function cerrarLoading(){
    $('#myModalLoading').modal('hide');
}

function ModalEmergenteHTML(id_Body){
    construyesimpleModalEmergenteHTML(id_Body);
}

function construyesimpleModalEmergenteHTML(id_Body){
	$("#myModalVentanaEmergente").remove();
	$("#"+id_Body+"").before(
	 '<div id="myModalVentanaEmergente" class="modal fade bs-example-modal-lg" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">'+
	 '<div id="myMVEmergenteCuerpo" class="modal-dialog modal-lg" style="overflow-y:scroll; max-height:550px; margin-bottom:-50px;">'+
	 '<div class="modal-content" id="contenedorConsulta">'+
	 	'<div class="modal-body"></div>'+
	 '</div>'+
	 '</div>'+
	 '</div>');
}

function ModalEmergenteHTMLSec(id_Body){
    construyesimpleModalEmergenteHTMLSec(id_Body);
}

function construyesimpleModalEmergenteHTMLSec(id_Body){
	$("#myModalVESec").remove();
	$("#"+id_Body+"").before(
	 '<div id="myModalVESec" class="modal fade bs-example-modal-lg" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">'+
	 '<div id="myMVECuerpoSec" class="modal-dialog modal-lg" style="overflow-y:scroll; max-height:550px; margin-bottom:-50px;">'+
	 '<div class="modal-content" id="contenedorCSec">'+
	 	'<div class="modal-body"></div>'+
	 '</div>'+
	 '</div>'+
	 '</div>');
}

function ModalEmergenteTool(id_Body,pnombre){
    toolModalEmergenteHTML(id_Body,pnombre);
}

function toolModalEmergenteHTML(id_Body,pnombre){
	$("#"+pnombre).remove();
	$("#"+id_Body+"").before(
	 // '<div id="'+pnombre+'" class="modal fade bs-example-modal-lg" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">'+
	 // '<div id="'+pnombre+'" class="modal fade bs-example-modal-lg" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">'+
	 '<div id="'+pnombre+'" class="modal fade bs-example-modal-lg" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">'+
	 '<div class="modal-dialog modal-lg" style="overflow-y:scroll; max-height:550px; margin-bottom:-50px;">'+
	 '<div class="modal-content" id="contenedor'+pnombre+'">'+
	 	'<div class="modal-body"></div>'+
	 '</div>'+
	 '</div>'+
	 '</div>');
}

function ModalEmergenteHTMLPosicion(id_Body,posicionx){
    var ps = '30';
    if(posicionx != null ){
        ps = posicionx;
    }
    construyesimpleModalEmergentePosicion(id_Body,ps);
}

function construyesimpleModalEmergentePosicion(id_Body,ps)
{
	$("#myModalVentanaEmergente").remove();
	$("#"+id_Body+"").before(
	 '<div id="myModalVentanaEmergente" class="modal fade bs-example-modal-lg" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">'+
	 '<div class="modal-dialog modal-lg" style="overflow-y:scroll; max-height:550px; margin-bottom:-50px; margin-top: '+ps+'px !important">'+
	 '<div class="modal-content" id="contenedorConsulta">'+
	 	'<div class="modal-body"></div>'+
	 '</div>'+
	 '</div>'+
	 '</div>');
}

function MEmergente(id_Body)
{
	construyesimpleMEmergenteHTML(id_Body);
}

function construyesimpleMEmergenteHTML(id_Body)
{
	$("#myModalVentanaEmergente").remove();
	$("#"+id_Body+"").before(
	 '<div id="myModalVentanaEmergente" class="modal fade bs-example-modal-lg" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">'+
	 '<div class="modal-dialog modal-lg" style="max-height:550px; margin-bottom:-50px;">'+
	 '<div class="modal-content" id="contenedorConsulta">'+
	 	'<div class="modal-body"></div>'+
	 '</div>'+
	 '</div>'+
	 '</div>');
}

function cerrarModalEmergente()
{
	$('#myModalVentanaEmergente').modal('hide');
}

function Modal(id_Body,titulo,mensaje,estilo,funcion,posicionx)
{
	construyesimpleModal(id_Body,titulo,mensaje,estilo,funcion,posicionx);
	$('#simpleModal').modal('toggle');
}

function reacomodaBody(){
    setTimeout(function(){$("body").css("padding-right","0px");},2000);
}

function construyesimpleModal(id_Body,titulo,mensaje,estilo,funcion,posicionx)
{
	var title = titulo;
	var message = mensaje;
	var stile = estilo;
	var fc = funcion;
	var opcion = null;
        var ps = 30;
        if(posicionx !== null){
            ps = posicionx;
        }

	$("#simpleModal").remove();

	switch (stile) {
		case 'success':
			if ( fc == null ) {
				opcion = "<button id='btnCierreModal' type='button' class='btn btn-danger btn-sm' data-dismiss='modal' onclick='reacomodaBody()' ><span class='glyphicon glyphicon-remove'></span>&nbsp;Cerrar</button>";
			} else {
				opcion = "<button type='button' class='btn btn-success btn-sm' data-dismiss='modal' onclick='reacomodaBody()' ><span class='glyphicon glyphicon-saved'></span>&nbsp;Aceptar</button>";
				opcion += "<button type='button' class='btn btn-danger btn-sm' data-dismiss='modal'><span class='glyphicon glyphicon-remove'></span>&nbsp;Cancelar</button>";
			}
			
			$("#"+id_Body+"").before(
				"<div class='modal modal-info fade in' data-backdrop='static' id='simpleModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>"+
					"<div class='modal-dialog' style='margin-top: 150px !important'>"+
						"<div class='modal-content'>"+
							"<div class='modal-header'>"+
								"<button id='btnCierreModalX' type='button' class='close' data-dismiss='modal' aria-label='Close' onclick='reacomodaBody()' ><span aria-hidden='true'>&times;</span></button>"+
								"<h5 class='modal-title'><span class='title-modal'>"+title+"</span></h5>"+
							"</div>"+
							"<div class='modal-body'><p>"+message+"</p>"+"</div>"+
							"<div class='modal-footer bg-contenido-footer'>"+opcion+"</div>"+
						"</div>"+
					"</div>"+
				"</div>");
			break;
		case 'success2':
			if ( fc == null ) {
				opcion = "<button type='button' class='btn btn-danger btn-sm' data-dismiss='modal' onclick='reacomodaBody()' ><span class='glyphicon glyphicon-remove'></span>&nbsp;Cerrar</button>";
			} else {
				opcion = "<button type='button' class='btn btn-success btn-sm' data-dismiss='modal' onclick='setTimeout(function(){"+fc+"},400)'><span class='glyphicon glyphicon-saved'></span>&nbsp;Aceptar</button>";
			}
			
			$("#"+id_Body+"").before(
				"<div class='modal fade' data-backdrop='static' id='simpleModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>"+
					"<div class='modal-dialog' style='margin-top: "+ps+"px !important'>"+
						"<div class='modal-content'>"+
							"<div class='modal-header modal-success'>"+
								"<button type='button' class='close' data-dismiss='modal' aria-label='Close' onclick='reacomodaBody()' ><span aria-hidden='true'>&times;</span></button>"+
								"<h5 class='modal-title'><span class='glyphicon glyphicon-ok-sign'></span>&nbsp;&nbsp;<span class='title-modal'>"+title+"</span></h5>"+
							"</div>"+
							"<div class='modal-body'><p style='color:#000000'>"+message+"</p>"+"</div>"+
							"<div class='modal-footer bg-contenido-footer'>"+opcion+"</div>"+
						"</div>"+
					"</div>"+
				"</div>");
			break;
		case 'primary':
			if ( fc == null ) {
				opcion = "<button type='button' class='btn btn-danger btn-sm' data-dismiss='modal' onclick='reacomodaBody()' ><span class='glyphicon glyphicon-remove'></span>&nbsp;Cerrar</button>";
			} else {
				opcion = "<button type='button' class='btn btn-success btn-sm' data-dismiss='modal' onclick='setTimeout(function(){"+fc+"},400)'><span class='glyphicon glyphicon-saved'></span>&nbsp;Aceptar</button>";
				opcion += "<button type='button' class='btn btn-danger btn-sm' data-dismiss='modal' onclick='reacomodaBody()' ><span class='glyphicon glyphicon-remove'></span>&nbsp;Cancelar</button>";
			}
			
			$("#"+id_Body+"").before(
				"<div class='modal modal-success fade in' id='simpleModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>"+
					"<div class='modal-dialog' style='margin-top: "+ps+"px !important'>"+
						"<div class='modal-content'>"+
							"<div class='modal-header'>"+
								"<button type='button' class='close' data-dismiss='modal' aria-label='Close' onclick='reacomodaBody()' ><span aria-hidden='true'>&times;</span></button>"+
								"<h5 class='modal-title'><span class='glyphicon glyphicon-exclamation-sign'></span>&nbsp;&nbsp;<span class='title-modal'>"+title+"</span></h5>"+
							"</div>"+
							"<div class='modal-body'><p>"+message+"</p>"+"</div>"+
							"<div class='modal-footer bg-contenido-footer'>"+opcion+"</div>"+
						"</div>"+
					"</div>"+
				"</div>");
			break;
		case 'warning':
			if ( fc == null ) {
				opcion = "<button type='button' class='btn btn-danger btn-sm' data-dismiss='modal' onclick='reacomodaBody()' >Cerrar</button>";
			} else {
				opcion = "<button type='button' class='btn btn-success btn-sm' data-dismiss='modal' onclick='setTimeout(function(){"+fc+"},400)'>Aceptar</button>";
				opcion += "<button type='button' class='btn btn-danger btn-sm' data-dismiss='modal' onclick='reacomodaBody()' >Cancelar</button>";
			}
			
			$("#"+id_Body+"").before(
				"<div class='modal modal-warning fade in' id='simpleModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>"+
					"<div class='modal-dialog' style='margin-top: "+ps+"px !important'>"+
						"<div class='modal-content'>"+
							"<div class='modal-header'>"+
								"<button type='button' class='close' data-dismiss='modal' aria-label='Close' onclick='reacomodaBody()' ><span aria-hidden='true'>&times;</span></button>"+
								"<h5 class='modal-title'><span class='title-modal'>"+title+"</span></h5>"+
							"</div>"+
							"<div class='modal-body'><p style='color:#000000'>"+message+"</p>"+"</div>"+
							"<div class='modal-footer bg-contenido-footer'>"+opcion+"</div>"+
						"</div>"+
					"</div>"+
				"</div>");
			break;
		case 'danger':
			if(fc == null) {
				opcion = "<button type='button' class='btn btn-danger btn-sm' data-dismiss='modal' onclick='reacomodaBody()' >Cerrar</button>";
			} else {
				opcion = "<button type='button' class='btn btn-success btn-sm' data-dismiss='modal' onclick='setTimeout(function(){"+fc+"},400)'><span class='glyphicon glyphicon-saved'></span>&nbsp;Aceptar</button>";
				opcion += "<button type='button' class='btn btn-danger btn-sm' data-dismiss='modal' onclick='reacomodaBody()' ><span class='glyphicon glyphicon-remove'></span>&nbsp;Cancelar</button>";
			}
			
			$("#"+id_Body+"").before(
				"<div class='modal modal-danger fade in' id='simpleModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>"+
					"<div class='modal-dialog' style='margin-top: "+ps+"px !important'>"+
						"<div class='modal-content'>"+
							"<div class='modal-header'>"+
								"<button type='button' class='close' data-dismiss='modal' aria-label='Close' onclick='reacomodaBody()' ><span aria-hidden='true'>&times;</span></button>"+
								"<h5 class='modal-title'><span class='glyphicon glyphicon-floppy-remove'></span>&nbsp;&nbsp;<span class='title-modal'>"+title+"</span></h5>"+
							"</div>"+
							"<div class='modal-body'><p>"+message+"</p>"+"</div>"+
							"<div class='modal-footer bg-contenido-footer'>"+opcion+"</div>"+
						"</div>"+
					"</div>"+
				"</div>");
			break;
		case 'primary_inf':
			if ( fc == null ) {
				opcion = "<button type='button' class='btn btn-danger btn-sm' data-dismiss='modal' onclick='reacomodaBody()' ><span class='glyphicon glyphicon-remove'></span>&nbsp;Cerrar</button>";
			} else {
				opcion = "<button type='button' class='btn btn-success btn-sm' data-dismiss='modal' onclick='setTimeout(function(){"+fc+"},400)'><span class='glyphicon glyphicon-saved'></span>&nbsp;Aceptar</button>";
				opcion += "<button type='button' class='btn btn-danger btn-sm' data-dismiss='modal' onclick='reacomodaBody()' ><span class='glyphicon glyphicon-remove'></span>&nbsp;Cancelar</button>";
			}
			
			$("#"+id_Body+"").before(
				"<div class='modal fade' id='simpleModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>"+
					"<div class='modal-dialog' style='margin-top: "+ps+"px !important'>"+
						"<div class='modal-content'>"+
							"<div class='modal-header modal-info'>"+
								"<button type='button' class='close' data-dismiss='modal' aria-label='Close' onclick='reacomodaBody()' ><span aria-hidden='true'>&times;</span></button>"+
								"<h5 class='modal-title'><span class='glyphicon glyphicon-info-sign'></span>&nbsp;&nbsp;<span class='title-modal'>"+title+"</span></h5>"+
							"</div>"+
							"<div class='modal-body'><p style='color:#000000'>"+message+"</p>"+"</div>"+
							"<div class='modal-footer bg-contenido-footer'>"+opcion+"</div>"+
						"</div>"+
					"</div>"+
				"</div>");
			break;
		case 'primary-files':
			if ( fc == null ) {
				opcion = "<button type='button' class='btn btn-danger btn-sm' data-dismiss='modal' onclick='reacomodaBody()' ><span class='glyphicon glyphicon-remove'></span>&nbsp;Cerrar</button>";
			} else {
				opcion = "<button type='button' class='btn btn-success btn-sm' data-dismiss='modal' onclick='setTimeout(function(){"+fc+"},400)'><span class='glyphicon glyphicon-saved'></span>&nbsp;Aceptar</button>";
				opcion += "<button type='button' class='btn btn-danger btn-sm' data-dismiss='modal' onclick='reacomodaBody()' ><span class='glyphicon glyphicon-remove'></span>&nbsp;Cancelar</button>";
			}
			
			$("#"+id_Body+"").before(
				"<div class='modal fade' id='simpleModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>"+
					"<div class='modal-dialog' style='margin-top: "+ps+"px !important'>"+
						"<div class='modal-content'>"+
							"<div class='modal-header modal-info'>"+
								"<button type='button' class='close-modal' data-dismiss='modal' aria-label='Close' onclick='reacomodaBody()' ><span aria-hidden='true'>&times;</span></button>"+
								"<h5 class='modal-title'><i class='fa fa-file-pdf-o'></i>&nbsp;&nbsp;<span class='title-modal'>"+title+"</span></h5>"+
							"</div>"+
							"<div class='modal-body'><iframe src='"+message+"' width='570px' height='500px'></iframe></div>"+
							"<div class='modal-footer bg-contenido-footer'>"+opcion+"</div>"+
						"</div>"+
					"</div>"+
				"</div>");
			break;
		case 'notify':
			if ( fc == null ) {
				opcion = "<button type='button' class='btn btn-danger btn-sm' data-dismiss='modal' onclick='reacomodaBody()' ><span class='glyphicon glyphicon-remove'></span>&nbsp;Cerrar</button>";
			} else {
				opcion = "<button type='button' class='btn btn-success btn-sm' data-dismiss='modal' onclick='setTimeout(function(){"+fc+"},400)'><span class='glyphicon glyphicon-saved'></span>&nbsp;Aceptar</button>";
				opcion += "<button type='button' class='btn btn-danger btn-sm' data-dismiss='modal' onclick='reacomodaBody()' ><span class='glyphicon glyphicon-remove'></span>&nbsp;Cancelar</button>";
			}
			
			$("#"+id_Body+"").before(
				"<div class='modal fade in' data-backdrop='static' id='simpleModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>"+
					"<div class='modal-dialog' style='margin-top: 150px !important'>"+
						"<div class='modal-content'>"+
							"<div class='modal-header bg-primary'>"+
								"<button type='button' class='close' data-dismiss='modal' aria-label='Close' onclick='reacomodaBody()' ><span aria-hidden='true'>&times;</span></button>"+
								"<h5 class='modal-title'><span class='title-modal'>"+title+"</span></h5>"+
							"</div>"+
							"<div class='modal-body'><p>"+message+"</p>"+"</div>"+
							"<div class='modal-footer bg-contenido-footer'>"+opcion+"</div>"+
						"</div>"+
					"</div>"+
				"</div>");
			break;
		default:
			console.log("Lo sentimos, por el momento el modal '"+stile+"' no existe.");
	}
}

function ModalForm(id_Body,titulo,mensaje,estilo,funcion)
{
	construyesimpleModalForm(id_Body,titulo,mensaje,estilo,funcion);
	$('#simpleModalForm').modal('toggle');
}

function construyesimpleModalForm(id_Body,titulo,mensaje,estilo,funcion)
{
	var title = titulo;
	var message = mensaje;
	var stile = estilo;
	var fc = funcion;
	var opcion = null;

	$("#simpleModalForm").remove();

	if(stile == 'primary_form')
	{
		if(fc == null)
		{
			opcion = "<button type='button' class='btn btn-danger btn-sm' data-dismiss='modal'><span class='glyphicon glyphicon-remove'></span>&nbsp;Cerrar</button>";
		}
		else
		{
			opcion = "<button type='button' class='btn btn-success btn-sm' onclick='setTimeout(function(){"+fc+"},400)'><span class='glyphicon glyphicon-saved'></span>&nbsp;Aceptar</button>";
			opcion += "<button type='button' class='btn btn-danger btn-sm' data-dismiss='modal'><span class='glyphicon glyphicon-remove'></span>&nbsp;Cancelar</button>";
		}

		$("#"+id_Body+"").before(
		 "<div class='modal fade' id='simpleModalForm' data-keyboard='false' data-backdrop='static' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>"+
		 "<div class='modal-dialog'>"+
		  "<div class='modal-content'>"+
			  "<div class='well well-sm' style='color:#FFFFFF; margin-left:10px; margin-right:10px; margin-bottom:-5px'><strong>"+
			    "<span class='glyphicon glyphicon-info-sign'></span>&nbsp;&nbsp;"+title+"</strong>"+
				"<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"+
			  "</div>"+
			  "<div class='modal-body'><p style='color:#000000; font-size:14px;'>"+message+"</p>"+"</div>"+
			  "<div class='modal-footer bg-contenido-footer'>"+opcion+"</div>"+
		  "</div>"+
		"</div>"+
		"</div>");
	}
}

function modalPDF(id_Body,titulo)
{
	$("#myModalVentanaEmergente").remove();
	$("#"+id_Body+"").before(
	'<div class="modal fade" id="myModalPDF">'+
        '<div class="modal-dialog">'+
           '<div class="modal-header modal-content" style="height:40px; font-size:12px">'+
               '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
               '<h5 class="modal-title"><span id="icono_span" class=""></span>&nbsp;&nbsp;<label id="tituloModal">'+titulo+'</label></h5></div>'+
           '<div class="normal-content" id="divPDF">'+
               '<iframe src="" width="570px" height="500px"></iframe>'+
           '</div>'+
           '<div class="modal-footer bg-contenido-alertas">'+
               '<button class="btn btn-danger btn-sm" data-dismiss="modal" type="button">'+
                   '<span class="glyphicon glyphicon-remove-sign"></span>&nbsp;Cerrar'+
               '</button>'+
           '</div>'+
       '</div>'+
   '</div>'
        );
}

/*
* Valida que el texto escrito en el campo sea un
*  caracter numerico.
* Uso: onkeypress="return getKeyNumber(event);"
*/
function getKeyNumber( events )
{
  	var key = (window.event ) ? events.keyCode:events.which;
  	if( ( key >= 48 && key <= 57 ) || key == 8 || key == 0||(key == 37))
	{
  		return true;
  	}
	else
	{
		return false;
	}
}
/*
* Valida que el texto escrito en el campo sea un
*  caracter numerico.
* Uso: onkeypress="return getKeyNumberDecimal(event);"
*/
function getKeyNumberDecimal(events)
{
	var key=(window.event)?events.keyCode:events.which;
	if((( key >= 48 && key <= 57) || key == 8 || key == 0 )||//0-9,backEspace
			(key==44 || key==46 || key==45)/*',','.','-'*/)
	{
		return true;
	}
	else
	{
		return false;
	}
}


/*
* Valida que el texto escrito en el campo sea un
*  caracter numerico o texto
* Uso: onkeypress="return getKeyNumberText(event);"
*/
function getKeyNumberText(events)
{
	var key=(window.event)?events.keyCode:events.which;
	if((( key >= 48 && key <= 57) || //0-9
                key == 8 ||   //backEspace
                key == 32 ||   //backEspace
                key == 0 ||   //NULL
                key == 241 || //ñ
                key == 209 || //Ñ
                (key >= 65 && key <= 90) || // A -Z
                (key >= 97 && key <= 122) )) // a -z)
	{   return true;
	} else {
            return false;
	}
}
/*
* Valida que el texto escrito en el campo sea un
*  caracter numerico o texto
* Uso: onkeypress="return getKeyNumTxtNoSpace(event);"
*/
function getKeyNumTxtNoSpace(events)
{
	var key=(window.event)?events.keyCode:events.which;
	if((( key >= 48 && key <= 57) || //0-9
                key == 8 ||   //backEspace
            //    key == 32 ||   //backEspace
                key == 0 ||   //NULL
            //    key == 241 || //ñ
            //    key == 209 || //Ñ
                (key >= 65 && key <= 90) || // A -Z
                (key >= 97 && key <= 122) )) // a -z)
	{   return true;
	} else {
            return false;
	}
}
/*
* Valida que el texto escrito en el campo sea un
*  caracter texto
* Uso: onkeypress="return getKeyText(event);"
*/
function getKeyText(events)
{
	var key=(window.event)?events.keyCode:events.which;
	if((    key == 8 ||   //backEspace
                key == 32 ||   //backEspace
                key == 0 ||   //NULL
                key == 241 || //ñ
                key == 209 || //Ñ
                key==46 || // .
                key==40 || // (
                key==41 || // )
                (key >= 65 && key <= 90) || // A -Z
                (key >= 97 && key <= 122) )) // a -z)
	{   return true;
	} else {
            return false;
	}
}
/*
* Valida que el texto escrito en el campo sea un
*  caracter texto
* Uso: onkeypress="return getKeyJustText(event);"
*/
function getKeyJustText(events)
{
	var key=(window.event)?events.keyCode:events.which;
	if((    key == 8 ||   //backEspace
                key == 32 ||   //backEspace
                key == 0 ||   //NULL
                key == 241 || //ñ
                key == 209 || //Ñ
                (key >= 65 && key <= 90) || // A -Z
                (key >= 97 && key <= 122) )) // a -z)
	{   return true;
	} else {
            return false;
	}
}
/**
* FUNCION PARA DAR FORMATO TIPO CANTIDAD
* MONETARIA
* USO: EN SU INPUTEXT DE UNA PROPIEDAD MAPEADA STRING
* onblur="formatCurrency(this);"
* @param num
* @return
*/
function formatCurrency(num)
{
	num = num.toString().replace(/\$|\,/g,'');
	if(isNaN(num))
	num = "0";  //FIXME: num es cadena o es numero?
	sign = (num == (num = Math.abs(num)));
	num = Math.floor(num*100+0.50000000001);
	cents = num%100;
	num = Math.floor(num/100).toString();
	if(cents < 10)
	cents = "0" + cents;
	for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
	num = num.substring(0,num.length-(4*i+3))+','+
	num.substring(num.length-(4*i+3));
	return (((sign)?'':'-') +num + '.' + cents);
}

//poner formato de numeros
function formatNumber(num,prefix)
{
   prefix = prefix || '';
   num += '';
   var splitStr = num.split('.');
   var splitLeft = splitStr[0];
   var splitRight = splitStr.length > 1 ? '.' + splitStr[1] : '';
   var regx = /(\d+)(\d{3})/;
   while (regx.test(splitLeft)) {
      splitLeft = splitLeft.replace(regx, ' $1' + ',' + '$2');
   }
    if( splitRight.length == 0 )
	   		splitRight = ".00";
	 else if( splitRight.length == 2 )
	   		splitRight += "0";
   var cadNumero = splitRight.substring(0,3);
   return prefix + splitLeft + cadNumero;
}
//quita formato de numeros
function unFormatNumber( param )
{
	return param.replace(/([^0-9.-])/g,'' )*1;
}
/*Funcion donde formatea la cantidad*/
function formateo(elemento)
{
	if(elemento.value != "")
		elemento.value = formatNumber(elemento.value);
}
/*Funcion donde quita el formato a la cantidad*/
function sinformateo(elemento)
{
	if(elemento.value != "")
		elemento.value = unFormatNumber(elemento.value);
}
/*Funcion para limitar el numero de caracteres en un TextArea
  Forma de usar
  <textarea maxlength="10" onkeyup="return lengthText(this)"></textarea>
  El maxlength="10" indica la cantidad de limitacion de caracteres
 */
 function lengthText(obj)
 {
	 var mlength=obj.getAttribute? parseInt(obj.getAttribute("maxlength")) : "";
	 if (obj.getAttribute && obj.value.length>mlength)
		 obj.value=obj.value.substring(0,mlength)
 }
/*
 * La fucion selectDinamico requiere de los siguientes parametros
        valor_padre : valor del padre combo
        nombre_hijo : nombre del combo hijo
        url_json    : ruta php donde se crea el json
        posicion    : parametro de identificacion de query
 */
function selectDinamico(valor_padre,nombre_hijo,url_json,posicion){
    $("#"+nombre_hijo).empty();
    var arreglo_datos = [];
    ajaxJson(url_json,"posicion="+posicion+"&padre="+valor_padre,
    function(data){
        arreglo_datos.push({id: "", text: '[Seleccione una opción...]'});
        for (var i in data) {
            arreglo_datos.push({id: data[i].id, text: data[i].descripcion});
        }
    });

     // console.warn(arreglo_datos.length);

     if(arreglo_datos.length==1)
      {
       // arreglo_datos.push({id: 0, text: 'No se encontró información'});
        arreglo_datos = [];
      }

    $("#"+nombre_hijo).select2({
    	data : arreglo_datos,
        theme: 'classic'
    });
}
/*
 * La fucion selectDinamico requiere de los siguientes parametros
        valor_padre : valor del padre combo
        nombre_hijo : nombre del combo hijo
        url_json    : ruta php donde se crea el json
        posicion    : parametro de identificacion de query
 */
function selectdependiente(valor_padre,nombre_hijo,url_json,posicion){
    $("#"+nombre_hijo).empty();
    var arreglo_datos = "";
    ajaxJson(url_json,"posicion="+posicion+"&padre="+valor_padre,
    function(data){
        //arreglo_datos.push({id: "", text: '[Seleccione una opción...]'});
        arreglo_datos += "<option value=''>[Seleccione una opción...]</option>";
        for (var i in data) {
            //arreglo_datos.push({id: data[i].id, text: data[i].descripcion});
            arreglo_datos += "<option value='"+data[i].id+"'>"+data[i].descripcion+"</option>";
        }
    });

     // console.warn(arreglo_datos.length);

     /*if(arreglo_datos.length==1)
      {
       // arreglo_datos.push({id: 0, text: 'No se encontró información'});
        arreglo_datos = [];
      } */

    $("#"+nombre_hijo).html(arreglo_datos);
}
/* Ajax Con Return de Respuesta
 * var Variable = ajaxJson(url,parametros,function(data){})
 */
function ajaxEmergente(urldoc,parametros,success){
    ajaxemergente({url:urldoc, type:'POST', data:parametros, success:success});
}

function ajaxemergente(property)
{
	var prop = jQuery.extend
		({async:false
		},property);

	jQuery.ajax({
		url:prop.url,
		type: prop.type,
		data: prop.data,
		async: prop.async,
		success: function(data)
		{
			prop.success(data);
		}
	});
}
/* Ajax Con Return de Respuesta
 * var Variable = ajaxJson(url,parametros,function(data){})
 */
function ajaxEmergenteAsin(urldoc,parametros,success){
    ajaxemergenteasin({url:urldoc, type:'POST', data:parametros, success:success});
}

function ajaxemergenteasin(property){
    var prop = jQuery.extend
            ({async:true
            },property);

    jQuery.ajax({
            url:prop.url,
            type: prop.type,
            data: prop.data,
            async: prop.async,
            success: function(data)
            {
                    prop.success(data);
            }
    });
}
/* Ajax Con Return de Respuesta
 * var Variable = ajaxJson(url,parametros,function(data){})
 */
function ajaxJson(urldoc,parametros,success)
{
    ajaxjson({url:urldoc, type:'POST', data:parametros, success:success});
}

function ajaxjson(property)
{
	var prop = jQuery.extend
		({dataType:'JSON',
		async:false
		},property);

	jQuery.ajax({
		url:prop.url,
		type: prop.type,
		data: prop.data,
		async: prop.async,
		dataType:prop.dataType,
		success: function(data, textStatus, transport)
		{
			prop.success(data);
		},
		error: function (result, errorType, errorMessage) {
			prop.success(errorMessage);
		}
	});
}

function ajaxJsonAsin(urldoc,parametros,success)
{
    ajaxjson({url:urldoc, type:'POST', data:parametros, success:success});
}

function ajaxjsonasin(property)
{
	var prop = jQuery.extend
		({dataType:'JSON',
		async:true
		},property);

	jQuery.ajax({
		url:prop.url,
		type: prop.type,
		data: prop.data,
		async: prop.async,
		dataType:prop.dataType,
		success: function(data, textStatus, transport)
		{
			prop.success(data);
		},
		error: function (result, errorType, errorMessage) {
			prop.success(errorMessage);
		}
	});
}
// FUNCION PARA VALIDAR FORMULARIOS
function limpiarForms(formulario)
{
// recorremos todos los campos que tiene el formulario
	$(":input", formulario).each(function() {
		var type = this.type;
		var tag = this.tagName.toLowerCase();
//limpiamos los valores de los campos: text, password y textarea
		if (type == "text" || type == "password" || tag == "textarea" || type == "email" || type == "tel")
			this.value = "";
// excepto de los checkboxes y radios, le quitamos el checked
// pero su valor no debe ser cambiado
		else if (type == "checkbox" || type == "radio")
			this.checked = false;
// los selects le ponesmos el indice a -
		else if (tag == "select")
		{
			this.selectedIndex = -1;
			$("#"+this.id+"").selectpicker('val','');
		}

	});
}

function ValidaEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}


function paginar_tabla(idtabla,datosJSON,columnas,parametros,paramScroll = false){

    var objeto = {};
    var datos = parametros.split('&');
    $.each( datos, function( key, value ) {
        var valor = value.split('=');
        objeto[""+valor[0]+""] = valor[1];
    });

    $('#'+idtabla).dataTable( {

        "destroy": true,
        "searching": false,
        "ordering": false,
        "scrollX":paramScroll,

	 "dom": 'T<"clear">lfrtip',

         'processing': true,
         'paging': true,
         'serverSide': true,

	 "ajax": {
                   "type":"POST",
                   "dataType": "json",
                   "data": objeto ,
                   "url": datosJSON,
                   "complete" : function(xhr, status) {
                        /* CLONAR INFORMACION DE PAGINA SUPERIOR -> DERECHA*/
                        if($('#dt_clon_Info')){$('#dt_clon_Info').remove();}
                        $('#'+idtabla+'_length').append("<div id='dt_clon_Info' class='dataTables_info' style='float:right'>"+$('#'+idtabla+'_info').html()+"</div>");
                        $('[data-toggle="tooltip"]').tooltip();
                    }
                 },

         "columns": columnas,

	 "tableTools": {
		 "sRowSelect": "multi",
		 "aButtons": [
			 {
				 "sExtends": "select_none",
				 "sButtonText": "Borrar selección"
			 }]
	 },
	 "pagingType": "full_numbers",
	 "language": {
		 "lengthMenu": "Mostrar _MENU_ registros por página.",
		 "zeroRecords": "No se encontró registro.",
		 "info": "  _START_ de _END_ (_TOTAL_ registros totales).",
		 "infoEmpty": "0 de 0 de 0 registros",
		 "infoFiltered": "(Encontrado de _MAX_ registros)",
		 "search": "Buscar: ",
		 "processing": "Procesando...",
                  "paginate": {
			 "first": "Primero",
			 "previous": "Anterior",
			 "next": "Siguiente",
			 "last": "Último"
		 }

	 }
 });
 }

function paginar_tabla_asin(idtabla,datosJSON,columnas,parametros)
{
    var objeto = {};
    var datos = parametros.split('&');
    $.each( datos, function( key, value ) {
        var valor = value.split('=');
        objeto[""+valor[0]+""] = valor[1];
    });

    $('#'+idtabla).dataTable( {

        "destroy": true,
        "searching": false,
        "ordering": false,

	 "dom": 'T<"clear">lfrtip',

         'processing': true,
         'paging': true,
         'serverSide': true,

	 "ajax": {
                   "type":"POST",
                   "dataType": "json",
                   "data": objeto ,
                   "url": datosJSON,
                   "async":false,
                   "complete" : function(xhr, status) {
                        /* CLONAR INFORMACION DE PAGINA SUPERIOR -> DERECHA*/
                        if($('#dt_clon_Info')){$('#dt_clon_Info').remove();}
                        $('#'+idtabla+'_length').append("<div class='dataTables_info' style='float:right'>"+$('#'+idtabla+'_info').html()+"</div>");
                    }
                 },

         "columns": columnas,

	 "tableTools": {
		 "sRowSelect": "multi",
		 "aButtons": [
			 {
				 "sExtends": "select_none",
				 "sButtonText": "Borrar selección"
			 }]
	 },
	 "pagingType": "full_numbers",
	 "language": {
		 "lengthMenu": "Mostrar _MENU_ registros por página.",
		 "zeroRecords": "No se encontró registro.",
		 "info": "  _START_ de _END_ (_TOTAL_ registros totales).",
		 "infoEmpty": "0 de 0 de 0 registros",
		 "infoFiltered": "(Encontrado de _MAX_ registros)",
		 "search": "Buscar: ",
		 "processing": "Procesando...",
                  "paginate": {
			 "first": "Primero",
			 "previous": "Anterior",
			 "next": "Siguiente",
			 "last": "Último"
		 }

	 }
 });
 }

  function paginar_tabla_definido(idtabla,datosJSON,columnas,parametros)
{
    var objeto = {};
    var datos = parametros.split('&');
    $.each( datos, function( key, value ) {
        var valor = value.split('=');
        objeto[""+valor[0]+""] = valor[1];
    });

    $('#'+idtabla).dataTable( {

        "destroy": true,
        "searching": false,
        "ordering": false,
        "lengthMenu": [ 81 ],
	 "dom": 'T<"clear">lfrtip',

         'processing': true,
         'paging': true,
         'serverSide': true,

	 "ajax": {
                   "type":"POST",
                   "dataType": "json",
                   "data": objeto ,
                   "url": datosJSON,
                   "complete" : function(xhr, status) {
                        /* CLONAR INFORMACION DE PAGINA SUPERIOR -> DERECHA*/
                        if($('#dt_clon_Info')){$('#dt_clon_Info').remove();}
                        $('#'+idtabla+'_length').append("<div class='dataTables_info' style='float:right'>"+$('#'+idtabla+'_info').html()+"</div>");
                    }
                 },

         "columns": columnas,

	 "tableTools": {
		 "sRowSelect": "multi",
		 "aButtons": [
			 {
				 "sExtends": "select_none",
				 "sButtonText": "Borrar selección"
			 }]
	 },
	 "pagingType": "full_numbers",
	 "language": {
		 "lengthMenu": "Mostrar _MENU_ registros por página.",
		 "zeroRecords": "No se encontró registro.",
		 "info": "  _START_ de _END_ (_TOTAL_ registros totales).",
		 "infoEmpty": "0 de 0 de 0 registros",
		 "infoFiltered": "(Encontrado de _MAX_ registros)",
		 "search": "Buscar: ",
		 "processing": "Procesando...",
                  "paginate": {
			 "first": "Primero",
			 "previous": "Anterior",
			 "next": "Siguiente",
			 "last": "Último"
		 }

	 }
 });
 }

   function paginar_tabla2(idtabla,datosJSON,columnas,parametros,funciones)
{
    var objeto = {};
    var datos = parametros.split('&');
    $.each( datos, function( key, value ) {
        var valor = value.split('=');
        objeto[""+valor[0]+""] = valor[1];
    });

    $('#'+idtabla).dataTable( {

        "destroy": true,
        "searching": false,
        "ordering": false,
        "lengthMenu": [ 100,200,500,1000 ],
	 "dom": 'T<"clear">lfrtip',

         'processing': true,
         'paging': true,
         'serverSide': true,

	 "ajax": {
                   "type":"POST",
                   "dataType": "json",
                   "data": objeto ,
                   "url": datosJSON,
                   "complete" : function(xhr, status) {
                        /* CLONAR INFORMACION DE PAGINA SUPERIOR -> DERECHA*/
                        if($('#dt_clon_Info')){$('#dt_clon_Info').remove();}
                        $('#'+idtabla+'_length').append("<div class='dataTables_info' style='float:right'>"+$('#'+idtabla+'_info').html()+"</div>");
                    }
                 },

         "columns": columnas,

	 "tableTools": {
		 "sRowSelect": "multi",
		 "aButtons": [
			 {
				 "sExtends": "select_none",
				 "sButtonText": "Borrar selección"
			 }]
	 },
	 "pagingType": "full_numbers",
	 "language": {
		 "lengthMenu": "Mostrar _MENU_ registros por página.",
		 "zeroRecords": "No se encontró registro.",
		 "info": "  _START_ de _END_ (_TOTAL_ registros totales).",
		 "infoEmpty": "0 de 0 de 0 registros",
		 "infoFiltered": "(Encontrado de _MAX_ registros)",
		 "search": "Buscar: ",
		 "processing": "Procesando...",
                  "paginate": {
			 "first": "Primero",
			 "previous": "Anterior",
			 "next": "Siguiente",
			 "last": "Último"
		 }

	 },
         "drawCallback": function() {
            if(funciones != null || funciones != ''){
                eval(funciones);
            }
        }
 });
 }

/*
    *   Comparar fechas:
    *   retorna true si fecha es mayor que fecha2
    *   y false cuando fecha2 es mayor que fecha
*/
/* siempre y cuando sea mayor o menor*/
function compare_dates(fecha, fecha2)
  {
    var xMonth=fecha.substring(3, 5);
    var xDay=fecha.substring(0, 2);
    var xYear=fecha.substring(6,10);
    var yMonth=fecha2.substring(3, 5);
    var yDay=fecha2.substring(0, 2);
    var yYear=fecha2.substring(6,10);
    if (xYear> yYear)
    {
        return(true)
    }
    else
    {
      if (xYear == yYear)
      {
        if (xMonth> yMonth)
        {
            return(true)
        }
        else
        {
          if (xMonth == yMonth)
          {
            if (xDay> yDay)
              return(true);
            else
              return(false);
          }
          else
            return(false);
        }
      }
      else
        return(false);
    }
}

/* siempre y cuando sea mayor */
function compare_dates_mayor(fecha, fecha2)
  {
    var xMonth=fecha.substring(3, 5);
    var xDay=fecha.substring(0, 2);
    var xYear=fecha.substring(6,10);
    var yMonth=fecha2.substring(3, 5);
    var yDay=fecha2.substring(0, 2);
    var yYear=fecha2.substring(6,10);
    if (xYear> yYear)  {
        return(true)
    }   else  {
      if (xYear == yYear)  {
        if (xMonth> yMonth)  {
            return(true)
        }   else   {
          if (xMonth == yMonth)   {
            if (xDay > yDay)
              return(true);
            else{
                if (xDay == yDay)
                    return(true);
                else
                    return(false);
            }
          }
          else
            return(false);
        }
      }
      else
        return(false);
    }
}
// Función que valida la extensión del archivo a cargar
function verifica_extension(archivo, array_extensiones)
{
    var extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase();
    var permitida = false;
    for (var i = 0; i < array_extensiones.length; i++)
    {
        if (array_extensiones[i] == extension)
        {
            permitida = true;
            break;
        }
    }

    return permitida;
}

// Función para calcular los días transcurridos entre dos fechas
restaFechas = function(f1,f2)
 {
 var aFecha1 = f1.split('/');
 var aFecha2 = f2.split('/');
 var fFecha1 = Date.UTC(aFecha1[2],aFecha1[1]-1,aFecha1[0]);
 var fFecha2 = Date.UTC(aFecha2[2],aFecha2[1]-1,aFecha2[0]);
 var dif = fFecha2 - fFecha1;
 var dias = Math.floor(dif / (1000 * 60 * 60 * 24));
 return dias;
 }



 /*
 * La fucion comboDynamic requiere de los siguientes parametros
 * obj1 nombre del combo padre
 * obj2 nombre del combo hijo
 * urldoc ruta del archivo php que obtine los datos
 * title leyenda que se posicionara en el primer option del combo hijo
 */
function comboDynamic(obj1,obj2,urldoc,task,title){

    if ($('#'+obj1+'').val().trim() != ""){
        if (title == null || title == ''){
            $('#'+obj2+'').html("<option value=''>[Seleccione una opci&oacute;n]</option>");
        } else {
            $('#'+obj2+'').html("<option value=''>["+title+"]</option>");
        }
        $.ajax({
          type: "POST",
          url: urldoc,
          async: false,
          dataType: "json",
          data: "posicion="+task+"&id_padreP="+$('#'+obj1+'').val(),
          success: function(data){
            $(data).each(function(i, v){
                $("#"+obj2+"").append('<option value="'+v.id+'">'+v.descripcion+'</option>');
            });
          },
          error: function(jqXHR, textStatus, errorThrown){
                alert("Error al ejecutar =&gt; " + textStatus + " - " + errorThrown);
          }
        });
    } else {
        if (title == null || title == '') {
                $('#'+obj2+'').html("<option value=''>[Seleccione una opci&oacute;n]</option>");
        } else {
                $('#'+obj2+'').html("<option value=''>["+title+"]</option>");
        }
    }
}



//funcion para validar los decimales y agregar de manera automatica los decimales faltantes en 0

function validardecimales(events, valor, medicion){

	range = /^\d{1,2}(\.\d{1,2})?$/;

  if(medicion=='Porcentaje')
   {
	  hundred = /^100$/;
	  hundred2 = /^100.00$/;

      var stringNumber="";
	  var numero = events.value;
	  var busq = numero.indexOf(".");

      if (numero!="")
       {

		  if(!(range.test(events.value) || hundred.test(events.value) || hundred2.test(events.value)))
		  {

		     events.value='';
		     return  Modal(valor,'Validación de datos','El porcentaje no esta en el rango de 0 a 100.00 o está ingresando más de dos decimales', 'danger');
    	  }
		  else
		  {

						  if (busq==-1)
						    {
						       events.value =  numero + ".00";

						   	}else{


						      var numeroArray = numero.split(".");
							  var decimals = (numeroArray[1].length != undefined)?numeroArray[1].length:0;


							   if (decimals==1)
							   {
							   	 events.value =  numero + "0";
							   }
							   else if (decimals==2)
							   {
							   	 events.value =  numero;
							    }
							   	return true;
			 		 		 }

     	  }//end else

      }else{
	       events.value ="";
	       return false;
	       }


 	}//end del if medicion
    else{

 			  var stringNumber="";
			  var numero = events.value;
			  var busq = numero.indexOf(".");

              if (numero!="")
              {
				  if (busq==-1)
				    {
				       events.value =  numero + ".00";

				   	}else{


				      var numeroArray = numero.split(".");
					  var decimals = (numeroArray[1].length != undefined)?numeroArray[1].length:0;

					   if (decimals==1)
					   {
					   	 events.value =  numero + "0";
					   }
					   else if (decimals==2)
					   {
					   	 events.value =  numero;
					   }

					   	return true;
					}//end else  if (busq==-1)

			  }else{

			  	  events.value ="";
			  	  return false;
			  }

    }//end del else medicion

}//end dela funcion

//Funcion para obtener elemento y obtener el href que servirá en la  function rutaarchivo($ruta_carpeta=null, $archivo=null) ubicada en el archivo global.php

function obt_ruta(elem)
{
   var ruta= $(elem).data('route-file');
   window.location.href = ruta;
}

/*
 * Creado:	Ing. Ruben Huchin
 * Fecha:	18/Febrero/2019
 * Desc:	Función creada para obtener la ruta de descarga del archivo y abrir un una nueva
 *			ventana con lo cual se evitaría el detalle cuando se intenta descargar una imagen.
*/
function download_file(obj) {
	var route	= $(obj).data('route-file');
	window.open(route, '_blank');
}

/*
* Obtiene el texto del campo para poder convertirlo
* a Upper Case.
* Uso: onkeyup="return convertUpper(this);"
*/
function convertUpper(elem) {
	let str = $(elem).val();
	let n_str = str.toUpperCase();
	return $(elem).val(n_str);
}

/*
* Valida que el texto escrito en el campo sea un
*  caracter fecha.
* Uso: onkeypress="return getKeyDate(event);"
*/
function getKeyDate( events ) {
	var key = (window.event ) ? events.keyCode:events.which;
	if ( ( key >= 47 && key <= 57 ) || key == 8 || key == 0 || (key == 37) ) {
		return true;
	} else {
		return false;
	}
}

/*
* Valida que el texto escrito en el campo sea un
*  caracter hora.
* Uso: onkeypress="return getKeyHour(event);"
*/
function getKeyHour( events ) {
	var key = (window.event ) ? events.keyCode:events.which;
	if ( ( key >= 48 && key <= 57 ) || key == 8 || key == 0 || (key == 58) ) {
		return true;
	} else {
		return false;
	}
}

/*
* Valida que el texto escrito en el campo sea un
*  caracter de solo texto con espacios
* Uso: onkeypress="return validar(event);"
*/
function validar(e) { // 1
	tecla = (document.all) ? e.keyCode : e.which; // 2
	if (tecla==8) return true; // 3
	patron =/[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9.,\s]+/; // 4
	te = String.fromCharCode(tecla); // 5
	return patron.test(te); // 6
}


/****************************************************************************/
/*DECLARACIÓN DE VARIABLES GLOBALES*/
let flag_action = false,
obj_changes	= {
	evaluador_checked: [],
	evaluador_inchecked: [],
	contador: 0,
	evaluados_checked: [], 
	evaluados_inchecked: [], 
	contadorE: 0 
};

/****************************************************************************/
/*
 *	Desc:	Función creada para realizar petición post.
*/
function ajaxPost(urlRequest, parametros, success) {
	$.post(urlRequest, parametros, function(data, request, settings) {
		success(data);
	}, 'json')
	.fail(function(result, typeError, errorMessage) {
		success(errorMessage);
	});
}