<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 05/Nov/2019 02:22 AM
 *
 * Setup key and initial vector for each registered user
 **/

namespace PHPGuard\Core;


use PHPGuard\Hashing\Hash;

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
     * Chunks a string to an array and appends extra characters to it
     *
     * @param  string  $value  The entered string
     *
     * @return array return chunked array
     */
    private function chunk($value)
    {
        if ($value <= 3) {
            return [":ءژ~'".$value."`چز- گ| پ"];
        }
        $chars = str_split($value, 3);
        for ($i = 0; $i < count($chars); $i++) {
            $chars[$i] = ":ءژ~'".$chars[$i]."`چز- گ| پ";
        }
        return $chars;
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
        return Hash::make($this->chunk($key), "SHA3-512", true, true);
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
        return Hash::make($this->chunk($iv), "SHA384", true, true);
    }
}