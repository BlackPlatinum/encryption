<?php

/**
 * @author  BlackPlatinum Developers
 * @license MIT
 * Date: 19/Aug/2020 9:32 PM
 **/

namespace BlackPlatinum\Encryption\Support;

use BlackPlatinum\Encryption\Core\Exception\KeyException;

trait InteractWithKeyFiles
{
    /**
     * Write content of generated key to a file.
     *
     * @param string $content
     * @param string $fileName
     * @return void
     */
    protected function writeKey($content, $fileName = null)
    {
        $path = isset($fileName) ? keys_path() . $fileName . '.key' : keys_path() . 'key.key';

        if (file_exists($path)) {
            $this->deleteKey();
            $this->write($path, $content);
            return;
        }

        $this->write($path, $content);
    }

    /**
     * Write content of generated public and private keys to files.
     *
     * @param array $keysContent
     * @return void
     */
    protected function writeRSAPairKeys(array $keysContent)
    {
        $basePath = keys_path();

        if (file_exists($basePath . 'rsa-private-key.key') || file_exists($basePath . 'rsa-public-key.key')) {
            $this->deleteRSAPairKeys();
            $this->write($basePath . 'rsa-private-key.key', $keysContent[0]);
            $this->write($basePath . 'rsa-public-key.key', $keysContent[1]);
            return;
        }

        $this->write($basePath . 'rsa-private-key.key', $keysContent[0]);
        $this->write($basePath . 'rsa-public-key.key', $keysContent[1]);
    }

    /**
     * Delete generated key.
     *
     * @param string $fileName
     * @return void
     *
     * @throws KeyException
     */
    protected function deleteKey($fileName = null)
    {
        $path = isset($fileName) ? keys_path() . $fileName . '.key' : keys_path() . 'key.key';

        if (file_exists($path)) {
            @unlink($path);
            return;
        }

        throw new KeyException("[KeyException]:\n\n>>> There is no key to drop!\n");
    }

    /**
     * Delete generated public and private keys.
     *
     * @return void
     *
     * @throws KeyException
     */
    protected function deleteRSAPairKeys()
    {
        $basePath = keys_path();
        $keys = [$basePath . 'rsa-private-key.key', $basePath . 'rsa-public-key.key'];

        foreach ($keys as $key) {
            if (!file_exists($key)) {
                throw new KeyException("[KeyException]:\n\n>>> There is no key to drop!\n");
            }
            @unlink($key);
        }
    }

    /**
     * Write the given content to the specified file.
     *
     * @param string $path
     * @param string $content
     * @return void
     */
    private function write($path, $content)
    {
        file_put_contents($path, $content);
    }
}
