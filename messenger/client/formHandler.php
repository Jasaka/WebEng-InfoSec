<?php

include ('/Users/youssefElOuatiq/phpLibrary/httpful.phar');
require 'vendor/autoload.php';



echo " <p> hello Word hier bin ich </p>";


echo "<h2> Registrierung Bausteine </h2>";

$identity = $_POST['username'];
$password = $_POST['password'];

echo '     '.$identity;
echo '     '.$password;

echo "<p></p>";
//
//
//
$bytes = openssl_random_pseudo_bytes(64);
$salt_masterkey   = bin2hex($bytes);
//

 //test salt master key and master key
echo "salt_masterkey  64 bytes   ==>     ".$salt_masterkey;
//$password = "test234";
echo "<p></p>";
$masterKey = hash_pbkdf2 ( 'sha256', $password , $salt_masterkey , 10000);
//echo "masterkey   PBKDF2 [password / salt / 256 Bit /  10000] ==>     ". $masterKey;
//
//
//
//echo "<p></p>";
//
//
//
//
//
$config = array(
    "digest_alg" => "sha512",
    "private_key_bits" => 2048,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
    );
//
//// Create the private and public key
$res = openssl_pkey_new($config);
//
//// Extract the private key from $res to $privKey
openssl_pkey_export($res, $privkey_user);
//
//// Extract the public key from $res as array to $pubKey as String
$pubkey_user = openssl_pkey_get_details($res);
$pubkey_user = $pubkey_user["key"];




 //test public key and private key

echo $pubkey_user;
echo "<p></p>";


//echo $privkey_user;





//echo "<p> Privatekey verschlüsselt </p>";


//
//# --- ENCRYPTION ---
//
///*
// * string mcrypt_encrypt ( string $cipher , string $key , string $data , string $mode [, string $iv ] )
// * string $cipher ==> MCRYPT_RIJNDAEL_128
// * String $key ==> $masterkey
// * string $data ==> $privkey_user
// *string $mode ==> MCRYPT_MODE_CBC
// * $iv ==> initialization vector
// */
//
//
//
//
//# the key should be random binary, use scrypt, bcrypt or PBKDF2 to
//# convert a string into a key
//# key is specified using hexadecimal
$masterKey = pack('H*', $masterKey );
//$key_size =  strlen($masterKey);
//
//echo "<p></p>";
//echo "Key size: " . $key_size;
//
//echo "<p></p>";
//
//
//
//# --- ENCRYPTION ---
//
//$privkey_user_enc = mcrypt_ecb (MCRYPT_RIJNDAEL_128, $masterKey, $privkey_user, MCRYPT_MODE_CBC);

$privkey_user_enc = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $masterKey, $privkey_user, MCRYPT_MODE_ECB);



echo "privkey_user encrypted with AES-ECB-128 + masterkey ==>  hier hier hier " ;
echo "<p>hier bla bla bla</p>";
echo $privkey_user_enc;

echo "<p>privkey_user_enc_base64</p>";

$privkey_user_enc_base64 = base64_encode($privkey_user_enc);

echo $privkey_user_enc_base64;


# --- DECRYPTION ---

echo "privkey_user decrypted with AES-ECB-128 + masterkey ==>   " ;
echo "<p></p>";

$privkey_user_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $masterKey, $privkey_user_enc, MCRYPT_MODE_ECB);

echo  $privkey_user_dec ;


//strlen — Ermitteln der String-Länge
echo "Ermitteln der String-Länge ";
$key_size2 =  strlen($privkey_user_enc);

echo "<p></p>";
echo "Key size: " . $key_size2 . "\n";

echo "<p>hier bin ich 1ste response </p>";




//hier müsssen wir noch schauen wie wir post und update hinbekommen !!!
$fields = array(
    'identity' => "111",
    'salt_masterkey' => "11",
    'pubkey_user' => "11",
    'privkey_user_enc' => "11"
    );

//$url = "http://localhost/messenger/serverRest/user/1/";


//$response = \Httpful\Request::get($url)
//    ->expectsJson()
//    ->body(http_build_query($fields))
//    ->send();



//echo "<p> hier bin ich 2</p>";
//echo $response;
//
//echo "<p> hier bin ich 3</p>";
//var_dump($response);








echo "<h2> anmeldung Bausteine </h2>";


$uri = "http://localhost/messenger/serverRest/user/1/";

$response = \Httpful\Request::get($uri)
    //->expectsJson()
    ->sendsJson()
    ->expectsJson()
    ->send();

echo "<p> Resopnse vom server</p>";
echo $response;
$myresponse = json_decode($response,true);


echo "<p> hier bin ich / Alle imoprtierten variablen vom Response </p>";

echo "<p> user_id ==></p>";

echo $myresponse['user_id'];

echo "<p> identity  ==></p>";
echo $myresponse['identity'];

echo "<p> salt_masterkey  ==></p>";
echo $myresponse['salt_masterkey'];

echo "<p> pubkey_user  ==></p>";
echo $myresponse['pubkey_user'];


echo "<p> privkey_user_enc ==></p>";

echo $privkey_user_enc;


echo "<p> privkey_user_encDb  Datenbank</p>";
$privkey_user_encDb = $myresponse['privkey_user_enc'];

echo $privkey_user_encDb;


//echo "<p> pubkey_user_encDb_base64  ==></p>";
//$privkey_user_encDb_base64 = base64_decode($privkey_user_encDb);
//echo $privkey_user_enc_base64;

echo "<p> pubkey_user_encDb_base64 enc bla ==></p>";

$privatkey_encDb = base64_decode($privkey_user_encDb);

echo $privatkey_encDb;






$identityDb = $myresponse['identity'];
$salt_masterkeyDb = $myresponse['salt_masterkey'];
$pubkey_userDb = $myresponse['pubkey_user'];


echo "<p> hier bin ich 22223</p>";



echo "<p>masterkey wieder bilden ===></p>";

$masterKeyNew = hash_pbkdf2 ( 'sha256', $password , $salt_masterkeyDb , 10000);
echo "masterkey   PBKDF2 [password / salt / 256 Bit /  10000] ==>     ". $masterKeyNew;

//# the key should be random binary, use scrypt, bcrypt or PBKDF2 to
//# convert a string into a key
//# key is specified using hexadecimal
$masterKeyNew = pack('H*', $masterKeyNew );


echo "<p>privatkey..... ===></p>";

$privkey_user_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $masterKeyNew, $privatkey_encDb, MCRYPT_MODE_ECB);

echo $privkey_user_dec;





$uri = "http://localhost/messenger/serverRest/message/all/";

$response = \Httpful\Request::get($uri)

    ->expectsJson()
    ->send();

echo "<p> Resopnse vom server</p>";
echo $response;


?>