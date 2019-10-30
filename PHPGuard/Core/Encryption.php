<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 16/Oct/2019 02:39 AM
 *
 * Base encryption interface
 **/

namespace PHPGuard\Core;


interface Encryption
{
    public function encrypt($data, $serialize = true);

    public function encryptString($value);
}