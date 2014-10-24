   <div class="panel-group" id="accordion">
  <div class="panel panel-default">
    <div class="panel-heading">
      <div class="container-fluid">
      		<h4 class="panel-title ">
		        <a data-toggle="collapse" data-parent="#accordion" href="#datosPersonales" class="col-sm-6">
		          Datos Personales
		        </a>        
		    </h4>
		    <div class="col-sm-6">
		    	<div class="btn-group pull-right">
				  <button type="button" class="btn btn-default"><i class="glyphicon glyphicon-plus-sign"></i> Agregar</button>
				  <button type="button" class="btn btn-default"><i class="glyphicon glyphicon-remove-sign"></i> Eliminar</button>
				  <button type="button" class="btn btn-default" style="display:;"><i class="glyphicon glyphicon-ok-circle"></i> Reactivar</button>
				  <button type="button" class="btn btn-default"><i class="glyphicon glyphicon-edit"></i> Modificar</button>
				</div>
		    </div>
      </div>
    </div>
      
    <div id="datosPersonales" class="panel-collapse collapse in">
      <div class="panel-body">
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<label for="txtNombre" class="col-sm-2 control-label">Nombre</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="txtNombre" placeholder="Nombre">
					</div>
				</div>
				<div class="form-group">
					<label for="txtApellidoPaterno" class="col-sm-2 control-label">Apellido Paterno</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="txtApellidoPaterno" placeholder="Apellido Paterno">
					</div>
				</div>
				<div class="form-group">
					<label for="txtApellidoMAterno" class="col-sm-2 control-label">Apellido Materno</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="txtApellidoMAterno" placeholder="Apellido Materno">
					</div>
				</div>
				<div class="form-group">
					<label for="txtFechaNacimiento" class="col-sm-2 control-label">Fecha Nacimiento</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="txtFechaNacimiento" placeholder="Fecha Nacimiento">
					</div>
				</div>
				<div class="form-group">
					<label for="txtLugarNacimiento" class="col-sm-2 control-label">Lugar Nacimiento</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="txtLugarNacimiento" placeholder="Lugar Nacimiento">
					</div>
				</div>
				<div class="form-group">
					<label for="cmbSexo" class="col-sm-2 control-label">Sexo</label>
					<div class="col-sm-10">
						<select id="cmbSexo" class="form-control">
							<option value="1">Hombre</option>
							<option value="0">Mujer</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="cmbEstadoCivil" class="col-sm-2 control-label">Estado Civil</label>
					<div class="col-sm-10">
						<select id="cmbEstadoCivil" class="form-control">
							
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="txtRfc" class="col-sm-2 control-label">RFC</label>
					<div class="col-sm-10">
						<input type="text" data-required='true' class="form-control" id="txtRfc" placeholder="RFC">
					</div>
				</div>
				<div class="form-group">
					<label for="txtCurp" class="col-sm-2 control-label">CURP</label>
					<div class="col-sm-10">
						<input type="text" data-required='true' class="form-control" id="txtCurp" placeholder="CURP">
					</div>
				</div>
				<div class="col-sm-12">
					<button class="btn btn-primary pull-right">Guardar <i class="glyphicon glyphicon-floppy-disk"></i></button>
					<button class="btn btn-default pull-right">Cancelar</button>
				</div>
			</form>
       </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#datosContacto">
          Datos de Contacto
        </a>
      </h4>
    </div>
    <div id="datosContacto" class="panel-collapse collapse">
      <div class="panel-body">
      		<form class="form-horizontal" role="form">
      			<div class="form-group">
					<label for="txtDireccion" class="col-sm-2 control-label">Direccion</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="txtDireccion" placeholder="Direccion">
					</div>
				</div>
				<div class="form-group">
					<label for="txtCodigoPostal" class="col-sm-2 control-label">Codigo Postal</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="txtCodigoPostal" placeholder="Codigo Postal">
					</div>
				</div>
				<div class="form-group">
					<label for="cmbColonia" class="col-sm-2 control-label">Colonia</label>
					<div class="col-sm-10">
						<select id="cmbColonia" class="form-control">
							
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="txtTelefono" class="col-sm-2 control-label">Telefono</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="txtTelefono" placeholder="Telefono">
					</div>
				</div>
				<div class="form-group">
					<label for="txtCelular" class="col-sm-2 control-label">Celular</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="txtCelular" placeholder="Celular">
					</div>
				</div>
				<div class="form-group">
					<label for="txtEmail" class="col-sm-2 control-label">Email</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="txtEmail" placeholder="Email">
					</div>
				</div>
				<div class="col-sm-12">
					<button class="btn btn-primary pull-right">Guardar <i class="glyphicon glyphicon-floppy-disk"></i></button>
					<button class="btn btn-default pull-right">Cancelar</button>
				</div>
			</form>
       </div>
    </div>
  </div>
</div>