<?php
require_once 'Crypto.php';
include ('/Users/youssefElOuatiq/phpLibrary/httpful.phar');
require 'vendor/autoload.php';




echo "<h2> Nachrichtenversand Bausteine </h2>";
//Empfänger und Nachricht abfangen
$reciever = $_POST['reciever'];



$message = $_POST['message'];


echo "<p> receiver abgefangen ==></p>";
echo '     '.$reciever;
echo "<hr>";
echo "<p> Nachricht abgefangen ==></p>";
echo '     '.$message;
echo "<hr>";



//
//make a Request so we cann geht data from DB  ([\w]+)/pub_key/([\w]+)
$uri = "http://localhost/messenger/serverRest/youssef/pub_key/$reciever";

$response = \Httpful\Request::get($uri)
    ->expectsJson()
    ->sendsJson()
    ->send();

//echo "<p> Resopnse vom server</p>";
//echo $response;

//echo "<p> Resopnse details </p>";
//var_dump($response);


//decode the response to json
$myresponse = json_decode($response,true);

echo "<p> public Key of reciever from DB ==></p>";
$pubkey_recipient = base64_decode($myresponse['pubkey_user']);
echo $pubkey_recipient;
echo "<hr>";


//create Instance of class Crypto
$crypto = new Crypto();




//create key_recipient with 128 bit (16 Byte) long
$key_recipient = $crypto->getKey_recipient128();
echo "<p> symmetrischer Schlüssel key_recipient der Länge 128 bit erzeugen ==></p>";
echo $key_recipient;
echo "<br>key_recipient<hr>";



//create a random IV to use with CBC encoding
$iv = $crypto->createIV();
echo "<p> Initialisierungsvektor iv der Länge 128 Bit  erzeugen==></p>";
echo $iv;
echo "<hr>";




//encrypt the message with AES-CBC-128 + key_recipient + iv to Cipher
$cipher = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key_recipient, $message, MCRYPT_MODE_CBC, $iv);
echo "<p> Nachricht mit Hilfe von AES-CBC-128 und key_recipient, iv zu Cipher verschlüsseln ==></p>";
echo $cipher;
echo "<hr>";



//encrypt the key_recipient with RSA and pubkey_recipient  to key_recipient_enc + base64_encode
openssl_public_encrypt($key_recipient, $key_recipient_enc, $pubkey_recipient);
//$key_recipient_enc = base64_encode($key_recipient_enc);
echo "<p> key_recipient_enc mit RSA und pubkey_recipient verschlüsselt</p>";
echo $key_recipient_enc;   //encrypted string
echo "<hr>";


$identity = 'john';

//make a Request so we cann geht data from DB
$uri = "http://localhost/messenger/serverRest/user/$identity/";

$response = \Httpful\Request::get($uri)
    ->sendsJson()
    ->expectsJson()
    ->send();

echo "<p> Resopnse vom server</p>";
echo $response;

//echo "<p> Resopnse details </p>";
//var_dump($response);


//decode the response to json
$myresponse = json_decode($response,true);



$password = "1234";  //passwort müssen wir dynamisch abfangen können (session, angemeldet ... auf die post variablen zugreifen)


//privateKey_user_encDB decrypt to privateKey_user_dec
$privkey_user_encDb = $myresponse['privkey_user_enc'];
$privatkey_encDb = base64_decode($privkey_user_encDb);
$salt_masterkeyDb = $myresponse['salt_masterkey'];
$masterKeyNew = $crypto->getMasterkey($password, $salt_masterkeyDb);

$privkey_user_dec = $crypto->getPrivkeyUserDec($masterKeyNew,$privatkey_encDb);
echo $privkey_user_dec;
echo "<hr>";



$identity = "mounir";  //identität müssen wir dynamisch abfangen können (session, angemeldet ... auf die post variablen zugreifen)

//concate all the variable need to create a digi Signature       ist das richtig so ??
$signData1 = $identity.$cipher.$iv.$key_recipient_enc;



////compute signature with SHA-256  ### have wi to do these for all Strings one by one "Nachrichtenpaket" ??
//compute signature with SHA-256 and privkey_user
$sig_recipient = base64_encode($crypto->digiSign($signData1, $privkey_user_dec));
echo "hier ist die Signature  mit SHA-256 and privkey_user Innere Umschlag  ==>     ".$sig_recipient;
echo "<hr>";

//wie setzt man das prinzip von inner und außere Umschlag um


//packege of the Message  ==>  ich glaube dass das nicht richtig ist ??!!
//$messagePackage = array(
//    'identity'=> $identity,
//    'cipher'=> $cipher,
//    'iv'=> $iv,
//    'key_recipient_enc'=> $key_recipient_enc,
//    'sig_recipient'=> $signature,
//);


//get unix timestamp
$timestamp = time();
echo "Timestamp ==>     ";
echo $timestamp;
echo "<hr>";


//äußere Umschlag bilden
$signData2 = $signData1.$key_recipient_enc.$timestamp.$identity;


//compute signature with SHA-256 and privkey_user
$sig_service = base64_encode($crypto->digiSign($signData2, $privkey_user_dec));
echo "hier ist die Signature sig_service äußere Umschlag SHA-256 and privkey_user ==>     ".$sig_service;
echo "<hr>";


















?>