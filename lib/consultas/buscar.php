<?php
	require_once("cconexion.php");
	if($_REQUEST)
	{
		if($_REQUEST['accion']=="1"){
		$textobuscar = $_REQUEST['textobuscar'];
		$ficha = $_REQUEST['ficha'];
			$consulta="select asunto.idasunto, asunto.descripcion from asunto inner join asuntogerencia on asunto.idasunto = asuntogerencia.idasunto
			inner join gerencia on gerencia.idgerencia = asuntogerencia.idgerencia  where asuntogerencia.idgerencia = (select idgerencia from empleado where ficha = '".$ficha."' and status = 1) and asunto.status=1 and upper(asunto.descripcion) like upper('%".$textobuscar."%') order by asunto.descripcion";
		 
		//$consulta = "select idasunto, descripcion from asunto where status=1 and upper(descripcion) like upper('%".$textobuscar."%') order by descripcion";
		$cnx =new conexion();
		$datos = $cnx->returnJSON($consulta,false);
		echo $datos;
		}
		else if($_REQUEST['accion']=="2"){
			$autorizacion = "3001678";
			$password = "DwR987T4290";
			$numeroServicio = "500123";
			$numeroPersonalBuscar = $_REQUEST['empleadobuscar'];
		if($numeroPersonalBuscar != '000000'){
		
			//$webService = ;
			$servicio = new SoapClient("http://132.132.14.226/rechum2007/planeacion/ServiciosWeb/ElectronicServiceRH.asmx?WSDL");
			
			$params->NoAutorizacion = $autorizacion;
			$params->PwdAutorizacion = $password;
			$params->NoServicio = $numeroServicio;
			$params->NoPersonalBuscar = $numeroPersonalBuscar;
			
			$objectresult = $servicio->InfoGralEmpByNoPersonal($params);
			$result = $objectresult->InfoGralEmpByNoPersonalResult;
			$cnx =new conexion();
			$sql = "select * from cliente where ficha ='".$result->GeneralesEmpleado->NoPersonal."'";
			if($cnx->returnRS($sql,false) === null)
				{
					$idcliente = '(select COALESCE(MAX(idcliente)+1,1) FROM cliente)';
					$ficha = $result->GeneralesEmpleado->NoPersonal;
					$nombre = $result->GeneralesEmpleado->Nombre;
					$direccion = "(select COALESCE(iddireccion,0) from direccion where upper(descripcion) = UPPER('".$result->GeneralesEmpleado->SubDivisionDescrip."'))";
					$departamento = "(select COALESCE(iddepartamento,0) from departamento where upper(descripcion) = upper('".$result->GeneralesEmpleado->UnidadDescrip."'))";
					$uo = "(select COALESCE(idunidad,0) from unidad where upper(descripcion) = upper('".$result->GeneralesEmpleado->DivisionDescrip."'))";
					$sql = "insert into cliente values($idcliente,'$ficha','$nombre',$departamento,1,$direccion,$uo)";
					$x =$cnx->consultaAccion($sql,false);
				}
			$datos = json_encode($result->GeneralesEmpleado);
			echo $datos;
		}
		else
		{
			$cnx =new conexion();
			$sql = "select ficha as \"NoPersonal\", nombre as \"Nombre\", iddepartamento \"UnidadDescrip\",iddireccion\"SubDivisionDescrip\",idunidadorganizativa \"DivisionDescrip\" from cliente where ficha ='".$numeroPersonalBuscar."'";
			$rs =$cnx->returnRS($sql);
			$str="";
			if ($rs != null) 
			{
				//$str .="[";			
				while($r = $rs->FetchRow()) 
				{
					$str .= '{ "NoPersonal":"'.$r[0].'",'; 		
					$str .= '"Nombre":"'.$r[1].'",'; 			
					$str .= '"UnidadDescrip":"'.$r[2].'",'; 			
					$str .= '"SubDivisionDescrip":"'.$r[3].'",'; 			
					$str .= '"DivisionDescrip":"'.$r[4].'"}'; 			
					
				}	
				//$str .="]";	
				//$str = json_encode($str);
				echo $str;
			}
		}

		}
		else if($_REQUEST['accion']=="3"){
		$usuario = $_REQUEST['usuario'];
		$password = $_REQUEST['password'];
		$sql = "select * from empleado where usuario='$usuario' and password = md5('$password') and status =1";
		$cnx =new conexion();
		$datos = $cnx->returnRS($sql,false);
		if($datos != null){
		session_start();
		$_SESSION['idempleado'] = $datos->Fields(0);
		$_SESSION['ficha'] = $datos->Fields(1);
		$_SESSION['nombre'] = $datos->Fields(2);
		$_SESSION['idgerencia'] = $datos->Fields(6);
		$_SESSION['tipoacceso'] = $datos->Fields(7);
		echo $datos->RecordCount();
		}
		else
			echo "0";
		
		//echo "Sesion: ".$_SESSION['idempleado'];
		}
		else if($_REQUEST['accion'] == "4")
		{
			$idtipocliente = $_REQUEST['idtipocliente'];
			$idtipoatencion = $_REQUEST['idtipoatencion'];
			$idarea = $_REQUEST['idarea'];
			$idtipoasunto = $_REQUEST['idtipoasunto'];
			$idtiposervicio = $_REQUEST['idtiposervicio'];
			$idtiposolicitud = $_REQUEST['idtiposolicitud'];
			$ficha = $_REQUEST['ficha'];
			$turnado = $_REQUEST['turnado'];
			$resoluto = $_REQUEST['resoluto'];
			$fecha = $_REQUEST['fecha'];
			$fechasolucion = $_REQUEST['fechasolucion'];
			$idempleado = $_REQUEST['idempleado'];
			$pendiente = $_REQUEST['pendiente'];
			$unidadorganizativa = "select idunidadorganizativa from cliente where ficha = '$ficha'";
			$idservicio = "select coalesce(max(idservicio)+1,0) from servicio";
			date_default_timezone_set('Mexico/General');
			$hora = date('H:i:s');
			if($pendiente == "0")
			$sql = "insert into servicio (idservicio,fechasolicitud,traspasado,resolucion,fechasolucion,idtiposervicio,idtiposolicitud,idtipoatencion,idarea,idasunto,idcliente,idempleado,idtipocliente,unidadorganizativa) values (($idservicio),'".$fecha." ".$hora."',$turnado,$resoluto,'".(($fechasolucion!='')?$fechasolucion.' '.$hora:'')."',$idtiposervicio,$idtiposolicitud,$idtipoatencion,$idarea,$idtipoasunto,(select idcliente from cliente where ficha ='$ficha'),$idempleado,$idtipocliente,($unidadorganizativa))";
			else 
				$sql = "insert into servicio (idservicio,fechasolicitud,traspasado,resolucion,idtiposervicio,idtiposolicitud,idtipoatencion,idarea,idasunto,idcliente,idempleado,idtipocliente,unidadorganizativa,status) values (($idservicio),'".$fecha." ".$hora."',$turnado,$resoluto,$idtiposervicio,$idtiposolicitud,$idtipoatencion,$idarea,$idtipoasunto,(select idcliente from cliente where ficha ='$ficha'),$idempleado,$idtipocliente,($unidadorganizativa),0)";
			$cnx = new conexion();
			echo $cnx->consultaAccion($sql,false);
			
		}
		else if($_REQUEST['accion'] == "5")
		{
			$fechainicio = $_REQUEST['fechainicio'];
			$fechafin = $_REQUEST['fechafin'];
			$ficha = $_REQUEST['ficha'];
			$tipoacceso = $_REQUEST['tipoacceso'];
			if($tipoacceso === '1'){
			$query = 'select fechasolicitud as "Fecha de Solicitud","Turnado a Otro Nivel","Tipo de Resolucion","Fecha de Solucion",servicio,solicitud,"Tipo Atencion",
area,"Asunto", "Cliente","Unidad Organizativa","Tipo de Cliente" from reporte where status =1 and fechasolicitud::date between \''.$fechainicio.'\' and \''.$fechafin.'\' and idempleado = (select idempleado from empleado where ficha = \''.$ficha.'\')';
			}
			else if($tipoacceso === '0'){				
				$query = 'select fechasolicitud as "Fecha de Solicitud","Turnado a Otro Nivel","Tipo de Resolucion","Fecha de Solucion",servicio,solicitud,"Tipo Atencion",
				area,"Asunto", "Cliente","Unidad Organizativa","Tipo de Cliente" from reporte where status =1 and fechasolicitud::date between \''.$fechainicio.'\' and \''.$fechafin.'\'';
			}
			else if($tipoacceso === '2')
			{
				$query = 'select fechasolicitud as "Fecha de Solicitud","Turnado a Otro Nivel","Tipo de Resolucion","Fecha de Solucion",servicio,solicitud,"Tipo Atencion",
				area,"Asunto", "Cliente","Unidad Organizativa","Tipo de Cliente" from reporte where status =1 and fechasolicitud::date between \''.$fechainicio.'\' and \''.$fechafin.'\' and (select idgerencia from empleado where idempleado =reporte.idempleado) = (select idgerencia from empleado where ficha =\''.$ficha.'\') ';	//where 
			}
			$cnx = new conexion();
			echo $cnx->returnTabla($query,false);
		}
		else if($_REQUEST['accion'] == "6")
		{
			$idempleado = $_REQUEST['idempleado'];
			$sql = 'select idservicio,fechasolicitud,servicio, solicitud, "Tipo Atencion",area,"Asunto","Cliente","Tipo de Cliente",status from reporte where status=0 and idempleado ='.$idempleado;
			$cnx = new conexion();
			echo $cnx->returnTabla($sql,false,true,"Solucionado","registrosolucionado(this)",false);
		}
		else if($_REQUEST['accion'] == "7")
		{			
			$query="update servicio set status =1, fechasolucion=localtimestamp(2) where idservicio= ";
			$cnx = new conexion();
			echo $cnx->consultaAccion($query.$_REQUEST['consulta'],false);			
		}
		else if($_REQUEST['accion'] == "8")
		{
			$idgerencia = $_REQUEST['idgerencia'];
			$tipoacceso =$_REQUEST['tipoacceso'];
			$sql = "";
			if($tipoacceso === '0')
				{
					$sql = "select distinct area.idarea,area.descripcion from area inner join areagerencia on areagerencia.idarea = area.idarea
					inner join gerencia on gerencia.idgerencia = areagerencia.idgerencia";
				}
				else if($tipoacceso === '1')
				{			
					$sql = "select area.idarea,area.descripcion from area inner join areagerencia on areagerencia.idarea = area.idarea
					inner join gerencia on gerencia.idgerencia = areagerencia.idgerencia
					where gerencia.idgerencia = $idgerencia";
				}
				else if($tipoacceso === '2')
				{
					$sql = "select area.idarea,area.descripcion from area inner join areagerencia on areagerencia.idarea = area.idarea
					inner join gerencia on gerencia.idgerencia = areagerencia.idgerencia
					where gerencia.idgerencia = $idgerencia";
				}

			$cnx = new conexion();
			$rs = $cnx->returnRS($sql,false);
			$body = "";
			for($i=0;$i<$rs->RecordCount();$i++)
			{
						
					$body.='<label>'.$rs->Fields(1).'</label>&nbsp;<img data-id="'.$rs->Fields(0).'" src="img/radio-unchecked.png" width="24px" height="24px" /><br/>';
				$rs->MoveNext();
			}
			echo $body;
		}
		else if($_REQUEST['accion'] == "9")
		{
			$sql = "select idempleado from empleado where ficha='".$_REQUEST['ficha']."' and password = md5('".$_REQUEST['password']."')";
			$cnx = new conexion();
			$rs = $cnx->returnRS($sql,false);
			if(isset($_REQUEST['usuario']))
				{
					
					if($rs->RecordCount() !== 0)
						{
							$sql = "update empleado set usuario = '".$_REQUEST['usuario']."' where idempleado =".$rs->Fields(0);
							if($cnx->ConsultaAccion($sql) == 0)
							{
								die ("Ocurrio un Error Mientras se trataba de actualizar los datos Por Favor Intentalo de Nuevo.");
							}
						}
				}
			if(isset($_REQUEST['passwordNuevo']) && $_REQUEST['passwordNuevo'] !== "")
				{
					$sql = "update empleado set password = md5('".$_REQUEST['passwordNuevo']."') where idempleado =".$rs->Fields(0);
					if($cnx->ConsultaAccion($sql) == 0)
					{
						die ("Ocurrio un Error Mientras se trataba de actualizar los datos Por Favor Intentalo de Nuevo.");
					}
				}
		}
		else if($_REQUEST['accion'] =="10")
		{
			$tiporeporte = $_REQUEST['tiporeporte'];
			$fechainicio = $_REQUEST['fechainicio'];
			$fechafin = $_REQUEST['fechafin'];
			switch($tiporeporte)
			{
				case "1":
				$sql = "SELECT servicio,COUNT(idservicio)as numero FROM reporte WHERE \"Fecha de Solucion\" BETWEEN '$fechainicio' AND '$fechafin'
				GROUP BY  servicio";
				break;
				case "2":
				$sql = "SELECT \"Tipo Atencion\" servicio ,COUNT(idservicio)numero FROM reporte 
				WHERE \"Fecha de Solucion\" BETWEEN '$fechainicio' AND '$fechafin'
				GROUP BY \"Tipo Atencion\"";
				break;
				case "3"://pendiente modificar, muestre todo los intervalos fecha 31/10/2013 06:28 p.m.
				$sql = "SELECT 'AL PRIMER CONTACTO'servicio,COUNT(idservicio)numero FROM reporte WHERE \"Fecha de Solucion\"::date - fechasolicitud::date = 0 AND \"Fecha de Solucion\" BETWEEN '$fechainicio' AND '$fechafin'
				UNION
				SELECT '1 O MAS DIAS'servicio,COUNT(idservicio)numero FROM reporte WHERE \"Fecha de Solucion\"::date - fechasolicitud::date <> 0 AND \"Fecha de Solucion\" BETWEEN '$fechainicio' AND '$fechafin'";
				break;
				case "4":
				$sql = "SELECT solicitud servicio,COUNT(idservicio)numero FROM reporte WHERE  \"Fecha de Solucion\" BETWEEN '$fechainicio' AND '$fechafin'
				GROUP BY solicitud,idtiposolicitud";
				break;
				case "5":
				$sql = "SELECT 'PRESENCIAL' servicio,COUNT(idservicio)numero FROM reporte WHERE idtipoatencion = 3 AND \"Fecha de Solucion\" BETWEEN '$fechainicio' AND '$fechafin'
				UNION
				SELECT 'NO PRESENCIAL',COUNT(idservicio)cantidad FROM reporte WHERE idtipoatencion <> 3 AND \"Fecha de Solucion\" BETWEEN '$fechainicio' AND '$fechafin'
				ORDER BY numero";
				break;
				case "6":
				$sql = "SELECT 'FUERA DE POLITICA' servicio,COUNT(idservicio)numero FROM reporte WHERE idtiposolicitud = 2 AND \"Fecha de Solucion\" BETWEEN '$fechainicio' AND '$fechafin'
				UNION
				SELECT 'DENTRO DE POLITICA' servicio,COUNT(idservicio)numero FROM reporte WHERE idtiposolicitud <> 2 AND \"Fecha de Solucion\" BETWEEN '$fechainicio' AND '$fechafin'";				
				break;
				case "7":
				$sql = "SELECT 'FUERA DE POLITICA (+)' servicio,COUNT(idservicio)numero FROM reporte WHERE idtiposolicitud = 2 and \"Tipo de Resolucion\" = 'Positiva' AND \"Fecha de Solucion\" BETWEEN '$fechainicio' AND '$fechafin'
				UNION
				SELECT 'FUERA DE POLITICA (-) ' servicio,COUNT(idservicio) FROM reporte WHERE idtiposolicitud = 2 and \"Tipo de Resolucion\" = 'Negativa' AND \"Fecha de Solucion\" BETWEEN '$fechainicio' AND '$fechafin'";
				break;
				case "8":
				$sql = "SELECT \"Tipo de Resolucion\"servicio,COUNT(idservicio)numero FROM reporte WHERE \"Fecha de Solucion\" BETWEEN  '$fechainicio' AND '$fechafin' GROUP BY \"Tipo de Resolucion\"";
				break;
				case "9":
				$sql = "SELECT \"Turnado a Otro Nivel\"servicio,COUNT(idservicio)numero FROM reporte WHERE \"Fecha de Solucion\" BETWEEN '$fechainicio' AND '$fechafin'
				GROUP BY \"Turnado a Otro Nivel\"";
				break;
				case "10":
				$sql = "SELECT \"Asunto\"servicio,COUNT(idservicio)numero FROM reporte 
				WHERE \"Fecha de Solucion\" BETWEEN '$fechainicio' AND '$fechafin'
				GROUP BY \"Asunto\" ORDER BY numero DESC LIMIT 5
				";
				break;
				case "11":
				$sql = "SELECT 'PRESENCIALES'servicio,COUNT(idservicio)numero FROM reporte WHERE (idtiposervicio = 1 AND  idtipoatencion = 3) AND \"Fecha de Solucion\" BETWEEN '$fechainicio' AND '$fechafin'
				UNION
				SELECT 'NO PRESENCIALES'sevicio,COUNT(idservicio) FROM reporte WHERE (idtiposervicio = 1 AND  idtipoatencion <> 3) AND \"Fecha de Solucion\" BETWEEN '$fechainicio' AND '$fechafin'
				";
				break;
				case "12":
				$sql = "SELECT solicitud servicio,COUNT(idservicio)numero FROM reporte 
				WHERE (idtiposervicio = 1 ) AND \"Fecha de Solucion\" BETWEEN '$fechainicio' AND '$fechafin' 
				GROUP BY solicitud";
				break;
				case "13": 
				$sql = "SELECT solicitud||' '||\"Tipo de Resolucion\" servicio,COUNT(idservicio)numero FROM reporte 
				WHERE (idtiposervicio = 1 AND idtiposolicitud = 2 ) AND \"Fecha de Solucion\" BETWEEN '$fechainicio' AND '$fechafin' 
				GROUP BY solicitud,\"Tipo de Resolucion\"
				";
				break;
			}
			$cnx = new conexion();
			echo $cnx->newReturnJSON($sql);
		}
	}
?>