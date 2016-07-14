<?php
require_once 'Crypto.php';
include ('/Users/youssefElOuatiq/phpLibrary/httpful.phar');
require 'vendor/autoload.php';



echo "<h2> Registrierung Bausteine </h2>";

$identity = $_POST['username'];
$password = $_POST['password'];

echo '     '.$identity;
echo '     '.$password;

echo "<hr>";



//create Instance of class Crypto
$crypto = new Crypto();



//create salt_masterkey with 64 Bytes long
echo "<p> salt Masterkey ==> </p>";
$salt_masterkey = $crypto->getSaltMasterkey();
echo $salt_masterkey;
echo "<hr>";



//create masterkey   PBKDF2 [password / salt / 256 Bit /  10000]
$masterKey = $crypto->getMasterkey($password, $salt_masterkey);
echo "masterkey   PBKDF2 [password / salt / 256 Bit /  10000] ==> ";
echo "<p></p>";
echo $masterKey;
echo "<hr>";



//create pubkey_user with RSA-2048
$pubkey_user = $crypto->getPubkeyUser();
echo $pubkey_user;
echo "<p> ====>  Public key encode 64</p>";
$pubkey_user_enc_base64 = base64_encode($pubkey_user);
echo $pubkey_user_enc_base64;
echo "<hr>";



//create private key with RSA-2048
$privkey_user = $crypto->getPrivkeyUser();
echo $privkey_user;
echo "<p> ====> Private key encode 64</p>";
$privkey_user = base64_encode($privkey_user);
echo $privkey_user;
echo "<hr>";



//get private key encrypted via AES-ECB-128 with masterkey and password
$privkey_user_enc = $crypto->getPrivkeyUserEnc($password, $salt_masterkey);
echo "privkey_user encrypted with AES-ECB-128 + masterkey ==> ";
echo "<p></p>";
echo $privkey_user_enc;
echo "<hr>";



//get $privkey_user_enc encrypted one more time via base64_encode ==> json and database compatible
$privkey_user_enc_base64 = base64_encode($privkey_user_enc);
echo "<p>privkey_user_enc_base64</p>";
echo $privkey_user_enc_base64;
echo "<hr>";


$postData = array(
    'salt_masterkey'=> $salt_masterkey,
    'pubkey_user'=> $pubkey_user_enc_base64,
    '$privkey_user_enc'=> $privkey_user_enc_base64,
    'identity'=> $identity,
);

//make a Request so we cann geht data from DB
//$uri = "http://localhost/messenger/serverRest/test";
//
//$response = \Httpful\Request::post($uri)
//    ->sendsJson()
//    ->expectsJson()
//    ->addHeader('salt_masterkey', $salt_masterkey)
//    ->send();
//
//
//
//
//echo "<p> Resopnse vom server</p>";
////var_dump($response);
//
//$response = json_decode($response, true);
//
////$myresponse = json_decode($response,true);
//
//print_r($response);
//
//





?>