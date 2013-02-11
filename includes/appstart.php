<?

if (!defined("_IN_PREMISE"))
	die("Hacking Attempt. Execution Halted");

require_once("config.php");
require_once("common.php");
require_once("mysql.php");
require_once("user.php");
require_once("keygen.php");
require_once("idea.php");
require_once("comment.php");
require_once("vote.php");

if (!defined("_REQUIRE_AUTH")) {
	define("_REQUIRE_AUTH", true);
}

$_connection = new Database();
$_path = pathinfo($_SERVER["SCRIPT_NAME"]);

session_start();

if (!isset($sector[0]))
	$sector[0] = "other";

if (!isset($sector[1]))
	$sector[1] = "other";

	
if (!isset($_SESSION['user_authenticated']) || $_SESSION['user_authenticated'] != true) {
	$_SESSION['user_authenticated'] = false;

	if (_REQUIRE_AUTH == true)
		header( "Location: $site_location/login.php" );
}
else
{
	$_currentUser = $_SESSION['user'];
}
?>