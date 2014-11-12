<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Bolsa de practicantes de AHMSA 2014">
  <meta name="author" content="Miguel Angel Padilla Abrego - Thewolf">
  <title>Bolsa de Practicantes</title>
  <!-- CSS -->
	<link rel="stylesheet" href="css/normalize.css" />
	<link rel="stylesheet" href="css/bootstrap.css"  />
	<link rel="stylesheet" href="css/ui/jquery-ui.min.css">
  <link rel="stylesheet" href="css/bootstrap-custom.css">
	<!-- Suporte de HTML5 para IE -->
  <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
  <![endif]-->
</head>
<body>
	<nav class="navbar navbar-inverse navbar-fixed-top primary" role="navigation">
	  <div class="container">
	    <div class="navbar-header">
	      <div class="nav-collapse  bs-navbar-collapse">   
          <a class="navbar-brand" href="index.php">Bolsa de Practicantes - AHMSA 2014</a>
        </div>
	    </div>
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav navbar-right">
          <li><a href="unlogin.php">Salir</a></li>
	      </ul>
	    </div>
	  </div>
	</nav>
  <div class="wrap">
	  <div class="container">
	  	<div class="row">

<div id="tbPracticantes">
</div>

<div class="modal" id="frmSolicitar">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="lblTitulo"></h4>
      </div>
      <div class="modal-body">
        <div class="form-horizontal">
          <div class="form-group">
            <div class="control-label col-sm-2"><b>Solicitante:</b></div>
            <div class="col-sm-10"><input type="text" id="txtSolicitante" class="form-control" /></div>
          </div>
          <div class="form-group">
            <div class="control-label col-sm-2"><b>Email:</b></div>
            <div class="col-sm-6"><input type="text" id="txtEmail" class="form-control" /></div>
            <div class="control-label col-sm-2"><b>Ext:</b></div>
            <div class="col-sm-2"><input type="text" id="txtExt" class="form-control" /></div>
          </div>
          <div class="form-group">
            <div class="control-label col-sm-2"><b>Direccion:</b></div>
            <div class="col-sm-4"><input type="text" id="txtDireccion" class="form-control" /></div>
            <div class="control-label col-sm-2"><b>Departamento:</b></div>
            <div class="col-sm-4"><input type="text" id="txtDepartamento" class="form-control" /></div>
          </div>
          <div class="form-group">
            <div class="control-label col-sm-2"><b>Jefe Dpto.</b></div>
            <div class="col-sm-10"><input type="text" id="txtJefeDpto" class="form-control" /></div>
          </div>
          <hr/>
          <div class="form-group">
            <div class="control-label col-sm-2"><b>Proyecto:</b></div>
            <div class="col-sm-5"><input type="text" id="txtProyecto" class="form-control" /></div>
            <div class="control-label col-sm-2"><b>Duracion:</b></div>
            <div class="col-sm-3">
              <div class="input-group">
                <input type="number" id="txtDuracion" value="3" class="form-control" />
                <span class="input-group-addon">Meses</span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="control-label col-sm-2"><b>Actividades:</b></div>
            <div class="col-sm-10"><textarea id="txtActividades" class="form-control"></textarea></div>
          </div>
        </div>
      </div>
      <!-- Hidden inputs -->
      <input type="hidden" value="0" id="idSolicitante" />
      <input type="hidden" value="0" id="idDepartamento" />
      <input type="hidden" value="0" id="idCandidato" />
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="btnCerrar" data-dismiss="modal">Cerrar</button>
        <button type="button" id="btnSolicitar" class="btn btn-primary">Solicitar</button>
      </div>
    </div>
  </div>
</div>

      </div>
    </div>
  </div>
  <footer id="footer" class="footer">
    <div class="container">
      <p>
          <img src="img/logo_rh.png" width="250" height="auto" style="margin-right:50px;"/>
        Sitio Dise&ntilde;ado por <a href="javascript:;">Subgerencia de Contrataci&oacute;n e Integraci&oacute;n</a>
      </p>
    </div>
  </footer>
  <!-- JavaScript -->
  <script src="js/jquery-1.10.2.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/ui/jquery.ui.core.js"></script>
  <script src="js/ui/jquery.ui.widget.js"></script>
  <script src="js/ui/jquery.ui.position.js"></script>
  <script src="js/ui/jquery.ui.menu.js"></script>
  <script src="js/ui/jquery.ui.autocomplete.js"></script>
  <script src="js/fn-bpracticas.js"></script>
</body>
</html>