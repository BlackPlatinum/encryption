<?php

/**
 * @author  BlackPlatinum Developers
 * @license MIT
 * Date: 16/Oct/2019 02:39 AM
 **/

namespace BlackPlatinum\Encryption\Core\Crypto\Symmetric;

use BlackPlatinum\Encryption\Core\Exception\CryptoException;
use BlackPlatinum\Encryption\Core\Exception\EncryptionException;

interface Encryption
{
    /**
     * Encrypt the given data.
     *
     * @param mixed $data
     * @param bool $serialize
     * @return string
     *
     * @throws EncryptionException
     * @throws CryptoException
     */
    public function encrypt($data, $serialize);

    /**
     * Encrypt the given string.
     *
     * @param string $data
     * @return string
     *
     * @throws EncryptionException
     * @throws CryptoException
     */
    public function encryptString($data);
}
