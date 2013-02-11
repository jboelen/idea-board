<?	
	define("_IN_PREMISE", true);
	define("_REQUIRE_AUTH", true);
	
	require_once("../includes/appstart.php");
	require_once("../includes/header.php");
	
	if ($_currentUser->authority != 2)
	{
		header( "Location: $site_location/" );
	}
	
	if (isset($_POST['postback'])){
		$user = new User();
		$user->key = $_POST['inputKey'];
		$user->firstname = $_POST['inputFirstName'];
		$user->lastname = $_POST['inputLastName'];
		$user->email = $_POST['inputEmail'];
		
		if($user->Save()) {
			?>
			<div class="alert alert-success">
              <button type="button" class="close" data-dismiss="alert">×</button>
              <strong>Success!</strong> You have successfully invited <?=($user->firstname . " " . $user->lastname)?>  to share new Ideas.
            </div>
			<?
			if (!$user->SendInvite())
			{
			?>
			<div class="alert alert-error">
              <button type="button" class="close" data-dismiss="alert">×</button>
              <strong>Oh no!</strong> An account was created for <?=($user->firstname . " " . $user->lastname)?>, but and invitation could not be sent!
            </div>
			<?
			}
		}else{
			?>
			<div class="alert alert-error">
              <button type="button" class="close" data-dismiss="alert">×</button>
              <strong>Oh no!</strong> <?=($user->firstname . " " . $user->lastname)?> was unable to be invited to share new Ideas.
            </div>
			<?
		}
	}
	
	$key = new RegistrationKey();
?>
<h1>Create Invitation</h1>
<div>
	<form id="form-register" method="post" class="form-horizontal">
		<input type="hidden" name="postback" value="true">
		<div class="control-group">
			<label class="control-label">Registration Key</label>
			<div class="controls controls-row">
				<input id="key1" name="inputKey" class="input-xlarge" type="text" value="<?=$key->Value?>" >
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputEmail">Email</label>
			<div class="controls">
				<input type="text" id="inputEmail" name="inputEmail" placeholder="Email" >
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputFirstName">First Name</label>
			<div class="controls">
				<input type="text" id="inputFirstName" name="inputFirstName" placeholder="First Name">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputLastName">Last Name</label>
			<div class="controls">
				<input type="text" id="inputLastName" name="inputLastName" placeholder="Last Name">
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<button type="submit" class="btn btn-primary">Invite</button>
			</div>
		</div>
	</form>
</div>
<h1>User List </h1>
<table class="table table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Email</th>
                  <th>Registration Key</th>
                </tr>
              </thead>
              <tbody>
<?
	$_users = User::GetAll();
	foreach($_users as $_user)
	{
		if (isset($_GET['oops']) && strlen($_user->key) != 0)
		{
			//$_user->SendInvite();
			//echo "sent email to $_user->firstname";
		}
	?>	
                <tr>
                  <td><?=$_user->ID()?></td>
                  <td><?=$_user->firstname?></td>
                  <td><?=$_user->lastname?></td>
                  <td><?=$_user->email?></td>
                  <td><?=$_user->key?></td>
                </tr>

    <?
	}
?>
              </tbody>
            </table>
<?	
	require_once("../includes/footer.php");
?>