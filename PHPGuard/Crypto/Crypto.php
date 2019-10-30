<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 16/Oct/2019
 *
 * Main AES encryption class to encrypt and decrypt data
 **/

namespace PHPGuard\Crypto;


use PHPGuard\Core\Encryption;
use PHPGuard\Core\Decryption;
use PHPGuard\Exception\EncryptionException;
use PHPGuard\Exception\DecryptionException;
use PHPGuard\Core\AssetReader;
use RuntimeException;


class Crypto extends AssetReader implements Encryption, Decryption
{

    // Algorithm name
    private const AES128 = "AES-128-CBC";

    // Algorithm name
    private const AES256 = "AES-256-CBC";

    // store key
    private $KEY;

    // store IV
    private $IV;

    // store method
    private $method;

    // mode
    private $options;

    // determines which algorithm must use
    private $flag_128 = false;

    // determines which algorithm must use
    private $flag_256 = false;


    /**
     * Main constructor initial basic values
     *
     * @param  string  $method  [optional] cryptography method name
     * @param  int     $option  [optional] $option = 0, use internal key and iv. $option = 1, use internal key but generates different
     *                          ivs in each run
     */
    public function __construct($method = self::AES128, $option = 0)
    {
        $this->method = $method;
        $this->options = $option;
        if ($this->options === 0) {
            if ($this->method === self::AES128) {
                $this->flag_128 = true;
                $this->KEY = parent::readKey128();
                $this->IV = parent::readIV128();
            } else {
                $this->flag_256 = true;
                $this->KEY = parent::readKey256();
                $this->IV = parent::readIV256();
            }
        }
        if ($this->options === 1) {
            if ($this->method === self::AES128) {
                $this->flag_128 = true;
                $this->KEY = parent::readKey128();
                $this->ivGenerator();
            } else {
                $this->flag_256 = true;
                $this->KEY = parent::readKey256();
                $this->ivGenerator();
            }
        }
    }


    /**
     * Validate cryptography method name is acceptable or not
     *
     * @return boolean return true if cryptography method name is acceptable, false otherwise
     */
    private function validate()
    {
        return $this->method === self::AES128 || $this->method === self::AES256;
    }


    /**
     * Generates initial vector if $options equals to 1
     *
     * @return null
     */
    private function ivGenerator()
    {
        if ($this->flag_128) {
            $this->IV = openssl_random_pseudo_bytes(openssl_cipher_iv_length(self::AES128));
            return;
        }
        $this->IV = openssl_random_pseudo_bytes(openssl_cipher_iv_length(self::AES256));
        return;
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
        if (!$this->validate()) {
            throw new EncryptionException("Cipher method wrong!");
        }
        if (is_null($this->IV)) {
            throw new RuntimeException("Undefined option!");
        }
        if ($this->flag_128) {
            $cipher = openssl_encrypt($value, self::AES128, $this->KEY, 0, $this->IV);
            if ($cipher === false) {
                throw new EncryptionException("Could not encrypt the data!");
            }
            return base64_encode($cipher);
        }
        $cipher = openssl_encrypt($value, self::AES256, $this->KEY, 0, $this->IV);
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
        if (!$this->validate()) {
            throw new EncryptionException("Cipher method wrong!");
        }
        if ($this->flag_128) {
            $plain = openssl_decrypt(base64_decode($cipher), self::AES128, $this->KEY, 0, $this->IV);
            if ($plain === false) {
                throw new DecryptionException("Could not decrypt the data!");
            }
            return $plain;
        }
        $plain = openssl_decrypt(base64_decode($cipher), self::AES256, $this->KEY, 0, $this->IV);
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


    /**
     * Returns supported cryptography algorithms by this class
     *
     * @return array return name of supported cryptography algorithms by this class
     */
    public static function supported()
    {
        return [self::AES128, self::AES256];
    }
}