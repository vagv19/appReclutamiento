<?php
include_once "cconexion.php";
	class pagination
	{
		var $sqlCount="";
		var $sql="";
		var $adjacents = 3;
		var $total_pages;
		var $limit;
		var $page;
		var $start;
		var $prev;
		var $next;
		var $lastpage;
		var $lpm1;
		var $pagination="";
		var $servicio ="";
		var $funcion = "";
		var $filtar="";
		function inicializar($sql,$sqlCount,$limit = 8,$page = 0,$servicio,$funcion="paginar",$filtrar="filtrar")
		{
			$this->funcion = $funcion;
			$this->filtrar=$filtrar;
			$this->sqlCount = $sqlCount;
			$this->limit = $limit;
			$this->page = $page;
			$this->servicio=$servicio;
			if($this->page!=0)
			{
				$this->start =($page -1) * $limit;
			}
			else
			{
				$this->start =0;
			}
			$this->sql = $sql." LIMIT $this->limit offset $this->start";
			$cnx = new conexion();
			$datos = $cnx->returnRS($this->sqlCount);
			//$datos=$conexion->Execute($query);
			if($datos->Recordcount()==0)
			{
				die ("error, no existen datos...");		
			}
			
			$this->total_pages = $datos->Fields(0);
			if ($this->page == 0) $this->page = 1;					//if no page var is given, default to 1.
			$this->prev = $this->page - 1;							//previous page is page - 1
			$this->next = $this->page + 1;							//next page is page + 1
			$this->lastpage = ceil($this->total_pages/$this->limit);		//lastpage is = total pages / items per page, rounded up.
			$this->lpm1 = $this->lastpage - 1;
		}
		function returnNoPaginas()
		{
			if($this->lastpage >= 1)
			{	
				$this->pagination .= "<ul class=\"pagination\" style='maragin-top:10px;' >";
				//previous button
				if ($this->page > 1) 
				$this->pagination.= "<li class=\"arrow\"><a href=\"javascript:;\" onClick='$this->funcion(\"$this->prev\",$this->servicio)'>&laquo;</a></li>";
				else
				$this->pagination.= "<li class=\"arrow disabled\"><a href=\"javascript:;\" onClick='$this->funcion(\"$this->prev\",$this->servicio)'>&laquo;</a></li>";	

				//pages	
				if ($this->lastpage < 7 + ($this->adjacents * 2))	//not enough pages to bother breaking it up
				{	
					for ($counter = 1; $counter <= $this->lastpage; $counter++)
					{
						if ($counter == $this->page)
							$this->pagination.= "<li class=\"active\"><a href='javascript:;'>$counter</a></li>";
						else
							$this->pagination.= "<li><a href=\"javascript:;\" onClick='$this->funcion(\"$counter\",$this->servicio)'>$counter</a></li>";//$targetpage?page=$counter					
					}
				}
				elseif($this->lastpage > 5 + ($this->adjacents * 2))	//enough pages to hide some
				{
					//close to beginning; only hide later pages
					if($this->page < 1 + ($this->adjacents * 2))		
					{
						for ($counter = 1; $counter < 4 + ($this->adjacents * 2); $counter++)
						{
							if ($counter == $this->page)
								$this->pagination.= "<li class=\"active\"><a href='javascript:;'>$counter</a></li>";
							else
								$this->pagination.= "<li><a href=\"javascript:;\" onClick='$this->funcion($counter,$this->servicio)'>$counter</a></li>";					
						}
						$this->pagination.= "<li><a href='javascript:;'>...</a></li>";
						$this->pagination.= "<li><a href=\"javascript:;\" onClick='$this->funcion($this->lpm1,$this->servicio)'>$this->lpm1</a></li>";
						$this->pagination.= "<li><a href=\"javascript:;\" onClick='$this->funcion($this->lastpage,$this->servicio)'>$this->lastpage</a></li>";		
					}
					//in middle; hide some front and some back
					elseif($this->lastpage - ($this->adjacents * 2) > $this->page && $this->page > ($this->adjacents * 2))
					{
						$this->pagination.= "<li><a href=\"javascript:;\" onClick='$this->funcion(\"1\",$this->servicio)'>1</a></li>";
						$this->pagination.= "<li><a href=\"javascript:;\" onClick='$this->funcion(\"2\",$this->servicio)'>2</a></li>";
						$this->pagination.= "<li><a href=\"javascript:;\">...</a></li>";
						for ($counter = $this->page - $this->adjacents; $counter <= $this->page + $this->adjacents; $counter++)
						{
							if ($counter == $this->page)
								$this->pagination.= "<li class=\"active\"><a href='javascript:;'>$counter</a></li>";
							else
								$this->pagination.= "<li><a href=\"javascript:;\" onClick='$this->funcion(\"$counter\",$this->servicio)'>$counter</a></li>";					
						}
						$this->pagination.= "<li><a href=\"javascript:;\">...</a></li>";
						$this->pagination.= "<li><a href=\"javascript:;\" onClick='$this->funcion($this->lpm1,$this->servicio)'>$this->lpm1</a></li>";
						$this->pagination.= "<li><a href=\"javascript:;\" onClick='$this->funcion($this->lastpage,$this->servicio)'>$this->lastpage</a></li>";			
					}
					//close to end; only hide early pages
					else
					{
						$this->pagination.= "<li><a href=\"javascript:;\" onClick='$this->funcion(\"1\",$this->servicio)'>1</a></li>";
						$this->pagination.= "<li><a href=\"javascript:;\" onClick='$this->funcion(\"2\",$this->servicio)'>2</a></li>";
						$this->pagination.= "<li><a href=\"javascript:;\">...</a></li>";
						for ($counter = $this->lastpage - (2 + ($this->adjacents * 2)); $counter <= $this->lastpage; $counter++)
						{
							if ($counter == $this->page)
								$this->pagination.= "<li class=\"active\"><a href='javascript:;'>$counter</a></li>";
							else
								$this->pagination.= "<li><a href=\"javascript:;\" onClick='$this->funcion(\"$counter\",$this->servicio)'>$counter</a></li>";					
						}
					}
				}

				//next button
				if ($this->page < $counter - 1) 
				$this->pagination.= "<li><a href=\"javascript:;\" onClick='$this->funcion(\"$this->next\",$this->servicio)'>&raquo;</a></li>";
				else
				$this->pagination.= "<li class=\"disabled\"><a href=\"javascript:;\">&raquo;</a></li>";
				$this->pagination.= "</ul>";		
			}
		}
		function crearTablaPaginacionFiltrar($button=false,$btnText="",$func="",$btnInicio=false,$debug=false,$img=false)
		{
			$this->returnNoPaginas();
			$cnx = new conexion();
			$tablaCompleta = $cnx->returnTabla($this->sql,$debug,$button,$btnText,$func,$btnInicio,$img);
			echo '<div class="col-sm-12" style="margin-bottom:10px;">
			<div class="input-group">
			<input id="txtFiltrar" type="text" class="form-control">
			<span class="input-group-btn">
			<button id="btnFiltrar" class="btn btndefault" type="button" onclick="'.$this->filtrar.'($(\'#txtFiltrar\').val(),'.$this->servicio.')">Buscar</button>
			</span>
			</div><!-- /input-group -->
			</div><br/>'.$this->pagination;
			return "<div id='divtabla' >".$tablaCompleta."</div>";
		}
		function crearTablaPaginacion($button=false,$btnText="",$func="",$btnInicio=false,$debug=false,$img=false)
		{
			$this->returnNoPaginas();
			$cnx = new conexion();
			$tablaCompleta = $cnx->returnTabla($this->sql,$debug,$button,$btnText,$func,$btnInicio,$img);
			echo ''.$this->pagination;
			return "<div id='divtabla' >".$tablaCompleta."</div>";
		}
	}
?>