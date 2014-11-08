<?php
/**
* Clase para crear objetos html dado un resultset.
* Fecha de Creacion: 24/09/2014 
* Fecha de Actualizacion: 26/09/2014 
* TODO: terminar, 
*/
include_once 'cconexion.php';
class HTMLObject
{
	var $htmlObject;
	var $sql;
	function HTMLObject($table)
	{
        $this->htmlObject = '';
		$this->sql = "select column_name as columna,data_type as tipodato,coalesce(column_default,'0') as default,coalesce(character_maximum_length,0) as length,
is_nullable as null,coalesce((select 1
from information_schema.constraint_column_usage
inner join information_schema.table_constraints 
on information_schema.table_constraints.constraint_name=
information_schema.constraint_column_usage.constraint_name 
where information_schema.table_constraints.table_name = '$table' 
and column_name =information_schema.columns.column_name
and constraint_type = 'PRIMARY KEY'
),0)isprimary,
coalesce((select information_schema.constraint_column_usage.table_name
from information_schema.constraint_column_usage
inner join information_schema.table_constraints 
on information_schema.table_constraints.constraint_name=
information_schema.constraint_column_usage.constraint_name 
where information_schema.table_constraints.table_name = '$table' 
and column_name =information_schema.columns.column_name
and constraint_type = 'PRIMARY KEY'
),'')primarytable,
coalesce((select 1 
from information_schema.constraint_column_usage
inner join information_schema.table_constraints 
on information_schema.table_constraints.constraint_name=
information_schema.constraint_column_usage.constraint_name 
where information_schema.table_constraints.table_name = '$table' 
and column_name =information_schema.columns.column_name
and constraint_type = 'FOREIGN KEY' limit 1
),0)isforeign,
coalesce((select information_schema.constraint_column_usage.table_name 
from information_schema.constraint_column_usage
inner join information_schema.table_constraints 
on information_schema.table_constraints.constraint_name=
information_schema.constraint_column_usage.constraint_name 
where information_schema.table_constraints.table_name = '$table' 
and column_name =information_schema.columns.column_name
and constraint_type = 'FOREIGN KEY' limit 1
),'')foreigntable
from information_schema.columns
where table_name = '$table'
";
	}
	function returnHTMLObject()
	{
		$objeto = "";
		$cnx = new conexion();
		$datarequired=false;
		$rs = $cnx->returnRS($this->sql, true);
		while ($r = $rs->FetchRow()) {
			if($r["columna"] == "status")
			{
				$objeto .= '<input type="hidden" name="status" id="status" />';
			}
            elseif($r['columna'] == 'idcandidato')
            {
                
            }
            elseif($r['columna'] == 'idempleado')
            {
                
            }
			elseif($r["isprimary"] == "1")
			{
				$objeto .= '<input type="hidden" name="'.$r["columna"].'" id="'.$r["columna"].'" />';	
			}
			elseif($r["isforeign"] == "1")
			{
                $objeto .= '<div class="form-group">';
				$objeto .= "<label for='".$r['columna']."' class='col-sm-2 control-label'>".str_replace("id",'',$r['columna'])."</label>";
				$objeto .= '<div class="col-sm-7">';
                $objeto .= '<select name="'.$r["columna"].'" id="'.$r["columna"].'" class="form-control" >';
				$objeto .= $cnx->crearOption('select '.$r["columna"].' as id,descripcion from '.$r['foreigntable'],'-1');
                $objeto .= '</select>';
                $objeto .= '</div>';
                $objeto .= '</div>';
                
			}
			else
			{
				$datarequired = $r['null']=='YES'?'TRUE':'FALSE';
				$length = $r['length']!='0'?'data-length="'.$r['length'].'"':'';
				if($r["tipodato"] == "integer" || $r["tipodato"] == "numeric")
				{
                    $objeto .= '<div class="form-group">';
					$objeto .= "<label for='".$r['columna']."' class='col-sm-2 control-label'>".$r['columna']."</label>";
					$objeto .= '<div class="col-sm-7">';
                    $objeto .= '<input id="'.$r['columna'].'" name="'.$r['columna'].'" class="form-control" type="text" data-type="numeric" '.$length.' data-required="'.$datarequired.'" />';
                    $objeto .= '</div>';
                    $objeto .= '</div>';
                }
				elseif($r['tipodato'] == 'character varying')
				{
                    $objeto .= '<div class="form-group">';
					$objeto .= "<label for='".$r['columna']."' class='col-sm-2 control-label'>".$r['columna']."</label>";
                    $objeto .= '<div class="col-sm-7">';
					$objeto .= '<input id="'.$r['columna'].'" name="'.$r['columna'].'" class="form-control"  type="text" data-type="alphanumeric" '.$length.' data-required="'
                    .$datarequired.'" />';	
                    $objeto .= '</div>';
                    $objeto .= '</div>';
				}
                elseif($r['tipodato'] == 'text')
				{
                    $objeto .= '<div class="form-group">';
					$objeto .= "<label for='".$r['columna']."' class='col-sm-2 control-label'>".$r['columna']."</label>";
                    $objeto .= '<div class="col-sm-7">';
					$objeto .= '<textarea id="'.$r['columna'].'" name="'.$r['columna'].'" class="form-control"  type="text" data-type="alphanumeric" '.$length.' data-required="'
                    .$datarequired.'" ></textarea>';	
                    $objeto .= '</div>';
                    $objeto .= '</div>';
				}
                elseif($r['tipodato'] == 'date')
                {
                   $objeto .= '<div class="form-group">';
					$objeto .= "<label for='".$r['columna']."' class='col-sm-2 control-label'>".$r['columna']."</label>";
                    $objeto .= '<div class="col-sm-7">';
					$objeto .= '<input id="'.$r['columna'].'" name="'.$r['columna'].'" class="form-control"  type="text" data-type="date" '.$length.' data-required="'
                    .$datarequired.'" />';	
                    $objeto .= '</div>';
                    $objeto .= '</div>'; 
                }
			}

		}
		return $objeto;
	}
}
?>