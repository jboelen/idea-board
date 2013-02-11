<?
foreach($_items as $_item){
	$up = false;
	$down = false;
	
	if (isset($_votes[$_item->id]))
	{
		switch($_votes[$_item->id]->value)
		{
			case -1:
				$down = true;
				break;
			case 1:
				$up = true;
				break;
		}
	}
	$now = new DateTime;

?>
<div id="idea-<?=$_item->id?>" class="row">
	<div class="span1">
		<?/*
		<div><a id="btn-up-<?=$_item->id?>" class="btn btn-small<?=($up ? " btn-success" : "")?>" href="javascript:Listing.Vote(<?=($up ? "0" : "1")?>, <?=$_item->id?>);"><i class="icon-arrow-up<?=($up ? " icon-white" : "")?>"></i></a></div>
		<div class="spacer"></div>
		<div><a id="btn-down-<?=$_item->id?>" class="btn btn-small <?=($down ? "btn-danger" : "")?>" href="javascript:Listing.Vote(<?=($down ? "0" : "-1")?>, <?=$_item->id?>);"><i class="icon-arrow-down <?=($down ? " icon-white" : "")?>"></i></a></div>
		*/ ?>
	</div>
	<div class="span8">
		<div><a href="<?=$site_location?>/discuss.php?id=<?=$_item->id?>"><span><strong><?=$_item->title?></strong></span></a></div>
		<div><span><?=$_item->summary?></span></div>
	</div>
	<div class="span2">
<? if($_item->get_Owner()->ID() == $_currentUser->ID()){ ?>
		<div><? if ($_item->submitted  > $now->modify("-30 minutes")){ ?><a class="btn btn-small" href="<?=$site_location?>/edit.php?action=revise&ideaId=<?=$_item->id?>" title="Edit"><i class="icon-edit"></i></a>&nbsp;<? } ?><a class="btn btn-small" href="javascript:Listing.Delete(<?=$_item->id?>);" title="Delete"><i class="icon-trash"></i></a></div>
		<div class="spacer"></div>
<? } ?>
		<div><a class="btn btn-small" href="<?=$site_location?>/discuss.php?id=<?=$_item->id?>" title="Comments"><i class="icon-comment"></i></a></div>
	</div>
</div>	
<? //$_item->get_HotScore()
?>
<hr />
<?
}
?>
