<?php
require_once("cconexion.php");
	
	
			if(isset($_REQUEST['serviciobuscar']))
			{
				$servicio=$_REQUEST['serviciobuscar'];
				$consulta ="SELECT * FROM busquedaservicio WHERE upper(servicio) LIKE upper('%".$servicio."%')";
			}
			elseif (isset($_REQUEST['id'])) {
				$id = $_REQUEST['id'];
				$consulta = "select * from busquedaservicio where iddepartamento =$id";
			}
			else
			$consulta ="SELECT * FROM busquedaservicio";
			$cnx = new conexion();
			$rs = $cnx->returnRS($consulta);
			$resultado='';
			$principio='';
			$listaservicio='';
			$fin='';
			$ficha='0';
			if($rs !== null)
			{
				while($row = $rs->FetchRow())
				{			
					if($row[0] != $ficha)
						{							
							$resultado.=$principio.$listaservicio.$fin;
							$fin = $listaservicio = $principio = '';
							$principio='<a href="#" class="list-group-item" >
							<h4 class="list-group-item-heading">'.htmlentities($row[1], ENT_COMPAT,'UTF-8', true).' </h4>
							<p class="list-group-item-text">
							<div class="row">
							<div class="col-sm-2">
							<img src="http://intranet.gan/rec_hum/foto/'.$row[0].'.jpg" height="88px" width="88px" />
							</div>
							<div class="col-sm-9">
							<div class="col-sm-2" style="text-align:right">
							Puesto:
							</div>
							<div class="col-sm-10">
							'.htmlentities($row[6], ENT_COMPAT,'UTF-8', true).'
							</div>
							<div class="col-sm-2" style="text-align:right">
							Correo:
							</div>
							<div class="col-sm-10">
							'.htmlentities($row[2], ENT_COMPAT,'UTF-8', true).'
							</div>
							<div class="col-sm-2" style="text-align:right">
							Extension:
							</div>
							<div class="col-sm-10">
							'.$row[3].'
							</div>
							Servicios que ofrece
							<ul>';
							$listaservicio='<li>
							'.htmlentities($row[4], ENT_COMPAT,'UTF-8', true).'
							</li>';
							
							$fin ='</ul>
							</div>
							<div class="col-sm-2 pull-right"><button data-id="'.$row[0].'" class="btn btn-info" onclick="mostrarUbicacion($(this).attr(\'data-id\'))">Ver Ubicacion</button></div>	
							</div>
							</p>
							</a>';
						}
					else if($ficha == $row[0]){
						$listaservicio.='<li>
						'.htmlentities($row[4], ENT_COMPAT,'UTF-8', true).'
						</li>';
					}
					$ficha = $row[0];	
				}
				$resultado.=$principio.$listaservicio.$fin;
				if($resultado !== '')
				echo $resultado;
				else
				echo "<p class='lead'>No Existen Resultados</p>";
			}
			else
				echo "<p class='lead'>No Existen Resultados</p>";
		

?>