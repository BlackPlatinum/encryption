<?php

/**
 * @author  BlackPlatinum Developers
 * @license MIT
 * Date: 19/Aug/2020 9:32 PM
 **/

namespace BlackPlatinum\Encryption\Support;

trait InteractWithKeyFiles
{
    /**
     * Write content of generated key to a file.
     *
     * @param string $content
     * @return void
     */
    protected function writeKey($content)
    {
        $path = keys_path() . 'key.key';

        if (file_exists($path)) {
            @unlink($path);
            file_put_contents($path, $content);
            return;
        }

        file_put_contents($path, $content);
    }
}
