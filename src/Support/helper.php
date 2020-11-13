<?php

if (!function_exists('keys_path')) {

    /**
     * Get the path for encryption keys.
     *
     * @return string
     */
    function keys_path()
    {
        return PHP_OS === 'WINNT' ? dirname(__DIR__, 2) . '\keys' . '\\' : dirname(__DIR__, 2) . '/keys/';
    }
}
