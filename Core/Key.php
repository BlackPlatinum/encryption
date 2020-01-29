<?php

/**
 * @author  BlackPlatinum Developers
 * @license MIT
 * Date: 14/Nov/2019 22:14 PM
 *
 * Managing key is done by this class
 **/

namespace BlackPlatinum\Encryption\Core;


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


    /** Returns registered key
     *
     * @return string Returns registered key
     *
     * @throws KeyException Throws key exception if it fails to get key
     */
    public static function getKey()
    {
        $redis = new Redis();
        $redis->connect("127.0.0.1");
        $key = Hash::makeHash(["This", "Is", "Redis", "Key", "!"], Hash::DEFAULT_SALT);
        $key = $redis->get($key);
        if (!$key) {
            throw new KeyException("The key has not been set yet!");
        }
        return $key;
    }
}