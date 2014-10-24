var accion ="update";
$(document).ready(function(){
    $(".nav.nav-tabs > li.active").click();
    sendRequest("POST","lib/consultas/servicio.php",true,"servicio=26&campos=idpresentacion as id,descripcion&tabla=presentacion",function(data) {
        $("#cmbPresentacion").html(data);
    });
    sendRequest("POST","lib/consultas/servicio.php",true,"servicio=26&campos=idtipoentrevista as id,descripcion&tabla=tipoentrevista",function(data) {
        $("#cmbTipoEntrevista").html(data);
        sendRequest("POST","lib/consultas/servicio.php",true,"servicio=26&campos=id,descripcion&tabla=viewtipoentrevistadimension&campowhere=idtipoentrevista&valorwhere=1",function(data) {
            $("#cmbDimension").html(data);
        });
    });
    sendRequest("POST","lib/consultas/servicio.php",true,"servicio=26&campos=idresultado as id,resultado as descripcion&tabla=resultado",function(data) {
        $("#cmbResultado").html(data);
    });
});
$("body").delegate("tr > td > .btn-group > button","click",function(){
	var servicio="";
	var titleMBox ="";
	var tabla="";
	var objeto = $(this);
	if ($(this).attr('data-accion') == "update") {
		accion = "update";
		switch($(this).attr('data-table'))
		 {
		 	case  "antecedentelaboralcandidato":
		 		titleMBox = "Antecedente Laboral";
		 		servicio = "15";
		 		tabla = "antecedentelaboral";
		 	break;
		 	case "areainterescandidato":
		 		titleMBox = "Areas de Interes";
		 		servicio = "16";
		 		tabla = "candidatoareainteres";
		 	break;
		 	case "conocimientocandidato":
		 		titleMBox ="Conocimiento";
		 		servicio ="21";
		 		tabla = "candidatoconocimiento";
		 	break;
		 	case 'cursocandidato':
		 		titleMBox = "Cursos";
		 		servicio = "23";
		 		tabla = "candidatocurso";
		 	break;
            case 'entrevistacandidato':
                 titleMBox = "Entrevista";
                 servicio = "25";
                 tabla = "entrevista";
		 }
		sendRequest("POST","lib/consultas/servicio.php",true,"servicio="+servicio+"&tabla="+tabla+"&campo="+$(this).attr('data-campo')+"&id="+$(this).attr("data-id"),function(data){
		        	$("#mBoxHeader").html(titleMBox);
		        	$("#mBoxContainer").html(data);
		        	$("#mBox").modal('show');
		        	switch(tabla)
					 {
					 	case  "antecedentelaboral":
					 		$('#txtFechaInicio').datepicker({format: 'yyyy-mm-dd'});
					 		$('#txtFechaFin').datepicker({format: 'yyyy-mm-dd'});
					 	break;
					 	case "entrevistacandidato":
					 	     $('#txtFecha').datepicker({format: 'yyyy-mm-dd'});
				        break;
					 }
		        });
	} else if ($(this).attr('data-accion') == "delete"){
		switch($(this).attr('data-table'))
		 {
		 	case  "antecedentelaboralcandidato":
		 		servicio = "18";
		 		tabla = "antecedentelaboral";
		 	break;
		 	case "areainterescandidato":
		 		servicio = "20";
		 		tabla = "candidatoareainteres";
		 	break;
		 	case "conocimientocandidato" :
		 		servicio = "22";
		 		tabla = "candidatoconocimiento";
		 	break;
            case "cursocandidato":
                servicio = "24";
            break;     
		 }
		sendRequest("POST","lib/consultas/servicio.php",true,"servicio="+servicio+"&tabla="+tabla+"&accion=delete&id="+$(this).attr("data-id"),function(data){
			var response = $.parseJSON(data);
			mensaje(response.codigo,response.mensaje);
			$(".nav.nav-tabs > li.active").click();					
		}); 
	}
	else
	{
		accion = "insert";
		switch(objeto.attr('data-table'))
		 {
		 	case  "antecedentelaboralcandidato":
		 		titleMBox = "Antecedente Laboral";
		 		servicio = "15";
		 		tabla = "antecedentelaboral";
		 	break;
		 	case "areainterescandidato":
		 		titleMBox = "Areas de Interes";
		 		servicio = "16";
		 		tabla = "candidatoareainteres";
		 	break;
		 	case "conocimientocandidato" :
		 		titleMBox = "Conocimientos";
		 		servicio  = "21";
		 		tabla = "candidatoconocimiento";	
		 	break;
            case "cursocandidato" :
                 titleMBox = "Cursos";
		 		servicio = "23";
                 tabla = "candidatocurso";
            break;     
		 }
		sendRequest("POST","lib/consultas/servicio.php",true,"servicio="+servicio+"&tabla="+tabla,function(data){
		        	$("#mBoxHeader").html(titleMBox);
		        	$("#mBoxContainer").html(data);
		        	$("#mBox").modal('show');
		        	switch(tabla)
					 {
					 	case  "antecedentelaboral":
					 		$('#txtFechaInicio').datepicker({format: 'yyyy-mm-dd'});
					 		$('#txtFechaFin').datepicker({format: 'yyyy-mm-dd'});
					 	break;
					 	case "candidatoareainteres":
					 		
					 	break;
					 }
		        });
	}
	/**/
});
$("body").delegate("#btnGuardarModal","click",function(){
	var servicio =0;
	var tabla = $('.nav.nav-tabs > li.active').children().attr("href").replace("#","");
	switch(tabla)
		 {
		 	case  "antecedentelaboralcandidato":
		 		servicio = "17";
		 		tabla = "antecedentelaboral";
		 	break;
		 	case "areainterescandidato":
		 		servicio = "19";
		 		tabla = "candidatoareainteres";
		 	break;
		 	case "conocimientocandidato":
		 		servicio = "22";
		 		tabla = "candidatoconocimiento";
		 	break;
            case "cursocandidato" :
                 servicio = "24";
                 tabla = "candidatocurso"
            break;     
		 }
		 sendRequest("POST","lib/consultas/servicio.php",true,"servicio="+servicio+"&tabla="+tabla+"&"+$("#frm"+tabla).serialize()+"&accion="+accion,function(data){
		        	var response = $.parseJSON(data);
					mensaje(response.codigo,response.mensaje);
					if(response.codigo == "1")
					{
						$(".nav.nav-tabs > li.active").click();
						$("#mBox").modal('hide');
	 					accion = "update";
					}
		        });
});
$(".nav.nav-tabs > li").click(function(){
	var tabla = $(this).children().attr("href").replace("#","");
	var campos="";
	switch(tabla)
		 {
		 	case  "antecedentelaboralcandidato":
		 		campos = "idantecedentelaboral, \"Fecha de Inicio\",\"Fecha de Termino\",\"Empresa\",\"Puesto\",\"Personas a Cargo\",\"Sueldo\",\"Jefe\",\"Numero de Contacto\",\"Motivo de Separacion\"";	
		 	break;
		 	case "areainterescandidato":
		 		campos = "idareainteres, \"Area de Interes\"";	
		 	break;
		 	case "conocimientocandidato":
		 		campos = "idcandidatoconocimiento,descripcion";	
		 	break;
		 	case "cursocandidato":
		 		campos = "idcandidatocurso,\"Curso\"";
		 	break;
            case "entrevistacandidato":
                 $('#txtFecha').datepicker({format: 'yyyy-mm-dd'});				        
                 return;
            break;     
		 }
	sendRequest("POST","lib/consultas/servicio.php",true,"servicio=14&campos="+campos+"&idcandidato=1&tabla="+tabla,function(data){
		        	$("#"+tabla).html(data).addClass('active').siblings().removeClass('active');
		        });
});
$("#btnGuardarEntrevista").click(function() {
    sendRequest("POST","lib/consultas/servicio.php",true,"servicio=27&"+$("form").serialize(),function(data){
       var response = $.parseJSON(data);
       if(response.codigo == "1")
       {
           $("#mBoxHeader").text('Habilidades');
           sendRequest("POST","lib/consultas/servicio.php",true,"servicio=28&identrevista="+response.id,function(data){
              $("#mBoxContainer").html(data);
              $("#mBox").modal('show');
           });
       }
    });
});
/*    $('body').onunload=function(e)
    {
        "use strict";
        e.preventDefault();
    if(!(confirm("Realmente deseas salir?")))   
    {
       return ;
    }
    }*/