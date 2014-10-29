<form id="frmestudio" class="form-horizontal" role="form"><input type="hidden" name="idestudio" id="idestudio">
    <div class="form-group">
        <label for="txtFechaInicio" class="col-sm-2 control-label">Fecha Inicio</label>
        <div class="col-sm-7">
            <input id="txtFechaInicio" name="txtFechaInicio" class="form-control" type="text" data-type="date" data-required="TRUE">
        </div>
    </div>
    <div class="form-group">
        <label for="txtFechaFin" class="col-sm-2 control-label">Fecha Fin</label>
        <div class="col-sm-7">
            <input id="txtFechaFin" name="txtFechaFin" class="form-control" type="text" data-type="date" data-required="TRUE">
        </div>
    </div>
    <div class="form-group">
        <label for="txtGrado" class="col-sm-2 control-label">Grado</label>
        <div class="col-sm-7">
            <input id="txtGrado" name="txtGrado" class="form-control" type="text" data-type="numeric" data-required="TRUE">
        </div>
    </div>
    <div class="form-group">
        <label for="cmbCicloEscolar" class="col-sm-2 control-label">Ciclo Escolar</label>
        <div class="col-sm-7">
            <select name="cmbCicloEscolar" id="cmbCicloEscolar" class="form-control">
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="cmbCarrera" class="col-sm-2 control-label">Carrera</label>
        <div class="col-sm-7">
            <select name="cmbCarrera" id="cmbCarrera" class="form-control">
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="txtTitulo" class="col-sm-2 control-label">Titulo</label>
        <div class="col-sm-7">
            <input id="txtTitulo" name="titulo" class="form-control" type="text" data-type="numeric" data-required="TRUE">
        </div>
    </div>
    <div class="form-group">
        <label for="txtCedulaprofesional" class="col-sm-2 control-label">Cedula Profesional</label>
        <div class="col-sm-7">
            <input id="txtCedulaprofesional" name="txtCedulaprofesional" class="form-control" type="text" data-type="alphanumeric" data-length="200" data-required="TRUE">
        </div>
    </div>
    <input type="hidden" name="status" id="status">
    <div class="form-group">
        <label for="txtPromedio" class="col-sm-2 control-label">Promedio</label>
        <div class="col-sm-7">
            <input id="txtPromedio" name="txtPromedio" class="form-control" type="text" data-type="numeric" data-required="TRUE">
        </div>
    </div>
</form>