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
    // Decrypts all type of data
    public function decrypt($jsonPayload, $unserialize);

    // Decrypts string data
    public function decryptString($jsonPayload);
}