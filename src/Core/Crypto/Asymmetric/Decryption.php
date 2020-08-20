<?php

/**
 * @author  BlackPlatinum Developers
 * @license MIT
 * Date: 20/Aug/2020 16:46
 **/

namespace BlackPlatinum\Encryption\Core\Crypto\Asymmetric;

interface Decryption
{
    /***/
    public function publicKeyDecrypt($cipher, $key);

    /***/
    public function privateKeyDecrypt($cipher, $key);
}
