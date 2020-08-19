<?php

/**
 * @author  BlackPlatinum Developers
 * @license MIT
 * Date: 05/Nov/2019 02:22 AM
 **/

namespace BlackPlatinum\Encryption\Core;

use BlackPlatinum\Encryption\Core\Hashing\Hash;

abstract class KeySetup
{
    use Hash;

    /**
     * Class constructor.
     */
    protected function __construct()
    {
        //
    }

    /**
     * Chunk a string to an array.
     *
     * @param string $value
     * @return array
     */
    private function chunk($value)
    {
        return str_split($value, 4);
    }

    /**
     * Prepare encryption key to use.
     *
     * @param string $key
     * @return string
     */
    protected function prepareKey($key)
    {
        return self::makeHash($this->chunk($key), self::$defaultSalt);
    }
}
