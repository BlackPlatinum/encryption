<?php

/**
 * @author  BlackPlatinum Developers
 * @license MIT
 * Date: 16/Aug/2020 03:10
 **/

namespace BlackPlatinum\Encryption\Crypto\Asymmetric;

use BlackPlatinum\Encryption\Core\Crypto\Asymmetric\BaseCrypto;
use BlackPlatinum\Encryption\Core\Crypto\Asymmetric\Decryption;
use BlackPlatinum\Encryption\Core\Crypto\Asymmetric\Encryption;
use BlackPlatinum\Encryption\Core\Exception\DecryptionException;
use BlackPlatinum\Encryption\Core\Exception\EncryptionException;

class Crypto extends BaseCrypto implements Encryption, Decryption
{
    /**
     * Create an instance of Crypto.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Decrypt the cipher with the public key.
     *
     * @param string $cipher
     * @param string $key
     * @return mixed
     *
     * @throws DecryptionException
     */
    public function publicKeyDecrypt($cipher, $key)
    {
        return parent::decryptWithPublicKey($cipher, $key);
    }

    /**
     * Decrypt the cipher with the private key.
     *
     * @param $cipher
     * @param $key
     * @return mixed
     *
     * @throws DecryptionException
     */
    public function privateKeyDecrypt($cipher, $key)
    {
        return parent::decryptWithPrivateKey($cipher, $key);
    }

    /**
     * Encrypt the data with the public key.
     *
     * @param mixed $data
     * @param string $key
     * @return string
     *
     * @throws EncryptionException
     */
    public function publicKeyEncrypt($data, $key)
    {
        return parent::encryptWithPublicKey($data, $key);
    }

    /**
     * Encrypt the data with the private key.
     *
     * @param $data
     * @param $key
     * @return string
     *
     * @throws EncryptionException
     */
    public function privateKeyEncrypt($data, $key)
    {
        return parent::encryptWithPrivateKey($data, $key);
    }
}
