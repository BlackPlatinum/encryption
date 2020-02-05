<?php

/**
 * @author  BlackPlatinum Developers
 * @license MIT
 * Date: 16/Oct/2019 02:39 AM
 *
 * Base decryption interface
 **/

namespace BlackPlatinum\Encryption\Core\BaseCrypto;


interface Decryption
{
    // Decrypts all type of data
    public function decrypt($jsonPayload, $unserialize);

    // Decrypts string data
    public function decryptString($jsonPayload);
}