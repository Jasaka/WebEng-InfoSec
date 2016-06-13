<?php

class Crypto
{
    public $RSAresult;


    function __construct()
    {
        //config RSA-2048 und and create Public Key and Private Keys
        $configArray = array("digest_alg" => "sha512", "private_key_bits" => 2048, "private_key_type" => OPENSSL_KEYTYPE_RSA,);
        $this->RSAresult = openssl_pkey_new($configArray);
    }

    

    //create salt_masterkey with 64 Bytes long
    public function getSaltMasterkey()
    {
        $bytes = openssl_random_pseudo_bytes(64);
        $salt_masterkey   = bin2hex($bytes);
        
        return $salt_masterkey;
    }

    //create key_recipient with 128 Bit (16 Byte) long
    public function getKey_recipient128()
    {
        $bytes = openssl_random_pseudo_bytes(16);
        $key_recipient   = bin2hex($bytes);

        //$key_recipient = pack('H*', $key_recipient );



        return $key_recipient;
    }

    //create und transform masterkey   PBKDF2 [password / salt / 256 Bit /  10000]
    public function getMasterkey($password, $salt_masterkey)
    {
        $masterKey = hash_pbkdf2 ( 'sha256', $password , $salt_masterkey , 10000);


        //# the key should be random binary, use scrypt, bcrypt or PBKDF2 to
        //# convert a string into a key
        //# key is specified using hexadecimal
        $masterKey = pack('H*', $masterKey );

        return $masterKey;
    }

//    //config RSA-2048 und and create Public Key and Private Keys
//    public function createAllRSA()
//    {
//        $configArray = array("digest_alg" => "sha512", "private_key_bits" => 2048, "private_key_type" => OPENSSL_KEYTYPE_RSA,);
//        $this->RSAresult = openssl_pkey_new($configArray);
//
//        //return $res;
//    }

    
    //get pubkey_user from createAllRSA()
    public function getPubkeyUser() 
    {
        //$this->RSAresult = $this->createAllRSA();
        $pubkey_user = openssl_pkey_get_details($this->RSAresult);
        $pubkey_user = $pubkey_user["key"];

        return $pubkey_user;
    }


    //get private key from createAllRSA()
    public function getPrivkeyUser()
    {
        //$res = $this->createAllRSA();
        openssl_pkey_export($this->RSAresult, $privkey_user);

        return $privkey_user;
    }


    //get private key encrypted via AES-ECB-128 with masterkey 
    public function getPrivkeyUserEnc($password, $salt_masterkey)
    {
        $masterKey = $this->getMasterkey($password, $salt_masterkey);
        $privkey_user = $this->getPrivkeyUser();
        $privkey_user_enc = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $masterKey, $privkey_user, MCRYPT_MODE_ECB);

        return $privkey_user_enc;
    }




    //get private key encrypted via AES-ECB-128 with masterkey
    public function getPrivkeyUserDec($masterKeyNew, $privatkey_encDb)
    {
        $privkey_user_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $masterKeyNew, $privatkey_encDb, MCRYPT_MODE_ECB);
        
        return $privkey_user_dec;
    }


    //create a random IV to use with CBC encoding
    public function createIV()
    {
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        
        return $iv;
    }




    //compute signature with SHA-256
    public function digiSign($data, $privkey_userDb)
    {
        openssl_sign($data, $signature, $privkey_userDb, "sha256");

        return $signature;
    }




    

}



