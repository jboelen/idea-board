<?

Class Vote{
	public $voteId;
	public $ideaId;
	public $userId;
	public $value;
	public $date;
	
	
	function __construct(){
		$this->voteId = 0;
		$this->ideaId = 0;
		$this->userId = 0;
		$this->value = 0;
		$this->date = new DateTime();
	}
	
	function Save(){
		global $_connection;
		
		if ($this->voteId == 0) {
			$_connection->QueryString = "INSERT INTO Vote (`ideaid`, `userid`,`value`,`date`) VALUES (?,?,?,?)";

			$_connection->addInParam('i', $this->ideaId);
			$_connection->addInParam('i', $this->userId);
			$_connection->addInParam('i', $this->value);
			$_connection->addInParam('s', $this->submitted->format('Y-m-d H:i:s'));
			
			$_connection->prepare();
			$_connection->execute();
			
			$this->id = $_connection->getInsertId();
			$_connection->close();
			
			if ($this->id != 0)
				return true;
				
		}else{
			$_connection->QueryString = "UPDATE Vote SET `ideaid` = ?,`value` = ?,`date` = ? WHERE `voteId` = ?";

			$_connection->addInParam('i', $this->ideaId);
			$_connection->addInParam('i', $this->value);
			$_connection->addInParam('s', $this->submitted->format('Y-m-d H:i:s'));
			$_connection->addInParam('i', $this->voteId);
			
			$_connection->prepare();
			$_connection->execute();
			
			$_connection->close();

			return true;
		}
		
		return false;
	}
	
	public static function GetByUserIdAndIdeaId($userId, $ideaId) {
		global $_connection;
		
		$_connection->QueryString = "SELECT `voteid`, `ideaid`, `userid`, `value`, `date` FROM Vote WHERE `userid` = ? AND `ideaid` = ?";
		
		$_connection->addInParam('i', $userId);
		$_connection->addInParam('i', $ideaId);
		
		$result = new Vote();
		
		$_connection->addOutParam($result->voteId);
		$_connection->addOutParam($result->ideaId);
		$_connection->addOutParam($result->userId);
		$_connection->addOutParam($result->value);
		$_connection->addOutParam($date);
		
		$_connection->prepare();
		$_connection->execute();
		
		$_connection->fetch();
		$_connection->close();
		
		$result->submitted = new DateTime($date);	
		
		return $result;
	}
	
	public static function GetByUserId($userId) {
		global $_connection;
		
		$_connection->QueryString = "SELECT `voteid`, `ideaid`, `userid`, `value`, `date` FROM Vote WHERE `userid` = ?";
		
		$_connection->addInParam('i', $userId);
		
		$_connection->addOutParam($_voteId);
		$_connection->addOutParam($_ideaId);
		$_connection->addOutParam($_userId);
		$_connection->addOutParam($_value);
		$_connection->addOutParam($_date);
		
		$_connection->prepare();
		$_connection->execute();
		
		$result = array();
		
				
		while($_connection->fetch()){
			$temp = new Vote();
			$temp->voteId = $_voteId;
			$temp->ideaId = $_ideaId;
			$temp->userId = $_userId;
			$temp->value = $_value;
			$temp->submitted = new DateTime($_date);
		
			$result[$temp->ideaId] = $temp;
		}
		$_connection->close();	
		
		return $result;
	}
}

?>