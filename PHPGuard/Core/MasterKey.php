<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 14/Nov/2019 22:14 PM
 *
 * Managing master key is done by this class
 **/

namespace PHPGuard\Core;


use PHPGuard\Core\Exceptions\MasterKeyException;
use PHPGuard\Core\Hashing\Hash;
use Redis;


class MasterKey
{

    /**
     * Constructor
     *
     * Creates connection with redis database
     */
    private function __construct()
    {
        //
    }


    /** Returns generated master key
     *
     * @return string Returns registered master key
     *
     * @throws MasterKeyException Throws master key exception if it fails to get master key
     */
    public static function getMaster()
    {
        $redis = new Redis();
        $redis->connect("127.0.0.1");
        $key = Hash::makeHash(["This", "Is", "?", "!"]);
        $key = $redis->get($key);
        if (!$key) {
            throw new MasterKeyException("Master key has not been set yet!");
        }
        return $key;
    }
}