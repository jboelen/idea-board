<?php
/**
 * User: James
 * Date: 5/21/13
 * Time: 8:40 PM
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
    case 'GET':
        rest_get($request);
        break;
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function rest_get($request) {

    if (count($request) == 1)
    {
        if($request[0] == 'promoted'){
            echo json_encode(Idea::getList(true));
        } else {
            $list = Idea::getList();

            if (count($list) > 0) {
                switch($request[0])
                {
                    case 'top':
                        quickSort($list, "Score");
                        break;
                    case 'hot':
                        quickSort($list, "get_HotScore");
                        break;
                    default:
                        break;
                }
            }
            echo json_encode($list);
        }
    }
}
