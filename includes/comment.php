<?
Class Comment {
	private $commentId;
	public $ideaId;
	public $parentCommentId;
	private $_children;
	public $hasChildren;
	public $userId;
	private $_user;
	public $text;
	
	function __construct(){
		$this->commentId = 0;
		$this->ideaId = 0;
		$this->parentCommentId = 0;
		$this->userId = 0;
		$this->text = "";
		$this->hasChildren = false;
	}
	
	function Set_User($User)
	{
		$this->$userId = $User->ID();
	}
	
	function Get_User() {
		if ($this->_user == null)
		{
			$this->_user = User::GetById($this->userId);
		}
		return $this->_user;
	}
	
	function Get_CommentId() {
		return $this->commentId;
	}
	
	function Save() {
		global $_connection;
		
		if ($this->commentId == 0) {
			$_connection->QueryString = "INSERT INTO Comment(`ideaId`, `parentCommentId`, `userId`, `text`) VALUES(?,?,?,?)";
			
			$_connection->addInParam('i', $this->ideaId);
			$_connection->addInParam('i', $this->parentCommentId);
			$_connection->addInParam('i', $this->userId);
			$_connection->addInParam('s', $this->text);
			
			$_connection->prepare();
			$_connection->execute();
			
			$this->commentId = $_connection->getInsertId();
			$_connection->close();
			
			if ($this->commentId != 0)
				return true;
		}
		else
		{
			$_connection->QueryString = "UPDATE Comment SET `text` = ? WHERE commentId = ?";
			
			$_connection->addInParam('s', $this->text);
			$_connection->addInParam('i', $this->commentId);
						
			$_connection->prepare();
			$_connection->execute();
			
			$_connection->close();
			return true;
		}
		
		return false;
	}
	
	function SetChildren(&$children){
		$this->_children = $children;
		if (count($children) > 0)
			$this->hasChildren = true;
	}
	
	function GetChildren(){
		return $this->_children;
	}
	
	public static function GetByIdeaId($ideaId) {
		global $_connection;
		
		$_connection->QueryString = "SELECT `commentId`, `ideaId`, `parentCommentId`, `userId`, `text` FROM Comment WHERE `ideaId` = ?";

		$_connection->addInParam('i', $ideaId);
		
		$_connection->addOutParam($Qcommentid);
		$_connection->addOutParam($Qideaid);
		$_connection->addOutParam($Qparentcommentid);
		$_connection->addOutParam($Quserid);
		$_connection->addOutParam($Qtext);
		
		$_connection->prepare();
		$_connection->execute();
		
		$all_comments = array();
		while($_connection->fetch()){

			$temp = new Comment();
			$temp->commentId = $Qcommentid;
			$temp->ideaId = $Qideaid;
			$temp->parentCommentId = $Qparentcommentid;
			$temp->userId = $Quserid;
			$temp->text = $Qtext;
		
			$all_comments[] = $temp;
		}
		
		$_connection->close();
		
		$result = array();
		
		foreach ($all_comments as $_comment) {
			if ($_comment->parentCommentId == 0){
				$_comment->SetChildren(Comment::BuildChildren($all_comments, $_comment));
				$result[] = $_comment;
			}
		}
		
		return $result;
	}
	
	public static function GetById($commentId) {
		global $_connection;
		
		$_connection->QueryString = "SELECT `commentId`, `ideaId`, `parentCommentId`, `userId`, `text` FROM Comment WHERE `commentId` = ?";

		$_connection->addInParam('i', $commentId);
		
		$result = new Comment();
		$_connection->addOutParam($result->commentId);
		$_connection->addOutParam($result->ideaId);
		$_connection->addOutParam($result->parentCommentId);
		$_connection->addOutParam($result->userId);
		$_connection->addOutParam($result->text);
		
		$_connection->prepare();
		$_connection->execute();
		$_connection->fetch();
		$_connection->close();
		
		return $result;
	}
	
	public static function BuildChildren($AllElements, &$currentElement) {
		$children = array();
		foreach ($AllElements as $_comment) {
			if ($_comment->parentCommentId == $currentElement->Get_CommentId())
			{
				$_comment->SetChildren(Comment::BuildChildren($AllElements, $_comment));
				$children[] = $_comment;			
			}
		}
		return $children;
	}
}

?>