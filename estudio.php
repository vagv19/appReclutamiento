<?php 
    $bandera = false;
    include_once dirname(__FILE__).("/lib/consultas/cconexion.php");
    $cnx = new conexion();
    if($_REQUEST)
    {
        extract($_REQUEST);
        if(isset($idestudio)){
        $sql = "select * from estudio where idestudio=$idestudio";
        $rs = $cnx->returnRS($sql);
        if($rs != null)
        {
            $bandera= true;
            $row = $rs->FetchRow();
        }
        }
    }
?>
<form id="frmestudio" class="form-horizontal" role="form">
    <input type="hidden" name="idestudio" id="idestudio" value="<?php echo $bandera == true? $row[0]:'-1' ?>">
    <div class="form-group">
        <label for="cmbInstitucion" class="col-sm-2 control-label">Institucion</label>
        <div class="col-sm-7">
            <div class="input-group">
                <select name="cmbInstitucion" id="cmbInstitucion" class="form-control">
                    <?php echo $cnx->crearOption('select idinstitucion as id,descripcion from institucion where status=1',$bandera == true ? $row['idinstitucion']:'-1'); ?>
                </select>
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button" data-servicio="" id="btnExaminarInstitucion"><i class="glyphicon glyphicon-search"></i></button>
                </span>
            </div><!-- /input-group -->            
        </div>
    </div>
     <div class="form-group">
        <label for="cmbCarrera" class="col-sm-2 control-label">Carrera</label>
        <div class="col-sm-7">
            <div class="input-group">
                <select name="cmbCarrera" id="cmbCarrera" class="form-control">
                    <?php echo $cnx->crearOption('select idcarrera as id,descripcion from carrera where status=1',$bandera == true ? $row['idcarrera']:'-1'); ?>
                </select>
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button" data-servicio="" id="btnExaminarCarrera"><i class="glyphicon glyphicon-search"></i></button>
                </span>
            </div><!-- /input-group -->
        </div>
    </div>
        <div class="form-group">
        <label for="cmbCicloEscolar" class="col-sm-2 control-label">Ciclo Escolar</label>
        <div class="col-sm-7">
            <div class="input-group">
                <select name="cmbCicloEscolar" id="cmbCicloEscolar" class="form-control">
                    <?php echo $cnx->crearOption('select idcicloescolar as id,descripcion from cicloescolar where status=1',$bandera == true ? $row['idcicloescolar']:'-1',true); ?>
                </select>
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button" data-servicio="" id="btnExaminarCicloEscolar"><i class="glyphicon glyphicon-search"></i></button>
                </span>
            </div><!-- /input-group -->    
        </div>
    </div>
        <div class="form-group">
        <label for="txtGrado" class="col-sm-2 control-label">Grado</label>
        <div class="col-sm-7">
            <input id="txtGrado" name="txtGrado" class="form-control" type="text" data-type="numeric" data-required="TRUE" value="<?php echo $bandera == true? $row['grado']:'' ?>" />
        </div>
    </div>
        <div class="form-group">
        <label for="txtPromedio" class="col-sm-2 control-label">Promedio</label>
        <div class="col-sm-7">
            <input id="txtPromedio" name="txtPromedio" class="form-control" type="text" data-type="numeric" data-required="TRUE" value="<?php echo $bandera == true? $row['promedio']:'' ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label for="txtFechaInicio" class="col-sm-2 control-label">Fecha Inicio</label>
        <div class="col-sm-7">
            <input id="txtFechaInicio" name="txtFechaInicio" class="form-control" type="text" data-type="date" data-required="TRUE" value="<?php echo $bandera == true? $row["fechainicio"]:'' ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label for="txtFechaFin" class="col-sm-2 control-label">Fecha Fin</label>
        <div class="col-sm-7">
            <input id="txtFechaFin" name="txtFechaFin" class="form-control" type="text" data-type="date" data-required="TRUE" value="<?php echo $bandera == true? $row['fechafin']:'' ?>"/>
        </div>
    </div>    
    <div class="form-group">
        <label for="cmbEstadoEstudio" class="col-sm-2 control-label">Estado Estudio</label>
        <div class="col-sm-7">
            <div class="input-group">
                <select name="cmbEstadoEstudio" id="cmbEstadoEstudio" class="form-control">
                    <?php echo $cnx->crearOption('select idestatusestudio as id,descripcion from statusestudio where status=1',$bandera == true ? $row['idestatusestudio']:'-1',true); ?>
                </select>
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button" data-servicio="" id="btnExaminarEstadoEstudio"><i class="glyphicon glyphicon-search"></i></button>
                </span>
            </div><!-- /input-group -->    
        </div>
    </div>
    <div class="form-group">
        <label for="txtCedulaprofesional" class="col-sm-2 control-label">Cedula Profesional</label>
        <div class="col-sm-7">
            <input id="txtCedulaprofesional" name="txtCedulaProfesional" class="form-control" type="text" data-type="alphanumeric" data-length="200" data-required="TRUE" value="<?php echo $bandera == true? $row['cedulaprofesional']:'' ?>"/>
        </div>
    </div>
    <input type="hidden" name="status" id="status">

</form>
<!-- script type="text/javascript" src="js/estudio.js"></script>
<!-- buscar como cambiar esta incluision de script -->