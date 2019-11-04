<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 05/Nov/2019 02:09 AM
 *
 * Console Command class
 **/

namespace PHPGuard\Console;


use PHPGuard\Console\Core\Kernel;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Commands extends Kernel
{
    protected static $defaultName = "set:adminkey";

    public function __construct(string $name = null)
    {
        parent::__construct($name);
    }


    protected function configure()
    {
        parent::configure();
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {

    }
}