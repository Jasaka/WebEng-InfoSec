<?php

require 'vendor/autoload.php';











require_once("UserRestHandler.php");
require_once ("MessageRestHandler.php");

$view = "";
if(isset($_GET["view"]))
	$view = $_GET["view"];

$user_id = "";
if(isset($_GET["user_id"]))
	$user_id = $_GET["user_id"];

//muss noch gestezt werden  
$password = "";


//$request = '';
//if(isset($_GET["request"]))
//	$request = $_GET["request"];

$message_id = '';
if(isset($_GET["message_id"]))
	$request = $_GET["message_id"];

$test_id = '';
if(isset($_GET["test_id"]))
	$request = $_GET["test_id"];


$user_identityrec = '';
if(isset($_GET["user_identityrec"]))
	$user_identityrec = $_GET["user_identityrec"];





/**
 * Property: method
 * The HTTP method this request was made in, either GET, POST, PUT or DELETE
 */
$method = $_SERVER['REQUEST_METHOD'];

//user url reaction




//get user
if($method == 'GET' && $view == "user" && $user_id != null)
{
	$userRestHandler = new UserRestHandler();
	$userRestHandler->getUserDb($user_id);
}

//delete user
if($method == 'DELETE' && $view == "user" && $user_id != null)
{
	$userRestHandler = new UserRestHandler();
	$userRestHandler->deleteUserDb($user_id);
}

//muss noch angepasst werden ==> innere methode
//save user
if($method == 'POST' && $view == "user" && $user_id != null)
{
	$userRestHandler = new UserRestHandler();
	$userRestHandler->getUserDb($user_id);
}


//get pub_key from Db for reciever
if ($method == 'GET' && $view == "pub_keyrec")
{

	$userRestHandler = new UserRestHandler();
	$userRestHandler->getUserDbIdent($user_identityrec);

}





//Mockup server answer for /reg
if ($method == 'POST' && $view == "registration")
{
	$id = 1;
	$messageRestHandler = new MessageRestHandler();
	$messageRestHandler->getMessage($id);

}


//Mockup server answer for /login
if ($method == 'POST' && $view == "login")
{
	$id = 2;
	$messageRestHandler = new MessageRestHandler();
	$messageRestHandler->getMessage($id);

}

//Mockup server answer for /pub_key
if ($method == 'GET' && $view == "pub_key")
{
	$id = 3;
	$messageRestHandler = new MessageRestHandler();
	$messageRestHandler->getMessage($id);

}


//Mockup server answer for /messageGetPostDel
if ($view == "messageGetPostDel")
{
	if($method == 'GET') {$id = 4;}
	if($method == 'POST') {$id = 5;}
	if($method == 'DELETE') {$id = 6;}


		$messageRestHandler = new MessageRestHandler();
		$messageRestHandler->getMessage($id);
}


//Mockup server answer for /messageDelAll
if ($method == 'DELETE' && $view == "messageDelAll")
{
	$id = 7;
	$messageRestHandler = new MessageRestHandler();
	$messageRestHandler->getMessage($id);

}

//Mockup server answer for /delaccount
if ($method == 'POST' && $view == "delaccount")
{
	$id = 8;
	$messageRestHandler = new MessageRestHandler();
	$messageRestHandler->getMessage($id);

}




















//message url reaction for one message

//get latest message
if($method == 'GET' && $view == "messageSingle" && $user_id != null)
{
	$userRestHandler = new UserRestHandler();
	$userRestHandler->getMessageDb($user_id);
}

//delete  message by id
if($method == 'DELETE' && $view == "messageSingle" && $message_id != null)
{
	$userRestHandler = new UserRestHandler();
	$userRestHandler->deleteMessageDb($message_id);
}

//muss noch angepasst werden ==> innere methode
//save message
if($method == 'POST' && $view == "messageSingle" && $user_id != null)
{
	$userRestHandler = new UserRestHandler();
	$userRestHandler->saveMessageDb($user_id);
}




//message url reaction for all message

if($method == 'GET' && $view == "allemessage" && $user_id != null)
{
	$messageRestHandler = new MessageRestHandler();
	$messageRestHandler->getAllMessageDB($user_id);
}

if($method == 'DELETE' && $view == "allemessage" && $user_id != null)
{
	$messageRestHandler = new MessageRestHandler();
	$messageRestHandler->deleteAllMessageDb($user_id);
}















?>
