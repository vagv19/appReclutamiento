<?php 
class Sqlgen
{
	public $db_type 	= 'mysql'; 		
	
	private $errors 		= array();		
	private $where 			= NULL;			
	private $limit			= NULL;			
	private $select			= NULL;			
	private $order			= NULL;			
	private $sql			= NULL;			
	private $like			= NULL;			
	private $from			= NULL;			
	private $join			= NULL;			
	private $where_in		= NULL;			
	private $between 		= NULL;			
	private $group_by 		= NULL;			
	private $having 		= NULL;			
	private $add_after		= NULL;			
	private $add_before		= NULL;			
	private $lasts_sql		= array();		
	private $last_sql		= NULL;			
	private $selectDistinct	= FALSE;		
	
	function __contruct($array = array())
	{
		if((bool) $array)
		{
			$this->load($array);
		}
	}
	public function load($params = array())
	{
		$array = array('db_type');
		
		foreach($array as $item)
		{
			if(isset($params[$item]))
			{	
				$this->$item = $params[$item];
			}
		}
		return $this;
	}
	
	
	
	public function print_debugger()
	{
		if((bool) $this->errors)
		{
			return $this->_implode($this->errors,'<br />');
		}
		return false;
	}
	
	public function get($table = NULL,$where = NULL)
	{
		if((bool) ! $table and (bool) ! $this->from)
		{
			$this->set_error("Warning: Wrong parameter in get().");
			return false;
		}
		
		if(is_array($where) and (bool) $where)
		{
			foreach($where as $k => $v)
			{
				$this->where($k,$v);
			}
		}
		
		if((bool) ! $table)
		{
			$table = $this->from;
		}
		
		return $this->sql($table,'select');
	}
	
	public function mass_insert($table,$dados = NULL)
	{
		if((bool) ! $dados)
		{
			$this->set_error("Warning: Wrong parameter in mass_insert().");
			return false;
		}
		
		$sqlk = NULL;
		$sqlv = NULL;
		$first = true;
		
		foreach($dados[0] as $k => $v)
		{
			if(!$first)
			{
				$sqlk .= ', '.$k.'';
				
			} else
			{
				$sqlk .= ''.$k.'';
				$first = false;
			}
		}
		
		$sqlv = $this->_generate_mass_insert($dados);
		
		return $this->sql($table,'insert',$sqlk,trim($sqlv,'(,)'));
	}
	
	public function insert($table,$dados = NULL)
	{
		if((bool) ! $dados)
		{
			$this->set_error("Precaucion: Parametros Incorrectos en el Insert().");
			return false;
		}
		
		$sqlk = NULL;
		$sqlv = NULL;
		$first = true;
		
		foreach($dados as $k => $v)
		{
			if(!$first)
			{
				$sqlk .= ', '.$k.'';
				if(is_string($v))
				{
					$sqlv .= ", '".$v."'";
				} else
				{
					$sqlv .= ", ".$v;
				}
				
			} else
			{
				$sqlk .= ''.$k.'';
				$sqlv .= $v;
				$first = false;
			}
		}
		
		return $this->sql($table,'insert',$sqlk,$sqlv);
	}
	
	public function update($table,$dados,$where = NULL)
	{
		
		if(!is_array($dados))
		{
			$this->set_error("Warning: Wrong parameter in update().");
			return false;
		}
		
		if(is_array($where) and (bool) $where)
		{
			foreach($where as $k => $v)
			{
				$this->where($k,$v);
			}
		}
		
		$set = NULL;
		$first = true;
		foreach($dados as $k => $v)
		{
			$aux = NULL;
			$k = trim($k);
			
			if((bool) preg_match("/(\+|-){1}$/",$k,$mt) === FALSE)
			{
				if(is_string($v))
				{
					$aux = ''.$k." = '".$v."'";
				} else
				{
					$aux = ''.$k." = ".$v;
				}
			} else
			{
				$k = rtrim($k,$mt[0]);
				$aux = ''.$k." = ".$k."".$mt[0].$v;
			}
			
			if(!$first)
			{
				$set .= ','.$aux;
			} else
			{
				$set .= $aux;
				$first = false;
			}
		}
		
		return $this->sql($table,'update',$set);
	}
	
	
	public function delete($table,$where = NULL)
	{
		if(is_array($where) and (bool) $where)
		{
			foreach($where as $k => $v)
			{
				$this->where($k,$v);
			}
		}
		return $this->sql($table,'delete');
	}
	
	public function last_query($showAll = FALSE)
	{
		if($showAll === FALSE)
		{
			return $this->last_sql;
		}
		
		return $this->_implode($this->lasts_sql,'<br />');
	}
	
	public function between($column,$min,$max,$fetch = 'AND',$comp = NULL)
	{
		$fetch = strtoupper(trim($fetch));
		
		if(!in_array($fetch,array('AND','OR')))
		{
			$this->set_error("Warning: Wrong parameter in between().");
			return false;
		}
		
		$column = $this->add_crase($column);
		$comp = strtoupper(trim($comp));
		
		if((bool) ! $comp OR $comp != 'NOT')
		{
			$bet = $column.' BETWEEN \''.$min.'\' AND \''.$max.'\'';
		} else
		{
			
			$bet = $column.' NOT BETWEEN \''.$min.'\' AND \''.$max.'\'';
		}
		
		if((bool) ! $this->between)
		{
			$this->between .= $fetch.' '.$this->_isolate($bet,false);
		} else
		{
			$this->between .= "\n".$fetch.' '.$this->_isolate($bet,false);
		}
		
		return $this;
	}
	
	public function group_by($column)
	{
		$this->group_by = $this->add_crase($column);
		return $this;
	}
	
	public function having($col,$valor = NULL,$fetch = 'AND')
	{
		if((bool) ! $col AND (bool) ! $valor)
		{
			$this->set_error("Warning: Wrong parameter in having().");
			return FALSE;
		}
		
		$fetch = strtoupper(trim($fetch));
		if(!in_array($fetch,array('AND','OR')))
		{
			$this->set_error("Warning: Wrong parameter in having().");
			return false;
		}
		
		if(!is_array($col))
		{
			$hav = NULL;
			$having = NULL;
			if((bool) preg_match_all("/(<|>|=|!)/U",$col,$mt))
			{
				$hav = $this->add_crase(trim(str_replace($mt[0],NULL,$col))).' '.$this->_implode($mt[0],'').' ';
			} else
			{
				$hav = $this->add_crase(trim($col)).' = ';
			}
			
			
			if(!is_string($valor))
			{
				$having .= $hav.$valor;
			} else
			{
				$having .= $hav." '".$valor."'";
			}
			
			if((bool) ! $this->having)
			{
				$this->having = $this->_isolate($having);
			} else
			{
				$this->having .= "\n".$fetch.' '.$this->_isolate($having);
			}
			
		} else
		{
			foreach($col as $kc => $vc)
			{
				$this->having($kc,$vc,$fetch);
			}
		}
		
		return $this;
	}
	
	public function join($table,$param,$type = NULL)
	{
		//OPTIONS left, right, outer, inner, left outer, and right outer
		if((bool) $type)
		{
			$type = strtoupper(trim($type));
			if(!in_array($type,$this->_explode('LEFT,RIGHT,OUTER,INNER,LEFT OUTER,RIGHT OUTER',',')))
			{
				$this->set_error("Warning: Wrong parameter in join().");
				return false;
			}
		}
		
		$join = NULL;
		
		if((bool) ! $type)
		{
			$join .= 'JOIN '.$this->add_crase($table).' ON ';
		} else
		{
			$join .= $type.' JOIN '.$this->add_crase($table).' ON ';
		}
		
		$join .= $this->add_crase($param);
		
		if((bool) ! $this->join)
		{
			$this->join .= $join;
		} else
		{
			$this->join .= "\n".$join;
		}
		
		return $this;
	}
	
	public function from($table = NULL)
	{
		$table = $this->clear($table);
		$this->from = $table;
		return $this;
	}
	
	public function order_by($tables,$order = NULL)
	{
		
		if(is_array($tables))
		{
			foreach($tables as $ktab => $vtab)
			{
				if($this->is_number($ktab))
				{
					$this->order_by($vtab,$order);
				} else
				{
					$this->order_by($ktab,$vtab);
				}
			}
			return $this;
		}
		
		if((bool) $order)
		{
			$order = strtoupper(trim($order));
			
			if(!in_array($order,array('ASC','DESC')))
			{
				$this->set_error("Warning: Wrong parameter in order_by(). 1");
				return false;
			}
			if(is_array($tables))
			{
				$this->set_error("Warning: Wrong parameter in order_by(). 2");
				return false;
			}
			$tables = trim($tables);
			if((bool) ! $this->order)
			{
				$this->order .= $this->add_crase($tables).' '.$order;
				return $this;
			} else
			{
				$this->order .= ','.$this->add_crase($tables).' '.$order;
				return $this;
			}
		}
		
		$t_order = strtoupper(trim($tables));
		if($t_order == 'RAND' OR $t_order == 'RAND()')
		{
			$this->order = 'RAND()';
			return $this;
		}
		
		if((bool) !preg_match("/(.+[ ])(asc|desc)/isU",$tables,$mt))
		{
			$this->set_error("Warning: Wrong parameter in order_by(). 3");
			return false;
		}
		
		if(isset($mt[1]) and isset($mt[2]))
		{
			return $this->order_by($mt[1],$mt[2]);
		}
		$this->set_error("Warning: Unknown error in order_by().");
		return false;
	}
	
	public function distinct()
	{
		$this->selectDistinct = TRUE;
		return $this;
	}
	
	public function select($tables,$keyword = NULL)
	{
		$keyword = strtolower(trim($keyword));
		switch($keyword)
		{
			case 'distinct':
			$this->distinct();
			break;
		}
		
		if($tables == '*')
		{
			$this->select = $this->_isolate('*',false);
			return $this;
		}
		
		if((bool) ! $this->select)
		{
			$this->select = $this->_isolate($this->add_crase($tables),false);
		} else
		{
			$this->select .= $this->_isolate(','.$this->add_crase($tables),false);
		}
		return $this;
	}
	
	public function limit($limite,$inicio = 0)
	{
		if($inicio === 0)
		{
			$this->limit = 'LIMIT '.$limite;
		} else
		{
			$this->limit = 'LIMIT '.$inicio.','.$limite;
		}
		return $this;
	}
	
	public function where_in($key,$value = NULL,$fetch = 'AND',$comp = NULL)
	{
		if((bool) ! $value)
		{
			$this->set_error("Warning: Wrong parameter in where_in().");
			return false;
		}
		
		if(!is_array($value))
		{
			$value = array($value);
		}
		
		$fetch = strtoupper(trim($fetch));
		
		if(!in_array($fetch,array('AND','OR')))
		{
			$this->set_error("Warning: Wrong parameter in where_in().");
			return false;
		}
		
		if((bool) $comp) $comp = strtoupper(trim($comp));
		
		$in = NULL;
		$in .= $this->add_crase($key);
		
		if((bool) ! $comp)
		{
			$in .= ' IN';
		} else
		{
			if($comp == 'NOT' OR $comp == 'NOT IN')
			{
				$in .= ' NOT IN';
			} else
			{
				$in .= ' IN';
			}
		}
		
		$vals = array();
		foreach($value as $val)
		{
			if(is_string($val))
			{
				$vals[] = '\''.$val.'\'';
			} else
			{
				$vals[] = $val;
			}
		}
		
		$in .= ' ('.$this->_implode($vals,',').')';
		$this->where_in .= "\n".$fetch.' '.$this->_isolate($in);
		return $this;
	}
	
	public function custom_where($where)
	{
		$this->where .= "\n".trim($where);
		return $this;
	}
	
	public function where($key,$value = NULL,$fetch = 'AND',$recursive = FALSE)
	{
		if((bool) trim($key) AND is_string($key) AND $value === NULL)
		{
			return $this->custom_where($key);
		}
		
		if(!is_array($key) and $value === NULL)
		{
			$this->set_error("Warning: Wrong parameter in where().");
			return false;
		}
		
		$fetch = strtoupper(trim($fetch));
		if(!in_array($fetch,array('AND','OR')))
		{
			$this->set_error("Warning: Wrong parameter in where().");
			return false;
		}
		
		if(!is_array($key))
		{
			$where = NULL;
			if((bool) ! $this->where)
			{
				if((bool) preg_match_all("/(<|>|=|!)/U",$key,$mt))
				{
					$key = $this->add_crase(trim(str_replace($mt[0],NULL,$key))).' '.$this->_implode($mt[0],'');
					
					if(is_string($value))
					{
						$where .= $key." '".$value."'";
					} else
					{
						$where .= $key." ".$value;
					}
				} else
				{
					$key = $this->add_crase($key);
					
					if(is_string($value))
					{
						$where .= $key." = '".$value."'";
					} else
					{
						$where .= $key." = ".$value;
					}
				}
			} else
			{
				if((bool) preg_match_all("/(<|>|=|!)/U",$key,$mt))
				{
					$key = $this->add_crase(trim(str_replace($mt[0],NULL,$key))).' '.$this->_implode($mt[0],'');
					if(is_string($value))
					{
						$where .= "\n".$fetch.' '.$key." '".$value."'";
					} else
					{
						$where .= "\n".$fetch.' '.$key." ".$value;
					}
				} else
				{
					$key = $this->add_crase($key);
					
					if(is_string($value))
					{
						$where .= "\n".$fetch.' '.$key." = '".$value."'";
					} else
					{
						$where .= "\n".$fetch.' '.$key." = ".$value;
					}
				}
			}
			if($recursive === FALSE)
			{
				$this->where .= $this->_isolate($where);
			} else
			{
				$this->where = trim($this->where);
				$this->where .= " ";
				return $where;
			}
		} else
		{
			if((bool) !$key)
			{
				$this->set_error("Warning: Wrong parameter in where().");
				return false;
			}
			
			$wr = NULL;
			foreach($key as $k => $v)
			{
				$wr .= $this->where($k,$v,$fetch,TRUE);
			}
			
			$this->where .= $this->_isolate($wr);
		}
		return $this;
	}
	
	public function like($column,$val = NULL,$tags = 'both',$fetch = 'AND',$neg = NULL,$recursive = FALSE)
	{
		if(!is_array($column) and (bool) ! $val)
		{
			$this->set_error("Warning: Wrong parameter in like().");
			return false;
		}
		
		$fetch = strtoupper(trim($fetch));
		if(!in_array($fetch,array('AND','OR')))
		{
			$this->set_error("Warning: Wrong parameter in like().");
			return false;
		}
		
		if(!is_array($column))
		{
			$like = NULL;
			switch($tags)
			{
				case 'none':
				{
					$like .= ' '.$this->add_crase($column)." LIKE '".$val."'";
				}
				break;
				case 'before':
				{
					$like .= ' '.$this->add_crase($column)." LIKE '%".$val."'";
				}
				break;
				case 'after':
				{
					$like .= ' '.$this->add_crase($column)." LIKE '".$val."%'";
				}
				break;
				case 'both':
				{
					$like .= ' '.$this->add_crase($column)." LIKE '%".$val."%'";
				}
				break;
				default:
				{
					$like .= ' '.$this->add_crase($column)." LIKE '%".$val."%'";
				}
				break;
			}
			if($recursive === FALSE)
			{
				$this->like .= $this->_isolate("\n".$fetch.$like);
			} else
			{
				$this->like = trim($this->like);
				$this->like = " ";
				return $like;
			}
			
		} else
		{
			$lk = NULL;
			foreach($column as $k => $v)
			{
				$lk = $this->like($k,$v,$tags,$fetch,TRUE);
			}
			$this->like .= $this->_isolate($lk);
		}
		return $this;
	}
	
	public function add_before($b = '(')//antes
	{
		$this->add_before = $b;
		return $this;
	}
	
	public function add_after($a = ')')//depois
	{
		$this->add_after = $a;
		return $this;
	}
	
	public function add_both($b = '(',$a = ')')//ambos
	{
		$this->add_before = $b;
		$this->add_after = $a;
		return $this;
	}
	
	public function clean()
	{
		$this->where 			= NULL;
		$this->limit			= NULL;
		$this->select			= NULL;
		$this->order			= NULL;
		$this->sql				= NULL;
		$this->like				= NULL;
		$this->from				= NULL;
		$this->join				= NULL;
		$this->where_in			= NULL;
		$this->between			= NULL;
		$this->group_by			= NULL;
		$this->having			= NULL;
		$this->add_after		= NULL;
		$this->add_before		= NULL;
		$this->selectDistinct	= FALSE;
		return $this;
	}
	
	
	/******************************************************************/
	/****************** PRIVATE FUNCTIONS *****************************/
	/******************************************************************/
	
	private function set_error($error = NULL)
	{
		if((bool) $error)
		{
			$this->errors[] = $error;
			return $this;
		}
		return false;
	}
	
	private function _generate_mass_insert($dados = NULL)
	{
		$mass = NULL;
		foreach($dados as $dd)
		{
			$sqlv = NULL;
			$first = true;
			foreach($dd as $k => $v)
			{
				if(!$first)
				{
					if(is_string($v))
					{
						$sqlv .= ", '".$v."'";
					} else
					{
						$sqlv .= ", ".$v;

					}
					
				} else
				{
					if(is_string($v))
					{
						$sqlv .= "'".$v."'";
					} else
					{
						$sqlv .= $v;
					}
					$first = false;
				}
			}
			
			if((bool) ! $mass)
			{
				$mass .= '('.$sqlv.')';
			} else
			{
				$mass .= ', ('.$sqlv.')';
			}
		}
		return $mass;
	}
	
	private function sql($table,$action,$first = NULL,$second = NULL)
	{
		$action = strtoupper(trim($action));
		$table = $this->clear($table);
		$sql = NULL;
		switch($action)
		{
			case 'UPDATE';
			{
				$sql .= "UPDATE ".$this->add_crase($table)." SET ".$first;
			}
			break;
			
			case 'SELECT':
			{
				if((bool) ! $this->select)
				{
					$sql .= 'SELECT * FROM '.$this->add_crase($table).'';
				} else
				{
					if($this->selectDistinct === FALSE)
					{
						$sql .= 'SELECT '.$this->select.' FROM '.$this->add_crase($table).'';
					} else
					{
						$sql .= 'SELECT DISTINCT '.$this->select.' FROM '.$this->add_crase($table).'';
					}
				}
			}
			break;
			
			case 'INSERT':
			{
				$sql .= 'INSERT INTO '.$this->add_crase($table).' ('.$first.') VALUES ('.$second.')';
				$this->clean();
				return $sql;
			}
			break;
			
			case 'DELETE':
			{
				$sql .= 'DELETE FROM '.$this->add_crase($table).'';
			}
			break;
			
			default:
			return false;
			break;
		}
		
		if((bool) $this->join)
		{
			$sql .= "\n".$this->join;
		}
		
		if((bool) $this->where)
		{
			$sql .= "\nWHERE ".$this->where;
		}
		
		if((bool) $this->where_in)
		{

			$this->where_in = trim($this->where_in);
			if((bool) ! $this->where)
			{
				$sql .= "\nWHERE ".ltrim($this->where_in,'AND,OR, ');
			} else
			{
				$sql .= "\n".$this->where_in;
			}
		}
		
		if((bool) $this->like)
		{
			$this->like = trim($this->like);
			if((bool) ! $this->where and (bool) ! $this->where_in)
			{
				$sql .= "\nWHERE ".ltrim($this->like,'AND,OR, ');
			} else
			{
				$sql .= "\n".$this->like;
			}
		}
		
		if((bool) $this->between)
		{
			$this->between = trim($this->between);
			if((bool) ! $this->where and (bool) ! $this->where_in and (bool) ! $this->like)
			{
				$sql .= "\nWHERE ".ltrim($this->between,'AND,OR, ');
			} else
			{
				$sql .= "\n".$this->between;
			}
		}
		
		if((bool) $this->group_by)
		{
			$sql .= "\nGROUP BY ".$this->group_by;
			
			if((bool) $this->having)
			{
				$sql .= "\nHAVING ".$this->having;
			}
		}
		
		if((bool) $this->order)
		{
			$sql .= "\nORDER BY ".$this->order;
		}
		if((bool) $this->limit)
		{
			$sql .= "\n".$this->limit;
		}
		$this->clean();
		$this->lasts_sql[] = $sql;
		$this->last_sql = $sql;
		return $sql;
	}
	
	private function add_crase($var)
	{
		if((bool) !$var)
		{
			return false;
		}
		
		if($var == '*')
		{
			return $var;
		}
		
		$var = trim(preg_replace("/´/",NULL,$var));
		
		if(strpos($var,',') === FALSE)
		{
			if((bool) strpos($var,'='))
			{
				$r = $this->_explode($var,'=');
				return $this->add_crase(trim($r[0])).' = '.$this->add_crase(trim($r[1]));
			}
			
			if((bool) preg_match("/[\(\)]/",$var))
			{
				if((bool) preg_match("/[a-z0-9_-]\(([a-z0-9_\.,%-]+)\)/i",$var,$mts))
				{
					if(strpos($mts[1],',') === FALSE)
					{
						return str_replace($mts[1],$this->add_crase($mts[1]),$var);
					} else
					{
						$f = explode(',',$mts[1]);
						return str_replace($mts[1],$this->add_crase($f[0]).",'".$f[1]."'",$var);
					}
				}
				return $var;
			}
			
			if((bool) preg_match("/( as )/i",$var))
			{
				$nv = $this->_explode($var,' as ');
				return $this->add_crase($nv[0]).' as '.$nv[1];
			}
			
			if(strpos($var," "))
			{
				$nv = explode(" ",$var);
				return $this->add_crase($nv[0]).' '.$nv[1];
			}
		
		
			if(strpos($var,'.') === FALSE)
			{
				return ''.$var.'';
			}
			
			if(strpos($var,'*') === FALSE)
			{
				return ''.$this->_implode($this->_explode($var,'.'),'.').'';
			} else
			{
				$n = $this->_explode($var,'.');
				return ''.$n[0].'.*';
			}
		} else
		{
		
			$tbs = $this->_explode($var,',');
			if((bool) !$tbs)
			{
				return false;
			}
			
			$sel = array();
			foreach($tbs as $t)
			{
				$sel[] = $this->add_crase(trim($t));
			}
			return $this->_implode($sel,',');
		}
	}
	
	private function _isolate($var,$add_fetch = true)
	{
		if((bool) $this->add_before)
		{
			$var = trim($var);
			if(preg_match("/^(or|and)/iU",$var,$mt) and $add_fetch)
			{
				$var = ltrim($var,'AND,OR');
				$var = "\n".$mt[0].' '.$this->add_before.trim($var);
			} else
			{
				$var = $this->add_before.$var;
			}
			$this->add_before = NULL;
		}
		
		if((bool) $this->add_after)
		{
			$var = $var.$this->add_after;
			$this->add_after = NULL;
		}
		
		return $var;
	}
	
	public function clear($var)
	{
		return preg_replace("/([´'\"])/",NULL,$var);
	}
	
	public function display_errors()
	{
		return $this->_implode($this->errors,'<br />');
	}
	
	public function _array_walk($array,$function)
	{
		$r = NULL;
		foreach($array as $kr => $ar)
		{
			if(is_array($ar))
			{
				$r[$kr] = $this->_array_walk($ar,$function);
			} else
			{
				$r[$kr] = $function($ar);
			}
		}
		return $r;
	}
	
	public function _implode($var,$glue = NULL)
	{
		if((bool) !$var OR $glue === NULL)
		{
			return false;
		}
		
		if(!is_array($var))
		{
			return $var;
		}
		
		return implode($glue,$var);
	}
	
	public function _explode($var,$delimiter = NULL)
	{
		if((bool) !$var OR $delimiter === NULL)
		{
			return false;
		}
		$var = trim($var,$delimiter);
		if(strpos($var,$delimiter) == FALSE)
		{
			return array($var);
		}
		return explode($delimiter,$var);
	}
	
	public function is_number($num)
	{
		if(preg_match("/^([0-9\.])+$/i",$num)) return TRUE; else return FALSE;
	}
}