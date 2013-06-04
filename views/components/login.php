<?php
/**
 * User: James
 * Date: 5/21/13
 * Time: 10:13 PM
 */
?>
<div class="hero-unit">
    <form method="post" class="form-horizontal">
        <legend>Please Sign In</legend>
        <div class="alert alert-block alert-error vote-error" ng-show="error.visible">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <h4>{{error.title}}</h4>
            {{error.message}}
        </div>
        <div class="control-group">
            <label class="control-label" for="inputEmail">Email</label>
            <div class="controls">
                <input type="text" id="inputEmail" name="inputEmail" placeholder="Email" ng-model="model.email">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="inputPassword">Password</label>
            <div class="controls">
                <input type="password" id="inputPassword" name="inputPassword" placeholder="Password" ng-model="model.password">
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <button type="submit" class="btn btn-primary" ng-click="submit()">Sign in</button>
            </div>
        </div>
    </form>
</div>
<div class="row">
    <div class="span2 offset10">
        <a href="account.php?action=register">Create an Account</a>
    </div>
</div>