<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 16/Oct/2019 20:56 PM
 *
 * Main class to compute digest hash of all types data
 **/

namespace PHPGuard\Hashing;


use PHPGuard\Core\BaseHash;
use PHPGuard\Core\Exceptions\HashException;

abstract class Hash implements BaseHash
{

    /**
     * @var string MD5 Algorithm
     */
    private const MD5 = "MD5";

    /**
     * @var string SHA1 Algorithm
     */
    private const SHA1 = "SHA1";

    /**
     * @var string SHA224 Algorithm
     */
    private const SHA224 = "SHA224";

    /**
     * @var string SHA256 Algorithm
     */
    private const SHA256 = "SHA256";

    /**
     * @var string SHA384 Algorithm
     */
    private const SHA384 = "SHA384";

    /**
     * @var string SHA512 Algorithm
     */
    private const SHA512 = "SHA512";

    /**
     * @var string SHA3-512 Algorithm
     */
    private const SHA3_512 = "SHA3-512";


    // Core method of generating digest from a data by a specific hash algorithm
    private static function hash($data, $algorithm, $serialize = false, $raw_output = false)
    {
        $digest = null;
        if ($serialize) {
            $digest = openssl_digest(json_encode(serialize($data)), $algorithm, $raw_output);
            if (!$digest) {
                throw new HashException("Could not hash the data!");
            }
            return $digest;
        }
        if (!is_string($data)) {
            throw new HashException("$data have to be string or change serialize parameter to true!");
        }
        $digest = openssl_digest($data, $algorithm, $raw_output);
        if (!$digest) {
            throw new HashException("Could not hash the data!");
        }
        return $digest;
    }


    // Core method of generating message authentication code from a data by a specific hash algorithm
    private static function mac($data, $key, $algorithm)
    {
        $mac = hash_hmac($algorithm, $data, $key);
        if (is_null($mac)) {
            throw new HashException("Could not generate message authentication code!");
        }
        return $mac;
    }


    /**
     * Makes hash from a data by a specific hash algorithm
     *
     * @param  string|mixed  $data        The data is being hashed
     * @param  string        $algorithm   The hash algorithm
     * @param  bool          $serialize   [optional] if $serialize is true, $data can be any type but resources
     *
     * @param  bool          $raw_output  [optional] Setting to true will return as raw output data, otherwise the return
     *                                    value is binhex encoded
     *
     * @return false|string return the digested hash value on success or false on failure
     *
     * @throws HashException Throws hash exception if can not compute the hash
     */
    public static function make($data, $algorithm = self::SHA3_512, $serialize = false, $raw_output = false)
    {
        return self::hash($data, $algorithm, $serialize, $raw_output);
    }


    /**
     * Makes message authentication code from a data by a specific hash algorithm
     *
     * @param  string  $data       The data is being hashed
     * @param  string  $key        Shared secret key used for generating the HMAC variant of the message digest
     * @param  string  $algorithm  The hash algorithm
     *
     * @return string return message authentication code
     */
    public static function makeMAC($data, $key, $algorithm = self::SHA3_512)
    {
        return self::mac($data, $key, $algorithm);
    }


    /**
     * Verifies that a password matches a hash
     *
     * @param  string  $password  The user's password
     * @param  string  $hash      A hash created by Hash::make() or every openssl based hashing system
     *
     * @return boolean returns true if the password and hash match, or false otherwise
     */
    public static function verify($password, $hash)
    {
        $algorithms = self::supported();
        foreach ($algorithms as $algorithm) {
            if (self::make($password, $algorithm) === $hash) {
                return true;
            }
        }
        return false;
    }


//    /**
//     * @param $hashed
//     *
//     * @return boolean
//     */
//    public static function needsRehash($hashed)
//    {
//
//    }


    /**
     * Returns supported hash algorithms
     *
     * @return array returns name of supported hash algorithms
     */
    public static function supported()
    {
        return [
                self::MD5,
                self::SHA1,
                self::SHA224,
                self::SHA256,
                self::SHA384,
                self::SHA512,
                self::SHA3_512
        ];
    }
}