<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 10/Dec/2019 15:04 PM
 *
 * Base PHPGuard hash class
 **/

namespace PHPGuard\Core\Hashes;


use PHPGuard\Core\Exceptions\HashException;


abstract class DoHash
{

    /**
     * Constructor
     */
    protected function __construct()
    {
        //
    }


    /**
     * @param  mixed  $data
     * @param  mixed  $algorithm
     * @param  array  $options
     *
     * @return string|false
     * @throws HashException
     */
    protected static function hash($data, $algorithm, $options)
    {
        $digest = null;
        $digest = password_hash((is_string($data) ? $data : json_encode($data)), $algorithm, $options);
        if (!$digest) {
            throw new HashException("Could not hash the data!");
        }
        return $digest;
    }


    /**
     * @param  mixed   $data
     * @param  string  $key
     *
     * @return string|null
     * @throws HashException
     */
    protected static function mac($data, $key)
    {
        $mac = null;
        $mac = hash_hmac("SHA3-512", (is_string($data) ? $data : json_encode($data)), $key);
        if (is_null($mac)) {
            throw new HashException("Could not generate message authentication code!");
        }
        return $mac;
    }


    /**
     * @param  mixed   $data
     * @param  string  $hashed
     *
     * @return boolean
     */
    protected static function verifyHashes($data, $hashed)
    {
        return password_verify((is_string($data) ? $data : json_encode($data)), $hashed);
    }


    /**
     * @param  string  $hashed
     * @param  mixed   $algorithm
     * @param  array   $options
     *
     * @return boolean
     */
    protected static function passwordNeedsRehash($hashed, $algorithm, $options)
    {
        return password_needs_rehash($hashed, $algorithm, $options);
    }


    /**
     * @param  mixed   $data
     * @param  string  $key
     * @param  string  $mac
     *
     * @return boolean
     * @throws HashException
     */
    protected static function verifyMacs($data, $key, $mac)
    {
        $calculated = self::mac($data, $key);
        return hash_equals($mac, $calculated);
    }
}