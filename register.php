<?
	if (!defined("_IN_PREMISE"))
		die("Hacking Attempt. Execution Halted");
	
	$_scripts = "register.js";
	$userfound = false;
	if (isset($_GET['key']) && strlen($_GET['key']) == 29)
	{
		$key_parts = explode('-', $_GET['key']);
	}
	
	$show_form = true;
	if(isset($_POST['postback']))
	{
		if (isset($_POST['inputKey1']) && strlen($_POST['inputKey1']) == 5 
			&& isset($_POST['inputKey2']) && strlen($_POST['inputKey2']) == 5
			&& isset($_POST['inputKey3']) && strlen($_POST['inputKey3']) == 5
			&& isset($_POST['inputKey4']) && strlen($_POST['inputKey4']) == 5
			&& isset($_POST['inputKey5']) && strlen($_POST['inputKey5']) == 5
			&& isset($_POST['inputEmail']) && strlen($_POST['inputEmail']) > 3 && filter_var($_POST['inputEmail'], FILTER_VALIDATE_EMAIL) != false
			&& isset($_POST['inputPassword']) && strlen($_POST['inputPassword']) > 3)
		{
			$pbKey = "{$_POST['inputKey1']}-{$_POST['inputKey2']}-{$_POST['inputKey3']}-{$_POST['inputKey4']}-{$_POST['inputKey5']}";
			$pbUser = new User();	
			$pbUser->GetByKey($pbKey);
			if ($pbUser->ID() > 0)
			{
				$pbUser->email = $_POST['inputEmail'];
				$pbUser->password = sha1($_POST['inputPassword']);
				$pbUser->key = "";
				$pbUser->Save();
				header('Refresh: 3; url=index.php'); //now send the header param
				echo <<<eof
				<div class="hero-unit">
					<h2>Your account has been created and you may now log in.</h2>
					<h4>Please wait while we redirect you to the login page.</h4>
				</div>
eof;
				$show_form = false;
			}	
		}
	}
	
	if ($show_form){

?>
<div class="hero-unit">
	<h2>Register</h2>
</div>
<div>
	<form id="form-register" method="post" class="form-horizontal">
		<input type="hidden" name="postback" value="true">
		<div class="control-group">
			<label class="control-label">Registration Key</label>
			<div class="controls controls-row">
				<input id="key1" name="inputKey1" class="input-mini keyinput" type="text" value="<?=(isset($key_parts)? $key_parts[0]:'')?>" onpaste="setTimeout(function(){Register.PasteKey(); Register.GetInformation();});" onchange="Register.GetInformation();" >
				<input id="key2" name="inputKey2" class="input-mini keyinput" type="text" value="<?=(isset($key_parts)? $key_parts[1]:'')?>" onchange="Register.GetInformation();">
				<input id="key3" name="inputKey3" class="input-mini keyinput" type="text" value="<?=(isset($key_parts)? $key_parts[2]:'')?>" onchange="Register.GetInformation();">
				<input id="key4" name="inputKey4" class="input-mini keyinput" type="text" value="<?=(isset($key_parts)? $key_parts[3]:'')?>" onchange="Register.GetInformation();">
				<input id="key5" name="inputKey5" class="input-mini keyinput" type="text" value="<?=(isset($key_parts)? $key_parts[4]:'')?>" onchange="Register.GetInformation();">
				<span id="icon"></span>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputEmail">Email</label>
			<div class="controls">
				<input type="text" id="inputEmail" name="inputEmail" placeholder="Email" >
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputPassword">Password</label>
			<div class="controls">
				<input type="password" id="inputPassword" name="inputPassword" placeholder="Password">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputFirstName">First Name</label>
			<div class="controls">
				<input type="text" id="inputFirstName" name="inputFirstName" placeholder="First Name" disabled>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputLastName">Last Name</label>
			<div class="controls">
				<input type="text" id="inputLastName" name="inputLastName" placeholder="Last Name" disabled>
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<button type="submit" class="btn btn-primary">Register</button>
			</div>
		</div>
	</form>
</div>
<? } ?>