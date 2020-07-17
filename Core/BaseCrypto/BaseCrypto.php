<?php

/**
 * @author  BlackPlatinum Developers
 * @license MIT
 * Date: 08/Dec/2019 19:38 PM
 *
 * Base BlackPlatinum encryption class
 **/

namespace BlackPlatinum\Encryption\Core\BaseCrypto;


use BlackPlatinum\Encryption\Core\KeySetup;
use BlackPlatinum\Encryption\Core\Exceptions\EncryptionException;
use BlackPlatinum\Encryption\Core\Exceptions\DecryptionException;
use BlackPlatinum\Encryption\Core\Hashing\Hash;


abstract class BaseCrypto extends KeySetup
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
     * @param  string  $payload
     *
     * @return array
     */
    private function getJsonPayload($payload)
    {
        $payload = json_decode(base64_decode($payload), true);
        if (!$this->isValidPayload($payload)) {
            throw new DecryptionException("Invalid payload!");
        }
        return $payload;
    }


    /**
     * @param  mixed  $payload
     *
     * @return boolean
     */
    private function isValidPayload($payload)
    {
        return is_array($payload) && isset($payload["iv"], $payload["cipher"], $payload["mac"]) && (strlen(
                    base64_decode(
                        $payload["iv"],
                        true
                    )
                ) === openssl_cipher_iv_length($this->algorithm));
    }


    /**
     * @param  mixed  $data
     * @param  string  $key
     * @param  boolean  $serialize
     *
     * @return string
     * @throws EncryptionException
     */
    protected function encryption($data, $key, $serialize)
    {
        $iv = random_bytes(openssl_cipher_iv_length($this->algorithm));
        $cipher = base64_encode(
            openssl_encrypt(
                $serialize ? json_encode(serialize($data)) : $data,
                $this->algorithm,
                $key,
                0,
                $iv
            )
        );
        if (!$cipher) {
            throw new EncryptionException("Could not encrypt the data!");
        }
        $mac = Hash::makeMAC($cipher, Hash::DEFAULT_SALT.$key.$iv);
        $iv = base64_encode($iv);
        $jsonPayload = json_encode(compact("iv", "cipher", "mac"));
        if (!$jsonPayload) {
            throw new EncryptionException("Could not encrypt the data!");
        }
        return base64_encode($jsonPayload);
    }


    /**
     * @param  string  $jsonPayload
     * @param  string  $key
     * @param  boolean  $unserialize
     *
     * @return false|mixed|string
     * @throws DecryptionException
     */
    protected function decryption($jsonPayload, $key, $unserialize)
    {
        $jsonPayload = $this->getJsonPayload($jsonPayload);
        $iv = base64_decode($jsonPayload["iv"]);
        $newMAC = Hash::makeMAC($jsonPayload["cipher"], Hash::DEFAULT_SALT.$key.$iv);
        if (!hash_equals($jsonPayload["mac"], $newMAC)) {
            throw new DecryptionException("Invalid MAC!");
        }
        $decrypted = openssl_decrypt(base64_decode($jsonPayload["cipher"]), $this->algorithm, $key, 0, $iv);
        if (!$decrypted) {
            throw new DecryptionException("Could not decrypt the data!");
        }
        return $unserialize ? unserialize(json_decode($decrypted)) : $decrypted;
    }


    /**
     * @param  integer  $length
     *
     * @return string
     */
    protected static function byteRandom($length)
    {
        return str_shuffle(random_bytes($length));
    }


    /**
     * @param  integer  $length
     *
     * @return string
     */
    protected static function stringRandom($length)
    {
        return str_shuffle(substr(bin2hex(random_bytes($length)), 0, $length));
    }
}
