<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 19/Oct/2019 21:10 PM
 *
 * Base hash interface
 **/

namespace PHPGuard\Core;


interface BaseHash
{
    // Base hashing method
    public static function make($data, $algorithm, $serialize = false, $raw_output = false);

    // Base message authentication code generator
    public static function makeMAC($data, $key, $algorithm, $serialize = false, $raw_output = false);
}