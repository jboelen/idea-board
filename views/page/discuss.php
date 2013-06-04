<?php
/**
 * User: James
 * Date: 5/22/13
 * Time: 12:12 AM
 */
define("_IN_IDEABOARD", true);
define("_REQUIRE_AUTH", true);

require_once('../../app/app_start.php');
?>

<div class="hero-unit">
    <h2>{{data.title}}</h2>
    <p>{{data.summary}}</p>
</div>
<? if($SITE['runtime']['currentuser']->authority == 2){ ?>
    <div>
        <p> Written By: {{data.owner.firstname}} {{data.owner.lastname}}</p>
    </div>
<? } ?>
<div>
    <p>{{data.description}}</p>
</div>