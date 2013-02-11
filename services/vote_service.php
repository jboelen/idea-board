<?
	define("_IN_PREMISE", true);
	define("_REQUIRE_AUTH", false);
	require_once("../includes/appstart.php");
	
	if (!isset($_POST['action']) || !isset($_POST['ideaId']) || !isset($_SESSION['user_authenticated']) || $_SESSION['user_authenticated'] != true) {
	  header("HTTP/1.0 400 Bad Request");
	  exit;
	}
	
	switch($_POST['action']){
		case 'vote':
		{
			if (!isset($_POST['value'])){
				echo json_encode(array('result' => true));
				exit;
			}
				
			$idea = Idea::GetById($_POST['ideaId']);
			$vote = Vote::GetByUserIdAndIdeaId($_currentUser->ID(), $idea->id);
			
			if ($idea->id != 0)
			{
				if ($vote->voteId != 0){
					switch(	$vote->value)
					{
						case -1:
							$idea->SetDownVotes(-1);
							break;
						case 0:
							break;
						case 1:
							$idea->SetUpVotes(-1);
							break;
					}
				}else{
					$vote->userId = $_currentUser->ID();
					$vote->ideaId = $idea->id;
					$vote->date = new DateTime();
				}
		
				switch($_POST['value'])
				{
					case -1:
						$idea->SetDownVotes(1);
						$vote->value = -1;
						break;
					case 0:
						$vote->value = 0;
						break;
					case 1:
						$idea->SetUpVotes(1);
						$vote->value = 1;
						break;
				}
				
				$vote->Save();
				$idea->Save();
					
				echo json_encode(array('result' => true));
			}else
				echo json_encode(array('result' => false));
		}break;
		case 'delete':
		{
			$idea = Idea::GetById($_POST['ideaId']);
			if ($idea->get_Owner()->ID() == $_currentUser->ID())
			{
				$idea->deleted = true;
				if ($idea->Save())
					echo json_encode(array('result' => true));
				else
					echo json_encode(array('result' => false));
			}else
				echo json_encode(array('result' => false));
		}break;
	}
	
?>