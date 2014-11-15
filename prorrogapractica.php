<?php

?>
<form class="form-horizontal" role="form">
    <fieldset>
        <input type="hidden" name="idpractica" id="idpractica" />
        <div class="form-group">
            <label for='chkProrroga' class='col-sm-2 control-label'>Prorroga</label>
            <div class="col-sm-7">
                <input id="chkProrroga" name="chkProrroga" class="form-control" type="check" data-type="numeric"  data-required="TRUE" />
            </div>
        </div>
        <div class="form-group">
            <label for='txtNumeroProrrroga' class='col-sm-2 control-label'>Numero Prorroga</label>
            <div class="col-sm-7">
                <input id="txtNumeroProrrroga" name="txtNumeroProrrroga" class="form-control" type="text" data-type="numeric"  data-required="TRUE" />
            </div>
        </div>
        <div class="form-group">
            <label for='txtMesesExtender' class='col-sm-2 control-label'>Cantidad de meses a prorrogar</label>
            <div class="col-sm-7">
                <input id="txtMesesExtender" name="txtMesesExtender" class="form-control" type="text" data-type="numeric"  data-required="TRUE" />
            </div>
        </div>        
    </fieldset>
</form>