<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 16/Oct/2019 20:56 PM
 *
 * Main hash class to compute digest of all type data
 **/

namespace PHPGuard\Hashing;


use PHPGuard\Core\Hashes\DoHash;
use PHPGuard\Core\Hashes\BaseHash;
use PHPGuard\Core\Exceptions\HashException;


abstract class Hash extends DoHash implements BaseHash
{

    /**
     * @var array Algorithms
     */
    private const ALGORITHMS = [
            PASSWORD_ARGON2ID,
            PASSWORD_ARGON2I,
            PASSWORD_BCRYPT,
            CRYPT_SHA512,
            CRYPT_SHA256,
            CRYPT_BLOWFISH,
            CRYPT_MD5
    ];


    /**
     * Constructor
     */
    private function __construct()
    {
        parent::__construct();
    }


    /**
     * Makes hash from a data by a specific hash algorithm
     *
     * @param  mixed   $data       The data is being hashed
     * @param  string  $algorithm  The hash algorithm
     * @param  array   $options    An associative array containing options
     *
     * @return string|false Returns the digested hash value on success or false on failure
     * @throws HashException Throws hash exception on failure
     */
    public static function makeHash($data, $algorithm = self::ALGORITHMS[0], $options = [])
    {
        return parent::hash($data, $algorithm, $options);
    }


    /**
     * Makes a message authentication code from a data by SHA3-512 hash algorithm
     *
     * @param  string  $data  The data is being hashed
     * @param  string  $key   Shared secret key used for generating the HMAC variant of the message digest
     *
     * @return string|null Returns calculated message authentication code
     * @throws HashException Throws hash exception on failure
     */
    public static function makeMAC($data, $key)
    {
        return parent::mac($data, $key);
    }


    /**
     * Verifies that a hashed data matches a hash
     *
     * @param  string  $data    The data
     * @param  string  $hashed  A hash created by Hash::makeHash()
     *
     * @return boolean Returns true if the data and hash match, or false otherwise
     */
    public static function verifyHash($data, $hashed)
    {
        return parent::verifyHashes($data, $hashed);
    }


    /**
     * Checks if the given hash matches the given options
     *
     * @param  string  $hashed     The hashed data
     * @param  string  $algorithm  The hash algorithm
     * @param  array   $options    An associative array containing options
     *
     * @return boolean Returns true if the hash should be rehashed to match the given algorithm and options, or false otherwise
     */
    public static function needsRehash($hashed, $algorithm, $options = [])
    {
        return parent::passwordNeedsRehash($hashed, $algorithm, $options);
    }


    /**
     * Checks if the given data matches the given MAC
     *
     * @param  string  $data  The data
     * @param  string  $key   The MAC generator's key
     * @param  string  $mac   The given MAC
     *
     * @return boolean Returns true if the data and MAC match, or false otherwise
     * @throws HashException Throws hash exception on failure
     */
    public static function verifyMAC($data, $key, $mac)
    {
        return parent::verifyMacs($data, $key, $mac);
    }


    /**
     * Returns supported hash algorithms
     *
     * @return array Returns name of supported hash algorithms
     */
    public static function supported()
    {
        return [
                "PASSWORD_ARGON2ID",
                "PASSWORD_ARGON2I",
                "PASSWORD_BCRYPT",
                "CRYPT_SHA512",
                "CRYPT_SHA256",
                "CRYPT_BLOWFISH",
                "CRYPT_MD5"
        ];
    }
}