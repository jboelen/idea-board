<?php
/**
 * User: James
 * Date: 5/22/13
 * Time: 12:16 AM
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
    case 'POST':
        rest_post($request, json_decode($HTTP_RAW_POST_DATA));
        break;
    case 'GET':
        rest_get($request);
        break;
    case 'DELETE':
        rest_delete($request);
        break;
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function rest_get($request) {
    global $SITE;
    if (count($request) == 1)
    {
        if($request[0] > 0){
            $item = Idea::GetById($request[0]);
            if($SITE['runtime']['currentuser']->authority == 2)
            {
                $item->get_Owner();
            }

            echo json_encode($item);
        }
    }
}

function rest_post($request, $data){
    global $SITE;
    $item = new Idea();
    $item->title = $data->{'title'};
    $item->summary = $data->{'summary'};
    $item->description = $data->{'description'};
    $item->owner = $SITE['runtime']['currentuser'];

    if ($item->Save() == true)
    {
        header("HTTP/1.0 201 Created");
        echo json_encode(array(
                'uri' => "/discuss/" . $item->id)
        );
    }
    else
    {
        header("HTTP/1.0 500 Internal Server Error");
    }
};

function rest_delete($request){
    global $SITE;

    $item = Idea::GetById($request[0]);
    var_dump($request);
    if($item->isOwner)
    {
        $item->deleted = true;

        if($item->Save() == true)
        {
            header('HTTP/1.0 204 No Content');
        }else
            header("HTTP/1.0 500 Internal Server Error");
    }else
        header('HTTP/1.0 403 Forbidden');
};