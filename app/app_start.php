<?php
/**
 * User: James
 * Date: 5/16/13
 * Time: 9:42 PM
 */
error_reporting(E_ALL);
ini_set('display_errors','On');

  if (!defined("_IN_IDEABOARD"))
    die("Hacking Attempt. Execution Halted");

  if (!defined("_REQUIRE_AUTH"))
    define("_REQUIRE_AUTH", true);

  if (!defined("_IS_API"))
    define("_IS_API", false);



  require_once("config.php");
  require_once("utilities.php");
  require_once("mysql.php");
  require_once("user.php");
  require_once("idea.php");

  session_start();

  $SITE['runtime']['connection'] =  new mysql();

    if (!isset($_SESSION['user_authenticated']) || $_SESSION['user_authenticated'] != true) {
        $_SESSION['user_authenticated'] = false;

        if (_REQUIRE_AUTH == true)
        {
            //die("test");
            if (_IS_API == false){
                echo "<login></login>";
            }
            else
               header("HTTP/1.0 403 Forbidden");
            die();
        }
    }
    else
    {
        $SITE['runtime']['currentuser'] = $_SESSION['user'];
    }