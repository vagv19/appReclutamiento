<?php
include_once dirname(__FILE__).("/lib/consultas/cconexion.php");
$cnx = new conexion();
if($_REQUEST)
{
    extract($_REQUEST);
    $sql= "select * from solicitudpendiente where idcandidato = $idcandidato";
    $rs = $cnx->returnRS($sql);
    $r = $rs->FetchRow();
}
else
    die('Acceso no autorizado');
?>
<form class="form-horizontal" role="form">
    <fieldset disabled>
         <div class="form-group">
        <label for='nombreproyecto' class='col-sm-2 control-label'>Nombre del Proyecto</label>
        <div class="col-sm-7">
            <input id="nombreproyecto" name="nombreproyecto" class="form-control"  type="text" data-type="alphanumeric" data-length="200" data-required="TRUE" value="<?php echo $r['nombreproyecto']; ?>" />
        </div>
    </div>
    <div class="form-group">
        <label for='meses' class='col-sm-2 control-label'>Duracion en meses</label>
        <div class="col-sm-7">
            <input id="meses" name="meses" class="form-control" type="text" data-type="numeric"  data-required="TRUE" value="<?php echo $r['meses']; ?>" />
        </div>
    </div>
    <div class="form-group">
        <label for='actividades' class='col-sm-2 control-label'>Actividades</label>
        <div class="col-sm-7">
            <textarea id="actividades" name="actividades" class="form-control"  type="text" data-type="alphanumeric"  data-required="TRUE" ><?php echo $r['actividades']; ?>
            </textarea>
        </div>
    </div>
    <div class="form-group">
        <label for='responsable' class='col-sm-2 control-label'>Responsable</label>
        <div class="col-sm-7">
            <input id="responsable" name="responsable" class="form-control"  type="text" data-type="alphanumeric" data-length="200" data-required="TRUE" value="<?php echo $r['responsable']; ?>" />
        </div>
    </div>
    <div class="form-group">
        <label for='direccion' class='col-sm-2 control-label'>Direccion</label>
        <div class="col-sm-7">
            <input id="direccion" name="direccion" class="form-control"  type="text" data-type="alphanumeric" data-length="200" data-required="TRUE" value="<?php echo $r['direccion']; ?>" />
        </div>
    </div>
    <div class="form-group">
        <label for='encargado' class='col-sm-2 control-label'>Encargado</label>
        <div class="col-sm-7">
            <input id="encargado" name="encargado" class="form-control"  type="text" data-type="alphanumeric" data-length="200" data-required="TRUE" value="<?php echo $r['encargado']; ?>" />
        </div>
    </div>
    <div class="form-group">
        <label for='correo' class='col-sm-2 control-label'>Correo</label>
        <div class="col-sm-7">
            <input id="correo" name="correo" class="form-control"  type="text" data-type="alphanumeric" data-length="200" data-required="TRUE" value="<?php echo $r['correo']; ?>" />
        </div>
    </div>
    <div class="form-group">
        <label for='descripcion' class='col-sm-2 control-label'>Descripcion</label>
        <div class="col-sm-7">
            <input id="descripcion" name="descripcion" class="form-control"  type="text" data-type="alphanumeric" data-length="200" data-required="TRUE" value="<?php echo $r['descripcion']; ?>" />
        </div>
    </div>
    </fieldset>
</form>