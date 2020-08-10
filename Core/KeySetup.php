<?php

/**
 * @author  BlackPlatinum Developers
 * @license MIT
 * Date: 05/Nov/2019 02:22 AM
 *
 * KeySetup class setup key for each cryptography algorithm
 **/

namespace BlackPlatinum\Encryption\Core;


use BlackPlatinum\Encryption\Core\Hashing\Hash;


abstract class KeySetup
{
    use Hash;

    /**
     * Constructor
     */
    protected function __construct()
    {
        //
    }


    /**
     * Chunks a string to an array
     *
     * @param  string  $value  The entered string
     *
     * @return array return chunked array
     */
    private function chunk($value)
    {
        return str_split($value, 4);
    }


    /**
     * Setup a key for each cryptography algorithm
     *
     * @param  string  $key  Entered key
     *
     * @return string Returns the constructed key
     */
    protected function setupKey($key)
    {
        return self::makeHash($this->chunk($key), self::$defaultSalt);
    }
}