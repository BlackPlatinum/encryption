<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 06/Nov/2019 01:40 PM
 *
 * Main CAST5 encryption class to encrypt and decrypt data
 **/

namespace PHPGuard\Crypto\Algorithms;


use PHPGuard\Core\Decryption;
use PHPGuard\Core\Encryption;
use PHPGuard\Core\Setup;
use PHPGuard\Exception\DecryptionException;
use PHPGuard\Exception\EncryptionException;
use RuntimeException;

class CAST5 extends Setup implements Encryption, Decryption
{
    // Algorithm name
    private const CAST = "CAST5-CBC";

    // Stores Key
    private $KEY;

    // Stores IV
    private $IV;


    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Sets key of cryptography system
     *
     * @param  string  $key  key of cryptography system [recommended use user's password as key]
     */
    public function setKey($key): void
    {
        $this->KEY = parent::setupKey($key);
    }


    /**
     * Sets IV of cryptography system
     *
     * @param  string  $iv  iv of cryptography system [recommended use user's password as iv]
     */
    public function setIV($iv): void
    {
        $this->IV = substr(parent::setupIV($iv), 0, 8);
    }


    /**
     * Gets key of cryptography system
     *
     * @return string return key of cryptography system
     */
    public function getKey()
    {
        return $this->KEY;
    }


    /**
     * Gets IV of cryptography system
     *
     * @return string return initial vector of cryptography system
     */
    public function getIV()
    {
        return $this->IV;
    }


    /**
     * Encrypts the given value
     *
     * @param  string  $value  the value that will be encrypted
     *
     * @return false|string return encrypted value, false on failure
     * @throws EncryptionException throws exception if validate method returns false or can not encrypt the the $value
     */
    public function encryptString($value)
    {
        if (is_null($this->IV) || is_null($this->KEY)) {
            throw new EncryptionException("Empty key or initial vector!");
        }
        $cipher = openssl_encrypt($value, self::CAST, $this->KEY, 0, $this->IV);
        if ($cipher === false) {
            throw new EncryptionException("Could not encrypt the data!");
        }
        return base64_encode($cipher);
    }


    /**
     * Decrypts the given cipher
     *
     * @param  string  $cipher  the cipher that will be decrypted
     *
     * @return false|string return decrypted cipher, false on failure
     * @throws DecryptionException throws exception if validate method returns false or can not decrypt the the $cipher
     */
    public function decryptString($cipher)
    {
        $plain = openssl_decrypt(base64_decode($cipher), self::CAST, $this->KEY, 0, $this->IV);
        if ($plain === false) {
            throw new DecryptionException("Could not decrypt the data!");
        }
        return $plain;
    }


    /**
     * Encrypts the given data
     *
     * @param  mixed  $data       the data that will be encrypted
     * @param  bool   $serialize  [recommended true], if $serialize is false and $data is string is correct,
     *                            but if $serialize is false and $data is not string you get run time exception
     *
     * @return false|string return encrypted value, false on failure
     * @throws EncryptionException throws exception if validate method returns false or can not decrypt the the $cipher
     */
    public function encrypt($data, $serialize = true)
    {
        if ($serialize === false && !is_string($data)) {
            throw new RuntimeException("Can not convert $data to string! change serialize to true");
        }
        if ($serialize === false && is_string($data)) {
            return $this->encryptString($data);
        }
        return $this->encryptString(json_encode(serialize($data)));
    }


    /**
     * Decrypts the given cipher
     *
     * @param  string  $cipher       the cipher that will be decrypted
     * @param  bool    $unserialize  [recommended true], if $unserialize is false you achieve unserialized json decoded value
     *                               and must be handled by user
     *
     * @return mixed return encrypted value, false on failure
     * @throws DecryptionException throws exception if validate method returns false or can not decrypt the the $cipher
     */
    public function decrypt($cipher, $unserialize = true)
    {
        if ($unserialize === false) {
            return $this->decryptString($cipher);
        }
        return unserialize(json_decode($this->decryptString($cipher)));
    }
}