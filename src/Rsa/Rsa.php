<?php

namespace Leonine\Rsa;

use Exception;

class Rsa
{

    protected $publicKey = '';
    protected $privateKey = '';


    /**
     * Rsa constructor.
     * @param string $privateKeyPath 我方私钥文件路径
     * @param string $publicKeyPath 他方公钥文件路径
     * @throws Exception
     */
    public function __construct($privateKeyPath = '', $publicKeyPath = '') {
        if (!is_file($privateKeyPath) || !is_file($publicKeyPath)) {
            throw new Exception('privateKey or publicKey not found!');
        }

        $privateKey = openssl_pkey_get_private(file_get_contents($privateKeyPath));
        $publicKey = openssl_pkey_get_public(file_get_contents($publicKeyPath));
        $this->privateKey = $privateKey;
        $this->publicKey = $publicKey;

    }

    /**
     * 使用他方公钥加密
     * @param string $data
     * @param resource $publickey
     * @param int $mode
     * @return string  返回base64编码后的字符串
     * @author leo
     * @date-time 2020/4/17-15:24
     */
    public function encrypt($data = '', $padding = OPENSSL_PKCS1_PADDING) {
        openssl_public_encrypt($data, $encrypted, $this->publicKey, $padding);
        return base64_encode($encrypted);
    }

    /**
     * 使用我方私钥解密
     * @param string $data
     * @param int $padding
     * @return mixed
     * @author leo
     * @date-time 2020/4/17-15:35
     */
    public function decrypt($data = '',$padding = OPENSSL_PKCS1_PADDING) {
        openssl_private_decrypt($data,$decrypted,$this->privateKey,$padding);
        return $decrypted;
    }



    public function sign() {

    }

    public function verify() {

    }


}