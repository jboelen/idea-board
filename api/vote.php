<?php
/**
 * User: James
 * Date: 5/27/13
 * Time: 11:39 PM
 */

error_reporting(E_ALL);
ini_set('display_errors','On');

define("_IN_IDEABOARD", true);
define("_REQUIRE_AUTH", true);
define("_IS_API", true);

require_once('../app/app_start.php');

$method = $_SERVER['REQUEST_METHOD'];
$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));

switch ($method) {
    case 'PUT':
        rest_put($request, json_decode( file_get_contents("php://input")));
        break;
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}