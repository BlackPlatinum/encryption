<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 05/Nov/2019 02:22 AM
 *
 * CryptoSetup class setup key and IV for each cryptography algorithm
 **/

namespace PHPGuard\Core;


use PHPGuard\Core\Hashing\Hash;


abstract class CryptoSetup
{

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
        return Hash::makeHash($this->chunk($key), Hash::DEFAULT_SALT);
    }


    /**
     * Setup an IV for each cryptography algorithm
     *
     * @param  string  $iv  Entered iv
     *
     * @return string Returns the constructed IV
     */
    protected function setupIV($iv)
    {
        return Hash::makeHash($this->chunk($iv), Hash::DEFAULT_SALT);
    }
}