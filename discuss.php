<?php 
	error_reporting(E_ALL);
	ini_set('display_errors','On');
	
	define("_IN_PREMISE", true);
	require_once("includes/appstart.php");
	require_once("includes/header.php");
	
	if (!isset($_GET['id']))
	{
		require_once("includes/footer.php");
		header( "Location: $site_location" );
		exit;
	}
	$idea = Idea::GetById($_GET['id']);
	if($idea->deleted == true){
		header( "Location: $site_location" );
		require_once("includes/footer.php");
		exit;
	}
	if (isset($_POST['postback']) && isset($_POST['inputBody']) && strlen($_POST['inputBody']) > 0){	
	
		if ($_POST['postback'] == "form1") {
			$new_comment = new Comment();
			$new_comment->ideaId = $idea->id;
			$new_comment->userId = $_currentUser->ID();
			$new_comment->text = $_POST['inputBody'];
			$new_comment->Save();
		}else if ($_POST['postback'] == "form3") {
			$comment = Comment::GetById($_POST['inputCommentId']);
			$comment->text = $_POST['inputBody'];
			$comment->Save();
		}else 
		{
			$new_comment = new Comment();
			$new_comment->ideaId = $idea->id;
			$new_comment->userId = $_currentUser->ID();
			$new_comment->parentCommentId = $_POST['inputParentId'];
			$new_comment->text = $_POST['inputBody'];
			$new_comment->Save();
		}
	}
	$_scripts = "discuss.js";
	$_comments = Comment::GetByIdeaId($idea->id);
	
	
	function AddComment($__comment, $__level){
		global $_comments, $_currentUser;
		
		?>
<div class="row">
	<div class="span6 comment offset<?=($__level)?>">
		<div class="row">
			<div class="span6">
				<p id="comment-actual_<?=$__comment->Get_CommentId()?>"><?=$__comment->text?></p>
				<? if($__comment->userId == $_currentUser->ID() && !$__comment->hasChildren) {?>
				<div id="comment-edit_<?=$__comment->Get_CommentId()?>" style="display:none;">
					<form id="form-discuss-edit" class="form" method="post">
						<input type="hidden" name="postback" value="form3">
						<input type="hidden" name="inputCommentId" value="<?=$__comment->Get_CommentId()?>">
						<div class="control-group">
							<div class="controls">
								<textarea name="inputBody" id="Description" style="resize: none;" class="input-xxlarge" rows="4"><?=$__comment->text?></textarea>
							</div>
						</div>
						<div class="control-group">
							<div class="controls">
								<button type="submit" class="btn" onclick="Discuss.ToggleEdit('<?=$__comment->Get_CommentId()?>');return false;">Cancel</button> &nbsp; <button type="submit" class="btn btn-primary">Edit</button>
							</div>
						</div>
					</form>		
				</div>
				<? } ?>
			</div>
		</div>
		<div class="row">
			<? 
			//<div class="span3 margin-m15">Date?</div> 
			?>
			<div class="span6 reply margin-m15">
				<? if($__comment->userId == $_currentUser->ID() && !$__comment->hasChildren) {?><a href="javascript:Discuss.ToggleEdit('<?=$__comment->Get_CommentId()?>');">Edit</a> | <?}?>
				<a href="javascript:Discuss.ToggleReply('<?=$__comment->Get_CommentId()?>');">Reply</a>
			</div>
		</div>
		<div class="row">
			<div class = "span6">
				<hr />
			</div>
		</div>
	</div>
</div>
<div id="comment-reply_<?=$__comment->Get_CommentId()?>" class="row" style="display:none;">
	<div class="span6 comment offset<?=($__level + 1)?>">
		<div class="row">
			<div class = "span6">
				<h4>Reply to Comment</h4>
				<div>
					<form id="form-discuss-reply" class="form" method="post">
						<input type="hidden" name="postback" value="form2">
						<input type="hidden" name="inputParentId" value="<?=$__comment->Get_CommentId()?>">
						<div class="control-group">
							<div class="controls">
								<textarea name="inputBody" id="Description" style="resize: none;" class="input-xxlarge" rows="4"></textarea>
							</div>
						</div>
						<div class="control-group">
							<div class="controls">
								<button type="submit" class="btn btn-primary">Add Reply</button>
							</div>
						</div>
					</form>				
				</div>
			</div>
		</div>
		<div class="row">
			<div class = "span6">
				<hr />
			</div>
		</div>
	</div>
</div>
		<?
		if ($__comment->hasChildren){
			foreach($__comment->GetChildren() as $_child)
			AddComment($_child, $__level + 1);
		}
	}
	
?>
<div class="hero-unit">
	<h2><?=$idea->title?></h2>
	<p><?=$idea->summary?></p>
</div>
<? if($_currentUser->authority == 2){ ?>
<div>
	<p> Written By: <?=$idea->get_Owner()->firstname?> <?=$idea->get_Owner()->lastname?></p>
</div>
<? } ?>
<div>
	<p><?=$idea->description?></p>
</div>
<legend>Comments</legend>
<?
	
	foreach($_comments as $_comment)
	{
		if ($_comment->parentCommentId == 0){
			AddComment($_comment, 0);
		}
	}
?>
<div>
	<h4>Add a new comment</h4>
	<div>
		<form id="form-discuss-new" class="form" method="post">
			<input type="hidden" name="postback" value="form1">
			<div class="control-group">
				<div class="controls">
					<textarea name="inputBody" id="Description" style="resize: none;" class="input-xxlarge" rows="4"></textarea>
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<button type="submit" class="btn btn-primary">Add Comment</button>
				</div>
			</div>
		</form>
	</div>
</div>
<?	
	require_once("includes/footer.php");
?>
