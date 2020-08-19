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
     * Delete generated key.
     *
     * @param string $fileName
     * @return void
     *
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
