<?php
/**
 * User: James
 * Date: 5/16/13
 */

define("_IN_IDEABOARD", true);
define("_REQUIRE_AUTH", true);

require_once('../../app/app_start.php');
?>
<accordion close-others="true">
    <accordion-group heading="What is <?=$SITE['general']['title']?>?">
        Idea Board is a place where you and others can collaborate and share ideas.
    </accordion-group>
    <accordion-group heading="Why can't I edit my <?=strtolower($SITE['general']['idea_type_singular'])?>?">
        You can only edit your posted <?=strtolower($SITE['general']['idea_type_singular'])?> within 30 minutes of sharing it.
    </accordion-group>
    <accordion-group heading="What is a promoted <?=strtolower($SITE['general']['idea_type_singular'])?>?">
        Promoted <?=strtolower($SITE['general']['idea_type_plural'])?> are ones which have been accepted by the group and tried out!
    </accordion-group>
    <accordion-group heading="What are the different sorting options?">
        <dl>
            <dt>Hot (Default)</dt>
            <dd>Uses a formula to ensure newly submitted <?=strtolower($SITE['general']['idea_type_plural'])?> with positive votes appear at the top of the list.</dd>
            <dt>New</dt>
            <dd>Orders the <?=strtolower($SITE['general']['idea_type_plural'])?> by date of submission from newest to oldest.</dd>
            <dt>Top List</dt>
            <dd>Orders the <?=strtolower($SITE['general']['idea_type_plural'])?> by the the total number of positive votes in descending order.</dd>
            <dt>Promoted<dt>
            <dd>Shows promoted <?=strtolower($SITE['general']['idea_type_plural'])?> ordered by their "hotness".</dd>
        </dl>
    </accordion-group>
    <accordion-group heading="I'm having issues sharing a new <?=strtolower($SITE['general']['idea_type_singular'])?>!">
        If you are trying to submit a new <?=strtolower($SITE['general']['idea_type_singular'])?> but keep encountering red boxes around the form, ensure that you have done the following:
        <ul>
            <li>Make sure you have filled out the Title and Summary fields</li>
            <li>Titles must be between 3 and 50 characters in length</li>
            <li>Summaries must be between 20 and 200 characters in length</li>
        </ul>

        If your submission fails to meet these criteria, you will need to adjust your <?=strtolower($SITE['general']['idea_type_singular'])?> to fall with in the ranges!
    </accordion-group>
</accordion>