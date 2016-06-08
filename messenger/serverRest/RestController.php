<?php
require_once("UserRestHandler.php");

$view = "";
if(isset($_GET["view"]))
	$view = $_GET["view"];

$user_id = "";
if(isset($_GET["user_id"]))
	$user_id = $_GET["user_id"];

//muss noch gestezt werden  
$password = "";


$request = '';
if(isset($_GET["request"]))
	$request = $_GET["request"];





///**
// * Property: method
// * The HTTP method this request was made in, either GET, POST, PUT or DELETE
// */
//$methodTest = '';
//
///**
// * Property: endpoint
// * The Model requested in the URI. eg: /files
// */
//$endpoint = '';
//
///**
// * Property: verb
// * An optional additional descriptor about the endpoint, used for things that can
// * not be handled by the basic methods. eg: /files/process
// */
//$verb = '';
//
///**
// * Property: args
// * Any additional URI components after the endpoint and verb have been removed, in our
// * case, an integer ID for the resource. eg: /<endpoint>/<verb>/<arg0>/<arg1>
// * or /<endpoint>/<arg0>
// */
//$args = Array();
//
///**
// * Property: file
// * Stores the input of the PUT request
// */
//$file = Null;

/*

$userRestHandler = new UserRestHandler();
$userRestHandler->getRequest();

*/

/*

$methodTest = $_SERVER['REQUEST_METHOD'];

$args = explode('/', rtrim($request, '/'));

$endpoint = array_shift($args);

if (array_key_exists(0, $args) && !is_numeric($args[0]))
{
	$verb = array_shift($this->args);
}

$userRestHandler = new UserRestHandler();
$userRestHandler->getRequest($methodTest,$endpoint, $verb, $args);

*/



/**
 * Property: method
 * The HTTP method this request was made in, either GET, POST, PUT or DELETE
 */
$method = $_SERVER['REQUEST_METHOD'];




if($method == 'GET' && $view == "user" && $user_id != null)
{
	$userRestHandler = new UserRestHandler();
	$userRestHandler->getUserDb($user_id);
}


if($method == 'DELETE' && $view == "user" && $user_id != null)
{
	$userRestHandler = new UserRestHandler();
	$userRestHandler->deleteUserDb($user_id);
}

















/*


switch($method)
{

	case 'POST':

		$userRestHandler = new UserRestHandler();
		$userRestHandler->getMessage($user_id);
		break;

	case 'Delete':
		$userRestHandler = new UserRestHandler();
		$userRestHandler->deleteUserDb($user_id);
		break;


}







//löschen
/*

//$method = '';
$method = $_SERVER['REQUEST_METHOD'];
//Löschen
/*if ($method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
	if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE') {
		$method = 'DELETE';
	} else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT') {
		$method = 'PUT';
	else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'GET') {
			$method = 'GET';
	} else {
		throw new Exception("Unexpected Header");
	}
}
*/




		
//löschen
/*
controls the RESTful services
URL mapping
*/
/*
switch($view){

	case "all":
		// to handle REST Url /user/list/
		$userRestHandler = new UserRestHandler();
		$userRestHandler->getAllUser();
		break;

	case "" :
		//404 - not found;
		break;

	case "user":
		// to handle REST Url /user/show/<id>/
		$userRestHandler = new UserRestHandler();
		if($method == 'GET')
		{
			$userRestHandler->getUserDb($_GET["user_id"]);
			break;
		}
		else if($method == 'DELETE')
		{
			$userRestHandler->deleteUserDb($_GET["user_id"]);
			break;
		}
}

*/


?>
