<?php
/**
 * User: James
 * Date: 5/19/13
 * Time: 10:07 AM
 */

define("_IN_IDEABOARD", true);
define("_REQUIRE_AUTH", true);

require_once('../../app/app_start.php');

$_SESSION['user_authenticated'] = false;
$_SESSION['user'] = null;
?>
<div class="hero-unit">
    <h2>You have been signed out.</h2>
    <h4>Please wait while we redirect you.</h4>
</div>