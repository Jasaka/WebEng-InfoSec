<?php
require_once 'Crypto.php';
include ('/Users/youssefElOuatiq/phpLibrary/httpful.phar');
require 'vendor/autoload.php';




echo " <p> hello Word </p>";


echo "<h2> Registrierung Bausteine </h2>";

$identity = $_POST['username'];
$password = $_POST['password'];

echo '     '.$identity;
echo '     '.$password;

echo "<p></p>";



//create Instance of class Crypto
$crypto = new Crypto();



//create salt_masterkey with 64 Bytes long
echo "<p> salt Masterkey ==> </p>";
$salt_masterkey = $crypto->getSaltMasterkey();
echo $salt_masterkey;
echo "<p></p>";



//create masterkey   PBKDF2 [password / salt / 256 Bit /  10000]

$masterKey = $crypto->getMasterkey($password, $salt_masterkey);
//echo "masterkey   PBKDF2 [password / salt / 256 Bit /  10000] ==> ";
//echo "<p></p>";
//echo $masterKey;
//echo "<p></p>";


//create pubkey_user with RSA-2048

$pubkey_user = $crypto->getPubkeyUser();
echo "<p> Public key </p>";
echo $pubkey_user;
echo "<p></p>";


//create private key with RSA-2048

//echo "<p> Private key normal </p>";
//$privkey_user = $crypto->getPrivkeyUser();
//echo $privkey_user;
//echo "<p></p>";


//get private key encrypted via AES-ECB-128 with masterkey and password

$privkey_user_enc = $crypto->getPrivkeyUserEnc($password, $salt_masterkey);
echo "privkey_user encrypted with AES-ECB-128 + masterkey ==> ";
echo "<p></p>";
echo $privkey_user_enc;
echo "<p></p>";


//get $privkey_user_enc encrypted one more time via base64_encode ==> json and database compatible

echo "<p>privkey_user_enc_base64</p>";
$privkey_user_enc_base64 = base64_encode($privkey_user_enc);
echo $privkey_user_enc_base64;
echo "<p></p>";













?>