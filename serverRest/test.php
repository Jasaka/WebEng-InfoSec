<?php



//
$message_id= "";
if(isset($_GET["message_id"]))
    $message_id = $_GET["message_id"];

echo $message_id;
////
////
////
//
////
$user_id2= "";
if(isset($_GET["user_id2"]))
    $user_id2 = $_GET["user_id2"];


echo $user_id2;
//
//
//
//
$user_id1= "";
if(isset($_GET["user_id1"]))
    $user_id1 = $_GET["user_id1"];
echo $user_id1;
//
//
//
//$rubrik= "";
//if(isset($_GET["rubrik"]))
//    $rubrik = $_GET["rubrik"];
//
////echo $rubrik;
//
//$seite= "";
//if(isset($_GET["seite"]))
//    $seite = $_GET["seite"];

//echo $seite;

//$view= "";
//if(isset($_GET["view"]))
//    $view = $_GET["view"];
//
//echo $view;
//
//
$user_id= "";
if(isset($_GET["user_id"]))
    $user_id = $_GET["user_id"];
//
//echo $user_id;


$method = $_SERVER['REQUEST_METHOD'];


//echo $method;

if ($method == 'GET')
{
    $mysqli = new mysqli("localhost", "root", "", "messenger");









    $result = $mysqli->query("SELECT message_txt FROM message WHERE user_id = $user_id");
    //$array = $result->fetch_assoc();

    $json = mysqli_fetch_all ($result, MYSQLI_ASSOC);
    $message = json_encode($json );

    echo $message;



}





    //print_r(array_values($user)) ;























?>