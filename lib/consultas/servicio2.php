<?php
	include_once 'cconexion.php';
	include_once 'HTMLObject.class.php';
	if($_REQUEST)
	{
		extract($_REQUEST);
		$cnx = new conexion();
		switch ($servicio) {
			case 'test':
                $object = new HTMLObject('venta');
				echo $object->returnHTMLObject();
			break;
			case 'login':
				# login code...
			break;
			case 'poblarCombo':
				# llenar combo code...
			$sql = 'select idarticulo,descripcion from articulo where status=1';
			echo $cnx->poblarCombo($sql,true);
			break;
			case 'articulo':
				switch ($accion) {
					case '1':
						# insert code...
						$idarticulo = '(select coalesce(max(idarticulo)+1,1) from articulo)';
						$sql ='insert into articulo values('.$idarticulo.',\''.$txtDescripcion.'\','.$txtCantidad.','.$txtPrecio.',1,\'\')';
						echo $cnx->consultaAccion($sql);
					break;
					case '2':
						# update code...
					break;
					case '3':
							# delete/reactivate code...
					break;
					case '4':
							# search code...
					break;	
					default:
						# code...
						break;
				}
			break;
			default:
				# code...
			break;
		}
	}
?>