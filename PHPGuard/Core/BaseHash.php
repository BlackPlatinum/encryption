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
    public static function md5($data, $serialize = false);

    public static function sha1($data, $serialize = false);

    public static function sha224($data, $serialize = false);

    public static function sha256($data, $serialize = false);

    public static function sha384($data, $serialize = false);

    public static function sha512($data, $serialize = false);
}