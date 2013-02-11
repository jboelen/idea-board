<?php 
	error_reporting(E_ALL);
	ini_set('display_errors','On');
	
	define("_IN_PREMISE", true);
	
	$sector[0] = "list";	
	if (isset($_GET['show']))
	{
		switch($_GET['show'])
		{
			case "promoted":
				$sector[1] = "pro";
				break;
			case "top":
				$sector[1] = "top";
				break;
			case "new":
				$sector[1] = "new";
				break;
			default:
				$sector[1] = "hot";
				break;
		}
	}else
		$sector[1] = "new";
	
	
	require_once("includes/appstart.php");
	require_once("includes/header.php");

	
	$_votes = Vote::GetByUserId($_currentUser->ID());

	if (isset($_GET['show']))
	{
		if ($_GET['show'] == "promoted"){
			$_items = Idea::getList(true);
		}
		else
			$_items = Idea::getList();
		
		/*if (count($_items) > 0) {	
			if ($_GET['show'] == "top")
				quickSort($_items, "Score");
			elseif ($_GET['show'] == "new"){
				//do nothing
			}else
			{
				quickSort($_items, "get_HotScore");
			}
		}
		*/
	}else
	{
		$_items = Idea::getList();
		//if (count($_items) > 0)
		//	quickSort($_items, "get_HotScore");
	}
	
	$_scripts = "listing.js";
	
	
	require_once("listing.php");
?>

<?	
	require_once("includes/footer.php");
?>