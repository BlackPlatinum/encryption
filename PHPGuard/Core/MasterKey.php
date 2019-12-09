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
use PHPGuard\Hashing\Hash;
use Redis;

class MasterKey
{

    /**
     * @var Redis
     */
    private $redis;

    /**
     * @var false|string
     */
    private $mk;


    /**
     * Constructor
     *
     * Creates connection with redis database
     */
    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect("127.0.0.1");
        $this->mk = Hash::make(["This", "Is", "?", "!"], "SHA384", true);
    }


    /** Returns generated master key
     *
     * @return string Returns registered master key
     *
     * @throws MasterKeyException Throws master key exception if it fails to get master key
     */
    public function getMaster()
    {
        $masterKey = $this->redis->get($this->mk);
        if (!$masterKey) {
            throw new MasterKeyException("Master key has not been set yet!");
        }
        return $masterKey;
    }


    /**
     * Drops registered master key
     */
    public function dropMaster(): void
    {
        $this->redis->del($this->mk);
    }


    /**
     * Drops all data in all databases
     */
    public function dropAll(): void
    {
        $this->redis->flushAll();
    }
}