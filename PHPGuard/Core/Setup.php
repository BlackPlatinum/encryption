<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 05/Nov/2019 02:22 AM
 *
 * Setup key and initial vector for each registered user
 **/

namespace PHPGuard\Core;


use PHPGuard\Hash\Hash;

abstract class Setup
{

    /**
     * Constructor
     */
    protected function __construct()
    {
        //
    }


    /**
     * Setup a key for each user
     *
     * @param  string  $key  Entered key
     *
     * @return string return the constructed key
     */
    protected function setupKey($key)
    {
        return Hash::sha512([":  ژ~'".$key."` ز- /|  "], true);
    }


    /**
     * Setup an initial vector for each user
     *
     * @param  string  $iv  Entered iv
     *
     * @return string return the constructed initial vector
     */
    protected function setupIV($iv)
    {
        return substr(Hash::sha384(["Q& ^".$iv.";?پ ="], true), 31, 16);
    }
}