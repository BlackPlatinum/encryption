<?php

/**
 * @author  BlackPlatinum Developers
 * @license MIT
 * Date: 14/Nov/2019 22:14 PM
 **/

namespace BlackPlatinum\Encryption\KeyManager;

use BlackPlatinum\Encryption\Core\Exception\KeyException;
use BlackPlatinum\Encryption\Core\Hashing\Hash;
use Redis;

class KeyManager
{
    use Hash;

    /**
     * The class constructor.
     */
    private function __construct()
    {
        //
    }

    /** Get registered encryption key in redis database.
     *
     * @return string
     * @throws KeyException
     */
    public static function getRedisKey()
    {
        $redis = new Redis();
        $redis->connect('127.0.0.1');

        $key = $redis->get(self::makeHash(['This', 'Is', 'Redis', 'Key', '!'], self::$defaultSalt));
        if (!$key) {
            $redis->close();
            throw new KeyException('The key has not been set yet!');
        }

        $redis->close();
        return $key;
    }

    /** Get encryption key stored in file.
     *
     * @return string
     * @throws KeyException
     */
    public static function getKey()
    {
        $key = keys_path() . 'key.key';

        if (!file_exists($key)) {
            throw new KeyException('The key has not been set yet!');
        }

        return file_get_contents($key);
    }
}
