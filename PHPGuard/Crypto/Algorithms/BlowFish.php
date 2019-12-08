<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 05/Nov/2019 23:47 PM
 *
 * Main BlowFish encryption class to encrypt and decrypt data
 **/

namespace PHPGuard\Crypto\Algorithms;


use PHPGuard\Core\BaseCrypto;
use PHPGuard\Core\Encryption;
use PHPGuard\Core\Decryption;
use PHPGuard\Exception\CryptoException;
use PHPGuard\Exception\EncryptionException;
use PHPGuard\Exception\DecryptionException;


class BlowFish extends BaseCrypto implements Encryption, Decryption
{

    /**
     * @var string Key
     */
    private $KEY;

    /**
     * @var string IV
     */
    private $IV;


    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct("BF-CBC");
    }


    /**
     * Validates value of key and IV
     *
     * @throws CryptoException Throws exception if key or IV remain null
     */
    private function validateAssets(): void
    {
        if (is_null($this->IV) || is_null($this->KEY)) {
            throw new CryptoException("Empty key or initial vector!");
        }
    }


    /**
     * Sets key of cryptography system
     *
     * @param  string  $key  Key of cryptography system [recommended use user's password as key]
     */
    public function setKey($key): void
    {
        $this->KEY = parent::setupKey($key);
    }


    /**
     * Sets IV of cryptography system
     *
     * @param  string  $iv  IV of cryptography system [recommended use user's password as IV]
     */
    public function setIV($iv): void
    {
        $this->IV = substr(parent::setupIV($iv), 0, 8);
    }


    /**
     * Returns key of cryptography system
     *
     * @return string Returns key of cryptography system
     */
    public function getKey()
    {
        return $this->KEY;
    }


    /**
     * Returns IV of cryptography system
     *
     * @return string Returns IV of cryptography system
     */
    public function getIV()
    {
        return $this->IV;
    }


    /**
     * Encrypts the given data
     *
     * @param  string  $data  The data that will be encrypted
     *
     * @return false|string Returns encrypted data, false on failure
     * @throws EncryptionException Throws exception if validate method returns false or can not encrypt the the $data
     * @throws CryptoException Throws exception if key or IV remain null
     */
    public function encryptString($data)
    {
        $this->validateAssets();
        return parent::stringEncryption($data, $this->KEY, $this->IV);
    }


    /**
     * Encrypts the given data
     *
     * @param  mixed  $data       The data that will be encrypted
     * @param  bool   $serialize  [Recommended true], If $serialize is false and $data is string is correct,
     *                            but if $serialize is false and $data is not string you will get EncryptionException
     *
     * @return false|string Returns encrypted value, false on failure
     * @throws EncryptionException Throws exception if validate method returns false or can not decrypt the the $cipher
     * @throws CryptoException Throws exception if key or IV remain null
     */
    public function encrypt($data, $serialize = true)
    {
        $this->validateAssets();
        return parent::encryption($data, $this->KEY, $this->IV, $serialize);
    }


    /**
     * Decrypts the given cipher
     *
     * @param  string  $cipher  The cipher that will be decrypted
     *
     * @return false|string Returns decrypted cipher, false on failure
     * @throws DecryptionException Throws exception if validate method returns false or can not decrypt the the $cipher
     * @throws CryptoException Throws exception if key or IV remain null
     */
    public function decryptString($cipher)
    {
        $this->validateAssets();
        return parent::stringDecryption($cipher, $this->KEY, $this->IV);
    }


    /**
     * Decrypts the given cipher
     *
     * @param  string  $cipher       The cipher that will be decrypted
     * @param  bool    $unserialize  [Recommended true], If $unserialize is false you achieve unserialized json decoded value
     *                               and must be handled by user
     *
     * @return false|mixed|string Returns encrypted value, false on failure
     * @throws DecryptionException Throws exception if validate method returns false or can not decrypt the the $cipher
     * @throws CryptoException Throws exception if key or IV remain null
     */
    public function decrypt($cipher, $unserialize = true)
    {
        $this->validateAssets();
        return parent::decryption($cipher, $this->KEY, $this->IV, $unserialize);
    }
}