<?php

/**
 * @author  BlackPlatinum Developers
 * @license MIT
 * Date: 20/Aug/2020 16:46
 **/

namespace BlackPlatinum\Encryption\Core\Crypto\Asymmetric;

interface Encryption
{
    /***/
    public function publicKeyEncrypt($data, $key);

    /***/
    public function privateKeyEncrypt($data, $key);
}
