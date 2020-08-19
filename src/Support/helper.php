<?php

if (!function_exists('keys_path')) {

    /**
     * Get the path for encryption keys.
     *
     * @return string
     */
    function keys_path()
    {
        $path = PHP_OS === 'WINNT' ? dirname(__DIR__, 2) . '\keys' . '\\' : dirname(__DIR__, 2) . '/keys/';

        if (!file_exists($path)) {
            mkdir($path);
            return $path;
        }

        return $path;
    }
}
