<?php
require_once 'Crypto.php';
include ('/Users/youssefElOuatiq/phpLibrary/httpful.phar');
require 'vendor/autoload.php';


echo "<h2> Nachrichtenversand Bausteine </h2>";

//Empfänger und Nachricht abfangen
$reciever = $_POST['reciever'];
$message = $_POST['message'];

echo '     '.$reciever;
echo "<p></p>";
echo '     '.$message;
echo "<p></p>";



//
//make a Request so we cann geht data from DB  ([\w]+)/pub_key/([\w]+)
$uri = "http://localhost/messenger/serverRest/youssef/pub_key/Mounir";

$response = \Httpful\Request::get($uri)
    ->expectsJson()
    ->sendsJson()
    ->send();

echo "<p> Resopnse vom server</p>";
echo $response;

//echo "<p> Resopnse details </p>";
//var_dump($response);


//decode the response to json
$myresponse = json_decode($response,true);


?>