<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 02/Nov/2019 00:51 AM
 *
 * Main PHPGuard cryptography class
 **/

namespace PHPGuard\Crypto;


use PHPGuard\Core\Crypto\BaseCrypto;
use PHPGuard\Core\Crypto\Encryption;
use PHPGuard\Core\Crypto\Decryption;
use PHPGuard\Core\Exceptions\CryptoException;
use PHPGuard\Core\Exceptions\EncryptionException;
use PHPGuard\Core\Exceptions\DecryptionException;
use Exception;


class Crypto extends BaseCrypto implements Encryption, Decryption
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
     * @var string Algorithm
     */
    private $algorithm;


    /**
     * Constructor
     *
     * @param  string  $algorithm  Cryptography algorithm
     *                             <p>
     *                             The default method is AES-256-CBC
     */
    public function __construct($algorithm = "AES-256-CBC")
    {
        $this->algorithm = strtoupper($algorithm);
        parent::__construct($this->algorithm);
    }


    /**
     * Validates cryptography method name is acceptable or not
     *
     * @return boolean Returns true if cryptography method name is acceptable, false otherwise
     */
    private function validateCipherMethod()
    {
        return in_array($this->algorithm, self::supported(), true);
    }


    /**
     * Validates value of Key and IV
     *
     * @return array Returns authenticity of Key and IV as an array
     * @throws CryptoException Throws exception if key or IV remain null
     */
    private function isAssetsValid()
    {
        return [isset($this->KEY) ?? false, isset($this->IV) ?? false];
    }


    /**
     * Set key of cryptography system
     *
     * @param  string  $key  Key of cryptography system [recommended use user's password as key]
     */
    public function setKey($key): void
    {
        $this->KEY = parent::setupKey($key);
    }


    /**
     * Set IV of cryptography system
     *
     * @param  string  $iv  IV of cryptography system [recommended use user's password as IV]
     */
    public function setIV($iv): void
    {
        if ($this->algorithm === self::supported()[0] || $this->algorithm === self::supported()[1] || $this->algorithm === self::supported()[2]) {
            $this->IV = substr(parent::setupIV($iv), 13, 16);
        }
        if ($this->algorithm === self::supported()[3] || $this->algorithm === self::supported()[4]) {
            $this->IV = substr(parent::setupIV($iv), 13, 8);
        }
    }


    /**
     * Set algorithm of cryptography system
     *
     * @param  string  $cipher  The new cipher
     *
     * @return Crypto Returns new instance of Crypto class with $cipher parameter
     */
    public function setCipher($cipher)
    {
        return new Crypto($cipher);
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
     * @param  mixed    $data       The data that will be encrypted
     * @param  boolean  $serialize  [Optional] If set to true, converts mixed types to string
     *
     * @return string Returns encrypted value, false on failure
     * @throws EncryptionException Throws exception if validate method returns false or can not decrypt the the $cipher
     * @throws CryptoException Throws exception if key or IV remain null
     */
    public function encrypt($data, $serialize = true)
    {
        if (!$this->validateCipherMethod()) {
            throw new EncryptionException("Cipher method not defined!");
        }
        if (!$this->isAssetsValid()[0] || !$this->isAssetsValid()[1]) {
            throw new CryptoException("Empty Key or IV!");
        }
        return parent::encryption($data, $this->KEY, $this->IV, $serialize);
    }


    /**
     * Encrypts the given data
     *
     * @param  string  $data  The data that will be encrypted
     *
     * @return string Returns encrypted data, false on failure
     * @throws EncryptionException Throws exception if validate method returns false or can not encrypt the the $data
     * @throws CryptoException Throws exception if key or IV remain null
     */
    public function encryptString($data)
    {
        if (!$this->validateCipherMethod()) {
            throw new EncryptionException("Cipher method not defined!");
        }
        if (!$this->isAssetsValid()[0] || !$this->isAssetsValid()[1]) {
            throw new CryptoException("Empty Key or IV!");
        }
        return parent::stringEncryption($data, $this->KEY, $this->IV);
    }


    /**
     * Decrypts the given cipher
     *
     * @param  string   $package      The package array that contains cipher and mac
     * @param  boolean  $unserialize  [Optional] If set to true, converts string types to mixed
     *
     * @return false|mixed|string Returns encrypted value, false on failure
     * @throws DecryptionException Throws exception if validate method returns false or can not decrypt the the $cipher
     * @throws CryptoException Throws exception if key or IV remain null
     */
    public function decrypt($package, $unserialize = true)
    {
        if (!$this->validateCipherMethod()) {
            throw new EncryptionException("Cipher method not defined!");
        }
        if (!$this->isAssetsValid()[0] || !$this->isAssetsValid()[1]) {
            throw new CryptoException("Empty Key or IV!");
        }
        return parent::decryption($package, $this->KEY, $this->IV, $unserialize);
    }


    /**
     * Decrypts the given cipher
     *
     * @param  string  $package  TThe package array that contains cipher and mac
     *
     * @return false|string Returns decrypted cipher, false on failure
     * @throws DecryptionException Throws exception if validate method returns false or can not decrypt the the $cipher
     * @throws CryptoException Throws exception if key or IV remain null
     */
    public function decryptString($package)
    {
        if (!$this->validateCipherMethod()) {
            throw new EncryptionException("Cipher method not defined!");
        }
        if (!$this->isAssetsValid()[0] || !$this->isAssetsValid()[1]) {
            throw new CryptoException("Empty Key or IV!");
        }
        return parent::stringDecryption($package, $this->KEY, $this->IV);
    }


    /**
     * Generates cryptographically secure pseudo-random bytes
     *
     * @param  integer  $length  The length of the random byte
     *
     * @return string Returns Generated random
     * @throws Exception Throws exception if can not generate random data
     */
    public static function randomBytes($length)
    {
        return parent::byteRandom($length);
    }


    /**
     * Generates cryptographically secure pseudo-random strings
     *
     * @param  integer  $length  The length of the random string
     *
     * @return string Returns Generated random
     * @throws Exception Throws exception if can not generate random data
     */
    public static function randomString($length)
    {
        return parent::stringRandom($length);
    }


    /**
     * Returns supported cryptography algorithms
     *
     * @return array Returns name of supported cryptography algorithms
     */
    public static function supported()
    {
        return [
                "AES-128-CBC",
                "AES-192-CBC",
                "AES-256-CBC",
                "BF-CBC",
                "CAST5-CBC"
        ];
    }
}