<?php
/**
 * Created by PhpStorm.
 * User: youssefElOuatiq
 * Date: 19.06.16
 * Time: 11:02
 */


//privatekey_user_encDb base64 ==> privatekey dec
$password = "1234";

$privkey_user_encDb = $myresponse['privkey_user_enc'];
$privatkey_encDb = base64_decode($privkey_user_encDb);
$salt_masterkeyDb = $myresponse['salt_masterkey'];
$masterKeyNew = $crypto->getMasterkey($password, $salt_masterkeyDb);

$privkey_user_dec = $crypto->getPrivkeyUserDec($masterKeyNew,$privatkey_encDb);

echo $privkey_user_dec.'<hr>';






//decrypt key_recipient_enc
openssl_private_decrypt ( $key_recipient_enc, $key_recipient_dec, $privkey_user_dec);
echo $key_recipient_dec;