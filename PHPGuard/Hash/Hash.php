<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 16/Oct/2019 20:56 PM
 *
 * Main class to compute digest hash of all types data
 **/

namespace PHPGuard\Hash;


use PHPGuard\Core\BaseHash;
use PHPGuard\Exception\HashException;

abstract class Hash implements BaseHash
{

    // md5 algorithm
    private const MD5 = "MD5";

    // sha1 algorithm
    private const SHA1 = "SHA1";

    // sha224 algorithm
    private const SHA224 = "SHA224";

    // sha256 algorithm
    private const SHA256 = "SHA256";

    // sha384 algorithm
    private const SHA384 = "SHA384";

    // sha512 algorithm
    private const SHA512 = "SHA512";


    /**
     * Make digested hash from a value by a specific hash algorithm
     *
     * @param  string|mixed  $data        The data is being hashed
     * @param  string        $method      The hash algorithm
     * @param  bool          $serialize   [optional] if $serialize is true, $data can be any type but resources
     *
     * @param  bool          $raw_output  [optional] Setting to true will return as raw output data, otherwise the return
     *                                    value is binhex encoded
     *
     * @return false|string return the digested hash value on success or false on failure
     */
    private static function hash($data, $method, $serialize = false, $raw_output = false)
    {
        $digest = null;
        if ($serialize === true) {
            $digest = openssl_digest(json_encode(serialize($data)), $method, $raw_output);
            if ($digest === false) {
                throw new HashException("Could not hash the data!");
            }
            return $digest;
        }
        if (!is_string($data)) {
            throw new HashException("$data have to be string or put second parameter true!");
        }
        $digest = openssl_digest($data, $method);
        if ($digest === false) {
            throw new HashException("Could not hash the data!");
        }
        return openssl_digest($data, $method);
    }


    /**
     * Make digested hash from a value by this specific hash algorithm
     *
     * @param  string|mixed  $data        the data is being hashed
     * @param  bool          $serialize   [optional] if $serialize is true, $data can be any type but resources.
     *                                    it uses json encode to convert any types to string
     *
     * @param  bool          $raw_output  [optional] Setting to true will return as raw output data, otherwise the return
     *                                    value is binhex encoded
     *
     * @return false|string return the digested hash value on success or false on failure
     * @throws HashException throws exception if could not hash the data
     */
    public static function md5($data, $serialize = false, $raw_output = false)
    {
        return self::hash($data, self::MD5, $serialize, $raw_output);
    }


    /**
     * Make digested hash from a value by this specific hash algorithm
     *
     * @param  string|mixed  $data        the data is being hashed
     * @param  bool          $serialize   [optional] if $serialize is true, $data can be any type but resources.
     *                                    it uses json encode to convert any types to string
     *
     * @param  bool          $raw_output  [optional] Setting to true will return as raw output data, otherwise the return
     *                                    value is binhex encoded
     *
     * @return false|string return the digested hash value on success or false on failure
     * @throws HashException throws exception if could not hash the data
     */
    public static function sha1($data, $serialize = false, $raw_output = false)
    {
        return self::hash($data, self::SHA1, $serialize, $raw_output);
    }


    /**
     * Make digested hash from a value by this specific hash algorithm
     *
     * @param  string|mixed  $data        the data is being hashed
     * @param  bool          $serialize   [optional] if $serialize is true, $data can be any type but resources.
     *                                    it uses json encode to convert any types to string
     *
     * @param  bool          $raw_output  [optional] Setting to true will return as raw output data, otherwise the return
     *                                    value is binhex encoded
     *
     * @return false|string return the digested hash value on success or false on failure
     * @throws HashException throws exception if could not hash the data
     */
    public static function sha224($data, $serialize = false, $raw_output = false)
    {
        return self::hash($data, self::SHA224, $serialize, $raw_output);
    }


    /**
     * Make digested hash from a value by this specific hash algorithm
     *
     * @param  string|mixed  $data        the data is being hashed
     * @param  bool          $serialize   [optional] if $serialize is true, $data can be any type but resources.
     *                                    it uses json encode to convert any types to string
     *
     * @param  bool          $raw_output  [optional] Setting to true will return as raw output data, otherwise the return
     *                                    value is binhex encoded
     *
     * @return false|string return the digested hash value on success or false on failure
     * @throws HashException throws exception if could not hash the data
     */
    public static function sha256($data, $serialize = false, $raw_output = false)
    {
        return self::hash($data, self::SHA256, $serialize, $raw_output);
    }


    /**
     * Make digested hash from a value by this specific hash algorithm
     *
     * @param  string|mixed  $data        the data is being hashed
     * @param  bool          $serialize   [optional] if $serialize is true, $data can be any type but resources.
     *                                    it uses json encode to convert any types to string
     *
     * @param  bool          $raw_output  [optional] Setting to true will return as raw output data, otherwise the return
     *                                    value is binhex encoded
     *
     * @return false|string return the digested hash value on success or false on failure
     * @throws HashException throws exception if could not hash the data
     */
    public static function sha384($data, $serialize = false, $raw_output = false)
    {
        return self::hash($data, self::SHA384, $serialize, $raw_output);
    }


    /**
     * Make digested hash from a value by this specific hash algorithm
     *
     * @param  string|mixed  $data        the data is being hashed
     * @param  bool          $serialize   [optional] if $serialize is true, $data can be any type but resources.
     *                                    it uses json encode to convert any types to string
     *
     * @param  bool          $raw_output  [optional] Setting to true will return as raw output data, otherwise the return
     *                                    value is binhex encoded
     *
     * @return false|string return the digested hash value on success or false on failure
     * @throws HashException throws exception if could not hash the data
     */
    public static function sha512($data, $serialize = false, $raw_output = false)
    {
        return self::hash($data, self::SHA512, $serialize, $raw_output);
    }
}