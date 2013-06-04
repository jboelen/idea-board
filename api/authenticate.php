<?php
/**
 * User: James
 * Date: 5/20/13
 * Time: 11:32 PM
 */

define("_IN_IDEABOARD", true);
define("_REQUIRE_AUTH", false);


require_once('../app/app_start.php');

$method = $_SERVER['REQUEST_METHOD'];
$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));

switch ($method) {
    case 'POST':
        rest_post($request, json_decode($HTTP_RAW_POST_DATA));
        break;
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function rest_post($request, $data){
    global $SITE;
    $login = User::Authenticate($data->{'email'}, $data->{'password'});

    if ($login != null)
    {
        $_SESSION['user_authenticated'] = true;
        $_SESSION['user'] = $login;

        header("HTTP/1.0 200 OK");
    }else{
        header("WWW-Authenticate:xBasic realm={$SITE['general']['title']} Authentication Subsystem");
        header('HTTP/1.0 401 Unauthorized');
    }
}
