function mensaje(opcion,msj)
{
	switch(opcion)
	{
		case "1": 
			$("#mBoxAlertTitle").html('Operacion realizada con exito <i class="glyphicon glyphicon-ok-circle"></i>');
			$("#mBoxAlertBody").html(msj);
		break;
		case "2": 
			$("#mBoxAlertTitle").html('Operacion realizada con errores <i class="glyphicon glyphicon-remove-circle"></i>');
			$("#mBoxAlertBody").html(msj);
		break;
		case "3":
			$("#mBoxAlertTitle").html('Al parecer ocurrio algo fuera de lo esperado <i class="glyphicon glyphicon-warning-sign"></i>');
			$("#mBoxAlertBody").html(msj);
		break;
	}
	$("#mBoxAlert").modal('show');
}
function sendRequest(type,url,async,data,funcion)
{
	$.ajax({
		type: type,
		url: url,
		async: async,
		data: data,
		success: funcion
	});
}
function paginar(nopagina,servicio)
{
	sendRequest('POST','lib/consultas/servicio.php',true,'servicio='+servicio+'&page='+nopagina,function(data){
		$("#mBoxContainer").html(data);
	});
	//$("#mboxBusqueda").modal("show");
}
function filtrar(texto,servicio)
{
	sendRequest('POST','lib/consultas/servicio.php',true,'servicio='+servicio+'&filtrar=true&texto='+texto,innerResultadoBusqueda);
	//$("#mboxBusqueda").modal("show");	
}
function resaltar(objeto)
{
	$(objeto).addClass("active").siblings().removeClass("active");
}
function innerHTML(objeto,data)
{
	$(objeto).html(data);
}
$("input[data-type='numeric']").keyup(function(){
	if(isNaN($(this).val()))
	{
		$(this).focus().val('').parent().append('<span class="glyphicon glyphicon-remove form-control-feedback"></span><span class="help-block">Error, Solo se admiten Numeros</span>').parent().addClass("has-error has-feedback").delay(1500).queue(function(next){
			$(this).removeClass("has-error");
			$('.form-control-feedback').remove();
			$('.help-block').remove();
			next();
		});
	}
	else
	{
		$(this).parent().append('<span class="glyphicon glyphicon-ok form-control-feedback"></span>').parent().removeClass("has-error has-feedback").addClass("has-success has-feedback").delay(1500).queue(function(next){
			$(this).removeClass("has-success has-feedback");
			$('.form-control-feedback').remove();
			next();
		});
	}
});
$("input[data-length]").blur(function(){
	if($(this).val().length != $(this).attr('data-length'))
	{
		$(this).focus().parent().append('<span class="glyphicon glyphicon-remove form-control-feedback"></span><span class="help-block">Error, El tama&ntilde;o permitido para este campo es de '+$(this).attr('data-length')+' Caracteres</span>').parent().addClass("has-error has-feedback").delay(1500).queue(function(next){
			$(this).removeClass("has-error");
			$('.form-control-feedback').remove();
			$('.help-block').remove();
			next();
		});
	}
});
$("body").delegate("input[data-type='date']","focus",function(){
    //alert('test')
    $("input[data-type='date']").datepicker({format: 'yyyy-mm-dd'});    
});
function mostrarPrestacion(objeto){
	var id = $(objeto).attr('data-id');
	sendRequest("POST","lib/consultas/servicio.php",true,"servicio=14&id="+id,function(data){
		$("#"+id).siblings().html('');
		$("#"+id).html('').html(data);

	});
}
$("body").delegate("a[data-selector]",'click',function(){
	$(this).parent().parent().parent().removeClass('panel-default').addClass('panel-primary').siblings().removeClass('panel-primary').addClass('panel-default');
	
});
$('#mBox').on('hidden.bs.modal', function (e) {
  $("#mBoxContainer").html('');
  $("#mBoxHeader").html('');
});
$(document).mouseup(function (e)
{
	var container = $("#popBusqueda");
	
	if (!container.is(e.target) // if the target of the click isn't the container...
	&& container.has(e.target).length === 0) // ... nor a descendant of the container
	{
		inicializarPopOver();
		$("#txtBuscar").val('');	
	}
});
$("#popBusqueda").popover();
$("#txtBuscar").keyup(function () {
	if ($(this).val().length >= 4) {
		sendRequest("POST","lib/consultas/servicio.php",true,"servicio=11&accion=4&value="+$(this).val()+"&campo="+$("#cmbBarraBusqueda.dropdown-menu > li.active").attr('data-campoBusqueda'),function(data){
		var position = $("#txtBuscar").offset();
		var top = position.top;
		var left = position.left;
		var estilo= {
			top: top-30,
			left: left-400
		};
	$("#popBusqueda").css(estilo).fadeIn(300);
	$("#divRSBusqueda").html(data);
	});
		
	} else{
		inicializarPopOver();
	};
}).blur(function () {
	$(this).val('');
});
function inicializarPopOver () {
	$("#popBusqueda").fadeOut(300);
	$("#divRSBusqueda").html('');
}