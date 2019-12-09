<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 08/Dec/2019 19:38 PM
 *
 * Base PHPGuard cryptography class
 **/

namespace PHPGuard\Core;


use PHPGuard\Core\Exceptions\EncryptionException;
use PHPGuard\Core\Exceptions\DecryptionException;


abstract class BaseCrypto extends CryptoSetup
{

    /**
     * @var string Algorithm
     */
    private $algorithm;


    /**
     * Constructor
     *
     * @param  string  $algorithm
     */
    protected function __construct($algorithm)
    {
        parent::__construct();
        $this->algorithm = $algorithm;
    }


    /**
     * @param  string  $value
     * @param  string  $key
     * @param  string  $iv
     *
     * @return false|string
     * @throws EncryptionException
     */
    protected function stringEncryption($value, $key, $iv)
    {
        $cipher = openssl_encrypt($value, $this->algorithm, $key, 0, $iv);
        if (!$cipher) {
            throw new EncryptionException("Could not encrypt the data!");
        }
        return base64_encode($cipher);
    }


    /**
     * @param  mixed   $data
     * @param  string  $key
     * @param  string  $iv
     * @param  bool    $serialize
     *
     * @return false|string
     * @throws EncryptionException
     */
    protected function encryption($data, $key, $iv, $serialize = true)
    {
        if (!$serialize && !is_string($data)) {
            throw new EncryptionException("Can not convert $data to string! change serialize to true");
        }
        if (!$serialize && is_string($data)) {
            return $this->stringEncryption($data, $key, $iv);
        }
        return $this->stringEncryption(json_encode(serialize($data)), $key, $iv);
    }


    /**
     * @param  string  $cipher
     * @param  string  $key
     * @param  string  $iv
     *
     * @return false|string
     * @throws DecryptionException
     */
    protected function stringDecryption($cipher, $key, $iv)
    {
        $plain = openssl_decrypt(base64_decode($cipher), $this->algorithm, $key, 0, $iv);
        if (!$plain) {
            throw new DecryptionException("Could not decrypt the data!");
        }
        return $plain;
    }


    /**
     * @param  string  $cipher
     * @param  string  $key
     * @param  string  $iv
     * @param  bool    $unserialize
     *
     * @return false|mixed|string
     * @throws DecryptionException
     */
    protected function decryption($cipher, $key, $iv, $unserialize = true)
    {
        if (!$unserialize) {
            return $this->stringDecryption($cipher, $key, $iv);
        }
        return unserialize(json_decode($this->stringDecryption($cipher, $key, $iv)));
    }
}