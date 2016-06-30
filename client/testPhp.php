<?php

include ('/Users/youssefElOuatiq/phpLibrary/httpful.phar');
require 'vendor/autoload.php';

$masterKeyNew = '26b_�Q}�#���y�8(��,{�� �';
$masterKeyNew = pack('H*', $masterKeyNew );

$privatkey_encDb = "yabadabado";
echo $privatkey_encDb;

echo "<hr>";


$crypted = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $masterKeyNew, $privatkey_encDb, MCRYPT_MODE_ECB);

echo $crypted;
echo "<hr>";

$decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $masterKeyNew, $privatkey_encDb, MCRYPT_MODE_ECB);


echo $decrypted;
echo "<hr>";

?>


