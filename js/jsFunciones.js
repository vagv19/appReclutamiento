$(".navbar-form >  .btn-group > button.btn.btn-default").click(function() {
	$(this).addClass("btn-primary").siblings().removeClass("btn-primary");
	if ($(this).attr('data-accion') === 'insert') {
		$("fieldset").attr('disabled', false);
		$("form").resetForm();
		$("#accion").attr('value', '1');
	} else if ($(this).attr('data-accion') === 'update') {
		modificar();
	} else if ($(this).attr('data-accion')=='delete') {
		eliminar ();
	} else{
		reactivar();
	};
});
$("ul.dropdown-menu > li > a").click(function() {
	$(this).parent().addClass('active').siblings().removeClass('active');
});
$("#btnAgendarCita").click(function() {

});
$("#btnCancelar").click(function() {
	inicializarFrm();
		
});
$("body").delegate("#btnBuscarCandidatoAgendar", "click" ,function() {
	sendRequest("POST","lib/consultas/servicio.php",true,"servicio=3&nombre="+ $("#txtBuscarCandidato").val(),function(data){
		        	$("#mBoxContainer").html(data);
		        });
});
function seleccionar(btn,x)
{
	var id = $(btn).attr('data-id');
	var idhorario = $("td[data-clicked='true']").attr('data-horario');
	var fecha = $("td[data-clicked='true']").attr('data-fecha');
	sendRequest("POST","lib/consultas/servicio.php",true,"servicio=8&idcandidato="+id+"&idhorario="+idhorario+"&fecha="+fecha+"&idempleado="+$("#cmbEmpleado").val(),function(data){
				var msj = data =='1'?"Insertado correctamente":"Se ha producido un error favor de verificar";
		        mensaje(data,msj);	
		        });
	$("td[data-clicked='true']").removeClass('info').addClass('success');
	$("td[data-clicked='true']").attr('data-clicked','false');
}
$("body").delegate("#cmbTipoEntrevista","change",function(){
	
	sendRequest("POST","lib/consultas/servicio.php",true,"servicio=4",function(data){
		        	$("#cmbEmpleado").html(data);
		        });

	
});
$("body").delegate("#cmbEmpleado","change",function(){	
	sendRequest("POST","lib/consultas/servicio.php",true,"servicio=6&idempleado="+$("#cmbEmpleado").val(),function(data){
		        	$("#calendar").html(data);
		        });
});
$("body").delegate("td[data-status='disponible']","click",function(){	
	$("#mBox").modal('show');
	$("#mBoxHeader").html('<form class="form-horizontal" role="form"><div class="form-group"><label for="txtBuscarCandidato" class="col-sm-2 control-label">Buscar</label><div class="col-sm-10"><input type="text" class="form-control" id="txtBuscarCandidato" placeholder="Buscar"></div></div><div class="form-group"><div class="col-sm-offset-2 col-sm-10">	<button id="btnBuscarCandidatoAgendar" type="button" class="btn btn-default">Buscar</button></div></div></form>');
	$(this).attr('data-clicked','true');
});
$("body").delegate("td[data-status='ocupado']","click",function(){	
	sendRequest("POST","lib/consultas/servicio.php",true,"servicio=7&folio="+$(this).attr('data-foliocitado'),function(data){
					$("#mBox").modal('show');
		        	$("#mBoxContainer").html(data);
		        });
});
$("body").delegate("button[data-fechaSiguiente]","click",function(){	
	sendRequest("POST","lib/consultas/servicio.php",true,"servicio=6&idempleado="+$("#cmbEmpleado").val()+"&fecha="+$(this).attr('data-fechaSiguiente'),function(data){
		        	$("#calendar").html(data);
		        });
	
});
$("input[data-required='true']").blur(function(){
	if($(this).val()== "")
	{
		$(this).parent().parent().addClass("has-error");
		mensaje("2","Error este campo es requerido");
		$(this).focus();
	}
	else
	{
		$(this).parent().parent().removeClass("has-error").addClass("has-success").delay(1000).removeClass("has-success");
	}
});

function testBrackets (bandera,x)
{
    if(bandera === true)
        {
            bandera = false;
            x+=1;
        }
    alert("algo");
}