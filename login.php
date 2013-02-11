<?
	error_reporting(E_ALL);
	ini_set('display_errors','On');
	//mysqli_report(MYSQLI_REPORT_ALL);
		
	define("_IN_PREMISE", true);
	define("_REQUIRE_AUTH", false);
	$sector[0] = "login";
	require_once("includes/appstart.php");
	require_once("includes/header.php");
	
	$error = false;
	if(isset($_POST['inputEmail']) && isset($_POST['inputPassword'])) {
		$user = new User();
		if ($user->signin($_POST['inputEmail'], sha1($_POST['inputPassword'])) == true)
		{
			echo "Success!";
			$_SESSION['user_authenticated'] = true;
			$_SESSION['user'] = $user;
			header( 'Location: index.php' );
		}else{
			$error = true;
		}
	}
?>

<div class="hero-unit">
	<legend>Please Sign In</legend>
	<form method="post" class="form-horizontal">
		<? if ($error == true){ ?>
			<div class="alert alert-block alert-error vote-error">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<h4>Unable to Sign In!</h4>
				The email and password combination you supplied did not have a match.
			 </div>
		<? }?>
		<div class="control-group">
			<label class="control-label" for="inputEmail">Email</label>
			<div class="controls">
				<input type="text" id="inputEmail" name="inputEmail" placeholder="Email" <?=(isset($_POST['inputEmail'])? 'value="' . $_POST['inputEmail'] . '"' : "")?>>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputPassword">Password</label>
			<div class="controls">
				<input type="password" id="inputPassword" name="inputPassword" placeholder="Password">
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<? /*<label class="checkbox">
					<input type="checkbox"> Remember me
				</label>*/?>
				<button type="submit" class="btn btn-primary">Sign in</button>
			</div>
		</div>
	</form>
</div>
<div class="row">
	<div class="span2 offset10">
		<a href="account.php?action=register">Create an Account</a>
	</div>
</div>

<?	
	require_once("includes/footer.php");
?>