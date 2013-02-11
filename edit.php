<?
	error_reporting(E_ALL);
	ini_set('display_errors','On');

	define("_IN_PREMISE", true);
	
	if (!isset($_GET['action']) || $_GET['action'] == 'new'){
		$sector[0] = "share";
	}
	
	require_once("includes/appstart.php");
	require_once("includes/header.php");
	
	$action = "new";
	
	if (!isset($_GET['action']) || $_GET['action'] == 'new')
	{
		if (isset($_POST['postback'])) {
			$idea = new Idea();
			$idea->title = $_POST['inputTitle'];
			$idea->summary = $_POST['inputSummary'];
			$idea->description = $_POST['inputDescription'];
			$idea->owner = $_currentUser;
			if ($idea->Save() == true)
			{
				header("Refresh: 3; url=discuss.php?id=$idea->id"); //now send the header param
				echo <<<eof
				<div class="hero-unit">
					<h2>You have successfully shared a new $_idea_type</h2>
					<h4>Please wait while you are redirected.</h4>
				</div>
eof;
				require_once("includes/footer.php");
				exit;
			}
			
		}
		
	} else if ($_GET['action'] == 'revise' && isset($_GET['ideaId'])) {
		$action = "revise";
		$idea = Idea::GetById($_GET['ideaId']);
		if ($idea->get_Owner()->ID() != $_currentUser->ID())
			header( 'Location: index.php' );
		$now = new DateTime;
		if ($idea->submitted  < $now->modify("-30 minutes"))
		{
			header("Refresh: 3; url=discuss.php?id=$idea->id"); //now send the header param
				echo <<<eof
				<div class="hero-unit">
					<h2>The edit period for this $_idea_type has expired.</h2>
					<h4>Please wait while you are redirected.</h4>
				</div>
eof;
				require_once("includes/footer.php");
				exit;
		}
			
		if (isset($_POST['postback'])) {
			$idea->title = $_POST['inputTitle'];
			$idea->summary = $_POST['inputSummary'];
			$idea->description = $_POST['inputDescription'];
			if ($idea->Save() == true)
			{
				header("Refresh: 3; url=discuss.php?id=$idea->id"); //now send the header param
				echo <<<eof
				<div class="hero-unit">
					<h2>You have successfully edited your $_idea_type</h2>
					<h4>Please wait while you are redirected.</h4>
				</div>
eof;
				require_once("includes/footer.php");
				exit;
			}
		}
		
	} else {
		header( 'Location: index.php' );
	}
		
		$_scripts = "edit.js";
?>
	<div class="hero-unit">
		<h2>Share a New <?=$_idea_type?></h2>
	</div>
	<div>
		<form id="form-edit-new" class="form-horizontal" method="post">
			<input type="hidden" name="postback" value="true">
		  	<div class="control-group">
				<label class="control-label" for="inputTitle">Title</label>
				<div class="controls">
			  		<input type="text" name="inputTitle" id="title" <?=($action == "revise"? 'value="' . $idea->title . '"': '')?>>
				</div>
		  	</div>
		  	<div class="control-group">
				<label class="control-label" for="inputSummary">Summary</label>
				<div class="controls">
			  		<textarea name="inputSummary" id="summary" style="resize: none;" class="input-xxlarge" rows="2"><?=($action == "revise"? $idea->summary : '')?></textarea>
				</div>
		  	</div>
		  	<div class="control-group">
				<label class="control-label" for="inputDescription">Description</label>
				<div class="controls">
			  		<textarea name="inputDescription" id="Description" style="resize: none;" class="input-xxlarge" rows="10"><?=($action == "revise"?  $idea->description : '')?></textarea>
				</div>
		  	</div>
		  	<div class="control-group">
				<div class="controls">
			  		<button type="submit" class="btn btn-primary"><?=($action == "revise"? "Edit": 'Share')?></button>
				</div>
		  	</div>
		</form>
	</div>
	
<?
	require_once("includes/footer.php");
?>