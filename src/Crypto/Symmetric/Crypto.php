<?php

/**
 * @author  BlackPlatinum Developers
 * @license MIT
 * Date: 02/Nov/2019 00:51 AM
 **/

namespace BlackPlatinum\Encryption\Crypto\Symmetric;

use BlackPlatinum\Encryption\Core\Crypto\Symmetric\BaseCrypto;
use BlackPlatinum\Encryption\Core\Crypto\Symmetric\Encryption;
use BlackPlatinum\Encryption\Core\Crypto\Symmetric\Decryption;
use BlackPlatinum\Encryption\Core\Exception\CryptoException;
use BlackPlatinum\Encryption\Core\Exception\EncryptionException;
use BlackPlatinum\Encryption\Core\Exception\DecryptionException;

class Crypto extends BaseCrypto implements Encryption, Decryption
{
    /**
     * @var string The encryption key.
     */
    private $key;

    /**
     * @var string The cryptography algorithm.
     */
    private $algorithm;

    /**
     * Create an instance of SymmetricKeyCrypto.
     *
     * @param string $algorithm
     * @return void
     */
    public function __construct($algorithm = 'AES-256-CBC')
    {
        $this->algorithm = strtoupper($algorithm);
        parent::__construct($this->algorithm);

        if (!$this->validateCipherMethod()) {
            throw new EncryptionException('Cipher method not defined!');
        }
    }

    /**
     * Validate cryptography algorithm is acceptable or not.
     *
     * @return bool
     */
    private function validateCipherMethod()
    {
        return in_array($this->algorithm, self::supported(), true);
    }

    /**
     * Validates if encryption key is set or not.
     *
     * @return bool Returns authenticity of Key
     *
     * @throws CryptoException
     */
    private function isKeySet()
    {
        return isset($this->key) ?? false;
    }

    /**
     * Set the encryption key.
     *
     * @param string $key
     *
     * @return $this
     */
    public function setKey($key)
    {
        $this->key = parent::prepareKey($key);

        return $this;
    }

    /**
     * Set the cryptography algorithm.
     *
     * @param string $cipher
     *
     * @return Crypto
     */
    public function setCipher($cipher)
    {
        return new Crypto($cipher);
    }

    /**
     * Get the encryption key.
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Get the cryptography algorithm.
     *
     * @return string
     */
    public function getCipher()
    {
        return $this->algorithm;
    }

    /**
     * Encrypt the given data.
     *
     * @param mixed $data
     * @param bool $serialize
     * @return string
     *
     * @throws EncryptionException
     * @throws CryptoException
     */
    public function encrypt($data, $serialize = true)
    {
        if (!$this->isKeySet()) {
            throw new CryptoException('Empty Key!');
        }
        return parent::encryption($data, $this->key, $serialize);
    }

    /**
     * Encrypt the given string.
     *
     * @param string $data
     * @return string
     *
     * @throws EncryptionException
     * @throws CryptoException
     */
    public function encryptString($data)
    {
        return $this->encrypt($data, false);
    }

    /**
     * Decrypt the given cipher.
     *
     * @param string $jsonPayload
     * @param bool $unserialize
     * @return false|mixed|string
     *
     * @throws DecryptionException
     * @throws CryptoException
     */
    public function decrypt($jsonPayload, $unserialize = true)
    {
        if (!$this->isKeySet()) {
            throw new CryptoException('Empty Key!');
        }
        return parent::decryption($jsonPayload, $this->key, $unserialize);
    }

    /**
     * Decrypt the given cipher.
     *
     * @param string $jsonPayload
     * @return false|string
     *
     * @throws DecryptionException
     * @throws CryptoException
     */
    public function decryptString($jsonPayload)
    {
        return $this->decrypt($jsonPayload, false);
    }

    /**
     * Generate a new key.
     *
     * @param int $length
     * @return string
     */
    public static function generateKey($length = 2048)
    {
        return self::randomBytes($length);
    }

    /**
     * Generate cryptographically secure pseudo-random bytes.
     *
     * @param integer $length
     * @return string
     */
    public static function randomBytes($length)
    {
        return parent::byteRandom($length);
    }

    /**
     * Generate cryptographically secure pseudo-random string.
     *
     * @param integer $length
     * @return string
     */
    public static function randomString($length)
    {
        return parent::stringRandom($length);
    }

    /**
     * Get supported cryptography algorithms.
     *
     * @return array
     */
    public static function supported()
    {
        return [
            'AES-128-CBC',
            'AES-192-CBC',
            'AES-256-CBC',
            'BF-CBC',
            'CAST5-CBC'
        ];
    }
}
