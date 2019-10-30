<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 22/Oct/2019 21:22 PM
 *
 * Generates key files
 **/

namespace PHPGuard\Console\Command;


use PHPGuard\Console\Commands;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateKey extends Commands
{
    protected static $defaultName = "generate:key";

    public function __construct(string $name = null)
    {
        parent::__construct($name);
    }


    protected function configure()
    {
        $this->setDescription("Generates new key files in related directories")
                ->setHelp("<comment>\nThis command allows you to generate keys for your cryptography system\n</comment>");
        parent::configure();
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("");
        $ans = parent::generateKey();
        if (!$ans) {
            throw new RuntimeException("[RuntimeException]:\n\nOperation not permitted! You maybe need sudo access, try: sudo php guard generate:key\nor maybe you need root permission, try: sudo -s then try php guard generate:key");
        }
        $output->writeln("<info>Keys generated successfully!</info>");
        $output->writeln("");
    }
}