<?php 
	include_once "header.php";
?>
    <div class="col-sm-9 col-sm-offset-3 col-sm-10 col-md-offset-2 main" id="contenedor">
    	<div class="row">
    		<div class="col-sm-2" style="text-align:right">							
				<label class="control-label">Empleado</label>				
			</div>								
			<div class="col-sm-10">									
				<select id="cmbEmpleado" class="form-control">
					<option>Victor Alfonso</option>	
				</select>								
			</div>
    	</div>
 		<div class="container" style="margin-top:3px;">
 			<div id="calendar" style="width: 600px;"></div>
 		</div>
    </div>
	<script src='js/moment.min.js'></script>
	<script src='js/fullcalendar.min.js'></script>
    <script src='js/es.js'></script>
	<script type="text/javascript">
		$(document).ready(function(){
			sendRequest("POST","lib/consultas/servicio.php",false,"servicio=4",function(data){
		        	$("#cmbEmpleado").html(data);
		        });
			sendRequest("POST","lib/consultas/servicio.php",true,"servicio=6&idempleado="+$("#cmbEmpleado").val(),function(data){
		        	$("#calendar").html(data);
		        });
		});
	</script> 
<?php	
	include_once "footer.php";
?>