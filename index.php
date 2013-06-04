<?php
define("_IN_IDEABOARD", true);
define("_REQUIRE_AUTH", false);
include_once('app/app_start.php');
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="<?=$SITE['general']['root']?>css/bootstrap.min.css">
        <style>
            body {
                padding-top: 60px;
                padding-bottom: 40px;
            }
        </style>
        <link rel="stylesheet" href="<?=$SITE['general']['root']?>css/bootstrap-responsive.min.css">
        <link rel="stylesheet" href="<?=$SITE['general']['root']?>css/main.css">
        <base href="<?=$SITE['general']['root']?>"/>
        <script src="<?=$SITE['general']['root']?>js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    </head>
    <body ng-app="ideaboardApp">
    <div ng-controller="MainCntl">
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

        <!-- This code is taken from http://twitter.github.com/bootstrap/examples/hero.html -->

        <div class="navbar navbar-fixed-top" >
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="<?=$SITE['general']['root']?>"><?=$SITE['general']['title']?></a>
                    <? if ($_SESSION['user_authenticated'] == true) { ?>
                        <div class="nav-collapse collapse">
                            <ul class="nav">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-filter"></i> <?=$SITE['general']['idea_type_plural']?> <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="<?=$SITE['general']['root']?>list/hot"><i class="icon-fire"></i>Hot</a></li>
                                        <li><a href="<?=$SITE['general']['root']?>list/new"><i class="icon-time"></i>New</a></li>
                                        <li><a href="<?=$SITE['general']['root']?>list/top"><i class="icon-list"></i>Top List</a></li>
                                        <li><a href="<?=$SITE['general']['root']?>list/promoted"><i class="icon-star"></i>Promoted</a></li>
                                    </ul>
                                </li>
                                <li><a href="<?=$SITE['general']['root']?>discuss/new"><i class="icon-pencil"></i> Share New</a></li>
                                <?//<li><a href="#about">Account Settings</a></li>
                                ?>
                                <li><a href="help"><i class="icon-question-sign"></i> Help</a></li>
                                <li><a href="logout">Sign Out</a></li>
                            </ul>
                        </div><!--/.nav-collapse -->
                    <? } else {?>
                        <div class="nav-collapse collapse">
                            <ul class="nav">
                                <li <?=($sector[0] == 'login' ? 'class="active"' : '')?>><a href="login">Login</a></li>
                                <?//<li><a href="#about">Account Settings</a></li>
                                ?>
                                <li <?=($sector[0] == 'reg' ? 'class="active"' : '')?>><a href="account/register">Register</a></li>
                            </ul>
                        </div><!--/.nav-collapse -->
                    <? } ?>
                </div>
            </div>
        </div>
        <div class="container" ng-view>

        </div>
        <pre>$location.path() = {{$location.path()}}</pre>
        <pre>$route.current.templateUrl = {{$route.current.templateUrl}}</pre>
        <pre>$route.current.params = {{$route.current.params}}</pre>
        <pre>$route.current.scope.name = {{$route.current.scope.name}}</pre>
        <pre>$routeParams = {{$routeParams}}</pre>
        <!-- /container -->
    </div>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.min.js"><\/script>')</script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.0.6/angular.min.js"></script>

        <script src="<?=$SITE['general']['root']?>js/vendor/bootstrap.min.js"></script>
        <script src="<?=$SITE['general']['root']?>js/vendor/ui-bootstrap-tpls-0.3.0.min.js"></script>
        <script src="<?=$SITE['general']['root']?>js/vendor/jquery.charactercount.js"></script>
        <script src="<?=$SITE['general']['root']?>js/plugins.js"></script>
        <script src="<?=$SITE['general']['root']?>js/main.js"></script>
    </body>
</html>
