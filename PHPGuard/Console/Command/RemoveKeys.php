<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 22/Oct/2019 21:40 PM
 *
 * Removes key files
 **/

namespace PHPGuard\Console\Command;


use PHPGuard\Console\Commands;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RemoveKeys extends Commands
{
    protected static $defaultName = "remove:key";

    public function __construct(string $name = null)
    {
        parent::__construct($name);
    }


    protected function configure()
    {
        $this->setDescription("Removes key files in related directories")
                ->setHelp("<comment>\nThis command allows you to remove key files\nYou can generate new keys with: php guard generate:key\n</comment>");
        parent::configure();
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("");
        $ans = parent::removeKeys();
        if (!$ans) {
            throw new RuntimeException("[RuntimeException]:\n\nOperation not permitted! You maybe need sudo access, try: sudo php guard remove:key\nor maybe you need root permission, try: sudo -s then try php guard remove:key");
        }
        $output->writeln("<info>Keys removed successfully!</info>");
        $output->writeln("");
    }
}