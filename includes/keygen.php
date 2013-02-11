<?
/*
 * Written By James Boelen
 */
 
if(!defined("_IN_PREMISE"))
	die("ERROR :: Hacking Attempt detected");

class RegistrationKey
{	
	public $Value = '';
	
	function __construct() {
		
		While($this->Value == '')
		{
			$temp = $this->generateKey();
			if (!$this->isUsed($temp))
				$this->Value = $temp;
		}
	}

	//http://tomglenn.co.uk/web-development/random-key-generator-in-php/
	private function generateKey($tokenprefix = '', $sections = 5, $sectionlength = 5)
	{
		// Declare salt and prefix
		$token = $tokenprefix;
		$salt = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	
		// Prepare randomizer
		srand((double) microtime() * 1000000);
	
		// Create the token
		for($i = 0; $i < $sections; $i++)
		{
			for($n = 0; $n < $sectionlength; $n++)
			{
				$token.=substr($salt, rand() % strlen($salt), 1);
			}
	
			if($i < ($sections - 1)){ $token .= '-'; }
		}
	
		// Return the token
		return $token;
	}
	
	private function isUsed($key)
	{
		global $_connection;
		
		$_connection->QueryString = "SELECT COUNT(*) as cnt FROM User WHERE `key` = ?";
		$_connection->addInParam('s', $key);
		$_connection->addOutParam($rows);
		
		$_connection->prepare();
		$_connection->execute();
		$_connection->fetch();
		
		$_connection->close();
		if ( $rows == 1)
			return true;
		else
			return false;
	}
}
	
?>