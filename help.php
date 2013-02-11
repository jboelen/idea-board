<?php 
	error_reporting(E_ALL);
	ini_set('display_errors','On');
	
	define("_IN_PREMISE", true);
	
	$sector[0] = "help";	
	
	require_once("includes/appstart.php");
	require_once("includes/header.php");
?>
<div class="accordion" id="accordion2">
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
        What is Idea Board?
      </a>
    </div>
    <div id="collapseOne" class="accordion-body collapse in">
      <div class="accordion-inner">
        Idea Board is a place where you and others can collaborate and share ideas.
      </div>
    </div>
  </div>
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
        Why can't I edit my <?=strtolower($_idea_type)?>?
      </a>
    </div>
    <div id="collapseTwo" class="accordion-body collapse">
      <div class="accordion-inner">
        You can only edit your posted <?=strtolower($_idea_type)?> within 30 minutes of sharing it.
      </div>
    </div>
  </div>
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
        What is a promoted <?=strtolower($_idea_type)?>?
      </a>
    </div>
    <div id="collapseThree" class="accordion-body collapse">
      <div class="accordion-inner">
        Promoted <?=strtolower($_idea_type)?>s are ones which have been accepted by the group and tried out!
      </div>
    </div>
  </div>
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseFour">
        What are the different sorting options?
      </a>
    </div>
    <div id="collapseFour" class="accordion-body collapse">
      <div class="accordion-inner">
        <dl>
        	<dt>Hot (Default)</dt>
        	<dd>Uses a formula to ensure newly submitted <?=strtolower($_idea_type)?>s with positive votes appear at the top of the list.</dd>
        	<dt>New</dt>
        	<dd>Orders the <?=strtolower($_idea_type)?>s by date of submission from newest to oldest.</dd>
        	<dt>Top List</dt>
        	<dd>Orders the <?=strtolower($_idea_type)?>s by the the total number of positive votes in descending order.</dd>
        	<dt>Promoted<dt>
        	<dd>Shows promoted <?=strtolower($_idea_type)?>s ordered by their "hotness".</dd>
        </dl>
      </div>
    </div>
  </div>
    <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseFive">
        I'm having issues sharing a new <?=strtolower($_idea_type)?>!
      </a>
    </div>
    <div id="collapseFive" class="accordion-body collapse">
      <div class="accordion-inner">
        If you are trying to submit a new <?=strtolower($_idea_type)?> but keep encountering red boxes around the form, ensure that you have done the following:
        <ul>
        	<li>Make sure you have filled out the Title and Summary fields</li>
        	<li>Titles must be between 3 and 50 characters in length</li>
        	<li>Summaries must be between 20 and 200 characters in length</li>
        </ul>
        
        If your submission fails to meet these criteria, you will need to adjust your <?=strtolower($_idea_type)?> to fall with in the ranges!
        	
      </div>
    </div>
  </div>
</div>
<?
	require_once("includes/footer.php");
?>