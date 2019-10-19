<?php

/**
 * @author Baha2r
 * @license MIT
 * Date: 16/Oct/2019
 *
 * Base hash interface
 **/

namespace PHPGuard\Core;


interface BaseHash
{
    public static function hash($data, $method, $raw_output = false, $serialize = false);
}