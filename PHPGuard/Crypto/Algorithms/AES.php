<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 16/Oct/2019 02:44 AM
 *
 * Main AES encryption class to encrypt and decrypt data.
 **/

namespace PHPGuard\Crypto\Algorithms;


use PHPGuard\Core\BaseCrypto;
use PHPGuard\Core\Encryption;
use PHPGuard\Core\Decryption;
use PHPGuard\Exception\CryptoException;
use PHPGuard\Exception\EncryptionException;
use PHPGuard\Exception\DecryptionException;


class AES extends BaseCrypto implements Encryption, Decryption
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
     * @var string Algorithm name
     */
    private $algorithm;


    /**
     * Constructor
     *
     * @param  string  $algorithm  Cryptography method name. The default method is AES-256-CBC
     */
    public function __construct($algorithm = "AES-256-CBC")
    {
        $this->algorithm = $algorithm;
        parent::__construct($this->algorithm);
    }


    /**
     * Validates cryptography method name is acceptable or not
     *
     * @return boolean Returns true if cryptography method name is acceptable, false otherwise
     */
    private function validateCipherMethod()
    {
        return $this->algorithm === "AES-128-CBC" || $this->algorithm === "AES-192-CBC" || $this->algorithm === "AES-256-CBC";
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
        $this->IV = substr(parent::setupIV($iv), 0, 16);
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
        if (!$this->validateCipherMethod()) {
            throw new EncryptionException("Cipher method wrong!");
        }
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
        if (!$this->validateCipherMethod()) {
            throw new EncryptionException("Cipher method wrong!");
        }
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
        if (!$this->validateCipherMethod()) {
            throw new DecryptionException("Cipher method wrong!");
        }
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