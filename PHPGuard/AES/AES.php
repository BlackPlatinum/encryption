<?php

/**
 * @author Baha2r
 * @license MIT
 * Date: 16/Oct/2019
 *
 * Main AES encryption class to encrypt and decrypt data
 **/

namespace PHPGuard\AES;


use PHPGuard\Core\Encryption;
use PHPGuard\Core\Decryption;
use PHPGuard\Exception\EncryptionException;
use PHPGuard\Exception\DecryptionException;
use PHPGuard\Core\AES128AssetReader;


class AES implements Encryption, Decryption
{

    /**
     * PHPGuard\Core\AES128AssetReader retrieved
     **/
    use AES128AssetReader;

    // store key
    private $KEY;

    // store IV
    private $IV;

    // store method
    private $method;

    // dynamicIV tag
    private $dynamicIV;


    /**
     * Main constructor initial basic values
     * @param string $method cryptography method name
     * @param boolean $dynamicIV dynamicIV mode
     */
    public function __construct($method = "AES-128-CBC", $dynamicIV = false)
    {
        $this->method = $method;
        $this->dynamicIV = $dynamicIV;
        $this->KEY = $this->readKey();
        if ($this->dynamicIV === true)
            $this->ivGenerator();
        else $this->IV = $this->readIV();
    }


    /**
     * Validate cryptography method name is acceptable or not
     * @return boolean return true if cryptography method name is acceptable, false otherwise
     */
    private function validate()
    {
        return $this->method === "AES-128-CBC" || $this->method === "AES-256-CBC";
    }


    /**
     * Generates initial vector if $dynamicIV is true
     * @return null
     */
    private function ivGenerator()
    {
        if ($this->method === "AES-128-CBC") {
            $this->IV = openssl_random_pseudo_bytes(openssl_cipher_iv_length("AES-128-CBC"));
            return;
        }
        $this->IV = openssl_random_pseudo_bytes(openssl_cipher_iv_length("AES-256-CBC"));
        return;
    }


    /**
     * Encrypts the given value
     * @param string $value the value that will be encrypted
     * @return false|string return encrypted value, false on failure
     * @throws EncryptionException throws exception if validate method returns false or can not encrypt the the $value
     */
    public function encryptString($value)
    {
        if (!$this->validate())
            throw new EncryptionException("Cipher method wrong!");
        $cipher = openssl_encrypt($value, "AES-128-CBC", $this->KEY, 0, $this->IV);
        if ($cipher === false)
            throw new EncryptionException("Could not encrypt the data!");
        return $cipher;
    }


    /**
     * Decrypts the given cipher
     * @param string $cipher the cipher that will be decrypted
     * @return false|string return decrypted cipher, false on failure
     * @throws DecryptionException throws exception if validate method returns false or can not decrypt the the $cipher
     */
    public function decryptString($cipher)
    {
        if (!$this->validate())
            throw new EncryptionException("Cipher method wrong!");
        $plain = openssl_decrypt($cipher, "AES-128-CBC", $this->KEY, 0, $this->IV);
        if ($plain === false)
            throw new DecryptionException("Could not decrypt the data!");
        return $plain;
    }


    /**
     * Encrypts the given data
     * @param mixed $data the data that will be encrypted
     * @param bool $serialize [recommended true], if $serialize is false and $data is string is correct
     * but if $serialize is false and $data is not string you get error
     * @return string return encrypted value, false on failure
     * @throws EncryptionException throws exception if validate method returns false or can not decrypt the the $cipher
     */
    public function encrypt($data, $serialize = true)
    {
        if ($serialize === false)
            return $this->encryptString($data);
        return $this->encryptString(base64_encode(json_encode($data)));
    }


    /**
     * Decrypts the given cipher
     * @param string $cipher the cipher that will be decrypted
     * @param bool $unserialize [recommended true], if $unserialize is false you achieve base_64 code and must be handled by
     * user
     * @return mixed return encrypted value, false on failure
     * @throws DecryptionException throws exception if validate method returns false or can not decrypt the the $cipher
     */
    public function decrypt($cipher, $unserialize = true)
    {
        if ($unserialize === false)
            return $this->decryptString($cipher);
        return json_decode(base64_decode($this->decryptString($cipher)));
    }
}