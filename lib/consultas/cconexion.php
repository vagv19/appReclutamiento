<?php
/*
 * Clase cconexion. Version 1.0.10
 * Permite:
 * Conectarse a una base de datos PostgreSQL.
 * Crear Consultas de Seleccion y de Accion.
 * Retornar ResultSets para su manipulacion.
 * Retornar un objeto JSON a partir de una consulta SQL.
 * Generar una tabla HTML indicando si lleva o no lleva boton y cual funcion ejecuta dicho boton.
 * Desarrollada por: Victor Alfonso Garcia Vazquez.
 */ 
class conexion
{
	/**
	 * Declaracion de variables globales  
	 */
	var $cnx;
	var $svr;
	var $usr;
	var $pwd;
	var $db;
	
	/*
	 * Funcion getData. Se utiliza para asignar los parametros de conexion a la base de datos
	 * en las variables globales.
	 */ 
	function getData()
	{
		include dirname(__FILE__).'/../conexion.inc.php';	
		include dirname(__FILE__).'/../adodb5/adodb.inc.php';
		$this->svr= $svr;
		$this->usr = $usr;
		$this->pwd = $pwd;
		$this->db = $db;
	}
	/*
	 * Funcion conectar. Se utiliza para establecer la conexion a la base de datos.
	 * Parametros: $debug. Boolean. Default False. Indica si la conexion que se va a establecer debe debuggearse o no.
	 * Regresa la conexion activa.
	 */ 
	function conectar($debug=false)
	{
		$this->getData();
		$conexion = ADONewConnection("postgres8");//$dvr); # eg 'mysql' o 'postgres'
		$conexion->debug = $debug;
		$conexion->Connect($this->svr, $this->usr, $this->pwd, $this->db);
		return $conexion;
	}
	/*
	 * Funcion login. Permite validar un usuario y password en la base de datos para accesar al sistema.
	 * Parametros: $consulta. String. Cadena que indica que consulta se ejecutara en la base de datos.
	 * 					  $debug. Boolean. Default False. Indica si la consulta se debe debuggear.
	 * Regresa 1/0. Si la consulta se realizo con exito retorna 1, en caso contrario 0.
	 * Nota. En caso de que la consulta retornara mas de un valor la funcion retornara el total de elementos de la consulta		 
	 */ 
	function login($consulta,$debug=false)
	{
		$datos =$this->returnRS($consulta,$debug);
		if($datos != null){
			return $datos->RecordCount();
			}
		else
			return 0;
	}
	/*
	 * Funcion consultaAccion. Permite ejecutar consultas de accion en la base de datos Ej.; Insert, Update Delete
	 * Parametros: $sql. String. Consulta de Accion a ejecutarse Ej.: Insert Into empleado values(1,'nombre');
	 * 					  $debug. Boolean. Default False. Indica si la consulta se debe debuggear.
	 * Retorna 1/0. 1 en caso de que la consulta se ejecute con exito.
	 * 					  0 en caso de que ocurra algun error.
	 */ 
	function consultaAccion($sql,$debug=false)
	{
		$this->cnx=$this->conectar($debug);
		if($this->cnx->Execute($sql) != false)
			return 1;
		else
			return 0;
		
	}

	function executeNonQuery($sql,$debug=false)
	{
		$this->cnx=$this->conectar($debug);
		$rs = $this->cnx->Execute($sql);
		return $rs->Fields(0);
	}
	/*
	 * Funcion returnRS. Ejecuta una consulta en la base de datos y retorna un ResultSet para su posterior manejo en alguna otra funcion.
	 * Parametros: $consulta. String. Cadena que indica que consulta se ejecutara en la base de datos.
	 * 					  $debug. Boolean. Default False. Indica si la consulta se debe debuggear.
	 * Retorna: el Objeto ResultSet para su manipulacion en otro lugar. 
	 * 				Null. En caso de que ocurra un error al ejecutar la consulta. 	 
	 */ 
	function returnRS($consulta,$debug=false)
	{
		$this->cnx=$this->conectar($debug);
		$rs = $this->cnx->Execute($consulta);
		if($rs != null )
			{
				if($rs->RecordCount()!=0)
					return $rs;
				else 
					return null;
			}
		else
			{
				return null;
			}
	}
	/*
	 * Funcion returnJSON. Funcion que a partir de un resultset retorna un objeto JSON
	 * Parametros: $query. String. consulta a ejecutarse
	 * Retorna: Un array codificado como JSON.
	 * 			    0 En caso de que ocurra algun error. 
	 */ 
	function returnJSON($query,$debug=false)
	{
		$rs=$this->returnRS($query,$debug);
		if ($rs != null) 
		{
			//if($rs->RecordCount() > 1)
			$rows = "[";
			$j = false;
			while($r = $rs->FetchRow())
			{
				if($j == false)
					$rows.="{";
				else
					$rows.=",{";
				for($i =0 ; $i<$rs->FieldCount();$i++)
				{
					$field = $rs->FetchField($i);
					if($i !== $rs->FieldCount()-1)
						$rows.='"'.$field->name.'": "'.$r[$i].'",';
					else
						$rows.='"'.$field->name.'": "'.$r[$i].'"';
				}
				$j=true;
				$rows.="}";
			}
			// if($rs->RecordCount() > 1)
				$rows.= "]";
			return $rows;
		}
		else 
		{
			return 0;
		}
	}
	/*
 * Funcion crearEncabezado. Crea el Encabezado de una tabla HTML.
*  Parametros: $rs. resultset. Objeto que contiene los datos de una consulta SQL previamente realizada.
* 						  $button. Boolean. Indica si la tabla contendra un boton.
* 						  $btnInicio. Boolean. Indica si el boton va en el primer elemento de la tabla o en el ultimo.
*	Retorna el encabezado creado como String.						
*/  
	function crearEncabezado($rs,$button=false,$btnInicio=false,$img=false)
		{
			$encabezado="";
			for($i=0;$i<$rs->FieldCount();$i++)
				{
					$field=$rs->FetchField($i);
					if(($button && $i == $rs->FieldCount()-1) && $btnInicio ==false)
					$encabezado.='<th align="right" style="width:100px;"></th>';
					else if(($button== true && $btnInicio == true && 0 == $i) || ($img ) && 0 == $i)
					$encabezado.='<th align="right" style="width:100px;"></th>';
					else
					$encabezado.='<th align="right">'.$field->name.'</th>';
				}
			return $encabezado;
		}
	function crearTbody($rs,$button,$btnText,$function,$btnInicio,$img=false)
		{
			$body="";
			for($i=0;$i<$rs->RecordCount();$i++)
				{					
					$body.='<tr data-idcandidato="'.$rs->Fields(0).'" data-Folio="'.$rs->Fields(1).'">';
					for($j=0;$j<$rs->FieldCount();$j++)
					{	
						if(($button && $j == $rs->FieldCount()-1) && $btnInicio == false )
						$body.='<td class="tdBtn" align="right"><button type="button" onclick="'.$function.'" class="btn btnTabla" data-id="'.$rs->Fields(0).'">'.$btnText.'</button></td>';
						else if($button && 0 == $j && $btnInicio)
						{
							$body.='<td  align="right"><button type="button" onclick="'.$function.'" class="btn btnTabla" data-descripcion="'.$rs->Fields(1).'" data-id="'.$rs->Fields(0).'">'.$btnText.'</button></td>';
						}
						elseif($img && 0 == $j)
						{
							$body.='<td  align="right"><img width="100px" height="100px" src="img/'.$rs->Fields("folio").'.jpg" /></td>';
						}
						else	
						$body.='<td align="right">'.$rs->Fields($j).'</td>';					
					}
					$body.="</tr>";
					$rs->MoveNext();
				}
			return $body;
		}
	function crearTbodyEdicion($rs,$tabla="")
		{
			$body="";
			$renglon="<tr>";
			for($i=0;$i<$rs->RecordCount();$i++)
				{					
					$body.='<tr>';
					for($j=0;$j<$rs->FieldCount();$j++)
					{	
						$field = $rs->FetchField();
						if($j==0)
						{
							$body.='<td style="width:100px;">
								<div class="btn-group">
									 <button id="" data-table="'.$tabla.'" data-id="'.$rs->Fields($j).'" data-campo="'.$field->name.'" data-accion="update" type="button" class="btn btn-default" style="padding:5px 3px;"><i class="glyphicon glyphicon-edit"></i></button>
									 <button id="" data-table="'.$tabla.'" data-id="'.$rs->Fields($j).'" data-campo="'.$field->name.'" data-accion="delete" type="button" class="btn btn-default" style="padding:5px 3px;"><i class="glyphicon glyphicon-remove-sign"></i></button>
								 </div>
							</td>';
							if($i == 0)
								$renglon = '<td style="width:100px;">
												<div class="btn-group">
													<button id="" data-table="'.$tabla.'" data-id="'.$rs->Fields($j).'" data-campo="'.$field->name.'" data-accion="insert" type="button" class="btn btn-default" ><i class="glyphicon glyphicon-plus-sign"></i></button>
												</div>	
											</td>';
						}
						else	
						{
							$body.='<td align="right">'.$rs->Fields($j).'</td>';
							if($i == 0)					
								$renglon.='<td></td>';
						}					
					}
					$body.="</tr>";
					$rs->MoveNext();
				}
				$renglon.="</tr>";
			return $body.$renglon;
		}	
	function returnTabla($query,$debug=false,$button =false,$btnText="",$function="",$btnInicio=false,$img=false)
		{
			$rs= $this->returnRS($query,$debug);
			if($rs != null)
				{
					$resultados="";
					if($rs->RecordCount()!=0)
						{
							$resultados="<table id=\"tabla\" class=\"table table-condensed table-hover table-bordered table-striped \" style='font-size:12px;'><thead><tr>";
							$resultados.=$this->crearEncabezado($rs,$button,$btnInicio,$img);
							$resultados.="</tr></thead><tbody>";
							$resultados.=$this->crearTbody($rs,$button,$btnText,$function,$btnInicio,$img);						
						$resultados.="</tbody></table>";
						if($resultados!="")
						{
							return $resultados;
						}
						else
						{
							echo "0";
						}
					}
	
				}
		}
			function returnTablaEdicion($query,$tabla="",$debug=false)
		{
			$rs= $this->returnRS($query,$debug);
			if($rs != null)
				{
					$resultados="";
					if($rs->RecordCount()!=0)
						{
							$resultados="<table id=\"tabla\" class=\"table table-condensed table-hover table-bordered table-striped \" style='font-size:12px;margin-top:5px;'><thead><tr>";
							$resultados.=$this->crearEncabezado($rs,true,true);
							$resultados.="</tr></thead><tbody>";
							$resultados.=$this->crearTbodyEdicion($rs,$tabla);						
						$resultados.="</tbody></table>";
						if($resultados!="")
						{
							return $resultados;
						}
						else
						{
							echo "0";
						}
					}					
	
				}
				else
					{
						$resultados="<table id=\"tabla\" class=\"table table-condensed table-hover table-bordered table-striped \" style='font-size:12px;margin-top:5px;'><thead><tr>";
							$resultados.="<td>Crear un registro nuevo</td>";
							$resultados.="</tr></thead><tbody>";
							$resultados.="<tr><td style='width:100px;'>
												<div class='btn-group'>
													<button id='' data-table=\"$tabla\"  data-accion=\"insert\" type=\"button\" class=\"btn btn-default\" ><i class=\"glyphicon glyphicon-plus-sign\"></i></button>
												</div>	
											</td></tr>";					
						$resultados.="</tbody></table>";
						echo "$resultados";
					}
		}
		function crearDropDownItem($sql,$debug = false)
		{
			$listItem = '0';
			$rs = $this->returnRS($sql,$debug);
			for($j=0;$j<$rs->FieldCount();$j++){
				$field = $rs->FetchField($j);
				if ($j == 0) {
					$listItem = '<li class="active" data-campoBusqueda="'.$field->name.'"><a href="javascript:;">'.$field->name.'</a></li>';
					
				} else {
					$listItem .= '<li data-campoBusqueda="'.$field->name.'"><a href="javascript:;">'.$field->name.'</a></li>';
				}
			}
			return $listItem;
		}
	function crearOption($query,$selected='-1',$debug=false)
			{
				$rs = $this->returnRS($query,$debug);
				$option = "";
				if($rs->RecordCount()!=0)
				{
					while($row = $rs->FetchRow())
					{
						if($selected == $row['id'])
							$option.="<option value='".$row['id']."' selected>".htmlentities($row['descripcion'])."</option>";
						else
							$option.="<option value='".$row['id']."'>".htmlentities($row['descripcion'])."</option>";
					}
				}
				return $option;
			}
	function crearTabs($sql,$function)
			{
				
				$rs = $this->returnRS($sql);
				$div="";
				if($rs->RecordCount()==0)
				{
					return "0";
				}
				$ul="<ul class='nav nav-tabs'>";
				$i=0;
				while($row = $rs->FetchRow())
				{
					if($i==0)
					{
						$ul.="<li class='active' onclick='$function' data-id='$row[0]'><a data-toggle='tab'  href='#".$row[0]."' >".htmlentities($row[1], ENT_COMPAT,'ISO-8859-1', true)."</a></li>";
						$div.="<div id='".$row[0]."' class='tab-pane fade in active' style='margin:5px;' ><div style='margin-top:20px;'></div></div>";
					}	
					else
					{
						$ul.="<li onclick='$function' data-id='$row[0]'><a data-toggle='tab'   href='#".$row[0]."'>".htmlentities($row[1], ENT_COMPAT,'ISO-8859-1', true)."</a></li>";	
						$div.="<div id='".$row[0]."' class='tab-pane fade' style='margin:5px;' ><div style='margin-top:20px;'></div></div>";
					}
					$i++;
				}
				$ul.="</ul>";
				
				return $ul."<div class='tab-content'>".$div."</div>";
			}
	function returnAccordion($sql)
	{
		//
		$rs = $this->returnRS($sql);
		if($rs->RecordCount()==0)
			{
				return "0";
			}
		$accordion ="";
		$i=0;
		while( $row = $rs->FetchRow() )
		{
			$accordion .= '
							<div class="panel '.($i==0?'panel-primary':'panel-default').'">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-selector="accordion" data-parent="#accordion" href="#'.$row[0].'-acc">
											'.$row[1].'
										</a>
									</h4>
								</div>
								<div id="'.$row[0].'-acc" class="panel-collapse collapse '.($i==0?'in':'').'">
									<div class="panel-body">
										'.$row[2].'
									</div>
								</div>
							</div>
						  ';
						  $i++;
		}
		return '<div class="panel-group" id="accordion" style="margin-top:5px;">'.$accordion.'</div>';	
	}
	function newReturnListGroup($sql,$title)
	{
		$rs = $this->returnRS($sql);
		$listgroup = "";
		$i=0;
		while($row = $rs->FetchRow())
		{
			$listgroup .= '<div class="list-group">
							  <a href="#" class="list-group-item ">
							    <h4 class="list-group-item-heading">'.$title.' '.($i+1).' </h4>
							    <p class="list-group-item-text">'.$row[0].'</p>
							  </a>';
			$i++;				  
		}
		return $listgroup;
	}
	function returnListGroup($sql,$object)
	{
		$rs = $this->returnRS($sql);
		$listgroup = '<div class="list-group">';
		while($row = $rs->FetchRow())
		{
			$listgroup .= '<a href="#" data-id="'.$row[0].'" data-object="'.$object.'" class="list-group-item"><i class="glyphicon glyphicon-record"></i> '.$row[1].'</a>';
		}
        $listgroup .= '</div>';
		return $listgroup;
		
	}
	function returnHTMLObject($rs,$value=false)
		{
			$htmlObject="";
			for($j=0;$j<$rs->FieldCount();$j++){
					$r = $rs->FetchField($j);
					$htmlObject.= '<div class="form-group">
										<label for="txt'.$r->name.'" class="col-sm-4 control-label">'.$r->name.'</label>
											<div class="col-sm-7">
												<input type="text" class="form-control" '.($r->type == 'int4'?"numeric":"alphanumeric").' id="txt'.$r->name.'" data-required="true"  name="txt'.$r->name.'" placeholder="'.$r->name.'"/>
											</div>
									</div>';
				}
		}	

}	
?>