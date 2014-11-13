<?php 
?>
<form>
    <fieldset>
        <input type="hidden" name="idpractica" id="idpractica" />
        <div class="form-group">
            <label for='fechainicio' class='col-sm-2 control-label'>fechainicio</label>
            <div class="col-sm-7">
                <input id="fechainicio" name="fechainicio" class="form-control"  type="text" data-type="date"  data-required="TRUE" />
            </div>
        </div>
        <div class="form-group">
            <label for='fechafin' class='col-sm-2 control-label'>fechafin</label>
            <div class="col-sm-7">
                <input id="fechafin" name="fechafin" class="form-control"  type="text" data-type="date"  data-required="TRUE" />
            </div>
        </div>
        <div class="form-group">
            <label for='numeroficha' class='col-sm-2 control-label'>numeroficha</label>
            <div class="col-sm-7">
                <input id="numeroficha" name="numeroficha" class="form-control" type="text" data-type="numeric"  data-required="TRUE" />
            </div>
        </div>

        <div class="form-group">
            <label for='montoayuda' class='col-sm-2 control-label'>montoayuda</label>
            <div class="col-sm-7">
                <input id="montoayuda" name="montoayuda" class="form-control" type="text" data-type="numeric"  data-required="TRUE" />
            </div>
        </div>
        <div class="form-group">
            <label for='prorroga' class='col-sm-2 control-label'>prorroga</label>
            <div class="col-sm-7">
                <input id="prorroga" name="prorroga" class="form-control" type="text" data-type="numeric"  data-required="TRUE" />
            </div>
        </div>
        <div class="form-group">
            <label for='numeroprorroga' class='col-sm-2 control-label'>numeroprorroga</label>
            <div class="col-sm-7">
                <input id="numeroprorroga" name="numeroprorroga" class="form-control" type="text" data-type="numeric"  data-required="TRUE" />
            </div>
        </div>
        <div class="form-group">
            <label for='promedio' class='col-sm-2 control-label'>promedio</label>
            <div class="col-sm-7">
                <input id="promedio" name="promedio" class="form-control" type="text" data-type="numeric"  data-required="TRUE" />
            </div>
        </div>
        <div class="form-group">
            <label for='totalhoras' class='col-sm-2 control-label'>totalhoras</label>
            <div class="col-sm-7">
                <input id="totalhoras" name="totalhoras" class="form-control" type="text" data-type="numeric"  data-required="TRUE" />
            </div>
        </div>
        <div class="form-group">
            <label for='resultado' class='col-sm-2 control-label'>resultado</label>
            <div class="col-sm-7">
                <input id="resultado" name="resultado" class="form-control" type="text" data-type="numeric"  data-required="TRUE" />
            </div>
        </div>
        <div class="form-group">
            <label for='idencargado' class='col-sm-2 control-label'>encargado</label>
            <div class="col-sm-7">
                <select name="idencargado" id="idencargado" class="form-control" >
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for='idtipoestadia' class='col-sm-2 control-label'>tipoestadia</label>
            <div class="col-sm-7">
                <select name="idtipoestadia" id="idtipoestadia" class="form-control" ></select>
            </div>
        </div>
        <div class="form-group">
            <label for='idtipopoliza' class='col-sm-2 control-label'>tipopoliza</label>
            <div class="col-sm-7">
                <select name="idtipopoliza" id="idtipopoliza" class="form-control" ></select>
            </div>
        </div>
        <div class="form-group">
            <label for='iddepartamento' class='col-sm-2 control-label'>departamento</label>
            <div class="col-sm-7">
                <select name="iddepartamento" id="iddepartamento" class="form-control" ></select>
            </div>
        </div>
        <input type="hidden" name="status" id="status" />
        <div class="form-group">
            <label for='numeroasignacion' class='col-sm-2 control-label'>numeroasignacion</label>
            <div class="col-sm-7">
                <input id="numeroasignacion" name="numeroasignacion" class="form-control" type="text" data-type="numeric"  data-required="TRUE" />
            </div>
        </div>
        <div class="form-group">
            <label for='fechaasignacion' class='col-sm-2 control-label'>fechaasignacion</label>
            <div class="col-sm-7">
                <input id="fechaasignacion" name="fechaasignacion" class="form-control"  type="text" data-type="date"  data-required="TRUE" />
            </div>
        </div>
        <div class="form-group">
            <label for='fechaterminopoliza' class='col-sm-2 control-label'>fechaterminopoliza</label>
            <div class="col-sm-7">
                <input id="fechaterminopoliza" name="fechaterminopoliza" class="form-control"  type="text" data-type="date"  data-required="TRUE" />
            </div>
        </div>
    </fieldset>
</form>