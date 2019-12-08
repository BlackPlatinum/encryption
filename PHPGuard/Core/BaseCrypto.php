<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 08/Dec/2019 19:38 PM
 *
 * Base PHPGuard cryptography class
 **/

namespace PHPGuard\Core;


class BaseCrypto extends CryptoSetup implements Encryption, Decryption
{

    public function decrypt($cipher, $unserialize = true)
    {
        // TODO: Implement decrypt() method.
    }

    public function decryptString($cipher)
    {
        // TODO: Implement decryptString() method.
    }

    public function encrypt($data, $serialize = true)
    {
        // TODO: Implement encrypt() method.
    }

    public function encryptString($value)
    {
        // TODO: Implement encryptString() method.
    }
}