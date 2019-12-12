<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 08/Dec/2019 19:38 PM
 *
 * Base PHPGuard cryptography class
 **/

namespace PHPGuard\Core\Crypto;


use PHPGuard\Core\CryptoSetup;
use PHPGuard\Core\Exceptions\EncryptionException;
use PHPGuard\Core\Exceptions\DecryptionException;
use PHPGuard\Core\Hashing\Hash;


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
     * @param  string  $package
     *
     * @return array
     */
    private function getJsonPackage($package)
    {
        $package = json_decode(base64_decode($package), true);
        if (!$this->isValidPackage($package)) {
            throw new DecryptionException("Invalid package!");
        }
        return $package;
    }


    /**
     * @param  mixed  $package
     *
     * @return boolean
     */
    private function isValidPackage($package)
    {
        return is_array($package) && isset($package["cipher"], $package["mac"]);
    }


    /**
     * @param  mixed    $data
     * @param  string   $key
     * @param  string   $iv
     * @param  boolean  $serialize
     *
     * @return string
     * @throws EncryptionException
     */
    protected function encryption($data, $key, $iv, $serialize)
    {
        $cipher = openssl_encrypt($serialize ? json_encode(serialize($data)) : $data, $this->algorithm, $key, 0, $iv);
        if (!$cipher) {
            throw new EncryptionException("Could not encrypt the data!");
        }
        $mac = Hash::makeMAC($cipher, $key);
        $package = json_encode(compact("cipher", "mac"));
        if (!$package) {
            throw new EncryptionException("Could not encrypt the data!");
        }
        return base64_encode($package);
    }


    /**
     * @param  string  $data
     * @param  string  $key
     * @param  string  $iv
     *
     * @return string
     * @throws EncryptionException
     */
    protected function stringEncryption($data, $key, $iv)
    {
        return $this->encryption($data, $key, $iv, false);
    }


    /**
     * @param  string   $package
     * @param  string   $key
     * @param  string   $iv
     * @param  boolean  $unserialize
     *
     * @return false|mixed|string
     * @throws DecryptionException
     */
    protected function decryption($package, $key, $iv, $unserialize)
    {
        $package = $this->getJsonPackage($package);
        $newMAC = Hash::makeMAC($package["cipher"], $key);
        if ($newMAC !== $package["mac"]) {
            throw new DecryptionException("Invalid MAC!");
        }
        $plain = openssl_decrypt($package["cipher"], $this->algorithm, $key, 0, $iv);
        if (!$plain) {
            throw new DecryptionException("Could not decrypt the data!");
        }
        return $unserialize ? unserialize(json_decode($plain)) : $plain;
    }


    /**
     * @param  string  $cipher
     * @param  string  $key
     * @param  string  $iv
     *
     * @return false|mixed|string
     * @throws DecryptionException
     */
    protected function stringDecryption($cipher, $key, $iv)
    {
        return $this->decryption($cipher, $key, $iv, false);
    }
}