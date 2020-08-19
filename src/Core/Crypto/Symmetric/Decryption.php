<?php

/**
 * @author  BlackPlatinum Developers
 * @license MIT
 * Date: 16/Oct/2019 02:39 AM
 **/

namespace BlackPlatinum\Encryption\Core\Crypto\Symmetric;

use BlackPlatinum\Encryption\Core\Exception\CryptoException;
use BlackPlatinum\Encryption\Core\Exception\DecryptionException;

interface Decryption
{
    /**
     * Decrypt the given cipher.
     *
     * @param string $jsonPayload
     * @param boolean $unserialize
     * @return false|mixed|string
     *
     * @throws DecryptionException
     * @throws CryptoException
     */
    public function decrypt($jsonPayload, $unserialize);

    /**
     * Decrypt the given cipher.
     *
     * @param string $jsonPayload
     * @return false|string
     *
     * @throws DecryptionException
     * @throws CryptoException
     */
    public function decryptString($jsonPayload);
}
