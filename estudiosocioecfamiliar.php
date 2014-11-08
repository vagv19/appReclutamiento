<?php
    $bandera = false;
    include_once dirname(__FILE__).'/lib/consultas/cconexion.php';
    $cnx = new conexion();
    if($_REQUEST)
    {
        extract($_REQUEST);
        if(isset($idestudiosocioecfamiliar))
        {$sql = "select * from estudiosocioecfamiliar where idestudiosocioecfamiliar=$idestudiosocioecfamiliar";$rs = $cnx->returnRS($sql);if($rs != null){    $bandera = true;    $row = $rs->FetchRow();}
        }
    }#remplazar txtResultado por cmbResultado rehacer consulta tabla esf
?>
<form id="frmestudiosocioecfamiliar" class="form-horizontal" role="form">
<input type="hidden" name="idEstudioSocioEcFamiliar" id="idEstudioSocioEcFamiliar" value="<?php echo $bandera == true ? $row['idestudiosocioecfamiliar'] : '-1' ?>" />
<div class="form-group">
    <label for='txtFecha' class='col-sm-2 control-label'>Fecha</label>
    <div class="col-sm-7">
        <input id="txtFecha" name="txtFecha" class="form-control"  type="text" data-type="date"  data-required="TRUE" value="<?php echo $bandera == true ? $row['fecha']:''; ?>" />
    </div>
</div>
<div class="form-group">
    <label for='txtEstructuraFamiliar' class='col-sm-2 control-label'>Estructura Familiar</label>
    <div class="col-sm-7">
        <textarea id="txtEstructuraFamiliar" name="txtEstructuraFamiliar" class="form-control"  type="text" data-type="alphanumeric"  data-required="TRUE"><?php echo $bandera == true ? $row['estructurafamiliar']:''; ?>
        </textarea>
    </div>
</div>
<div class="form-group">
    <label for='txtOrganizacionFamiliar' class='col-sm-2 control-label'>Organizacion Familiar</label>
    <div class="col-sm-7">
        <textarea id="txtOrganizacionFamiliar" name="txtOrganizacionFamiliar" class="form-control"  type="text" data-type="alphanumeric"  data-required="TRUE"><?php echo $bandera == true ? $row['organizacionfamiliar']:''; ?>
        </textarea>
    </div>
</div>
<div class="form-group">
    <label for='txtSalud' class='col-sm-2 control-label'>Salud</label>
    <div class="col-sm-7">
        <textarea id="txtSalud" name="txtSalud" class="form-control"  type="text" data-type="alphanumeric"  data-required="TRUE"><?php echo $bandera == true ? $row['salud']:''; ?>
        </textarea>
    </div>
</div>
<div class="form-group">
    <label for='txtAlimentacion' class='col-sm-2 control-label'>Alimentacion</label>
    <div class="col-sm-7">
        <textarea id="txtAlimentacion" name="txtAlimentacion" class="form-control"  type="text" data-type="alphanumeric"  data-required="TRUE"><?php echo $bandera == true ? $row['alimentacion']:''; ?>    
        </textarea>
    </div>
</div>
<div class="form-group">
    <label for='txtSituacionEconomica' class='col-sm-2 control-label'>Situacion Economica</label>
    <div class="col-sm-7">
        <textarea id="txtSituacionEconomica" name="txtSituacionEconomica" class="form-control"  type="text" data-type="alphanumeric"  data-required="TRUE"><?php echo $bandera == true ? $row['situacioneconomica']:''; ?>
        </textarea>
    </div>
</div>
<div class="form-group">
    <label for='txtVivienda' class='col-sm-2 control-label'>Vivienda</label>
    <div class="col-sm-7">
        <textarea id="txtVivienda" name="txtVivienda" class="form-control"  type="text" data-type="alphanumeric"  data-required="TRUE"><?php echo $bandera == true ? $row['vivienda']:''; ?>
        </textarea>
    </div>
</div>
<div class="form-group">
    <label for='txtReligion' class='col-sm-2 control-label'>Religion</label>
    <div class="col-sm-7">
        <textarea id="txtReligion" name="txtReligion" class="form-control"  type="text" data-type="alphanumeric"  data-required="TRUE"><?php echo $bandera == true ? $row['religion']:''; ?>
        </textarea>
    </div>
</div>
<div class="form-group">
    <label for='txtObservaciones' class='col-sm-2 control-label'>Observaciones</label>
    <div class="col-sm-7">
        <textarea id="txtObservaciones" name="txtObservaciones" class="form-control"  type="text" data-type="alphanumeric"  data-required="TRUE"><?php echo $bandera == true ? $row['observaciones']:''; ?>
        </textarea>
    </div>
</div>    
 <div class="form-group">
        <label for="cmbResultado" class="col-sm-2 control-label">Resultado</label>
        <div class="col-sm-7">    <select name="cmbResultado" id="cmbResultado" class="form-control">        <?php echo $cnx->crearOption('select idresultado as id,resultado as descripcion from resultado where idresultado between 5 and 7 and status=1',$bandera == true ? $row['resultado']:'-1'); ?>    </select>         
        </div>
    </div>
</form>