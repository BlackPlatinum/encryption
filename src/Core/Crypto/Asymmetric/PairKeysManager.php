<?php

/**
 * @author  BlackPlatinum Developers
 * @license MIT
 * Date: 20/Aug/2020 17:02
 **/

namespace BlackPlatinum\Encryption\Core\Crypto\Asymmetric;

use BlackPlatinum\Encryption\Core\Exception\KeyException;

trait PairKeysManager
{
    /**
     * Get the pair keys config for RSA algorithm.
     *
     * @param string $bits
     * @return  array
     */
    protected function getRSAConfig($bits = null)
    {
        return [
            'digest_alg' => 'SHA3-512',
            'private_key_bits' => is_null($bits) ? 4096 : intval($bits),
            'private_key_type' => OPENSSL_KEYTYPE_RSA,
            'encrypt_key' => true,
            'encrypt_key_cipher' => OPENSSL_CIPHER_AES_256_CBC
        ];
    }

    /**
     * Generate a new RSA pair private and public key.
     *
     * @param array $config
     * @return array
     *
     * @throws KeyException
     */
    protected function generateRSAPairKeys(array $config)
    {
        if (!$this->isRSAConfigValid($config)) {
            throw new KeyException(
                "Invalid key config: private key length is too short; it needs to be at least 384 bits, but {$config['private_key_bits']} provided."
            );
        }

        $resource = openssl_pkey_new($config);
        openssl_pkey_export($resource, $privateKey);
        $publicKey = openssl_pkey_get_details($resource)['key'];
        openssl_pkey_free($resource);

        return [
            $privateKey, $publicKey
        ];
    }

    /**
     * Check if RSA keys config is valid.
     *
     * @param array $config
     * @return bool
     */
    private function isRSAConfigValid(array $config)
    {
        return $config['private_key_bits'] >= 384;
    }
}
