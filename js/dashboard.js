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
/**clic en los botones de insertar,modificar y eliminar de las tablas */
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
            break;
            case 'entrevistadimension':
                titleMBox = "Editar Dimension";
                 sendRequest("POST","lib/consultas/servicio.php",true,"servicio=28&identrevista="+$("#idEntrevista").val(),function(data){
              $("#mBoxContainer").html(data);
              $("#mBox").modal('show');
           });
            return;     
            break;
            case 'estudiocandidato':
                    titleMBox = "Editar Estudios del Candidato";
                    $("#mBoxHeader").html(titleMBox);
		        	sendRequest("POST","estudio.php",true,"idestudio="+$(this).attr("data-id"),function(data){
                        $("#mBoxContainer").html(data);
                        var script = document.createElement('script');
                        script.type = 'text/javascript';
                         script.src = "js/estudio.js";
                         script.id = "scrEstudio";
                        $("body").append(script); 
                    });
		        	$("#mBox").modal('show');
                    return;
            break;
            case 'estudiosocioecfamiliarcandidato':
                titleMBox = "Editar Estudio Socio Economico Familiar";
                 $("#mBoxHeader").html(titleMBox);
                 sendRequest("POST","estudiosocioecfamiliar.php",true,"idestudiosocioecfamiliar="+$(this).attr('data-id'),function(data){
                    $("#mBoxContainer").html(data);
                 });
                 $("#mBox").modal('show');
                 return;
            break;     
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
            case 'entrevistadimension':
                 mensaje("2","No puedes eliminar las dimensiones");
            return;
            break; 
            case 'estudiocandidato':
                    servicio = '34';
            break;
            case 'estudiosocioecfamiliarcandidato':
                servicio = '41';     
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
            case 'entrevistadimension':
                 mensaje("2","No puedes agregar las dimensiones");
            return;
            break; 
            case 'estudiocandidato':
                 titleMBox = "Estudios del Candidato";
                    $("#mBoxHeader").html(titleMBox);
		        	sendRequest("POST","estudio.php",true,"",function(data){
                        $("#mBoxContainer").html(data);
                        var script = document.createElement('script');
                        script.type = 'text/javascript';
                         script.src = "js/estudio.js";
                         script.id = "scrEstudio";
                        $("body").append(script);  
                    });
		        	$("#mBox").modal('show');
                    return;
            break;
            case 'estudiosocioecfamiliarcandidato':
                 titleMBox = "Estudio Socio Economico Familiar del Candidato";
                 $("#mBoxHeader").html(titleMBox);
                 sendRequest("POST","estudiosocioecfamiliar.php",true,"",function(data){
                    $("#mBoxContainer").html(data);
                 });
                 $("#mBox").modal('show');
                 return;
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
/*boton guardar*/
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
            case "estudiocandidato":
                 servicio = "34";
                 tabla = "estudio";
            break;
            case "estudiosocioecfamiliarcandidato":
                 servicio = "41";
                 tabla = "estudiosocioecfamiliar";
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
/* *clic a las tabs* */
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
                 traerEntrevista();
                 return;
            break;
            case 'estudiocandidato':
                  campos= 'idestudio,"Fecha Inicio","Fecha Fin","Carrera","Institucion",grado,"Ciclo Escolar","Titulo","Cedula Profesional",promedio';
            break;
            case 'estudiosocioecfamiliarcandidato':
                 campos = 'idestudiosocioecfamiliar,fecha, "Estructura Familiar","Organizacion Familiar","Salud","Alimentacion","Situacion Economica","Vivienda","Religion","Observaciones","Resultado","Entrevistado por"';
            break;
            case 'procesopracticascandidato':
                sendRequest("POST","lib/consultas/servicio.php",true,"servicio=42",function(data){
                    if(data != "0")
                    {
                        var response = $.parseJSON(data);
                    $("#spFechaAsignacionPractica").html(response[0].fechaasignacion);
                    $("#spNumeroAsignacionPractica").html(response[0].numeroasignacion);
                    $("#spDepartamentoAsignacionPractica").html(response[0].descripcion);
                    $("#spEncargadoAsignacionPractica").html(response[0].nombre);
                    $("#spFechaInicioAsignacionPractica").html(response[0].fechainicio);
                    $("#spFechaTerminoAsignacionPractica").html(response[0].fechafin);
                    $("#spFechaVencimientoSeguro").html(response[0].fechaterminopoliza);
                    }
                }); 
                return;
            break;
		 }
	sendRequest("POST","lib/consultas/servicio.php",true,"servicio=14&campos="+campos+"&idcandidato=1&tabla="+tabla,function(data){
		        	$("#"+tabla).html(data).addClass('active').siblings().removeClass('active');
		        });
});
//Entrevista candidato, guardar,modificar y cancelar entrevista y dimensiones
$("#btnGuardarEntrevista").click(function() {
    sendRequest("POST","lib/consultas/servicio.php",false,"servicio=27&"+$("form").serialize()+"&accion="+$(this).attr("data-accion"),function(data){
       var response = $.parseJSON(data);
       if(response.codigo == "1" && $('#btnGuardarEntrevista').attr("data-accion") == 'insert')
       {
           $("#mBoxHeader").text('Habilidades');
           sendRequest("POST","lib/consultas/servicio.php",true,"servicio=28&identrevista="+response.id,function(data){
               $("#idEntrevista").val(response.id);
              $("#mBoxContainer").html(data);
              $("#mBox").modal('show');
           });
       }
       else if(response.codigo == '1' && $('#btnGuardarEntrevista').attr("data-accion") == 'update')
       {
           mensaje(response.codigo,response.mensaje);
           $("fieldset").attr("disabled",true);
       }
    });
    $(this).attr("data-accion","insert");
});
$("body").delegate("#btnAgregarDimensionEntrevista","click",function(){
    sendRequest("POST","lib/consultas/servicio.php",true,"servicio=29&"+$("#frmEntrevistaDimension").serialize(),function(data){
        var request = $.parseJSON(data);
        if(request.codigo == "1")
        {
            
            $("#cmbDimension").val($("#cmbDimension option:selected").next().val());
            sendRequest("POST","lib/consultas/servicio.php",true,"servicio=30&identrevista="+$("#identrevista").val(),function(data){
               $("#entrevistaContainer").html(data); 
                sendRequest("POST","lib/consultas/servicio.php",true,"servicio=32&identrevista="+$("#identrevista").val(),function(data){
                        $("#divDimension").html(data); 
                     });
            });
        }
    });
    //cambiar valor
    if($("#cmbDimension option:selected").val() == $("#cmbDimension option:last-child").val())
            {
                mensaje("1","Se han guardado todas las habilidades al candidato");
                $("#btnCerrarModal").click();
                $("#frmEntrevista > fieldset").attr("disabled",true);
                return;
            }
});
$("#btnModificarEntrevista").click(function(){
    $("fieldset").attr("disabled",false);
    $("#btnGuardarEntrevista").attr("data-accion","update");
});
$("#btnCancelarEntrevista").click(function(e){
    $("frmEntrevista").resetForm();
    $("fieldset").attr("disabled",false);
    traerEntrevista();
    
});
$("#btnSubirBolsaPractica").click(function(){
    sendRequest("POST","lib/consultas/servicio.php",true,"servicio=43&accion=subirbp",function(data){
        if(data == "1")
        {
            $("#divClasificacionCandidato").html("BP");
            mensaje(response.codigo,response.mensaje);//falta terminar esta parte para que el servicio aun no creado by the way retorne 1 o 0 y el msj
        }
    });
});
function traerEntrevista()
{
    sendRequest("POST","lib/consultas/servicio.php",false,"servicio=31",function(data){
                    if( data == "0")
                    {
                        $("#frmEntrevista > fieldset").attr("disabled",false);   
                    }
                     else{
                     $("#frmEntrevista > fieldset").attr("disabled",true);  
                     var request = ($.parseJSON(data))[0]; 
                     $("#idEntrevista").val(request.identrevista);
                     $("#txtFecha").val(request.fecha);
                     $("#cmbPresentacion").val(request.idpresentacion);
                     $("#txtLogros").val(request.logros);
                     $("#txtObservaciones").val(request.observaciones);
                     $("#cmbTipoEntrevista").val(request.idtipoentrevista);
                     sendRequest("POST","lib/consultas/servicio.php",true,"servicio=32&identrevista="+request.identrevista,function(data){
                        $("#divDimension").html(data); 
                     });
                     }
                 });
}