<?php
	include_once 'header.php';
?>
<div class="col-sm-10 col-sm-offset-2 main" id="contenedor">
	<div class="list-group">
		<a href="#" class="list-group-item">
			<h4 class="list-group-item-heading">
				<div class="row">
					<div class="col-sm-1" style="text-align:right">Folio:</div>
				<div class="col-sm-5">AH-10001</div>
				<div class="col-sm-6 pull-right">
					<div class="col-sm-9" style="text-align:right">Clasificacion:</div>
					<div class="col-sm-3">Bolsa AHMSA</div>
				</div>
				</div>
			</h4>
			<p class="list-group-item-text">
				<div class="row">
					<div class="col-sm-2">
					<img src="img/AH-10001.jpg" style="height:auto;width:100px;" class="img-thumbnail"/>
				</div>
				<div class="col-sm-9">
					<div class="col-sm-3" style="text-align:right">Nombre:</div>
					<div class="col-sm-9">VICTOR ALFONSO</div>
					<div class="col-sm-3" style="text-align:right">Apellido Paterno:</div>
					<div class="col-sm-9">GARCIA</div>
					<div class="col-sm-3" style="text-align:right">Apellido Materno:</div>
					<div class="col-sm-9">VAZQUEZ</div>
					<div class="col-sm-3" style="text-align:right">Telefono:</div>
					<div class="col-sm-9">6357710</div>
					<div class="col-sm-3" style="text-align:right">Celular:</div>
					<div class="col-sm-9">8661695631</div>
				</div>
				</div>
			</p>
		</a>
	</div>
		
	<div class="col-sm-12" style="margin-top:10px;">
		<ul class="nav nav-tabs" role="tablist">
		  <li class="active"><a href="#antecedentelaboralcandidato" role="tab" data-toggle="tab">Ant. Laborales</a></li>
		  <li><a href="#areainterescandidato" role="tab" data-toggle="tab">Areas Interes</a></li>
		  <li><a href="#conocimientocandidato" role="tab" data-toggle="tab">Conocimiento</a></li>
		  <li><a href="#cursocandidato" role="tab" data-toggle="tab">Cursos</a></li>
		  <li><a href="#entrevistacandidato" role="tab" data-toggle="tab">Entrevista</a></li>
		  <li><a href="#estudiocandidato" role="tab" data-toggle="tab">Estudios</a></li>
		  <li><a href="#estudiosocioecfamiliarcandidato" role="tab" data-toggle="tab">Est Soc. Ec. Familiar</a></li>
		  <li><a href="#procesopracticascandidato" role="tab" data-toggle="tab">Proceso Practicas</a></li>
		  <li><a href="#idiomacandidato" role="tab" data-toggle="tab">Idiomas</a></li>
		</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane active" id="antecedentelaboralcandidato"></div>
  <div class="tab-pane" id="areainterescandidato">...</div>
  <div class="tab-pane" id="conocimientocandidato">...</div>
  <div class="tab-pane" id="cursocandidato">...</div>
  <div class="tab-pane" id="entrevistacandidato">
    <form id="frmEntrevista" class="form-horizontal" role="form" style="margin-top:5px;">
        <input type="hidden" id="idEntrevista" />
        <div class="form-group">
			<label for="txtFecha" class="col-sm-2 control-label">Fecha</label>
				<div class="col-sm-7">
                    <input type="text" class="form-control" id="txtFecha" data-required="false"  name="txtFecha" data-date-language="es" value="" placeholder="Fecha">
				</div>
		</div>
        <div class="form-group">
			<label for="cmbPresentacion" class="col-sm-2 control-label">Presentacion</label>
				<div class="col-sm-7">
					<select id="cmbPresentacion" name="cmbPresentacion" class="form-control">
					</select>
				</div>
		</div>
        <div class="form-group">
			<label for="txtLogros" class="col-sm-2 control-label">Logros</label>
				<div class="col-sm-7">
					<input type="text" class="form-control" id="txtLogros" data-required="false"  name="txtLogros" value="" placeholder="logros">
				</div>
		</div>
        <div class="form-group">
			<label for="txtObservaciones" class="col-sm-2 control-label">observaciones</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="txtObservaciones" data-required="false"  name="txtObservaciones" data-date-language="es" value="" placeholder="observaciones">
            </div>
		</div>
        <div class="form-group">
			<label for="cmbTipoEntrevista" class="col-sm-2 control-label">Tipo Entrevista</label>
            <div class="col-sm-7">
                <select id="cmbTipoEntrevista" name="cmbTipoEntrevista" class="form-control">
                </select>
            </div>
		</div>
        <div class="col-sm-9">
            <button type="button" class="btn btn-default pull-right" id="btnGuardarEntrevista">Guardar <i class="glyphicon glyphicon-floppy-disk"></i></button>
        </div> 
      </form>
    <div id="divDimension"></div>
  </div>
  <div class="tab-pane" id="estudiocandidato">
  </div>
  <div class="tab-pane" id="estudiosocioecfamiliarcandidato">...</div>
  <div class="tab-pane" id="procesopracticascandidato">...</div>
  <div class="tab-pane" id="idiomacandidato">...</div>
</div>
	</div>
</div>
<script type="text/javascript" src="js/dashboard.js"></script>	
<?php
	include_once 'footer.php';
?>