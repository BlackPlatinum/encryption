<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 02/Nov/2019 00:51 AM
 *
 * Main PHPGuard cryptography class
 **/

namespace PHPGuard\Crypto;


class Crypto
{
    // Algorithm name
    private const AES128 = "AES-128-CBC";

    // Algorithm name
    private const AES256 = "AES-256-CBC";

    // Algorithm name
    private const BLOWFISH = "BF-CBC";

    // Algorithm name
    private const IDEA = "IDEA-CBC";

    // Algorithm name
    private const CAST = "CAST5-CBC";

    /**
     * Returns supported cryptography algorithms by this class
     *
     * @return array return name of supported cryptography algorithms by this class
     */
    public static function supported()
    {
        return [
                "AES"      => [self::AES128, self::AES256],
                "BlowFish" => [self::BLOWFISH],
                "IDEA"     => [self::IDEA],
                "CAST"     => [self::CAST]
        ];
    }
}