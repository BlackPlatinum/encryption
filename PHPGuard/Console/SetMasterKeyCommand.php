<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 12/Nov/2019 23:14 PM
 *
 * SetMasterKeyCommand class provides a system to generate master key
 **/

namespace PHPGuard\Console;


use Redis;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use PHPGuard\Console\EventHandler\InputListener;
use PHPGuard\Console\EventHandler\InputEvent;
use PHPGuard\Hash\Hash;
use PHPScanner\Scanner\Scanner;

class SetMasterKeyCommand extends Command
{
    //
}