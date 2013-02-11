<?
/*
 * Written By James Boelen
 */
 
if(!defined("_IN_PREMISE"))
	die("ERROR :: Hacking Attempt detected");

class Database
{	
	private $connection;
	private $types = "";
	private $InVars = array();
	private $OutVars = array();
	public $QueryString;
	private $statement;
	private $stored = false;
	function __construct()
	{
		global $db;
		$this->connection = new mysqli($db["address"], $db["username"], $db["password"], $db["database"]) or die("ERROR :: Could not connect to database {$db['database']}");
		if (mysqli_connect_errno()){
		    die("ERROR :: Could Not Connect To Database - " . mysqli_connect_error());
		}
	}
	
	function prepare($input = "!")
	{
		if($input != "!")
			$this->statement = $this->connection->prepare($input);
		else
		{
			$this->statement = $this->connection->prepare($this->QueryString);
		}
		
		if ($this->statement == false)
			die ("ERROR :: Bad Query String -> " . $this->QueryString);
	}
	
	function addInParam($type, &$value)
	{
		$this->types .= $type;
		$this->InVars[] = &$value;
	}
	
	function addOutParam(&$var)
	{
		$this->OutVars[] = &$var;
	}
	
	function execute()
	{
		$params = array();
		$params[] = $this->types;
		foreach($this->InVars as $key => $value) 
		            $params[] = &$this->InVars[$key];
		//var_dump($this->statement);
		//echo($this->QueryString);
		//var_dump(($params));
		if (count($this->InVars) > 0)
			call_user_func_array (array($this->statement,'bind_param'), $params);

		$ret = $this->statement->execute();
		
		if (count($this->OutVars) > 0)
			call_user_func_array (array($this->statement,'bind_result'), $this->OutVars);
		return $ret;
	}
	
	function fetch()
	{
        return $this->statement->fetch();
		
	}
	
	function close()
	{
		if($this->statement)
			$this->statement->close();
		unset($statement);
		$this->reset();
	}
	
	function get_rows()
	{
		if(!$this->stored)
		{
			$this->statement->store_result();
			$this->stored = true;
		}
			
		return $this->statement->num_rows;
	}
	
	function getInsertId(){
		return mysqli_insert_id($this->connection);
	}
	
	function seek($position = 0)
	{
		$this->statement->data_seek($position);
	}
	
	private function reset()
	{
		foreach ($this->InVars as $i => $value) {
		    unset($this->InVars[$i]);
		}	
		
		foreach ($this->OutVars as $i => $value) {
		    unset($this->OutVars[$i]);
		}	
		
		$this->types = "";
		$this->stored = false;
	}
	
	
	
	
}

?>