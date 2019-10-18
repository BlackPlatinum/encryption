<?php

/**
 * @author Baha2r
 * @license MIT
 * Date: 16/Oct/2019
 *
 * Base decryption interface
 **/

namespace PHPGuard\Core;


interface Decryption
{
    public function decrypt($cipher, $unserialize = true);

    public function decryptString($cipher);
}