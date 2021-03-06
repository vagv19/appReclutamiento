<?php
header('Content-language: es');
	include_once 'cconexion.php';
	include_once("paginacion.php");
    include_once "HTMLObject.class.php";
    include_once('sql_generator.class.php');
	if($_REQUEST)
	{
		extract($_REQUEST);
		switch ($servicio) {
			case '0':
				# login
			break;
			case '1':
				$sql="select folio,nombre as \"Candidato\",observaciones,\"Empleado Cita\",horario,descripcion as \"Tipo Cita\",asistio from vercita where status = 1 and fecha = '$fecha'";
				$cnx = new conexion();
				echo $cnx->returnTabla($sql,false,false,"","","",true);
			break;
			case '2':
				$sql ="select * from informacioncandidato where idcandidato =$id";
				$cnx = new conexion();
				$rs = $cnx->returnRS($sql);
				$resultado ="";
				while($r = $rs->FetchRow())
				{	
					$resultado .= '<div class="row" style="margin-top:3px;">
										<div class="col-sm-2">								
											<img src="img/'.$r[1].'.jpg" width="100px" height="auto">				
										</div>							
										<div class="col-sm-10" >								
											<div class="row"> 
											<div class="col-sm-2" style="text-align:right">						
												<label class="control-label">Folio</label>
											</div>								
											<div class="col-sm-10" >									
												<label id="lblFolio">'.$r[1].'</label>								
											</div>
											</div>	
											<div class="row">							
												<div class="col-sm-2" style="text-align:right">							
													<label class="control-label">Nombre</label>							
												</div>								
												<div class="col-sm-10">									
													<label id="lblNombre">'.$r[2].'</label>								
												</div>
											</div>	
											<div class="row">
												<div class="col-sm-2" style="text-align:right">							
													<label class="control-label">Tipo Entrev</label>				
												</div>								
												<div class="col-sm-10">									
													<select id="cmbTipoEntrevista" class="form-control">
														<option value="1">Examen</option>
														<option value="2">Entrevista</option>
													</select>								
												</div>
											</div>
											<div class="row" style="margin-top:3px;">
												<div class="col-sm-2" style="text-align:right">							
													<label class="control-label">Empleado</label>				
												</div>								
												<div class="col-sm-10">									
													<select id="cmbEmpleado" class="form-control">
														
													</select>								
												</div>
											</div>
											<div class="row" style="margin-top:3px;">	
												<div class="col-sm-2" style="text-align:right">							
													<label class="control-label">Horario</label>				
												</div>								
												<div class="col-sm-10">									
													<select id="cmbHorario" class="form-control">
														
													</select>								
												</div>
											</div>		
											<div class="col-sm-12" style="margin-top:3px;padding-top:3px;"><button type="button" class="btn btn-primary pull-right" data-idcandidato="'.$r[0].'">Guardar</button></div>					
										</div>
									</div>';
				}
				echo "$resultado";				
			break;
			case '3':
				$cnx = new conexion();
					$paginacion = new pagination();
					if(!isset($nombre))
					{
						$nombre ="";
					}
						$sqlCount = "select count(idcandidato) from informacioncandidato where nombre like '%$nombre%'";
						$sql = "select idcandidato,folio,nombre,edad from informacioncandidato where upper(nombre) like upper('%$nombre%')";
					
					if(isset($page))
						$paginacion->inicializar($sql,$sqlCount,4,$page,3);
					else
						$paginacion->inicializar($sql,$sqlCount,4,0,3);
					echo $paginacion->crearTablaPaginacion(true,"Seleccionar","seleccionar(this,$servicio)",false,false,true);
			break;
			case '4':
				$sql = "select idempleado as id, nombre as descripcion from empleado where status=1 and idempleado >0";
				$cnx = new conexion();
				echo $cnx->crearOption($sql);
			break;
			case '5':
				$sql = "select horario.idhorario as id,horario.horario as descripcion
from empleadohorario
inner join horario on empleadohorario.idhorario = horario.idhorario
where idempleado = $idempleado";
				$cnx = new conexion();
				echo $cnx->crearOption($sql);
			break;
			case '6':
				# construir calendario examenes psicometricos
				if(isset($fecha))
				{
					$fecha = date_parse($fecha);
					echo ($fecha['day']).'/'.$fecha['month'].'/'.$fecha['year'];
				}
				else
					{
						$fecha = getdate();
						$fecha = date_parse(($fecha['mday']-2).'-'.$fecha['mon'].'-'.$fecha['year']);
					}
				$calendario ='';
				$cnx = new conexion();
				$rs = $cnx->returnRS('select idhorario, horario from horario where idhorario >0 and status =1 order by idhorario');
				$days = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");
				$fechas = array();
				if($rs != null)
				{
					$calendario="<table id=\"tabla\" class=\"table table-condensed table-hover table-bordered  \" style='font-size:12px;margin-top:5px;'><thead><tr><td>Horario</td>";
					for ($i=0; $i < 7; $i++) { 
							$calendario .= "<td><b>".$days[$i]."</b><br/>".($fecha['day']+$i).'/'.$fecha['month'].'/'.$fecha['year']."</td>";
							$fechas[] = ($fecha['day']+$i).'/'.$fecha['month'].'/'.$fecha['year'];
						}	
					$calendario.="</tr></thead><tbody>";					
					while ($r = $rs->FetchRow()) {						
						$calendario .= '<tr>';
						$contador = 0;
						for ($i=0; $i < 8 ; $i++) { 
							if($i == 0)
							{
								$calendario .= '<td>'.$r[1].'</td>';
							}
							else								
							{
								
									$sql ="select * from horarioempleado where idempleado = $idempleado and iddia=($contador) and idhorario = $r[0]";
									$rsHorarioEmpleadoCita =$cnx->returnRS($sql);
									if($rsHorarioEmpleadoCita != null)
										{
											if($rsHorarioEmpleadoCita->Fields("status") == 1)
												{
													$rsHoraOcupada = $cnx->returnRS('select * from vercita where fecha = \''.$fechas[$contador].'\' and idhorario = '.$r[0].' and idempleadocita ='. $idempleado);
													if($rsHoraOcupada != null)
														$calendario .= '<td data-status="ocupado" data-folioCitado="'.$rsHoraOcupada->Fields("folio").'" class="success"></td>';
													else
														$calendario .= '<td data-status="disponible" class="info" data-fecha="'.$fechas[$contador].'" data-horario="'.$r[0].'" data-clicked="false"></td>';
												}
											elseif($contador == 0)
												$calendario .= '<td data-status="bloqueado" style="background-color:rgb(250, 255, 189)"></td>';
											elseif($r[0]>= 10 && $r[0] < 14)
												$calendario .= '<td data-status="bloqueado" style="background-color:rgb(250, 255, 189)"></td>';
											else	
												$calendario .= '<td data-status="bloqueado" class=""></td>';
										}
										else
											$calendario .= '<td data-status="bloqueado" style="background-color:rgb(250, 255, 189)"></td>';
											$contador++;
								
							}	
						}
						$calendario .= '</tr>';
					}
					$calendario.="</tbody></table>";
					echo "<div class='col-sm-6'><button class='btn btn-default' data-fechaAnterior='$fechas[0]'>Anterior</button></div><div class='col-sm-6'><button class='btn btn-default pull-right' data-fechaSiguiente='".date('Y-m-d', strtotime(strtotime($fechas[6]).'+1 day' ))."'>Siguiente</button></div>$calendario";
				}
			break;
			case '7':
				$sql = "select * from informacioncandidato where folio = '$folio'";
				$cnx = new conexion();
				echo $cnx->returnTabla($sql,false,false,"","","",true);
			break;
			case '8':
				$tipoentrevista = $idempleado == 100 ? '1':'2';
				$idcita='(select coalesce(max(idcita)+1,1) from cita)';
				$sql ="insert into cita values($idcita,'$fecha',$idempleado,0,'',0,$idcandidato,$idhorario,$tipoentrevista,1)";
				$cnx = new conexion();
				echo $cnx->consultaAccion($sql);
			break;
			case '9':
				$sql = "select folio,nombre from $tabla";
				$cnx = new conexion();
				echo $cnx->crearDropDownItem($sql);
			break;
			case '10':
				$sql ="select idcolonia as id,descripcion from colonia where codigopostal like '%$codigopostal%'";
				$cnx = new conexion();
				echo $cnx->crearOption($sql);
			break;
			case '11':
				switch ($accion) {
					case '1':
						$fecha = getdate();
						$strfecha = $fecha['year']."-".($fecha['mon'] <10 ? '0'.$fecha['mon']:$fecha['mon'])."-".$fecha['mday'];
						$chkDisponibilidadTurnos = isset($chkDisponibilidadTurnos)== true ? $chkDisponibilidadTurnos :"0" ;
						$chkDisponibilidadViajar = isset($chkDisponibilidadViajar) ==true ? $chkDisponibilidadViajar : "0";
						$chkDisponibilidadMudanza = isset($chkDisponibilidadMudanza) == true ? $chkDisponibilidadMudanza : "0";
						$cnx = new conexion();
						$sql = "select insertcandidato(upper('$txtNombre'),upper('$txtApellidoPaterno'),upper('$txtApellidoMaterno'),upper('$txtDireccion'),'$txtTelefono','$txtCelular',upper('$txtEmail'),$txtEstatura,$txtPeso,upper('$txtRfc'),upper('$txtCurp'),upper('$txtNoSeguridadSocial'),upper('$txtCartillaMilitar'),$cmbEstadoCivil,".$chkDisponibilidadViajar .",".$chkDisponibilidadTurnos .",".$chkDisponibilidadMudanza.",'$txtFechaNacimiento',upper('$txtLugarNacimiento'),$cmbSexo,upper('$txtLugarProcedencia'),0,16,$cmbColonia)";
						$rs = $cnx->executeNonQuery($sql);	
						if($rs == -1)
						{
							$rs = $cnx->returnRS("select idcandidato from candidato where upper(rfc)=upper('$txtRfc') and upper(curp) = upper('$txtCurp')");
							if($rs != null)
							{
								echo '{"codigo":"3","mensaje":"El candidato ya existe en el REC","idcandidato":"'.$rs->Fields(0).'"}';
							}
						}
						else{
							echo '{"codigo":"1","mensaje":"El candidato se ha Guardado Correctamente","idcandidato":"'.$rs.'"}';
						}
					break;
					case '2':
						# update code...
						$fecha = getdate();
						$strfecha = $fecha['year']."-".($fecha['mon'] <10 ? '0'.$fecha['mon']:$fecha['mon'])."-".$fecha['mday'];
						$chkDisponibilidadTurnos = isset($chkDisponibilidadTurnos)== true ? $chkDisponibilidadTurnos :"0" ;
						$chkDisponibilidadViajar = isset($chkDisponibilidadViajar) ==true ? $chkDisponibilidadViajar : "0";
						$chkDisponibilidadMudanza = isset($chkDisponibilidadMudanza) == true ? $chkDisponibilidadMudanza : "0";
						$cnx = new conexion();
						$sql = "update candidato set nombre=upper('$txtNombre'),apellidopaterno=upper('$txtApellidoPaterno'),apellidomaterno=upper('$txtApellidoMaterno'),direccion=upper('$txtDireccion'),telefono='$txtTelefono',celular='$txtCelular',email=upper('$txtEmail'),estatura=$txtEstatura,peso=$txtPeso,rfc=upper('$txtRfc'),curp=upper('$txtCurp'),imss=upper('$txtNoSeguridadSocial'),cartillamilitar=upper('$txtCartillaMilitar'),estadocivil=$cmbEstadoCivil,disponibilidadviajar=$chkDisponibilidadViajar,disponibilidadturnos=$chkDisponibilidadTurnos,disponibilidadmudanza=$chkDisponibilidadMudanza,\"fechaNacimiento\"='$txtFechaNacimiento',lugarnacimiento=upper('$txtLugarNacimiento'),sexo=$cmbSexo,lugarprocedencia=upper('$txtLugarProcedencia'),idempleado=0,\"fechaActualizacion\"=localtimestamp(2),idcolonia=$cmbColonia where idcandidato = $idCandidato";
						if ($cnx->consultaAccion($sql) =='1') {
							echo '{"codigo":"1","fecha":"'.$strfecha.'","mensaje":"El candidato se ha Actualizado Correctamente"}';
						} else {
							# code...
							echo '{"codigo":"2","mensaje":"Error al tratar de Actualizar la informacion del candidato"}';
						}
					break;
					case '3':
						# delete/reactivate code...
						$fecha = getdate();
						$strfecha = $fecha['year']."-".($fecha['mon'] <10 ? '0'.$fecha['mon']:$fecha['mon'])."-".$fecha['mday'];
						$sql = "update candidato set status = $status, \"fechaActualizacion\"='".$strfecha."' where idcandidato = $idcandidato";
						$cnx = new conexion();
						if ($cnx->consultaAccion($sql) =='1') {
							$str = ($status =='1' ? 'Reactivado' : 'Eliminado');
							echo '{"codigo":"1","fecha":"'.$strfecha.'","mensaje":"El candidato se ha '.$str.' Correctamente"}';
						} else {
							# code...
							$str = ($status =='1' ? 'Reactivar' : 'Eliminar' );
							echo '{"codigo":"2","mensaje":"Error al tratar de '.$str.'"}';
						}
						
					break;
					case '4':
						# search code...
						$sql = "select idcandidato,folio,nombrecompleto \"Nombre Completo\",edad from viewcandidato where upper($campo) like('%'||upper('$value')||'%') order by folio";
						$cnx = new conexion();
						echo $cnx->returnTabla($sql,false,false,"","",false,true);
					break;
					case '5':
						# info code...
						$sql = "select * from viewcandidato where idcandidato=".$idcandidato;
						$cnx = new conexion();
						echo $cnx->returnJSON($sql);
					break;
					default:
						# code...
					break;
				}
			break;
			case '12':
				$sql = "select idestadocivil as id, descripcion from $tabla";
				$cnx = new conexion();
				echo $cnx->crearOption($sql);
			break;
			case '13':
				$sql = "select idcolonia as id, descripcion from colonia where idcolonia=$idcolonia";
				$cnx = new conexion();
				echo $cnx->crearOption($sql);
			break;
			case '14':
				$campos = (isset($campos) && $campos !="") ? $campos : '*' ;
				$sql = 'select '.$campos.' from '.$tabla.' where idcandidato='.$idcandidato;
				$cnx = new conexion();
				echo $cnx->returnTablaEdicion($sql,$tabla);
			break;
			case '15':
				# code...
				$htmlObject = '';
				$cnx = new conexion();
				$rs ="";
				if(isset($id))
				{
					$sql ="select * from $tabla where $campo=$id and status=1";
					$rs = $cnx->returnRS($sql);
				}
				$htmlObject = '<form id="frm'.$tabla.'" class="form-horizontal" role="form">';
				$r =null;
				$campo = (isset($campo)) ? $campo : "";
				if(!isset($rs))
				{
					$rs = "";
				}
				if ($rs !== null && $rs !== "") {
					$r = $rs->FetchRow();
				}			
				$htmlObject .= '<input type="hidden" id="'.$campo.'" name="'.$campo.'" value="'. $r['idantecedentelaboral']  .'"/>';
				$htmlObject .= '<div class="form-group">
			<label for="cmbEmpresa" class="col-sm-4 control-label">Empresa</label>
				<div class="col-sm-5">
					<select id="cmbEmpresa" name="cmbEmpresa" class="form-control">
					'.$cnx->crearOption('select idempresa as id,descripcion from empresa',$r['idempresa']).'
					</select>
				</div>
				<div class="col-sm-2">
					<button type="button" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button>
				</div>
		</div>
		<div class="form-group">
			<label for="cmbPuesto" class="col-sm-4 control-label">Puesto</label>
				<div class="col-sm-7">
					<select id="cmbPuesto" name="cmbPuesto" class="form-control">
					'.$cnx->crearOption('select idpuesto as id,descripcion from puesto',$r['idpuesto']).'
					</select>
				</div>
		</div>
		<div class="form-group">
			<label for="txtJefe" class="col-sm-4 control-label">Jefe</label>
				<div class="col-sm-7">
					<input type="text" class="form-control" id="txtJefe" data-required="false"  name="txtJefe" value="'.$r['jefe'].'" placeholder="Jefe">
				</div>
		</div>
		<div class="form-group">
			<label for="txtContacto" class="col-sm-4 control-label">Contacto</label>
				<div class="col-sm-7">
					<input type="text" class="form-control" id="txtContacto" data-required="false"  name="txtContacto" value="'.$r['numerocontacto'].'" placeholder="Contacto">
				</div>
		</div>
		<div class="form-group">
			<label for="txtPersonasCargo" class="col-sm-4 control-label">Personas Cargo</label>
				<div class="col-sm-7">
					<input type="text" class="form-control" id="txtPersonasCargo" data-required="false"  name="txtPersonasCargo" value="'.$r['personascargo'].'" placeholder="Personas Cargo">
				</div>
		</div>
		<div class="form-group">
			<label for="txtSueldo" class="col-sm-4 control-label">Sueldo</label>
				<div class="col-sm-7">
					<input type="text" class="form-control" id="txtSueldo" data-required="false"  name="txtSueldo" value="'.$r['sueldo'].'" placeholder="Sueldo">
				</div>
		</div>
		<div class="form-group">
			<label for="txtFechaInicio" class="col-sm-4 control-label">Fecha Inicio</label>
				<div class="col-sm-7">
					<input type="text" class="form-control" id="txtFechaInicio" data-required="false"  name="txtFechaInicio" data-date-language="es" value="'.$r['fechainicio'].'" placeholder="Fecha Inicio">
				</div>
		</div>
		<div class="form-group">
			<label for="txtFechaFin" class="col-sm-4 control-label">Fecha Fin</label>
				<div class="col-sm-7">
					<input type="text" class="form-control" id="txtFechaFin" data-required="false"  name="txtFechaFin" data-date-language="es" value="'.$r['fechafin'].'" placeholder="Fecha Fin">
				</div>
		</div>
		<div class="form-group">
			<label for="cmbMotivoSeparacion" class="col-sm-4 control-label">MotivoSeparacion</label>
				<div class="col-sm-7">
					<select id="cmbMotivoSeparacion" name="cmbMotivoSeparacion" class="form-control">
					'.$cnx->crearOption('select idmotivoseparacion as id,descripcion from motivoseparacion',$r['idmotivoseparacion']).'
					</select>
				</div>
		</div></form>
		';		
		echo $htmlObject;		
			break;
			case '16':
				$htmlObject = '';
				$cnx = new conexion();
				$rs ="";
				if (isset($id)) {
					$sql ="select * from $tabla where $campo=$id and status=1";
					$rs = $cnx->returnRS($sql);
				}
				$r =null;
				if ($rs != null && $rs !== "") {
					$r = $rs->FetchRow();
				}
				$htmlObject = '<form id="frm'.$tabla.'" class="form-horizontal" role="form">';
				$htmlObject .= '<input type="hidden" name="idcandidatoareainteres" value="'.$r['idcandidatoareainteres'].'" />';
				$htmlObject .= '<div class="form-group">
			<label for="cmbAreaInteres" class="col-sm-4 control-label">Areas de Interes</label>
				<div class="col-sm-7">
					<select id="cmbAreaInteres" name="cmbAreaInteres" class="form-control">
					'.$cnx->crearOption('select idareainteres as id,descripcion from areainteres',$r['idareainteres']).'
					</select>
				</div>
		</div></form>';	
			echo $htmlObject;			
			break;
			case '17':
				# code...
				switch ($accion) {
					case 'update':
						$sql = "update $tabla set fechainicio='$txtFechaInicio',".(($txtFechaFin !='') ? "fechafin='$txtFechaFin'," : "")."personascargo=$txtPersonasCargo,sueldo=$txtSueldo,idempresa=$cmbEmpresa,idpuesto=$cmbPuesto,idmotivoseparacion=$cmbMotivoSeparacion,jefe='$txtJefe',numerocontacto='$txtContacto' where idantecedentelaboral=$idantecedentelaboral";
					break;
					case 'insert':
						$idantecedentelaboral = '(select coalesce(max(idantecedentelaboral)+1,1) from antecedentelaboral)';
						$sql = "insert into antecedentelaboral(idantecedentelaboral,fechainicio,".(($txtFechaFin !='') ? "fechafin," : "")."personascargo,sueldo,idcandidato,idempresa,idpuesto,idmotivoseparacion,jefe,numerocontacto,status) values($idantecedentelaboral,'$txtFechaInicio',".(($txtFechaFin !='') ? "'".$txtFechaFin."'," : "")."$txtPersonasCargo,$txtSueldo,1,$cmbEmpresa,$cmbPuesto,$cmbMotivoSeparacion,'$txtJefe','$txtContacto',1)";
					break;						
					default:
						die('{"codigo":"3","mensaje":"No tienes permiso de Estar Aqui"}');
						break;
				}
				
				execQuery($sql);
			break;
			case '18':
				$sql = "update $tabla set status=0 where idantecedentelaboral = $id";

				execQuery($sql);
			break;
			case '19':
				switch ($accion) {
					case 'insert':
						$idcandidatoareainteres = "(select coalesce(max(idcandidatoareainteres)+1,1) from candidatoareainteres)";
						$sql ="insert into candidatoareainteres values($idcandidatoareainteres,1,$cmbAreaInteres,1)";
					break;
					case 'update':
						$sql ="update candidatoareainteres set idareainteres=$cmbAreaInteres where idcandidatoareainteres = $idcandidatoareainteres";
					break;
					default:
						die('{"codigo":"3","mensaje":"No tienes permiso de Estar Aqui"}');
					break;
				}
				
				execQuery($sql);
			break;
			case '20':
				$sql = "update $tabla set status = 0 where idareainteres = $id";
				
				execQuery($sql);
			break;
			case '21':
				# conocimientocandidato code...
				$htmlObject = '';
				$cnx = new conexion();
				$rs ="";
				if(isset($id))
				{
					$sql ="select * from $tabla where $campo=$id and status=1";
					$rs = $cnx->returnRS($sql);
				}
				$htmlObject = '<form id="frm'.$tabla.'" class="form-horizontal" role="form">';
				$r =null;
				$campo = (isset($campo)) ? $campo : "";
				if(!isset($rs))
				{
					$rs = "";
				}
				if ($rs !== null && $rs !== "") {
					$r = $rs->FetchRow();
				}
				$htmlObject .= '<input type="hidden" id="'.$campo.'" name="'.$campo.'" value="'. $r['idcandidatoconocimiento']  .'"/>';
				$htmlObject .= '<div class="form-group">
			<label for="cmbConocimiento" class="col-sm-4 control-label">Conocimiento</label>
				<div class="col-sm-7">
					<select id="cmbConocimiento" name="cmbConocimiento" class="form-control">
					'.$cnx->crearOption('select idconocimiento as id,descripcion from conocimiento',$r['idconocimiento']).'
					</select>
				</div>
		</div></form>';	
			echo $htmlObject;		
			break;
			case '22':
				switch ($accion) {
					case 'update':
						$sql = "update candidatoconocimiento set idconocimiento = $cmbConocimiento where idcandidatoconocimiento = $idcandidatoconocimiento";
					break;
					case 'insert':
						$idcandidatoconocimiento = "(select coalesce(max(idcandidatoconocimiento)+1,1) from candidatoconocimiento)";
						$sql = "insert into candidatoconocimiento values($idcandidatoconocimiento,1,$cmbConocimiento,1)";
					break;
					case 'delete' :
						$sql = "update candidatoconocimiento set status = 0 where idcandidatoconocimiento = $id";
					break;	
					default:
						# code...
					break;
				}
				execQuery($sql);
			break;
			case '23':
				# code...
			$htmlObject = '';
				$cnx = new conexion();
				$rs ="";
				if(isset($id))
				{
					$sql ="select * from $tabla where $campo=$id and status=1";
					$rs = $cnx->returnRS($sql);
				}
				$htmlObject = '<form id="frm'.$tabla.'" class="form-horizontal" role="form">';
				$r =null;
				$campo = (isset($campo)) ? $campo : "";
				if(!isset($rs))
				{
					$rs = "";
				}
				if ($rs !== null && $rs !== "") {
					$r = $rs->FetchRow();
				}
				$htmlObject .= '<input type="hidden" id="'.$campo.'" name="'.$campo.'" value="'. $r['idcandidatocurso']  .'"/>';
				$htmlObject .= '<div class="form-group">
			<label for="cmbCurso" class="col-sm-4 control-label">Curso</label>
				<div class="col-sm-7">
					<select id="cmbCurso" name="cmbCurso" class="form-control">
					'.$cnx->crearOption('select idcurso as id,descripcion from curso',$r['idcurso']).'
					</select>
				</div>
		</div></form>';	
			echo $htmlObject;
			break;
            case '24':
                switch($accion)
                {
                    case 'update':
                        $sql = "update candidatocurso set idcurso= $cmbCurso 
                        where idcandidatocurso = $idcandidatocurso ";
                    break;
                    case 'insert':
                        $idcandidatocurso = "(select coalesce(max(idcandidatocurso)+1,1) from 
                        candidatocurso)";
                        $sql = "insert into candidatocurso values($idcandidatocurso,1,$cmbCurso,1)";
                    break;
                    case 'delete':
                        $sql = "update candidatocurso set status=0 where idcandidatocurso=$id";
                    break;
                }
                execQuery($sql);
            break;
            case '25':
                # code...
			$htmlObject = '';
				$cnx = new conexion();
				$rs ="";
				if(isset($id))
				{
					$sql ="select * from entrevista where $campo=$id and status=1";
					$rs = $cnx->returnRS($sql);
				}
				$htmlObject = '<form id="frm'.$tabla.'" class="form-horizontal" role="form">';
				$r =null;
				$campo = (isset($campo)) ? $campo : "";
				if(!isset($rs))
				{
					$rs = "";
				}
				if ($rs !== null && $rs !== "") {
					$r = $rs->FetchRow();
				}
				$htmlObject .= '<input type="hidden" id="'.$campo.'" name="'.$campo.'" value="'. $r['identrevista']  .'"/>';
				$htmlObject .= '<div class="form-group">
			<label for="txtFecha" class="col-sm-4 control-label">Fecha</label>
				<div class="col-sm-7">
					<input type="text" class="form-control" id="txtFecha" data-required="false"  name="txtFecha" data-date-language="es" value="'.$r['fecha'].'" placeholder="Fecha">
				</div>
		</div>';
            $htmlObject .= '<div class="form-group">
			<label for="cmbPresentacion" class="col-sm-4 control-label">Presentacion</label>
				<div class="col-sm-7">
					<select id="cmbPresentacion" name="cmbPresentacion" class="form-control">
					'.$cnx->crearOption('select idPresentacion as id,descripcion from presentacion',$r['idpresentacion']).'
					</select>
				</div>
		</div>';
            $htmlObject .= '<div class="form-group">
			<label for="txtlogros" class="col-sm-4 control-label">Logros</label>
				<div class="col-sm-7">
					<input type="text" class="form-control" id="txtlogros" data-required="false"  name="txtlogros" data-date-language="es" value="'.$r['logros'].'" placeholder="logros">
				</div>
		</div>';
            $htmlObject .= '<div class="form-group">
			<label for="txtObservaciones" class="col-sm-4 control-label">observaciones</label>
				<div class="col-sm-7">
					<input type="text" class="form-control" id="txtObservaciones" data-required="false"  name="txtObservaciones" data-date-language="es" value="'.$r['observaciones'].'" placeholder="observaciones">
				</div>
		</div>';
            $htmlObject .= '<div class="form-group">
			<label for="cmbTipoEntrevista" class="col-sm-4 control-label">Tipo Entrevista</label>
				<div class="col-sm-7">
					<select id="cmbTipoEntrevista" name="cmbTipoEntrevista" class="form-control">
					'.$cnx->crearOption('select idtipoentrevista as id,descripcion from tipoentrevista',$r['idtipoentrevista']).'
					</select>
				</div>
		</div>';
              $htmlObject .= '<div class="form-group">
			<label for="cmbDimension" class="col-sm-4 control-label">Dimension</label>
				<div class="col-sm-7">
					<select id="cmbDimension" name="cmbDimension" class="form-control">
					'.$cnx->crearOption('select dimension.iddimension as id,dimension as descripcion from dimension inner join tipoentrevistadimension on tipoentrevistadimension.iddimension=dimension.iddimension where idtipoentrevista=1').'
					</select>
				</div>
		</div>';
              $htmlObject .= '<div class="form-group">
			<label for="cmbResultado" class="col-sm-4 control-label">Resultado</label>
				<div class="col-sm-7">
					<select id="cmbResultado" name="cmbResultado" class="form-control">
					'.$cnx->crearOption('select idresultado as id,resultado as descripcion from resultado where idresultado between 1 and 4 and status=1').'
					</select>
				</div>
		</div>';
            $htmlObject .= "</form>";
            echo $htmlObject;
            break;
            case '26':
                if(isset($campowhere))
				    $sql = "select $campos from $tabla where $campowhere = $valorwhere ";
				else    
                    $sql = "select $campos from $tabla";
                $cnx = new conexion();
				echo $cnx->crearOption($sql);
			break;
            case '27':
                if($accion == 'insert')
                {
                    $identrevista = "(select coalesce(max(identrevista)+1,1) from entrevista)";
                    $sql = "insert into entrevista values($identrevista,'$txtFecha','$txtObservaciones',1,0,$cmbPresentacion,1,'$txtLogros',$cmbTipoEntrevista)returning                               identrevista;";
                    $cnx = new conexion();
                    $r = $cnx->executeNonQuery($sql);
                    if($r)
                    {
                        echo '{"codigo":"1","mensaje":"Datos Actualizados correctamente","id":"'.$r.'"}';
                    }
                    else
                    {
                        echo '{"codigo":"2","mensaje":"Hubo un error al tratar de realizar la consulta"}';		
                    }
                }
                else
                {
                    $sql = "update entrevista set fecha='$txtFecha',observaciones='$txtObservaciones',idpresentacion=$cmbPresentacion,logros='$txtLogros',idtipoentrevista=$cmbTipoEntrevista where identrevista=$idEntrevista";
                    execQuery($sql);
                }                
                
            break;
            case '28':
                $cnx = new conexion();
                $idtipoentrevista = "(select idtipoentrevista from entrevista where identrevista=$identrevista)";
                $htmlObject = '<form id="frmEntrevistaDimension" class="form-horizontal" role="form" >
                    <input type="hidden" id="identrevista" name="identrevista" value="'.$identrevista.'" />
                    <div class="form-group">
                        <label for="cmbDimension" class="col-sm-2 control-label">Dimension</label>
                        <div class="col-sm-7">
                            <select id="cmbDimension" name="cmbDimension" class="form-control">
                                '.$cnx->crearOption('select dimension.iddimension as id,dimension as descripcion from dimension inner join tipoentrevistadimension on tipoentrevistadimension.iddimension=dimension.iddimension where idtipoentrevista='.$idtipoentrevista).'
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cmbResultado" class="col-sm-2 control-label">Resultado</label>
                        <div class="col-sm-7">
                            <select id="cmbResultado" name="cmbResultado" class="form-control">
                                '.$cnx->crearOption('select idresultado as id,resultado as descripcion from resultado where idresultado between 1 and 4 and status=1').'
					        </select>
                        </div>
                    </div>
                    <button type="button" id="btnAgregarDimensionEntrevista" class="btn btn-default">Agregar <i class="glyphicon glyphicon-plus-sign"></i></button>
                </form>
                <div id="entrevistaContainer">
                
                </div>';
                echo $htmlObject;
            break;
            case '29':
                $cnx = new conexion();
                $sql = "select * from entrevistadimension where identrevista=$identrevista and iddimension=$cmbDimension";
                $rs = $cnx->returnRS($sql);
                if($rs !== null)
                {
                    $sql = "update entrevistadimension set idresultado= $cmbResultado where identrevista= $identrevista and iddimension= $cmbDimension";                    
                }
                else
                {
                    $identrevistadimension = '(select coalesce(max(identrevistadimension)+1,1) from entrevistadimension)';
                    $sql = "insert into entrevistadimension values($identrevistadimension,$identrevista,$cmbDimension,$cmbResultado)";
                }
                execQuery($sql);
            break;
            case '30':
                $sql = 'select dimension,resultado from dimensionresultado where identrevista = '.$identrevista;
                $cnx = new conexion();
				echo $cnx->returnTabla($sql);
            break;
            case '31':
                $sql = 'select * from entrevista where idcandidato=1 and identrevista=(select max(identrevista) from entrevista where status=1)';
                $cnx = new conexion();
                echo $cnx->returnJSON($sql);
            break;
            case '32':
                $sql = 'select identrevistadimension,dimension,resultado from dimensionresultado where identrevista ='.$identrevista;
                $cnx = new conexion();
                echo $cnx->returnTablaEdicion($sql,'entrevistadimension');
            break;
            case '33':
                $file = file_get_contents("../../estudio.php"); #include_once ;
                echo $file;
            break;
            case '34':
                $chkTitulo = isset($chkTitulo)==true?$chkTitulo:'0';
                switch($accion)
                {
                    case 'insert':
                        $idestudio = '(select coalesce(max(idestudio)+1,1) from estudio)';
                        $sql = "insert into estudio values($idestudio,'$txtFechaInicio','$txtFechaFin',$txtGrado,$cmbCicloEscolar,$cmbCarrera,$cmbInstitucion,'$chkTitulo','$txtCedulaProfesional',1,1,$txtPromedio);";
                    break;
                    case 'delete':
                        $sql = "update estudio set status =0 where idestudio = $id";
                    break;
                    case 'update':
                            $sql = "update estudio set fechainicio='$txtFechaInicio',fechafin='$txtFechaFin',grado=$txtGrado,idcicloescolar=$cmbCicloEscolar,idcarrera=$cmbCarrera,idinstitucion=$cmbInstitucion,titulo=$chkTitulo,cedulaprofesional='$txtCedulaProfesional',promedio=$txtPromedio where idestudio=$idestudio";
                    break;
                }
            execQuery($sql);
            break;
            case '35':
                 $cnx = new conexion();
                 $tabcontent = "";
                 $sql = 'select * from viewcicloescolarmasusado';
                 $tab = '<ul class="nav nav-tabs">';
                 $tab .= '<li class="active"><a data-toggle="tab" href="#masUsadas">Mas Usadas</a></li>';
                 $tab .= '<li><a data-toggle="tab" href="#buscarPorNombre">Buscar <i class="glyphicon glyphicon-search"></i></a></li>';                 
                 $tab .= '</ul>';
                 $tabcontent .= '<div class="tab-content" style="margin-top:20px">';
                 $tabcontent .= '<div id="masUsadas" class="tab-pane fade in active">'.$cnx->returnListGroup($sql,"cmbCicloEscolar").'</div>';
                 $tabcontent .= '<div id="buscarPorNombre" class="tab-pane fade">
                            <div class="container">
                            <div class="col-sm-8 form-group">                                
                                    <label class="control-label col-sm-4">Buscar</label>
                                <div class="col-sm-8">
                                    <div class="input-group">                  
                                      <input id="txtBuscarCicloEscolar" type="text" class="form-control"/>
                                      <span class="input-group-btn">
                                        <button id="btnBuscarPorNombre" class="btn btn-default" type="button">
                                            <i class="glyphicon glyphicon-search"></i>  
                                        </button>
                                      </span>
                                    </div>
                                </div>
                                </div>
                                <div id="bsqResultado" class="col-sm-8"></div>
                            </div>             
                        </div>';
                 $tabcontent .= '</div>';
                 echo $tab.$tabcontent;    
            break;
            case '36':
                $sql = "select idcicloescolar, descripcion from cicloescolar where descripcion like upper('%$txtBuscarCicloEscolar%')";
                $cnx = new conexion();
                echo $cnx->returnListGroup($sql,"cmbCicloEscolar");
            break;
            case '37':
                   $cnx = new conexion();
                 $tabcontent = "";
                 $sql = 'select * from viewcarreramasusada';
                 $tab = '<ul class="nav nav-tabs">';
                 $tab .= '<li class="active"><a data-toggle="tab" href="#masUsadas">Mas Usadas</a></li>';
                 $tab .= '<li><a data-toggle="tab" href="#buscarPorNombre">Buscar <i class="glyphicon glyphicon-search"></i></a></li>';                 
                 $tab .= '</ul>';
                 $tabcontent .= '<div class="tab-content" style="margin-top:20px">';
                 $tabcontent .= '<div id="masUsadas" class="tab-pane fade in active">'.$cnx->returnListGroup($sql,"cmbCarrera").'</div>';
                 $tabcontent .= '<div id="buscarPorNombre" class="tab-pane fade">
                            <div class="container">
                            <div class="col-sm-8 form-group">                                
                                    <label class="control-label col-sm-4">Buscar</label>
                                <div class="col-sm-8">
                                    <div class="input-group">                  
                                      <input id="txtBuscarCarrera" type="text" class="form-control"/>
                                      <span class="input-group-btn">
                                        <button id="btnBuscarCarreraNombre" class="btn btn-default" type="button">
                                            <i class="glyphicon glyphicon-search"></i>  
                                        </button>
                                      </span>
                                    </div>
                                </div>
                                </div>
                                <div id="bsqResultado" class="col-sm-8"></div>
                            </div>             
                        </div>';
                 $tabcontent .= '</div>';
                 echo $tab.$tabcontent;  
            break;
            case '38':
                    $sql = "select idcarrera,descripcion from carrera where descripcion like upper('%$txtBuscarCarrera%')";
                    $cnx = new conexion();
                    echo $cnx->returnListGroup($sql,"cmbCarrera");
            break;
            case '39':
                 $cnx = new conexion();
                 $tabcontent = "";
                 $sql = 'select * from viewinstitucionmasusada';
                 $tab = '<ul class="nav nav-tabs">';
                 $tab .= '<li class="active"><a data-toggle="tab" href="#masUsadas">Mas Usadas</a></li>';
                 $tab .= '<li><a data-toggle="tab" href="#buscarPorNombre">Buscar <i class="glyphicon glyphicon-search"></i></a></li>';                 
                 $tab .= '</ul>';
                 $tabcontent .= '<div class="tab-content" style="margin-top:20px">';
                 $tabcontent .= '<div id="masUsadas" class="tab-pane fade in active">'.$cnx->returnListGroup($sql,"cmbInstitucion").'</div>';
                 $tabcontent .= '<div id="buscarPorNombre" class="tab-pane fade">
                            <div class="container">
                            <div class="col-sm-8 form-group">                                
                                    <label class="control-label col-sm-1" for="txtBuscarInstitucion">Buscar</label>
                                <div class="col-sm-8">
                                    <div class="input-group">                  
                                      <input id="txtBuscarInstitucion" type="text" class="form-control"/>
                                      <span class="input-group-btn">
                                        <button id="btnBuscarInstitucionNombre" class="btn btn-default" type="button">
                                            <i class="glyphicon glyphicon-search"></i>  
                                        </button>
                                      </span>
                                    </div>
                                </div>
                                </div>
                                <div id="bsqResultado" class="col-sm-8"></div>
                            </div>             
                        </div>';
                 $tabcontent .= '</div>';
                 echo $tab.$tabcontent;  
            break;
            case '40':
                    $sql = "select idinstitucion,descripcion from institucion where descripcion like upper('%$txtBuscarInstitucion%')";
                    $cnx = new conexion();
                    echo $cnx->returnListGroup($sql,"cmbInstitucion");
            break;
            case '41':
                    $sqlGen = new Sqlgen();
                    $sql = '';
                    switch($accion)
                    {
                        case 'delete':
                            $sql = 'update estudiosocioecfamiliar set status=0 where idestudiosocioecfamiliar='.$id;
                        break;
                        case 'insert':
                            $idestudiosocioecfamiliar = '(select coalesce(max(idestudiosocioecfamiliar)+1,1) from estudiosocioecfamiliar)';
                            $data = array('idestudiosocioecfamiliar'=>$idestudiosocioecfamiliar,'fecha'=>$txtFecha,'estructurafamiliar'=>trim($txtEstructuraFamiliar),'organizacionfamiliar'=>trim($txtOrganizacionFamiliar),'salud'=>trim($txtSalud),'alimentacion'=>trim($txtAlimentacion),'situacioneconomica'=>trim($txtSituacionEconomica),'vivienda'=>trim($txtVivienda),'religion'=>trim($txtReligion),'idempleado'=>'0','idcandidato'=>'1','observaciones'=>trim($txtObservaciones),'resultado'=>$cmbResultado);
                            $sql =  $sqlGen->insert($tabla,$data);
                        break;
                        case 'update':
                            $data = array('fecha'=>$txtFecha,'estructurafamiliar'=>trim($txtEstructuraFamiliar),'organizacionfamiliar'=>trim($txtOrganizacionFamiliar),'salud'=>trim($txtSalud),'alimentacion'=>trim($txtAlimentacion),'situacioneconomica'=>trim($txtSituacionEconomica),'vivienda'=>trim($txtVivienda),'religion'=>trim($txtReligion),'idempleado'=>'0','idcandidato'=>'1','observaciones'=>trim($txtObservaciones),'resultado'=>$cmbResultado);
                            $sql = $sqlGen->update($tabla,$data,array('idestudiosocioecfamiliar' => $idEstudioSocioEcFamiliar));
                        break;
                    }
                    echo execQuery($sql);
            break;
            case '42':
                $sql = 'select * from viewasignacionpractica where idcandidato='.$idcandidato.' and idpractica=(select max(idpractica) from practica where idcandidato='.$idcandidato.')';
                $cnx = new conexion();
                echo $cnx->returnJSON($sql);
            break;
            case '43':
                switch($accion)
                {
                    case 'asignarpracticante':
                            $idpractica = "(select coalesce(max(idpractica)+1,1) from practica)";
                            $numeroasignacion = "(select coalesce(max(numeroasignacion)+1,1) from practica where idcandidato=$idcandidato)";
                            $sql = "insert into practica(idpractica,fechainicio,fechafin,numeroficha,montoayuda,idencargado,idtipoestadia,idtipopoliza,iddepartamento,fechaterminopoliza,idempleado,idcandidato,numeroasignacion,fechaasignacion,prorroga)
                            values($idpractica,'$txtFechaInicio','$txtFechaFin',$txtNumeroFicha,$txtMontoAyuda,$cmbEncargado,$cmbTipoEstadia,$cmbTipoPoliza,$cmbDepartamento,'$txtFechaTerminoPoliza',$idempleado,$idcandidato,$numeroasignacion,localtimestamp(2),0)";        
                        execQuery($sql);
                    break;
                    case 'calificarpracticante':
                        #codigo calificacion
                    break;
                    case 'subirbp':
                        $sql = "select fnsubirbolsapractica( $idcandidato);";
                        $cnx = new conexion();
                        $r = $cnx->executeNonQuery($sql);
                        if($r == "1")
                        {
                            echo '{"codigo":"1","mensaje":"Datos Actualizados correctamente"}';
                        }
                        else
                        {
                            echo '{"codigo":"2","mensaje":"El candidato no cumple con el promedio requerido o no le ha sido capturado"}';		
                        }
                    break;
                    case 'versolicitudpendiente':
                        $sql= "select * from solicitudpendiente where idcandidato = $idcandidato";
                        $cnx = new conexion();
                        echo $cnx->returnJSON($sql);
                    break;
                }
            break;
            case '44':
                $cnx = new conexion();
                 $tabcontent = "";
                 $sql = 'select * from viewstatusestudiomasusado';
                 $tab = '<ul class="nav nav-tabs">';
                 $tab .= '<li class="active"><a data-toggle="tab" href="#masUsadas">Mas Usadas</a></li>';
                 $tab .= '<li><a data-toggle="tab" href="#buscarPorNombre">Buscar <i class="glyphicon glyphicon-search"></i></a></li>';                
                 $tab .= '</ul>';
                 $tabcontent .= '<div class="tab-content" style="margin-top:20px">';
                 $tabcontent .= '<div id="masUsadas" class="tab-pane fade in active">'.$cnx->returnListGroup($sql,"cmbEstadoEstudio").'</div>';
                 $tabcontent .= '<div id="buscarPorNombre" class="tab-pane fade">
                                    <div class="container">
                                        <div class="col-sm-8 form-group">                                
                                            <label class="control-label col-sm-1" for="txtBuscarEstadoEstudio">Buscar</label>
                                            <div class="col-sm-8">
                                                <div class="input-group">                  
                                                  <input id="txtBuscarEstadoEstudio" type="text" class="form-control"/>
                                                  <span class="input-group-btn">
                                                    <button id="btnBuscarEstadoEstudioNombre" class="btn btn-default" type="button">
                                                        <i class="glyphicon glyphicon-search"></i>  
                                                    </button>
                                                  </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="bsqResultado" class="col-sm-8"></div>
                                    </div>             
                                </div>';
                 $tabcontent .= '</div>';
                 echo $tab.$tabcontent; 
            break;
            case '45':
                $sql = "select idestatusestudio,descripcion from statusestudio where descripcion like upper('%$txtBuscarEstadoEstudio%')";
                $cnx = new conexion();
                echo $cnx->returnListGroup($sql,"cmbEstadoEstudio");
            break;
			default:                
				die("No estas autorizado para estar aqui");
			break;
		}
	}
function execQuery($sql)
{
    $cnx = new conexion();
    if($cnx->consultaAccion($sql)=="1")
    {
        echo '{"codigo":"1","mensaje":"Datos Actualizados correctamente"}';
    }
    else
    {
        echo '{"codigo":"2","mensaje":"Hubo un error al tratar de realizar la consulta"}';		
    }
}
?>