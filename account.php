<?
	error_reporting(E_ALL);
	ini_set('display_errors','On');
	//mysqli_report(MYSQLI_REPORT_ALL);
	
	define("_IN_PREMISE", true);
	
	if (isset($_GET['action']) && $_GET['action'] == "register")
	{
		define("_REQUIRE_AUTH", false);
		$sector[0] = "reg";
	}
	else
	{
		define("_REQUIRE_AUTH", true);
	}
	
	require_once("includes/appstart.php");
	require_once("includes/header.php");
	
	if (isset($_GET['action']) && $_GET['action'] == "register")
	{
		require_once("register.php");
	}
?>

<?	
	require_once("includes/footer.php");
?>