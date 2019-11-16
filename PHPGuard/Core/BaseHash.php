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
    public static function hash($data, $method, $serialize = false, $raw_output = false);
}