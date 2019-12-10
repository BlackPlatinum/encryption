<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 16/Oct/2019 02:39 AM
 *
 * Base encryption interface
 **/

namespace PHPGuard\Core\Crypto;


interface Encryption
{
    // Encrypts all data types
    public function encrypt($data, $serialize);

    // Encrypts string type
    public function encryptString($data);
}