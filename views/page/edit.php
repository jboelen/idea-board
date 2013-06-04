<?php
/**
 * User: James
 * Date: 5/27/13
 * Time: 9:27 PM
 */
define("_IN_IDEABOARD", true);
define("_REQUIRE_AUTH", true);

require_once('../../app/app_start.php');
?>
<div>
    <div class="hero-unit" ng-show="new">
        <h2>Share a New <?=$SITE['general']['idea_type_singular']?> </h2>
    </div>
    <div class="hero-unit" ng-show="edit">
        <h2>{{data.title}} </h2>
    </div>
    <div>
        <form id="form-edit-new" class="form-horizontal" method="post">
            <input type="hidden" name="postback" value="true">
            <div class="control-group">
                <label class="control-label" for="inputTitle">Title</label>
                <div class="controls">
                    <input type="text" name="inputTitle" id="title" ng-model="data.title"  required />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputSummary">Summary</label>
                <div class="controls">
                    <textarea name="inputSummary" id="summary" style="resize: none;" class="input-xxlarge" rows="2" required ng-model="data.summary"></textarea><span class="help-inline">200</span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputDescription">Description</label>
                <div class="controls">
                    <textarea name="inputDescription" id="Description" style="resize: none;" class="input-xxlarge" rows="10" ng-model="data.description"></textarea>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-primary" ng-click="submit()">Share</button>
                </div>
            </div>
        </form>
    </div>
</div>