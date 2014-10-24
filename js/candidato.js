$(document).ready(function(){
	$("#candidato").addClass("active").siblings().removeClass("active");	
    sendRequest("POST","lib/consultas/servicio.php",true,"servicio=9&tabla=informacioncandidato",function(data){
		        	$("#cmbBarraBusqueda").html(data);
		        });
	sendRequest("POST","lib/consultas/servicio.php",true,"servicio=12&tabla=estadocivil",function(data){
		        	$("#cmbEstadoCivil").html(data);
		        });
	});
	$("#txtCodigoPostal").blur(function(){
		sendRequest("POST","lib/consultas/servicio.php",true,"servicio=10&codigopostal="+$("#txtCodigoPostal").val(),function(data){
		        	$("#cmbColonia").html(data);
		        });
	});
$("#btnGuardar").click(function(){
	sendRequest("POST","lib/consultas/servicio.php",true,"servicio=11&"+ $("form").serialize(),function(data){
		var response = $.parseJSON(data);
		mensaje(response.codigo,response.mensaje);
		if (response.fecha !== undefined) {
			$("#fechaActualizacionCandidato").html(response.fecha);			
		};
		inicializarFrm();
	});
});	
function inicializarFrm () {
	$("fieldset").attr('disabled',true);
	$("input[type='hidden']").val('0');
	$("form").resetForm();
	$("#cmbColonia").html('');
	$("#btnAgregar").removeClass("btn-primary").siblings().removeClass("btn-primary");
	$("#clasificacionCandidato").html('');
	$("#fechaAltaCandidato").html('');
	$("#fechaActualizacionCandidato").html('');
}
$("#txtPeso").blur(function(){
	if($(this).val()!="" && $("#txtEstatura").val()!="")
	{
		calcularIndiceMasaCorporal($(this).val(), $("#txtEstatura").val());
	}
})	;
function calcularIndiceMasaCorporal (peso,estatura) {
	 var imc = Math.floor(peso / (estatura*estatura));
                if (imc < 18)
                {
                    $("#pIndiceMasaCorporal").val("Peso Bajo");
                }
                else if (imc >= 18 && imc < 25)
                {
                    $("#pIndiceMasaCorporal").val("Normal");
                }
                else if (imc >= 25 && imc < 27)
                {
                    $("#pIndiceMasaCorporal").val("Sobrepeso");
                }
                else
                {
                    $("#pIndiceMasaCorporal").val("Obesidad");
                }
}
$("body").delegate("table.table.table-condensed.table-hover.table-bordered.table-striped > tbody > tr","click",function(){
	informacioncandidato($(this).attr('data-idcandidato'));
	inicializarPopOver();
});
function modificar () {
	if($("#idCandidato").val()== 0)
	{
		mensaje("2","Error, primero se debe seleccionar un candidato");
		$("#txtBuscar").focus();
		return;
	}
	$("fieldset").attr('disabled',false);
		$("#accion").attr('value','2');
}
function eliminar () {
	if($("#idCandidato").val()== 0)
	{
		mensaje("2","Error, primero se debe seleccionar un candidato");
		$("#txtBuscar").focus();
		return;
	}
	$("#accion").val('4');
		sendRequest("POST","lib/consultas/servicio.php",true,"servicio="+$(".nav.nav-sidebar >li.active").attr('data-service')+"&status=0&accion=3&idcandidato="+$("#idCandidato").val(),function(data){
		        	var response = $.parseJSON(data);
		        	mensaje(response.codigo,response.mensaje);
		        	$("#btnReactivar").fadeIn(10,function(){$("#btnEliminar").removeClass('btn-primary').fadeOut(10)});
		        	$("#fechaActualizacionCandidato").html(response.fecha);
		        });
}
function reactivar () {
	$("#accion").val('4');
		sendRequest("POST","lib/consultas/servicio.php",true,"servicio="+$(".nav.nav-sidebar >li.active").attr('data-service')+"&status=1&accion=3&idcandidato="+$("#idCandidato").val(),function(data){
		        	var response = $.parseJSON(data);
		        	mensaje(response.codigo,response.mensaje);
		        	$("#btnReactivar").removeClass('btn-primary').fadeOut(10,function(){$("#btnEliminar").fadeIn(10)});
		        	$("#fechaActualizacionCandidato").html(response.fecha);
		        });
}
function informacioncandidato (idcandidato) {
	sendRequest("POST","lib/consultas/servicio.php",true,"servicio=11&accion=5&idcandidato="+idcandidato,function(data){
		        	var candidato = $.parseJSON(data);
		        	candidato = candidato[0];
		        	$("#idCandidato").val(candidato.idcandidato);
		        	$("#txtNombre").val(candidato.nombre);
		        	$("#txtApellidoPaterno").val(candidato.apellidopaterno);
		        	$("#txtApellidoMaterno").val(candidato.apellidomaterno);
		        	$("#txtDireccion").val(candidato.direccion);
		        	$("#txtCodigoPostal").val(candidato.codigopostal);
		        	$("#cmbColonia").html('<option value="'+candidato.idcolonia+'">'+candidato.colonia+'</option>');
		        	$("#txtLugarProcedencia").val(candidato.lugarprocedencia);
		        	$("#txtTelefono").val(candidato.telefono);
		        	$("#txtCelular").val(candidato.celular);
		        	$("#txtEmail").val(candidato.email);
		        	$("#txtEstatura").val(candidato.estatura);
		        	$("#txtPeso").val(candidato.peso).blur();
		        	$("#txtRfc").val(candidato.rfc);
		        	$("#txtCurp").val(candidato.curp);
		        	$("#txtNoSeguridadSocial").val(candidato.noseguridadsocial);
		        	$("#txtCartillaMilitar").val(candidato.nocartillamilitar);
		        	$("#cmbEstadoCivil").val(candidato.cveestadocivil);
		        	$("#cmbSexo").val(candidato.sexo);
		        	$("#chkDisponibilidadViajar").attr("checked",candidato.disponibilidadviajar=='1'?true:false);
		        	$("#chkDisponibilidadTurnos").attr("checked",candidato.disponibilidadturnos=='1'?true:false);
		        	$("#chkDisponibilidadMudanza").attr("checked",candidato.disponibilidadmudanza=='1'?true:false);
		        	$("#txtFechaNacimiento").val(candidato.fechanacimiento);
		        	$("#txtLugarNacimiento").val(candidato.lugarnacimiento);
		        	$("#clasificacionCandidato").html(candidato.clave);
		        	$("#fechaAltaCandidato").html(candidato.fechaalta);
		        	$("#fechaActualizacionCandidato").html(candidato.fechaactualizacion);
		        	candidato.status == '0'? $("#btnReactivar").fadeIn(10,function(){$("#btnEliminar").fadeOut(10)}):$("#btnReactivar").fadeOut(10,function(){$("#btnEliminar").fadeIn(10)});

		        });
}