<?php

include ('/Users/youssefElOuatiq/phpLibrary/httpful.phar');
require 'vendor/autoload.php';


echo "hello Word";

$fields = array(
    'identity' => "identity",
    'salt_masterkey' => "salt_masterkey",
    'pubkey_user' => "pubkey_user",
    'privkey_user_enc' => "privkey_user_enc");

$uri = "http://localhost/messenger/serverRest/user/1/";

$response = \Httpful\Request::post($uri)
    ->sendsJson()
    ->body(http_build_query($fields))
    ->send();

echo $response;


?>


