<?php

/**
 * @author  BlackPlatinum Developers
 * @license MIT
 * Date: 16/Oct/2019 20:56 PM
 *
 * Main hash class to compute digest of all data types
 **/

namespace BlackPlatinum\Encryption\Core\Hashing;


use BlackPlatinum\Encryption\Core\Exceptions\HashException;


class Hash
{

    /**
     * @var string The default salt
     */
    public const DEFAULT_SALT = '؟$ْaُrgپoءn2idژ$v=19$}m=65536,t=4,p=1$dEtگvYVl\1ak(1Ke~kp6emچl1Lw$gD5÷hvPta?bykٌٍَُّ]ژٰآ»ؤfQbI)iQf*‍Q48OqG/p!llnWj+Mzb`1ym/zUVY';

    /**
     * Constructor
     */
    private function __construct()
    {
        //
    }


    /**
     * Evaluates hash algorithm name for supporting
     *
     * @param  string  $algorithm
     *
     * @return boolean Returns true if algorithm is supported, or false otherwise
     */
    private static function validateAlgorithm($algorithm)
    {
        return in_array(strtoupper($algorithm), self::supported(), true);
    }


    /**
     * Makes hash from a data by a specific hash algorithm
     *<p>
     * It uses SHA3-512 as default
     *
     * @param  mixed  $data  The data is being hashed
     * @param  string  $salt  [Optional] The salt that will be append to the data
     * @param  string  $algorithm  The hash algorithm
     * @param  boolean  $rawOutput  [Optional] True returns raw hashed string, false returns base64 encoded hashed string
     *
     * @return string|false Returns the digested hash value on success or false on failure
     */
    public static function makeHash($data, $salt = null, $algorithm = "SHA3-512", $rawOutput = false)
    {
        if (!self::validateAlgorithm($algorithm)) {
            throw new HashException("Invalid algorithm name!");
        }
        return openssl_digest((is_string($data) ? $data : json_encode($data)).$salt, $algorithm, $rawOutput);
    }


    /**
     * Makes a message authentication code from a data by a specific hash algorithm
     * <p>
     * It uses SHA3-512 as default
     *
     * @param  string  $data  The data is being hashed
     * @param  string  $key  Shared secret key used for generating the HMAC variant of the message digest
     * @param  string  $algorithm  The hash algorithm
     *
     * @return string Returns calculated message authentication code
     */
    public static function makeMAC($data, $key, $algorithm = "SHA3-512")
    {
        if (!self::validateAlgorithm($algorithm)) {
            throw new HashException("Invalid algorithm name!");
        }
        return hash_hmac($algorithm, $data, $key);
    }


    /**
     * Returns supported hash algorithms
     *
     * @return array Returns name of supported hash algorithms
     */
    public static function supported()
    {
        return [
            "SHA3-512",
            "SHA512",
            "WHIRLPOOL"
        ];
    }
}