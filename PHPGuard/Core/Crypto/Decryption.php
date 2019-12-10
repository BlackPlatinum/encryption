<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 16/Oct/2019 02:39 AM
 *
 * Base decryption interface
 **/

namespace PHPGuard\Core\Crypto;


interface Decryption
{
    public function decrypt($cipher, $unserialize = true);

    public function decryptString($cipher);
}