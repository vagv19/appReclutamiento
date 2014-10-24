<?php

session_start();
	if(isSet($_SESSION['nombre']))
		{
			if(!empty($_SESSION['nombre']))	{				
				session_destroy();
				}
		}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Identificate</title>

    <!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="css/normalize.css" />
	  <link href="css/bootstrap.min.css" rel="stylesheet" />
		<link href="css/bootstrap-custom.css" rel="stylesheet">
    <link href="css/signin.css" rel="stylesheet">
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
  <script src="js/respond.min.js"></script>
<![endif]-->
	<style>
		.form-signin{
			background-color:white;
			border-top-right-radius:20px;
			border-bottom-left-radius:20px;
			border: 1px solid #f5f5f5;
			box-shadow: 2px 2px 3px 0px #000;
		}
	</style>
  </head>

  <body>

    <div class="container">

      <form class="form-signin">
        <h2 class="form-signin-heading">Identificate</h2>
        <input id="txtUsuario" type="text" class="input-block-level form-control" placeholder="Nombre de Usuario" autofocus>
        <input id="txtPassword" type="password" class="input-block-level form-control" placeholder="Password">
        <button id="btnLogin" class="btn btn-lg btn-primary btn-block" type="button">Entrar <span class="glyphicon glyphicon-log-in"></span></button>
      </form>
		<div id="divMsjError" class="bs-callout bs-callout-danger">
		<button id="btnCerrarError" type="button" class="close">&times;</button>
		  <p id="msjError"></p>
		</div>
		<!--[if lt IE 9]>
			<div class="bs-callout bs-callout-info">
				<button type="button" class="close">&times;</button>
				<p class="lead">Este Sitio se visualiza mejor con Google Chrome.</p>
			</div>
			
		<![endif]-->
    </div> <!-- /container -->
<!-- -----Scripts----------- -->
<script src="js/jquery/jquery.js"></script>
<script src="js/ui/jquery.ui.effect.min.js"></script>
<script src="js/ui/jquery.ui.effect-slide.min.js"></script>
<script>
$("#txtUsuario").on("change",function(){
	$("#btnCerrarError").click();
});
$("#txtPassword").on("change",function(){$("#btnCerrarError").click();});
$("#txtPassword").keyup(function(e){
	if(e.keyCode == 13)
		{
			$("#btnLogin").click();
		}
});
$("#btnLogin").click(function(){
	var usuario = $("#txtUsuario").val();
	var password = $("#txtPassword").val();
	if(usuario == '')
	{
		error("Error. Debes teclear el usuario.");
		$("#txtUsuario").focus();
	}
	else if (password == '')
	{
	error("Error. Debes teclear el password.");
	$("#txtPassword").focus();
	}
	else{
	login(usuario,password);
	}
});
$("#btnCerrarError").click(function(){
	var effect = "slide";
			var options = {};
	$(this).parent().hide(effect,options,1000);
});
function error(msj)
{
	var effect = "slide";
			var options = {};
	$("#msjError").text(msj).parent().show(effect,options,1000);
	
}
function login(usuario, password)
{
	$.ajax({
            type: "POST",
            url: "lib/consultas/servicio.php",
            data: 'usuario='+usuario+'&password='+password+'&servicio=0',
            success: function(data) {
			if(data == '0')
				{
					var msj="Usuario no encontrado";
					error(msj);
					return;
				}
			else if (data == '1')
				{
					document.location ="empleado.php";
				}
            }
        });
}
</script>	
  </body>
</html>