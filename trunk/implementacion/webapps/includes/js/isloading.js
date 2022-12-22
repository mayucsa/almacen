function jsRemoveWindowLoad() {
	// eliminamos el div que bloquea pantalla
	$("#WindowLoad").remove();
}
function jsShowWindowLoad(mensaje){
	jsRemoveWindowLoad();
	//si no enviamos mensaje se pondra este por defecto
	if (mensaje === undefined) mensaje = "Cargando";
	height = 20;
	var ancho = 0;
	var alto = 0;
	//obtenemos el ancho y alto de la ventana de nuestro navegador, compatible con todos los navegadores
	if (window.innerWidth == undefined) ancho = window.screen.width;
	else ancho = window.innerWidth;
	if (window.innerHeight == undefined) alto = window.screen.height;
	else alto = window.innerHeight;
	//operación necesaria para centrar el div que muestra el mensaje
	var heightdivsito = alto/2 - parseInt(height)/2;
	imgCentro = "<div style='text-align:center;height:" 
	+ alto + "px;'><div  style='color:#000;margin-top:" 
	+ heightdivsito + "px; font-size:20px;font-weight:bold'>" 
	+ mensaje + "</div><img src='../../../includes/css/loading.gif' style='width:5vH;'></div>";
	div = document.createElement("div");
	div.id = "WindowLoad"
	div.style.width = ancho + "px";
	div.style.height = alto + "px";
	$("body").append(div);
	input = document.createElement("input");
	input.id = "focusInput";
	input.type = "text"
	//asignamos el div que bloquea
	$("#WindowLoad").append(input);
	//asignamos el foco y ocultamos el input text
	$("#focusInput").focus();
	$("#focusInput").hide();

	//centramos el div del texto
	$("#WindowLoad").html(imgCentro);
}