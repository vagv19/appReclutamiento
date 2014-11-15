<?php 
    if($_REQUEST)
    {
        #terminar para traer el promedio el encargado y el departamento
        extract($_REQUEST);
         include_once dirname(__FILE__).("/lib/consultas/cconexion.php");
        $cnx = new conexion();
        $sql = "";
    }
else
    die("No estas Autorizado para estar aqui");
?>
<form class="form-horizontal" role="form">
    <fieldset>
        <input type="hidden" name="idpractica" id="idpractica" />
        <div class="form-group">
            <label for='txtFechaInicio' class='col-sm-2 control-label'>Fecha Inicio</label>
            <div class="col-sm-7">
                <input id="txtFechaInicio" name="txtFechaInicio" class="form-control"  type="text" data-type="date"  data-required="TRUE" />
            </div>
        </div>
        <div class="form-group">
            <label for='txtFechaFin' class='col-sm-2 control-label'>Fecha Fin</label>
            <div class="col-sm-7">
                <input id="txtFechaFin" name="txtFechaFin" class="form-control"  type="text" data-type="date"  data-required="TRUE" />
            </div>
        </div>
        <div class="form-group">
            <label for='txtNumeroFicha' class='col-sm-2 control-label'>Numero Ficha</label>
            <div class="col-sm-7">
                <input id="txtNumeroFicha" name="txtNumeroFicha" class="form-control" type="text" data-type="numeric"  data-required="TRUE" />
            </div>
        </div>
        <div class="form-group">
            <label for='txtMontoAyuda' class='col-sm-2 control-label'>Monto Ayuda</label>
            <div class="col-sm-7">
                <input id="txtMontoAyuda" name="txtMontoAyuda" class="form-control" type="text" data-type="numeric"  data-required="TRUE" />
            </div>
        </div>
        <div class="form-group">
            <label for='txtPromedio' class='col-sm-2 control-label'>Promedio</label>
            <div class="col-sm-7">
                <input id="txtPromedio" name="txtPromedio" class="form-control" type="text" data-type="numeric"  data-required="TRUE" />
            </div>
        </div>
        <div class="form-group">
            <label for='cmbEncargado' class='col-sm-2 control-label'>Encargado del Practicante</label>
            <div class="col-sm-7">
                <select name="cmbEncargado" id="cmbEncargado" class="form-control" >
                    <?php #añadir crearOption  ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for='cmbTipoEstadia' class='col-sm-2 control-label'>Tipo Estadia</label>
            <div class="col-sm-7">
                <select name="cmbTipoEstadia" id="cmbTipoEstadia" class="form-control" ></select>
            </div>
        </div>
        <div class="form-group">
            <label for='cmbTipoPoliza' class='col-sm-2 control-label'>Tipo Poliza</label>
            <div class="col-sm-7">
                <select name="cmbTipoPoliza" id="cmbTipoPoliza" class="form-control" ></select>
            </div>
        </div>
        <div class="form-group">
            <label for='cmbDepartamento' class='col-sm-2 control-label'>Departamento</label>
            <div class="col-sm-7">
                <select name="cmbDepartamento" id="cmbDepartamento" class="form-control" ></select>
            </div>
        </div>
        <div class="form-group">
            <label for='txtFechaTerminoPoliza' class='col-sm-2 control-label'>Fecha Termino Poliza</label>
            <div class="col-sm-7">
                <input id="txtFechaTerminoPoliza" name="txtFechaTerminoPoliza" class="form-control"  type="text" data-type="date"  data-required="TRUE" />
            </div>
        </div>
    </fieldset>
</form>