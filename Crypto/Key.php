<?php

/**
 * @author  BlackPlatinum Developers
 * @license MIT
 * Date: 14/Nov/2019 22:14 PM
 *
 * Returns registered key in redis database
 **/

namespace BlackPlatinum\Encryption\Crypto;


use BlackPlatinum\Encryption\Core\Exceptions\KeyException;
use BlackPlatinum\Encryption\Core\Hashing\Hash;
use Redis;


class Key
{

    /**
     * Constructor
     */
    private function __construct()
    {
        //
    }


    /** Returns registered key in redis database
     *
     * @return string Returns registered key in redis database
     *
     * @throws KeyException Throws key exception if it fails to get key
     */
    public static function getKey()
    {
        $redis = new Redis();
        $redis->connect("127.0.0.1");
        $key = $redis->get(Hash::makeHash(["This", "Is", "Redis", "Key", "!"], Hash::DEFAULT_SALT));
        if (!$key) {
            $redis->close();
            throw new KeyException("The key has not been set yet!");
        }
        $redis->close();
        return $key;
    }
}
