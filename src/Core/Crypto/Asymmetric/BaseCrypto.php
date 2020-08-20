<?php

/**
 * @author  BlackPlatinum Developers
 * @license MIT
 * Date: 16/Aug/2020 02:13
 **/

namespace BlackPlatinum\Encryption\Core\Crypto\Asymmetric;

use BlackPlatinum\Encryption\Core\Exception\EncryptionException;
use BlackPlatinum\Encryption\Core\Exception\DecryptionException;

abstract class BaseCrypto
{
    /**
     * Class constructor.
     *
     * @return void
     */
    protected function __construct()
    {
        //
    }

    /**
     * @param mixed $data
     * @param string $key
     * @return string
     *
     * @throws EncryptionException
     */
    protected function encryptWithPublicKey($data, $key)
    {
        $result = openssl_public_encrypt(json_encode($data), $cipher, $key);

        if (!$result) {
            throw new EncryptionException('Could not encrypt the data!');
        }

        return base64_encode(bin2hex($cipher));
    }

    /**
     * @param $data
     * @param $key
     * @return string
     *
     * @throws EncryptionException
     */
    protected function encryptWithPrivateKey($data, $key)
    {
        $result = openssl_private_encrypt(json_encode($data), $cipher, $key);

        if (!$result) {
            throw new EncryptionException('Could not encrypt the data!');
        }

        return base64_encode(bin2hex($cipher));
    }

    /**
     * @param string $cipher
     * @param string $key
     * @return mixed
     *
     * @throws DecryptionException
     */
    protected function decryptWithPublicKey($cipher, $key)
    {
        $result = openssl_public_decrypt(hex2bin(base64_decode($cipher)), $plain, $key);

        if (!$result) {
            throw new DecryptionException('Could not decrypt the data!');
        }

        return json_decode($plain);
    }

    /**
     * @param $cipher
     * @param $key
     * @return mixed
     *
     * @throws DecryptionException
     */
    protected function decryptWithPrivateKey($cipher, $key)
    {
        $result = openssl_private_decrypt(hex2bin(base64_decode($cipher)), $plain, $key);

        if (!$result) {
            throw new DecryptionException('Could not decrypt the data!');
        }

        return json_decode($plain);
    }
}
