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
    public static function md5($data, $serialize = false);

    public static function sha1($data, $serialize = false);

    public static function sha224($data, $serialize = false);

    public static function sha256($data, $serialize = false);

    public static function sha384($data, $serialize = false);

    public static function sha512($data, $serialize = false);
}