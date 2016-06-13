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
echo "<p> Nachricht abgefangen ==></p>";
echo '     '.$message;
echo "<p></p>";



//
//make a Request so we cann geht data from DB  ([\w]+)/pub_key/([\w]+)
$uri = "http://localhost/messenger/serverRest/youssef/pub_key/Youssef";

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
$pubkey_recipient = $myresponse['pubkey_user'];
echo $pubkey_recipient;
echo "<p></p>";



//create Instance of class Crypto
$crypto = new Crypto();


//create key_recipient with 128 bit (16 Byte) long
$key_recipient = $crypto->getKey_recipient128();
echo "<p> symmetrischer Schlüssel key_recipient der Länge 128 bit ==></p>";
echo $key_recipient;
echo "<p></p>";



//create a random IV to use with CBC encoding
$iv = $crypto->createIV();
echo "<p> Initialisierungsveltor iv der Länge 128 Bit ==></p>";
echo $iv;
echo "<p></p>";




//encrypt the message with AES-CBC-128 + key_recipient + iv to Cipher
$cipher = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key_recipient, $message, MCRYPT_MODE_CBC, $iv);
echo "<p> Nachricht mit Hilfe von AES-CBC-128 und key_recipient, iv zu Cipher verschlüsseln ==></p>";
echo $cipher;
echo "<p></p>";




//just to test with another pubKey, it works ... ### but not with the pubkey what we did become via http request get.????????
$pubkey_userTest = $crypto->getPubkeyUser();
//echo "<p> pubkey zum testen ## neu geniriert   ==></p>";
//echo $pubkey_userTest;
//echo "<p></p>";



//encrypt the key_recipient with RSA and pubkey_recipient
echo "<p> key_recipient mit Hilfe von RSA und pubkey_recipient zu key_recipient_enc verschlüsseln ###  funktioniert nocht nicht problem mit dem importierten pubkey  pubkey_recipient==></p>";
//encrypt the key_recipient with RSA and pubkey_recipient  to key_recipient_enc
openssl_public_encrypt($key_recipient, $key_recipient_enc, $pubkey_recipient);
echo $key_recipient_enc;   //encrypted string
echo "<p></p>";


//compute signature with SHA-256  ### have wi to do these for all Strings one by one "Nachrichtenpaket" ??   not forget the get the private Key from DB !!
$privkey_userTest = $crypto->getPrivkeyUser();
//echo $privkey_userTest;
//compute signature with SHA-256
$signature = $crypto->digiSign($message, $privkey_userTest);
echo $signature;































?>