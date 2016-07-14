<?php

require_once 'Crypto.php';
include ('/Users/youssefElOuatiq/phpLibrary/httpful.phar');
require 'vendor/autoload.php';

?>



<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <title>Messenger Login</title>


    <link rel="stylesheet" href="css/reset.css">

    <link rel='stylesheet prefetch' href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900'>
    <link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>

    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="css/chat.css">




</head>

<body>


<!-- Mixins-->
<!-- Pen Title-->
<div class="pen-title">
    <h1>Messenger</h1><span>Pen <i class='fa fa-code'></i> by <a>Youssef El </a></span>
</div>
<div class="rerun"><a href="">Rerun Pen</a></div>
<div class="container">
    <div class="card"></div>
    <div class="card">
        <h1 class="title">Nachricht senden</h1>


        <form action="sendMessageHandler.php" method="post">
            <div class="input-container">
                <input type="text" name="reciever" id="reciever"  required="required"/>
                <label for="reciever">Empfänger</label>
                <div class="bar"></div>
            </div>
            <div class="input-container">

                <textarea class="textareamessage" type="text" name="message" id="message" required="required"></textarea>
                <label for="message">Nachricht</label>
                <div class="bar"></div>
            </div>
            <div class="button-container">
                <button><span>senden</span></button>
            </div>

        </form>


    </div>

</div>

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

<script src="js/index.js"></script>



<?php
    
    //später über session beziehen
    $identity = "john";
    $password = "1234";

    //timestamp
    $timestamp = time();


    $uri = "http://localhost/messenger/serverRest/user/data/$identity/";

    $response = \Httpful\Request::get($uri)
        ->sendsJson()
->expectsJson()
->send();

//echo "<p> Resopnse vom server</p>";
//echo $response;

//echo "<p> Resopnse details </p>";
//var_dump($response);


//decode the response to json
$myresponse = json_decode($response,true);



//extract data from response
//echo "<p> hier bin ich / Alle imoprtierten variablen vom Response </p>";

//echo "<p> user_id ==></p>";
$user_idDb = $myresponse['user_id'];
//echo $user_idDb;


//echo "<p> identity  ==></p>";
$identityDb = $myresponse['identity'];
//echo $identityDb;


//echo "<p> salt_masterkey  ==></p>";
$salt_masterkeyDb = $myresponse['salt_masterkey'];
//echo $salt_masterkeyDb;


//echo "<p> pubkey_user  ==></p>";
$pubkey_userDb = $myresponse['pubkey_user'];
//echo $pubkey_userDb;


//echo "<p> privkey_user_encDb  Datenbank</p>";
$privkey_user_encDb = $myresponse['privkey_user_enc'];
//echo $privkey_user_encDb;


//decode private key encrypted from DB @ base 64
//echo "<p> privkey_user_encDb_base64 enc  ==></p>";
$privatkey_encDb = base64_decode($privkey_user_encDb);
//$privatkey_encDb;





//create Instance of class Crypto
$crypto = new Crypto();



//create masterkey   PBKDF2 [password / salt / 256 Bit /  10000]
//echo "<p>masterkey wieder bilden ===></p>";
$masterKeyNew = $crypto->getMasterkey($password, $salt_masterkeyDb);
//echo "masterkey   PBKDF2 [password / salt / 256 Bit /  10000] ==>     ". $masterKeyNew;




# --- DECRYPTION ---  private key
//echo "<p>privatkey wieder entschlüsselt ===></p>";
$privkey_user_dec = $crypto->getPrivkeyUserDec($masterKeyNew,$privatkey_encDb);
//echo $privkey_user_dec;
//echo "<hr>";




$signData = $identity . $timestamp;


//compute signature with SHA-256 and privkey_user
$sign_ident_time = base64_encode($crypto->digiSign($signData, $privkey_user_dec));
echo "hier ist die Signature sign_ident_time ==>     ".$sign_ident_time;
echo "<hr>";


//    //make a request
//    $uri = "http://localhost/messenger/serverRest/user/checkGetMesg/$identity/$timestamp/$sign_ident_time";
//
//    $response = \Httpful\Request::get($uri)
//        ->sendsJson()
//        ->expectsJson()
//        ->send();















//    echo "<p> Hello world </p>";
//
//    $mysqli = new mysqli("localhost", "root", "", "messenger");
//
//    $sql = "SELECT * FROM message";
//
//    $result = $mysqli->query($sql);
//
//
//
//    if ( ! $result )
//    {
//    die('Ungültige Abfrage: ' . mysqli_error());
//    }
//
//    echo '<table border = "1">';
    //    while ($zeile = mysqli_fetch_array( $result, MYSQL_ASSOC))
    //    {
    //    echo '<tr>';
        //    echo '<td>'. $zeile['message_id'] . '</td>';
        //    echo "<td>". $zeile['cipher'] . "</td>";
        //    echo "<td>". $zeile['iv'] . "</td>";
        //    echo "<td>". $zeile['key_recipient_enc'] . "</td>";
        //    echo "<td>". $zeile['sig_recipient'] . "</td>";
        //    echo "<td>". $zeile['senderIdentity'] . "</td>";
        //    echo "<td>". $zeile['recieverIdentity'] . "</td>";
        //    echo "<td>". $zeile['timestamp'] . "</td>";
        //    echo '</tr>';
    //    }
    //    echo "</table>";
//
//    mysqli_free_result( $result );


?>



</body>
</html>
