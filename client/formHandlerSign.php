<?php
require_once 'Crypto.php';
include ('/Users/youssefElOuatiq/phpLibrary/httpful.phar');
require 'vendor/autoload.php';


echo "<h2> anmeldung Bausteine </h2>";

//hier müsssen wir noch schauen wie wir insert hinbekommen ==>  datenbank persistierung !!!



$identity = $_POST['username'];
$password = $_POST['password'];

//echo '     '.$identity;
//echo '     '.$password;

//echo "<p></p>";



//make a Request so we cann geht data from DB
$uri = "http://localhost/messenger/serverRest/user/1/";

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
//echo $privatkey_encDb;


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


if (strpos($privkey_user_dec, 'BEGIN PRIVATE KEY') !== false)
{
    $signsuccess = true;
}
else
{
    $signsuccess = false;
}


if (!$signsuccess)
{
    echo 'Das von dir eingegebene Passwort oder identität ist falsch !!!';
}

else
{
    header("Location: chat.html");
    exit;
}



