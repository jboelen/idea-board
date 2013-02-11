<?
/*
 * Written By James Boelen
 */
 
if(!defined("_IN_PREMISE"))
	die("ERROR :: Hacking Attempt detected");

Class User {

	public $id = 0;
	public $firstname = "";
	public $lastname = "";
	public $email = "";
	public $password = "";
	public $authlevel = 0;
	public $key = "";
	public $authority = 1;
	public $locked = 0;
	function __construct() {
		
	}
	
	function signin($email,$password) {
		global $_connection;
		
		$_connection->QueryString = "SELECT userId, firstname, lastname, email, authority FROM User WHERE email=? AND password=? AND locked = 0";
		
		$_connection->addInParam('s', $email);
		$_connection->addInParam('s', $password);
		
		$_connection->addOutParam($this->id);
		$_connection->addOutParam($this->firstname);
		$_connection->addOutParam($this->lastname);
		$_connection->addOutParam($this->email);
		$_connection->addOutParam($this->authority);
		
		$_connection->prepare();
		$_connection->execute();
		
		if ($_connection->get_rows() == 1) {
			$this->authlevel = 1;
			
			$_connection->fetch();
			$_connection->close();
			
			return true;
		}

		return false;
	}
	
	function ID()
	{
		return $this->id;
	}
	
	function signout() {
		return true;
	}
	
	function GetByKey($key)
	{
		global $_connection;
		$_connection->close();
		$_connection->QueryString = "SELECT `userId`, `key`, `firstname`, `lastname`, `email`, `authority`, `locked` FROM `User` WHERE `key`=?";
		
		$_connection->addInParam('s', $key);
		
		$_connection->addOutParam($this->id);
		$_connection->addOutParam($this->key);
		$_connection->addOutParam($this->firstname);
		$_connection->addOutParam($this->lastname);
		$_connection->addOutParam($this->email);
		$_connection->addOutParam($this->authority);
		$_connection->addOutParam($this->locked);
				
		$_connection->prepare();
		$_connection->execute();
		
		if ($_connection->get_rows() == 1) {
			$this->authlevel = 1;
			$_connection->fetch();
			$_connection->close();
			return true;
		}
		
		$_connection->close();
		return false;
	}
	
	public static function GetById($id)
	{
		global $_connection;
		$_connection->QueryString = "SELECT `userId`, `key`, `firstname`, `lastname`, `email`, `authority`, `locked` FROM `User` WHERE `userId`=?";
		
		$_connection->addInParam('s', $id);
		$result = new User();
		
		$_connection->addOutParam($result->id);
		$_connection->addOutParam($result->key);
		$_connection->addOutParam($result->firstname);
		$_connection->addOutParam($result->lastname);
		$_connection->addOutParam($result->email);
		$_connection->addOutParam($result->authority);
		$_connection->addOutParam($result->locked);
		
		$_connection->prepare();
		$_connection->execute();
		
		if ($_connection->get_rows() == 1) {
			$result->authlevel = 1;
			$_connection->fetch();
			$_connection->close();
			return $result;
		}

		$_connection->close();
		return $result;
	}
	
	public static function GetAll()
	{
		global $_connection;
		$_connection->QueryString = "SELECT `userId`, `key`, `firstname`, `lastname`, `email`, `authority`, `locked` FROM `User`";
		
		$_connection->addOutParam($_id);
		$_connection->addOutParam($_key);
		$_connection->addOutParam($_firstname);
		$_connection->addOutParam($_lastname);
		$_connection->addOutParam($_email);
		$_connection->addOutParam($_authority);
		$_connection->addOutParam($_locked);
		
		$_connection->prepare();
		$_connection->execute();
		
		$result = array();
		while($_connection->fetch()){
			$temp = new User();
			$temp->id = $_id;
			$temp->key = $_key;
			$temp->firstname = $_firstname;
			$temp->lastname = $_lastname;
			$temp->email = $_email;
			$temp->authority = $_authority;
			$temp->locked = $_locked;
			$result[] = $temp;
		}
			
		$_connection->close();
		return $result;
	}
	
	function Save()
	{
		global $_connection;
		if ($this->id == 0)
		{
			$_connection->QueryString = "INSERT INTO User (`key`,`firstname`,`lastname`,`email`) VALUES (?,?,?,?)";
			$_connection->addInParam('s', $this->key);
			$_connection->addInParam('s', $this->firstname);
			$_connection->addInParam('s', $this->lastname);
			$_connection->addInParam('s', $this->email);
			
			$_connection->prepare();
			$_connection->execute();
			
			$this->id = $_connection->getInsertId();
			$_connection->close();
			
			if ($this->ID() != 0)
				return true;
		}
		else
		{
			$_connection->QueryString = "UPDATE User SET `firstname` = ?, `lastname` = ?, `email` = ?, `password` = ?, `key`= ?, `authority` = ?, `locked`=? WHERE `userId`= ?";
			
			$_connection->addInParam('s', $this->firstname);
			$_connection->addInParam('s', $this->lastname);
			$_connection->addInParam('s', $this->email);
			$_connection->addInParam('s', $this->password);
			$_connection->addInParam('s', $this->key);
			$_connection->addInParam('i', $this->authority);
			$_connection->addInParam('i', $this->locked);
			$_connection->addInParam('i', $this->id);
			
			$_connection->prepare();
			$_connection->execute();
			$_connection->close();
			return true;
		}
		
		return false;
	}
	
	function SendInvite(){
	
		global $site_name;
		$to = "\"" . $this->firstname . " " . $this->lastname . "\"<" . $this->email . ">";
		$subject = "$site_name Invitation";
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		//$headers .= 'From: "$site_name" <no-reply@boelen.ca>' . "\r\n";
		$message = <<<eof
<html>
<head>
  <title>$subject</title>
</head>
<body>
  <h1>Hello {$this->firstname} {$this->lastname}!</h1>
  <p>You have been sent an invitation to collaborate and share ideas at $site_name. You may accept this
  invitation by clicking on the link below.</p>
  <p>
  Your invitation link: 
  <a href="http://premise.boelen.ca/account.php?action=register&key=$this->key"> Click Here to Accept!</a>
  </p> 
  <p>
  Your Registration Code: <strong>$this->key</strong>
  </p>
  <p>Sincerely,<br /> The Great Salmon Spirt.</p>
</body>
</html>
eof;
	return (mail($to, $subject, $message, $headers));
	}
	
	
}	
?>