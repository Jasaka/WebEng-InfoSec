<?php

//es funktioniert erst wenn mann ein masterkey mit PBKDF2 algor und Private  key... siehe messenger/formHandler.php
$privkey_user = "create privkey_user";
$masterKey = "create masterkey";



# --- ENCRYPTION ---

/*
* string mcrypt_encrypt ( string $cipher , string $key , string $data , string $mode [, string $iv ] )
* string $cipher ==> MCRYPT_RIJNDAEL_128
* String $key ==> $masterkey
* string $data ==> $privkey_user
*string $mode ==> MCRYPT_MODE_CBC
* $iv ==> initialization vector
*/




# the key should be random binary, use scrypt, bcrypt or PBKDF2 to
# convert a string into a key
# key is specified using hexadecimal

$masterKey = pack('H*', $masterKey );
$key_size =  strlen($key);

echo "<p></p>";
echo "Key size: " . $key_size . "\n";

echo "<p></p>";


# create a random IV to use with ECB encoding
$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);



$privkey_user_enc = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $masterKey, $privkey_user, MCRYPT_MODE_CBC, $iv);






# prepend the IV for it to be available for decryption
$ciphertext = $iv . $privkey_user_enc;



echo "privkey_user encrypted with AES-ECB-128 + masterkey ==>   " ;
echo "<p></p>";
echo $privkey_user_enc;
echo "<p></p>";

# --- DECRYPTION ---

# retrieves the IV, iv_size should be created using mcrypt_get_iv_size()
$iv_dec = substr($ciphertext, 0, $iv_size);

$ciphertext_dec = substr($ciphertext, $iv_size);

$plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $ciphertext_dec, MCRYPT_MODE_ECB, $iv_dec);




echo  $plaintext_dec . "\n";


?>