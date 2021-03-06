<?php 
    if($_REQUEST)
    {
        #terminar para traer el promedio el encargado y el departamento
        extract($_REQUEST);
        include_once dirname(__FILE__).("/lib/consultas/cconexion.php");
        $cnx = new conexion();
        $sql = "select encargado.idencargado,encargado.iddepartamento 
from solicitudpractica
inner join encargado on encargado.idencargado = solicitudpractica.idencargado
where idsolicitudpractica = (select idsolicitudpractica from solicitudpractica where idcandidato = $idcandidato and status=1)";
        $rs = $cnx->returnRS($sql);
        $row = $rs->FetchRow();
    }
else
    die("No estas Autorizado para estar aqui");
?>
<form id="frmpractica" class="form-horizontal" role="form">
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
                <input id="txtMontoAyuda" name="txtMontoAyuda" class="form-control" type="text" data-type="numeric"  data-required="TRUE" value="0.00" />
            </div>
        </div>
        <div class="form-group">
            <label for='cmbEncargado' class='col-sm-2 control-label'>Encargado del Practicante</label>
            <div class="col-sm-7">
                <select name="cmbEncargado" id="cmbEncargado" class="form-control" >
                    <?php echo $cnx->crearOption('select idencargado as id, nombre as descripcion from encargado where status=1',$row['idencargado']); ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for='cmbDepartamento' class='col-sm-2 control-label'>Departamento</label>
            <div class="col-sm-7">
                <select name="cmbDepartamento" id="cmbDepartamento" class="form-control" >
                    <?php echo $cnx->crearOption('select iddepartamento as id, descripcion from departamento where status=1',$row['iddepartamento']); ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for='cmbTipoEstadia' class='col-sm-2 control-label'>Tipo Estadia</label>
            <div class="col-sm-7">
                <select name="cmbTipoEstadia" id="cmbTipoEstadia" class="form-control" >
                    <?php echo $cnx->crearOption('select idtipoestadia as id, descripcion from tipoestadia where status=1','-1'); ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for='cmbTipoPoliza' class='col-sm-2 control-label'>Tipo Poliza</label>
            <div class="col-sm-7">
                <select name="cmbTipoPoliza" id="cmbTipoPoliza" class="form-control" >
                    <?php echo $cnx->crearOption('select idtipopoliza as id, descripcion from tipopoliza where status=1','-1'); ?>
                </select>
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