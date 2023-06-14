<?php

namespace App\Services;

class EncryptionService
{
    private $secret_key ;
    private $secret_IV ;
    private $encrypt_method ;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->encrypt_method = config("encryption.ENCRYPT_METHOD");
        $this->secret_key = config("encryption.secret_key");
        $this->secret_IV = config("encryption.secret_IV");
    }

    /**
     * encrypt string
     * @param string $string
     * @return string
     */
    public function encrypt(string $string){
        $key = hash('sha256',$this->secret_key );
        $iv = substr(hash('sha256', $this->secret_IV ), 0, 16);
        $encryptToken = openssl_encrypt($string, $this->encrypt_method, $key, 0, $iv);
        $encryptToken = base64_encode($encryptToken);
        return$encryptToken;
    }

    /**
     * decrypt string
     * @param string $token
     * @return false|string
     */
    public function decrypt(string $token){
        $key = hash('sha256', $this->secret_key);
        $iv = substr(hash('sha256', $this->secret_IV), 0, 16);
        $decryptToken = openssl_decrypt(base64_decode($token), $this->encrypt_method, $key, 0, $iv);        $decryptTokenArray = json_decode($decryptToken, 1);
        return $decryptToken;
    }
}
