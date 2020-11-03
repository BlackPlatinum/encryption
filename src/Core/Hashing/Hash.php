<?php

/**
 * @author  BlackPlatinum Developers
 * @license MIT
 * Date: 16/Oct/2019 20:56 PM
 **/

namespace BlackPlatinum\Encryption\Core\Hashing;

use BlackPlatinum\Encryption\Core\Exception\HashException;

trait Hash
{
    /**
     * @var string The default salt.
     */
    protected static $defaultSalt = '؟$ْaُrgپoءn2idژ$v19$}mwerv6tsdسردن‌َِآإ4p[1$dEtگvYVl\1ak(1Ke~kp6emچl1Lw$gD5÷hvPta?bykٌٍَُّ]ژٰآ»ؤfQbI)iQf*‍Q48OqG/p!llnWj+Mzb`1ym/zUVY';

    /**
     * Evaluate algorithm name for supporting.
     *
     * @param string $algorithm
     * @return bool
     */
    private static function validateAlgorithm($algorithm)
    {
        return in_array(strtoupper($algorithm), self::supported(), true);
    }

    /**
     * Hash the data by specified hash algorithm.
     *
     * @param mixed $data
     * @param string $salt
     * @param string $algorithm
     * @param bool $rawOutput
     * @return string
     */
    protected static function makeHash($data, $salt = null, $algorithm = 'SHA3-512', $rawOutput = false)
    {
        if (!self::validateAlgorithm($algorithm)) {
            throw new HashException('Invalid algorithm name!');
        }

        return openssl_digest((is_string($data) ? $data : json_encode($data)) . $salt, $algorithm, $rawOutput);
    }

    /**
     * Make a message authentication code from a data by specified hash algorithm.
     *
     * @param string $data
     * @param string $key
     * @param string $algorithm
     * @return string
     */
    protected static function makeMAC($data, $key, $algorithm = 'SHA3-512')
    {
        if (!self::validateAlgorithm($algorithm)) {
            throw new HashException('Invalid algorithm name!');
        }

        return hash_hmac($algorithm, $data, $key);
    }

    /**
     * Get supported hash algorithms.
     *
     * @return array
     */
    private static function supported()
    {
        return [
            'SHA3-512',
            'SHA512',
            'WHIRLPOOL'
        ];
    }
}
