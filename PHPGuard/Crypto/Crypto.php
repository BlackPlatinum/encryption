<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 02/Nov/2019 00:51 AM
 *
 * Main PHPGuard cryptography class
 **/

namespace PHPGuard\Crypto;


use PHPGuard\Core\Decryption;
use PHPGuard\Core\Encryption;
use PHPGuard\Crypto\Algorithms\AES;
use PHPGuard\Crypto\Algorithms\BlowFish;
use PHPGuard\Crypto\Algorithms\CAST5;
use PHPGuard\Crypto\Algorithms\RC4;
use PHPGuard\Exception\DecryptionException;
use PHPGuard\Exception\EncryptionException;
use RuntimeException;


class Crypto implements Encryption, Decryption
{
    // Algorithm name
    private const AES128 = "AES-128-CBC";

    // Algorithm name
    private const AES256 = "AES-256-CBC";

    // Algorithm name
    private const BLOWFISH = "BF-CBC";

    // Algorithm name
    private const RC4 = "RC4";

    // Algorithm name
    private const CAST = "CAST5-CBC";

    // The algorithm which is using now
    private $inUse;


    /**
     * Constructor
     *
     * @param  string  $algorithm  The cryptography algorithm
     *
     * @throws RuntimeException Throws exception if validate method returns false
     */
    public function __construct($algorithm = self::AES256)
    {
        if ($algorithm === self::AES128 || $algorithm === self::AES256) {
            $this->inUse = new AES($algorithm);
        }
        if ($algorithm === self::BLOWFISH) {
            $this->inUse = new BlowFish();
        }
        if ($algorithm === self::RC4) {
            $this->inUse = new RC4();
        }
        if ($algorithm === self::CAST) {
            $this->inUse = new CAST5();
        }
        if (!$this->validate()) {
            throw new RuntimeException("Cipher method wrong!");
        }
    }


    /**
     * Validates algorithms
     *
     * @return boolean return true if algorithm name is acceptable, return false otherwise
     */
    private function validate()
    {
        return !is_null($this->inUse);
    }


    /**
     * Sets key of cryptography system
     *
     * @param  string  $key  key of cryptography system [recommended use user's password as key]
     */
    public function setKey($key): void
    {
        $this->inUse->setKey($key);
    }


    /**
     * Sets IV of cryptography system
     *
     * @param  string  $iv  iv of cryptography system [recommended use user's password as iv]
     *
     * @throws EncryptionException Throws exception if IV will be set for RC4 algorithm
     */
    public function setIV($iv): void
    {
        if (get_class($this->inUse) === get_class(new RC4())) {
            throw new EncryptionException("There is no initial vector in RC4 algorithm!");
        }
        $this->inUse->setIV($iv);
    }


    /**
     * Sets algorithm of cryptography system
     *
     * @param  string  $cipher  The new cipher
     *
     * @return Crypto return new instance of Crypto with $cipher parameter
     */
    public function setCipher($cipher): Crypto
    {
        return (new Crypto($cipher));
    }


    /**
     * Gets key of cryptography system
     *
     * @return string return key of cryptography system
     */
    public function getKey()
    {
        return $this->inUse->getKey();
    }


    /**
     * Gets IV of cryptography system
     *
     * @return string return initial vector of cryptography system
     */
    public function getIV()
    {
        return $this->inUse->getIV();
    }


    /**
     * Gets the algorithm of cryptography system
     *
     * @return string return the algorithm of cryptography system
     */
    public function getCipher()
    {
        return get_class($this->inUse);
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
        return $this->inUse->encryptString($value);
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
        return $this->inUse->decryptString($cipher);
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
        return $this->inUse->encrypt($data, $serialize);
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
        return $this->inUse->decrypt($cipher, $unserialize);
    }


    /**
     * Returns supported cryptography algorithms by this class
     *
     * @return array return name of supported cryptography algorithms by this class
     */
    public static function supported()
    {
        return [
                "AES"      => [self::AES128, self::AES256],
                "BlowFish" => [self::BLOWFISH],
                "RC"       => [self::RC4],
                "CAST"     => [self::CAST]
        ];
    }
}