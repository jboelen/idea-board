<?
Class Idea {
	public $id;
	public $owner;
	private $ownerId;
	public $title;
	public $summary;
	public $description;
	public $promoted;
	public $upvotes;
	public $downvotes;
	public $submitted;
	public $deleted;
	
	private $hotscore;
	
	function __construct() {
		$this->id = 0;
		$this->title = "";
		$this->owner = null;
		$this->summary = "";
		$this->description = "";	
		$this->promoted = false;
		$this->upvotes = 0;
		$this->downvotes = 0;
		$this->submitted = new DateTime;
		$this->deleted = false;
	}
	
	function Score()
	{
		return $this->upvotes - $this->downvotes;
	}
	
	function SetUpVotes( $value ) {
		$this->upvotes += $value;
	}
	
	function SetDownVotes( $value ) {
		$this->downvotes += $value;
	}
	
	function Save(){
		global $_connection;
		
		if ($this->id == 0)
		{
			$_connection->QueryString = "INSERT INTO Idea (`userId`,`title`,`summary`,`description`,`upvotes`,`downvotes`,`submitted`,`promoted`) VALUES (?,?,?,?,?,?,?,?)";
			
			$_connection->addInParam('s', $this->owner->ID());
			$_connection->addInParam('s', $this->title);
			$_connection->addInParam('s', $this->summary);
			$_connection->addInParam('s', $this->description);
			$_connection->addInParam('i', $this->upvotes);
			$_connection->addInParam('i', $this->downvotes);
			$_connection->addInParam('s', $this->submitted->format('Y-m-d H:i:s'));
			$_connection->addInParam('i', $this->promoted);
			
			$_connection->prepare();
			$_connection->execute();
			$this->id = $_connection->getInsertId();
			$_connection->close();
			
			if ($this->ID() != 0)
				return true;
			
		}
		else
		{
			$_connection->QueryString = "UPDATE `Idea` SET `title` = ?, `summary` = ?, `description` = ?, `upvotes` = ?, `downvotes` = ?, `promoted` = ?, `deleted`= ? WHERE `ideaId` = ?";

			$_connection->addInParam('s', $this->title);
			$_connection->addInParam('s', $this->summary);
			$_connection->addInParam('s', $this->description);
			$_connection->addInParam('i', $this->upvotes);
			$_connection->addInParam('i', $this->downvotes);
			$_connection->addInParam('i', $this->promoted);
			$_connection->addInParam('i', $this->deleted);
			$_connection->addInParam('i', $this->id);
						
			$_connection->prepare();
			$_connection->execute();

			$_connection->close();
			return true;
		}
		
		return false;
	}
	
	function ID(){
		return $this->id;
	}
	
	function Value(){
	}
	
	function get_Owner(){
		if ($this->owner == null)
			$this->owner = User::GetById($this->ownerId);
			
		return $this->owner;
		
	}
	
	//https://github.com/reddit/reddit/blob/master/r2/r2/lib/db/_sorts.pyx
	function get_HotScore(){
		if(!isset($this->hotscore))
		{
			$s = $this->Score();
			$order = log(max(abs($s),1), 2);
			
			if ($s > 0)
				$sign = 1;
			else if ($s < 0)
				$sign = -1;
			else
				$sign = 0;
		
			$seconds = $this->submitted->format("U") - 1348963200;
			$this->hotscore =  round($order + $sign * $seconds / 172800, 7);
    	}
    	
    	return $this->hotscore;
	}
	
	public static function GetById($id)
	{
		global $_connection;
		
		$_connection->QueryString = "SELECT `ideaId`, `userId`,`title`,`summary`,`description`,`upvotes`,`downvotes`,`submitted`,`promoted`,`deleted` FROM Idea WHERE `ideaId` = ?";
		
		$_connection->addInParam('i', $id);
		
		$_connection->addOutParam($ideaid);
		$_connection->addOutParam($userid);
		$_connection->addOutParam($title);
		$_connection->addOutParam($summary);
		$_connection->addOutParam($description);
		$_connection->addOutParam($upvotes);
		$_connection->addOutParam($downvotes);
		$_connection->addOutParam($submitted);
		$_connection->addOutParam($promoted);
		$_connection->addOutParam($deleted);
		
		$_connection->prepare();
		$_connection->execute();	
		
		$_connection->fetch();

		$result = new Idea();
		$result->id = $ideaid;
		$result->ownerId = $userid;
		$result->title = $title;
		$result->summary = $summary;
		$result->description = $description;
		$result->upvotes = $upvotes;
		$result->downvotes = $downvotes;
		$result->submitted = new DateTime($submitted);
		$result->promoted = (bool)$promoted;
		$result->deleted = (bool)$deleted;
		
		$_connection->close();
		return $result;
	}
	
	
	public static function getList($_promoted = false)
	{
		global $_connection;
		
		$result = array();
		$_connection->QueryString = "SELECT `ideaId`, `userId`,`title`,`summary`,`description`,`upvotes`,`downvotes`, `submitted`,`promoted`,`deleted` FROM Idea WHERE `deleted` = 0 AND `promoted` = ? ORDER BY `submitted` DESC";
		$_connection->addInParam('i', $_promoted);
		
		$_connection->addOutParam($ideaid);
		$_connection->addOutParam($userid);
		$_connection->addOutParam($title);
		$_connection->addOutParam($summary);
		$_connection->addOutParam($description);
		$_connection->addOutParam($upvotes);
		$_connection->addOutParam($downvotes);
		$_connection->addOutParam($submitted);
		$_connection->addOutParam($promoted);
		$_connection->addOutParam($deleted);
		
		$_connection->prepare();
		$_connection->execute();	
		
		while($_connection->fetch())
		{
			$temp = new Idea();
			$temp->id = $ideaid;
			$temp->ownerId = $userid;
			$temp->title = $title;
			$temp->summary = $summary;
			$temp->description = $description;
			$temp->upvotes = $upvotes;
			$temp->downvotes = $downvotes;
			$temp->submitted = new DateTime($submitted);
			$temp->promoted = (bool)$promoted;
			$temp->deleted = (bool)$deleted;
			
			$result[] = $temp;
		}
		$_connection->close();
		return $result;
	}
}
?>