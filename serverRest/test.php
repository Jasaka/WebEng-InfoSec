<?php
require_once("UserRestHandler.php");
require_once ("MessageRestHandler.php");


$method = $_SERVER['REQUEST_METHOD'];

$para = $_POST['salt_masterkey'];


//$request = file_get_contents('php://input');


$view = "";
if(isset($_GET["view"]))
    $view = $_GET["view"];



//$request_body = @file_get_contents('php://input');


if($method == 'POST' && $view == "test" )
{
    $messageRestHandler = new MessageRestHandler();
    $messageRestHandler->getTest($para);
}









?>