<?
	define("_IN_PREMISE", true);
	
	require_once("includes/appstart.php");
	
	$_SESSION['user_authenticated'] = false;
	$_SESSION['user'] = NULL;
	
	require_once("includes/header.php");
	
	header('Refresh: 3; url=login.php'); //now send the header param
?>
				<div class="hero-unit">
					<h2>You have been signed out.</h2>
					<h4>Please wait while we redirect you.</h4>
				</div>
<?
	require_once("includes/footer.php");
?>