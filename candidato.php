<?php 
	include_once "header.php";
	include_once 'navbar.php';
?>

<div class="col-sm-6 col-sm-offset-3 col-sm-10 col-md-offset-2 main" id="contenedor">

	<form class="form-horizontal" role="form">
		<fieldset disabled>
		<input id="accion" name="accion" type="hidden" value="0"/>
		<input id="idCandidato" name="idCandidato" type="hidden" value="0"/>
		<div class="form-group">
			<label for="txtNombre" class="col-sm-4 control-label">Nombre</label>
				<div class="col-sm-7">
					<input type="text" class="form-control" id="txtNombre" name="txtNombre" data-required='true' placeholder="Nombre">
				</div>
		</div>
		<div class="form-group">
			<label for="txtApellidoPaterno" class="col-sm-4 control-label">Apellido Paterno</label>
				<div class="col-sm-7">
					<input type="text" class="form-control" id="txtApellidoPaterno" data-required='true'  name='txtApellidoPaterno' placeholder="Apellido Paterno">
				</div>
		</div>
		<div class="form-group">
			<label for="txtApellidoMAterno" class="col-sm-4 control-label">Apellido Materno</label>
				<div class="col-sm-7">
					<input type="text" class="form-control" id="txtApellidoMaterno" data-required='true'  name='txtApellidoMaterno' placeholder="Apellido Materno">
				</div>
		</div>
		<div class="form-group">
					<label for="txtDireccion" class="col-sm-4 control-label">Direccion</label>
					<div class="col-sm-7">
						<input type="text" class="form-control" name="txtDireccion" id="txtDireccion" placeholder="Direccion">
					</div>
				</div>
				<div class="form-group">
					<label for="txtCodigoPostal" class="col-sm-4 control-label">Codigo Postal</label>
					<div class="col-sm-7">
						<input type="text" data-type="numeric" data-required='true'  class="form-control" name="txtCodigoPostal" id="txtCodigoPostal" placeholder="Codigo Postal">
					</div>
				</div>
				<div class="form-group">
					<label for="cmbColonia" class="col-sm-4 control-label">Colonia</label>
					<div class="col-sm-6">
						<select id="cmbColonia" name="cmbColonia" class="form-control">							
						</select>
					</div>
					<div class="col-sm-2">
						<button id="btnExaminarColonia" class="btn btn-default" type="button"><i class="glyphicon glyphicon-search"></i></button>
					</div>
				</div>
				<div class="form-group">
					<label for="txtLugarProcedencia" class="col-sm-4 control-label">Lugar Procedencia</label>
					<div class="col-sm-7">
						<input type="text" class="form-control" data-type='alphanumeric' id="txtLugarProcedencia" name="txtLugarProcedencia" placeholder="Lugar Procedencia">
					</div>
				</div>
				<div class="form-group">
					<label for="txtTelefono" class="col-sm-4 control-label">Telefono</label>
					<div class="col-sm-7">
						<input type="text" class="form-control" data-type='alphanumeric' name="txtTelefono" id="txtTelefono" placeholder="Telefono">
					</div>
				</div>
				<div class="form-group">
					<label for="txtCelular" class="col-sm-4 control-label">Celular</label>
					<div class="col-sm-7">
						<input type="text" class="form-control" data-type='alphanumeric' name='txtCelular' id="txtCelular" placeholder="Celular">
					</div>
				</div>
				<div class="form-group">
					<label for="txtEmail" class="col-sm-4 control-label">Email</label>
					<div class="col-sm-7">
						<input type="text" class="form-control" data-type='alphanumeric' name="txtEmail" id="txtEmail" placeholder="Email">
					</div>
				</div>
		<div class="form-group">
			<label for="txtFechaNacimiento" class="col-sm-4 control-label">Fecha Nacimiento</label>
				<div class="col-sm-7">
					<input type="text" class="form-control" id="txtFechaNacimiento" name="txtFechaNacimiento" placeholder="Fecha Nacimiento">
				</div>
		</div>
		<div class="form-group">
			<label for="txtLugarNacimiento" class="col-sm-4 control-label">Lugar Nacimiento</label>
			<div class="col-sm-7">
			<input type="text" class="form-control" data-type='alphanumeric' id="txtLugarNacimiento" name="txtLugarNacimiento" placeholder="Lugar Nacimiento">
			</div>
		</div>
		<div class="form-group">
			<label for="cmbSexo" class="col-sm-4 control-label">Sexo</label>
			<div class="col-sm-7">
				<select id="cmbSexo" name="cmbSexo" class="form-control">
					<option value="1">Hombre</option>
					<option value="0">Mujer</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="txtEstatura" class="col-sm-4 control-label">Estatura</label>
			<div class="col-sm-7">
			<input type="text" data-required='false' data-type='numeric' class="form-control" id="txtEstatura" name="txtEstatura" placeholder="Estatura">
			</div>
		</div>
		<div class="form-group">
			<label for="txtPeso" class="col-sm-4 control-label">Peso</label>
			<div class="col-sm-7">
			<input type="text" data-required='false' data-type='numeric' class="form-control" id="txtPeso" name='txtPeso' placeholder="Peso">
			</div>
		</div>
		<div class="form-group">
			<label for="pIndiceMasaCorporal" class="col-sm-4 control-label">IMC</label>
			<div class="col-sm-7">
			<input type="text" data-required='false' data-type='alphanumeric' class="form-control" id="pIndiceMasaCorporal" name='' placeholder="IMC">
			</div>
		</div>
		<div class="form-group">
			<label for="cmbEstadoCivil" class="col-sm-4 control-label">Estado Civil</label>
			<div class="col-sm-7">
				<select id="cmbEstadoCivil" name='cmbEstadoCivil' class="form-control">
					
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="txtRfc" class="col-sm-4 control-label">RFC</label>
			<div class="col-sm-7">
			<input type="text" data-required='true' data-type='alphanumeric' class="form-control" id="txtRfc" name='txtRfc' placeholder="RFC">
			</div>
		</div>
		<div class="form-group">
			<label for="txtCurp" class="col-sm-4 control-label">CURP</label>
			<div class="col-sm-7">
			<input type="text" data-required='true' data-type='alphanumeric' class="form-control" id="txtCurp" name='txtCurp' placeholder="CURP">
			</div>
		</div>
		<div class="form-group">
			<label for="txtNoSeguridadSocial" class="col-sm-4 control-label">No Seguridad Social</label>
			<div class="col-sm-7">
			<input type="text" data-required='false' data-type='numeric' class="form-control" id="txtNoSeguridadSocial" name="txtNoSeguridadSocial" placeholder="No Seguridad Social">
			</div>
		</div>
		<div class="form-group">
			<label for="txtCartillaMilitar" class="col-sm-4 control-label">Cartilla Militar</label>
			<div class="col-sm-7">
				<input type="text" data-required='false' class="form-control" id="txtCartillaMilitar" name="txtCartillaMilitar" placeholder="Cartilla Militar">
			</div>
		</div>
		<div class="col-sm-8 col-sm-offset-4">
			<div class="checkbox">
				<label>
					<input name='chkDisponibilidadViajar' id='chkDisponibilidadViajar' name="chkDisponibilidadViajar" value='1' type="checkbox"> Disponibilidad para Viajar
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input name='chkDisponibilidadMudanza' id='chkDisponibilidadMudanza' name='chkDisponibilidadMudanza' value='1' type="checkbox"> Disponibilidad Mudanza
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input id='chkDisponibilidadTurnos' name='chkDisponibilidadTurnos' value='1' type="checkbox"> Disponibilidad Turnos
				</label>
			</div>
		</div>
		<div class="col-sm-12">
					<button type="button" id="btnGuardar" class="btn btn-primary pull-right">Guardar <i class="glyphicon glyphicon-floppy-disk"></i></button>
					<button type="button" id="btnCancelar" class="btn btn-default pull-right">Cancelar</button>
				</div>
		</fieldset>		
	</form>
</div>
<div class="col-sm-3">
	<div class="container-fluid" style="margin-bottom:10px;">
		<div class="row">
			<div class="col-sm-8" style="text-align:right">
				Clasificacion
			</div>	
			<div id="clasificacionCandidato" class="col-sm-4">
				
			</div>
			<div class="col-sm-8" style="text-align:right">
				Fecha Alta
			</div>	
			<div id="fechaAltaCandidato" class="col-sm-4">
				
			</div>
			<div class="col-sm-8" style="text-align:right">
				Fecha Actualizacion
			</div>	
			<div id="fechaActualizacionCandidato" class="col-sm-4">
				
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="js/candidato.js"></script>
<?php	
	include_once "footer.php";
?>