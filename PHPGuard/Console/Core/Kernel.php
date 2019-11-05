<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 22/Oct/2019 23:28 PM
 *
 * Kernel of commands represents in this class
 **/

namespace PHPGuard\Console\Core;


use PHPGuard\Crypto\Algorithms\AES;
use PHPGuard\Hash\Hash;
use PHPGuard\Core\AssetPath;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Command\Command;

class Kernel extends Command
{
    protected function SetAdminKey()
    {
        //
    }
}