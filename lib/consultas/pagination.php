<?php
	require_once("cconexion.php");
	$nombre="";
	if(isset($_REQUEST['asunto']))
	$nombre = $_REQUEST['asunto'];
	if(isset($_REQUEST['orderby']))			
		$orderby=$_REQUEST['orderby'];		
	if(isset($_REQUEST['tabla']))
		$tbl_name=$_REQUEST['tabla'];
	else	
	$tbl_name="empleado";		//your table name
if(isset($_REQUEST['ficha']))
$ficha=$_REQUEST['ficha'];
else	
die ("Error. Acceso no autorizado");
	$adjacents = 3;
	if($nombre === "")
$query = "select count(asunto.idasunto) from asunto inner join asuntogerencia on asunto.idasunto = asuntogerencia.idasunto
inner join gerencia on gerencia.idgerencia = asuntogerencia.idgerencia  where asuntogerencia.idgerencia = (select idgerencia from empleado where ficha = '$ficha' and status = 1) and asunto.status=1 
";
	else
$query = "select count(asunto.idasunto) from asunto inner join asuntogerencia on asunto.idasunto = asuntogerencia.idasunto
inner join gerencia on gerencia.idgerencia = asuntogerencia.idgerencia  where asuntogerencia.idgerencia = (select idgerencia from empleado where ficha = '$ficha' and status = 1) and asunto.status=1 and upper(asunto.descripcion) like upper('%".$nombre."%')
";
	$cnx = new conexion();
	$datos = $cnx->returnRS($query);
	//$datos=$conexion->Execute($query);
	if($datos->Recordcount()==0)
	{
		die ("error, no existen datos..Ss.");		
	}
	
	$total_pages = $datos->Fields(0);
	$targetpage = "pagination.php"; 	//your file name  (the name of this file)
	if(isset($_REQUEST['limit']))
		$limit=$_REQUEST['limit'];	
	$limit = 8; 	//how many items to show per page
	$page=0;
	if($_REQUEST)
	$page = $_REQUEST['page'];
	if($page) 
		$start = ($page -1) * $limit; 			//first item to display on this page
	else
		$start = 0;
	if($nombre !== "")	
$sql="select asunto.idasunto, asunto.descripcion \"Nombre Asunto\" from asunto inner join asuntogerencia on asunto.idasunto = asuntogerencia.idasunto
inner join gerencia on gerencia.idgerencia = asuntogerencia.idgerencia  where asuntogerencia.idgerencia = (select idgerencia from empleado where ficha = '".$ficha."' and status = 1) and asunto.status=1 and upper(asunto.descripcion) like upper('%".$nombre."%')  ORDER BY $orderby LIMIT $limit offset $start";
	else
$sql="select asunto.idasunto, asunto.descripcion \"Nombre Asunto\" from asunto inner join asuntogerencia on asunto.idasunto = asuntogerencia.idasunto
inner join gerencia on gerencia.idgerencia = asuntogerencia.idgerencia  where asuntogerencia.idgerencia = (select idgerencia from empleado where ficha = '".$ficha."' and status = 1) and asunto.status=1   ORDER BY $orderby LIMIT $limit offset $start";

	//$result = $cnx->returnRS($sql);
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;
$pagination ='';
	if($lastpage >= 1)
	{	
		$pagination .= "<ul class=\"pagination\" style='maragin-top:10px;' >";
		//previous button
		if ($page > 1) 
			$pagination.= "<li class=\"arrow\"><a href=\"javascript:;\" onClick='paginar(\"$targetpage\",\"$prev\")'>&laquo;</a></li>";
		else
			$pagination.= "<li class=\"arrow disabled\"><a href=\"javascript:;\" onClick='paginar(\"$targetpage\",\"$prev\")'>&laquo;</a></li>";	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<li class=\"active\"><a href='javascript:;'>$counter</a></li>";
				else
					$pagination.= "<li><a href=\"javascript:;\" onClick='paginar(\"$targetpage\",\"$counter\")'>$counter</a></li>";//$targetpage?page=$counter					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class=\"active\"><a href='javascript:;'>$counter</a></li>";
					else
						$pagination.= "<li><a href=\"javascript:;\" onClick='paginar(\"$targetpage\",$counter)'>$counter</a></li>";					
				}
				$pagination.= "<li><a href='javascript:;'>...</a></li>";
				$pagination.= "<li><a href=\"javascript:;\" onClick='paginar(\"$targetpage\",$lpm1)'>$lpm1</a></li>";
				$pagination.= "<li><a href=\"javascript:;\" onClick='paginar(\"$targetpage\",$lastpage)'>$lastpage</a></li>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<li><a href=\"javascript:;\" onClick='paginar(\"$targetpage\",\"1\")'>1</a></li>";
				$pagination.= "<li><a href=\"javascript:;\" onClick='paginar(\"$targetpage\",\"2\")'>2</a></li>";
				$pagination.= "<li><a href=\"javascript:;\">...</a></li>";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class=\"active\"><a href='javascript:;'>$counter</a></li>";
					else
						$pagination.= "<li><a href=\"javascript:;\" onClick='paginar(\"$targetpage\",\"$counter\")'>$counter</a></li>";					
				}
				$pagination.= "<li><a href=\"javascript:;\">...</a></li>";
				$pagination.= "<li><a href=\"javascript:;\" onClick='paginar(\"$targetpage\",$lpm1)'>$lpm1</a></li>";
				$pagination.= "<li><a href=\"javascript:;\" onClick='paginar(\"$targetpage\",$lastpage)'>$lastpage</a></li>";			
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<li><a href=\"javascript:;\" onClick='paginar(\"$targetpage\",\"1\")'>1</a></li>";
				$pagination.= "<li><a href=\"javascript:;\" onClick='paginar(\"$targetpage\",\"2\")'>2</a></li>";
				$pagination.= "<li><a href=\"javascript:;\">...</a></li>";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class=\"active\"><a href='javascript:;'>$counter</a></li>";
					else
						$pagination.= "<li><a href=\"javascript:;\" onClick='paginar(\"$targetpage\",\"$counter\")'>$counter</a></li>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<li><a href=\"javascript:;\" onClick='paginar(\"$targetpage\",\"$next\")'>&raquo;</a></li>";
		else
			$pagination.= "<li class=\"disabled\"><a href=\"javascript:;\">&raquo;</a></li>";
		$pagination.= "</ul>";		
	}
	
	//returnTabla($query,$debug=false,$button =false,$btnText="",$function="",$btnInicio)
		$tablaCompleta = $cnx->returnTabla($sql,false,true,"Seleccionar","seleccionarAsuntoFiltrado($(this).attr('data-id'),$(this).attr('data-descripcion'))",true);
echo '<div class="col-sm-12" style="margin-bottom:10px;">
<div class="input-group">
<input id="txtFiltrar" type="text" class="form-control">
<span class="input-group-btn">
<button id="btnFiltrar" class="btn btndefault" type="button">Buscar</button>
</span>
</div><!-- /input-group -->
</div><br/>'.$pagination;
	echo "<div id='divtabla' >".$tablaCompleta."</div>";
	//echo $pagination;
	?>