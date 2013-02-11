<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?=$site_name?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <?=(isset($_redirect)? "<meta http-equiv=\"REFRESH\" content=\"3;url=$_redirect\"></HEAD>":"")?>

    <!-- styles -->
    <link href="<?=$site_location?>/assets/css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="<?=$site_location?>/assets/css/bootstrap-responsive.css" rel="stylesheet">
	<link href="<?=$site_location?>/assets/css/styles.css" rel="stylesheet">
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- fav and touch icons -->
    <link rel="shortcut icon" href="<?=$site_location?>/assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="<?=$site_location?>/"><?=$site_name?></a>
          <? if ($_SESSION['user_authenticated'] == true) { ?>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="dropdown <?=($sector[0] == 'list' ? 'active' : '')?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-filter"></i> <?=$_idea_type?>s <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li <?=($sector[1] == 'hot' ?'class="active"' : '')?>><a href="<?=$site_location?>/?show=hot"><i class="icon-fire"></i> Hot</a></li>
                  <li <?=($sector[1] == 'new' ?'class="active"' : '')?>><a href="<?=$site_location?>/?show=new"><i class="icon-time"></i> New</a></li>
                  <li <?=($sector[1] == 'top' ?'class="active"' : '')?>><a href="<?=$site_location?>/?show=top"><i class="icon-list"></i> Top List</a></li>
                  <li <?=($sector[1] == 'pro' ?'class="active"' : '')?>><a href="<?=$site_location?>/?show=promoted"><i class="icon-star"></i> Promoted</a></li>
                </ul>
              </li>
              <li <?=($sector[0] == 'share' ? 'class="active"' : '')?>><a href="<?=$site_location?>/edit.php?action=new"><i class="icon-pencil"></i> Share New</a></li>
              <?//<li><a href="#about">Account Settings</a></li>
              ?>
              <li <?=($sector[0] == 'help' ? 'class="active"' : '')?>><a href="<?=$site_location?>/help.php"><i class="icon-question-sign"></i> Help</a></li>
              <li><a href="<?=$site_location?>/logout.php">Sign Out</a></li>
            </ul>
          </div><!--/.nav-collapse -->
          <? } else {?>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li <?=($sector[0] == 'login' ? 'class="active"' : '')?>><a href="<?=$site_location?>/login.php">Login</a></li>
              <?//<li><a href="#about">Account Settings</a></li>
              ?>
              <li <?=($sector[0] == 'reg' ? 'class="active"' : '')?>><a href="<?=$site_location?>/account.php?action=register">Register</a></li>
            </ul>
          </div><!--/.nav-collapse -->
          <? } ?>
        </div>
      </div>
    </div>

    <div class="container">