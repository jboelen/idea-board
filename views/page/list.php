<?php
/**
 * User: James
 * Date: 5/20/13
 * Time: 9:37 PM
 */

define("_IN_IDEABOARD", true);
define("_REQUIRE_AUTH", true);

require_once('../../app/app_start.php');
?>


<div ng-repeat="item in data">
    <div id="idea-{{item.id}}" class="row">
        <div class="span1">
            <div><vote direction="up" value="item.vote" item-id="item.id"></vote></div>
            <div class="spacer"></div>
            <div><vote direction="down" value="item.vote" item-id="item.id"></vote></div>
        </div>
        <div class="span8">
            <div><a href="<?=$SITE['general']['root']?>discuss/{{item.id}}"><span><strong>{{item.title}}</strong></span></a></div>
            <div><span>{{item.summary}}</span></div>
        </div>
        <div class="span2">
            <div><a class="btn btn-small" href="<?=$SITE['general']['root']?>discuss/edit/{{item.id}}" title="Edit" ng-show="item.editable"><i class="icon-edit"></i>&nbsp;</a><span class="btn btn-small" href="" title="Delete" ng-show="item.isOwner" ng-click="delete(item.id)"><i class="icon-trash"></i></span></div>
            <div><a class="btn btn-small" href="<?=$SITE['general']['root']?>discuss/{{item.id}}" title="Comments"><i class="icon-comment"></i></a></div>
        </div>
    </div>
    <hr />
</div>