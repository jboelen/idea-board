<?
	define("_IN_PREMISE", true);
	define("_REQUIRE_AUTH", false);
	require_once("../includes/appstart.php");
	
	if (!isset($_POST['key'])){
	  header("HTTP/1.0 400 Bad Request");
	  exit;
	}
	$user = new User();
	$user->GetByKey($_POST['key']);
	if ($user->ID() != 0)
		echo json_encode(array('email' => $user->email, 'firstname' => $user->firstname, 'lastname' => $user->lastname));
	else
		echo "";
?>