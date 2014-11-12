<?php
/**
 * Conexion
 *
 *
 * @category   Conexion
 * @package    Conexion
 * @copyright  Copyright (c) 20014 - 2014
 * @version    1.2.0, 2014-08-21
 * @author     Miguel Angel Padilla Abrego - Thewolf
 * @author     Victor Alfonso Garcia Vazquez
 */
class Conexion
{
	/**
	 *  
	 */
	protected $_Conexion;
  protected $_ADODBRoute;
	
	/**
	 * 
	 * 
	 */ 
	function __construct($identificador = null)
	{
    if(!isnull($identificador)){
      Conectar($identificador);
    }
    $this->_ADODBRoute = dirname(__FILE__) . '/adodb5/adodb.inc.php';
	}

	/**
	 * Funcion conectar. Se utiliza para establecer la conexion a la base de datos. Requiere del archivo Conexion.inc.php
	 *
   * @param   string  identificador   Identicador del archivo Conexion.inc.php para obtener los datos de conexion a la base de datos.
   * @return  boolean  Regresa verdadero si la conexion se establecio con exito, regresa falso en caso contrario.
   * @throws  
	 */ 
	function Conectar($identificador)
	{
    if (!file_exists($this->_ADODBRoute)) {
      throw new Exception("No se ah encontrado ADODB en la ruta indicada");
    }
    include $this->_ADODBRoute;
	  if (!file_exists(dirname(__FILE__). '/Conexion.inc.php')) {
      throw new Exception("No se ah encontrado el archivo de configuracion de base de datos");
    }
    include dirname(__FILE__). '/Conexion.inc.php';
    if (!isset($_DB["$identificador"])) {
      throw new Exception("No se ah encontrado la configuracion para la base de datos $identificador", 1);
    }
    extract($_DB["$identificador"]);
		$this->_Conexion = ADONewConnection("$driver");
		$this->_Conexion->debug = $debug;
		$this->_Conexion->Connect($server, $user, $password, $dbname) or die('No se pudo establecer la conexcion');
	}

  /**
   * Funcion conectar. Se utiliza para establecer la conexion a la base de datos. Los valores son dados manuelmente, no 
   * requiere del archivo Conexion.inc.php
   *
   * @param   string  identificador   Identicador del archivo Conexion.inc.php para obtener los datos de conexion a la base de datos.
   * @return  boolean  Regresa verdadero si la conexion se establecio con exito, regresa falso en caso contrario.
   * @throws  
   */ 
  function conectarbyparams($driver, $server, $user, $password, $dbname, $debug)
  {
    if (!file_exists($this->_ADODBRoute)) {
      throw new Exception("No se ah encontrado ADODB en la ruta indicada");
    }
    include_once $this->_ADODBRoute;
    $this->_Conexion = ADONewConnection("$driver");
    $this->_Conexion->debug = $debug;
    $this->_Conexion->Connect($server, $user, $password, $dbname) or die('No se pudo establecer la conexcion');
  }

  #Region Propiedades
  function setDebugMode($debug){
    $this->_Conexion->debug = $debug;
  }

  /**
   *  Asigna la ruta donde la clase buscara los archivos de ADODB
   * 
   *  @param  STRING  route    Define el directorio de acceso a ADODB
   *  @throws  
   */
  function setADODBRoute($route){
    if (!file_exists($route)) {
      throw new Exception("La ruta expecificada no es valida");
    }
    //Verificar que contenga los archivos minimos...
    if (false) {
      throw new Exception("No se han encontrado todos los archivos requeridos.");
    }
    $this->_ADODBRoute = $route . 'adodb.inc.php';
  }

  function getADODBRoute($realpath = false){
    if ($realpath) {
      return realpath($this->_ADODBRoute);
    }
    return $this->_ADODBRoute;
  }


	/*
	 * Funcion consultaAccion. Permite ejecutar consultas de accion en la base de datos Ej.; Insert, Update Delete
	 * Parametros: $sql. String. Consulta de Accion a ejecutarse Ej.: Insert Into empleado values(1,'nombre');
	 * 					  $debug. Boolean. Default False. Indica si la consulta se debe debuggear.
	 * Retorna 1/0. 1 en caso de que la consulta se ejecute con exito.
	 * 					  0 en caso de que ocurra algun error.
	 */ 
	function consultaAccion($sql)
	{
		if($this->_Conexion->Execute($sql) != false)
			return 1;
		else
			return 0;
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
		$rs = $this->_Conexion->Execute($consulta);
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
	

	/**
	 * toJSON. Ejecuta una consulta en la base de datos y retorna un ResultSet para su posterior manejo en alguna otra funcion.
	 * 
   * @param  string  _Query  null  Genera un string con el formato JSON de la consulta solicitada. Valor null toma el ResulSet actual.
   * @return  string  Cadena en formato JSON
	 */ 
	function toJSON($query)
	{
	  $rs=$this->returnRS($query);
		if ($rs != null) 
		{
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
			$rows.= "]";
			return $rows;
		}
		else 
		{
			return 0;
		}
	}
	
}	
?>