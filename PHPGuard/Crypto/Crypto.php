<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 02/Nov/2019 00:51 AM
 *
 * Main PHPGuard cryptography class
 **/

namespace PHPGuard\Crypto;


use PHPGuard\Core\BaseCrypto;
use PHPGuard\Core\Encryption;
use PHPGuard\Core\Decryption;
use PHPGuard\Core\Exceptions\CryptoException;
use PHPGuard\Core\Exceptions\EncryptionException;
use PHPGuard\Core\Exceptions\DecryptionException;


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
     * @var array All supported algorithms
     */
    private const ALGORITHMS = [
            "AES-128-CBC",
            "AES-192-CBC",
            "AES-256-CBC",
            "BF-CBC",
            "CAST5-CBC"
    ];


    /**
     * Constructor
     *
     * @param  string  $algorithm  Cryptography method name. The default method is AES-256-CBC
     */
    public function __construct($algorithm = self::ALGORITHMS[2])
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
        return in_array($this->algorithm, self::ALGORITHMS, true);
    }


    /**
     * Validates value of key and IV
     *
     * @return array
     * @throws CryptoException Throws exception if key or IV remain null
     */
    private function isAssetsValid()
    {
        return [isset($this->KEY) ?? false, isset($this->IV) ?? false];
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
        if ($this->algorithm === self::ALGORITHMS[0] || $this->algorithm === self::ALGORITHMS[1] || $this->algorithm === self::ALGORITHMS[2]) {
            $this->IV = substr(parent::setupIV($iv), 0, 16);
        }
        if ($this->algorithm === self::ALGORITHMS[3] || $this->algorithm === self::ALGORITHMS[4]) {
            $this->IV = substr(parent::setupIV($iv), 0, 8);
        }
    }


    /**
     * Sets algorithm of cryptography system
     *
     * @param  string  $cipher  The new cipher
     *
     * @return Crypto Returns new instance of Crypto class with $cipher parameter
     */
    public function setCipher($cipher)
    {
        return (new Crypto($cipher));
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
            throw new EncryptionException("Cipher method not defined!");
        }
        if (!$this->isAssetsValid()[0] || !$this->isAssetsValid()[1]) {
            throw new CryptoException("Empty Key or IV!");
        }
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
            throw new EncryptionException("Cipher method not defined!");
        }
        if (!$this->isAssetsValid()[0] || !$this->isAssetsValid()[1]) {
            throw new CryptoException("Empty Key or IV!");
        }
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
            throw new EncryptionException("Cipher method not defined!");
        }
        if (!$this->isAssetsValid()[0] || !$this->isAssetsValid()[1]) {
            throw new CryptoException("Empty Key or IV!");
        }
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
        if (!$this->validateCipherMethod()) {
            throw new EncryptionException("Cipher method not defined!");
        }
        if (!$this->isAssetsValid()[0] || !$this->isAssetsValid()[1]) {
            throw new CryptoException("Empty Key or IV!");
        }
        return parent::decryption($cipher, $this->KEY, $this->IV, $unserialize);
    }


    /**
     * Returns supported cryptography algorithms
     *
     * @return array Returns name of supported cryptography algorithms
     */
    public static function supported()
    {
        return self::ALGORITHMS;
    }
}