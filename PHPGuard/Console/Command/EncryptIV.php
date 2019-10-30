<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 30/Oct/2019 00:22 AM
 *
 * IV Encrypt class
 **/

namespace PHPGuard\Console\Command;


use PHPGuard\Console\Commands;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EncryptIV extends Commands
{
    protected static $defaultName = "encrypt:iv";

    public function __construct(string $name = null)
    {
        parent::__construct($name);
    }


    protected function configure()
    {
        $this->setDescription("Encrypts original initial vector files\n<comment>  Warning: In the beginning when you're starting the project, run this command and never do it again, You will lose your data!\n</comment>")
                ->setHelp("<comment>\nThis command allows you to encrypt initial vector files\nThis is necessary due to security issues\n");
        parent::configure();
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("");
        $ans = parent::encryptIV();
        if (!$ans) {
            throw new RuntimeException("[RuntimeException]:\n\nOperation not permitted! You maybe need sudo access, try: sudo php guard encrypt:iv\nor maybe you need root permission, try: sudo -s then try php guard encrypt:iv");
        }
        $output->writeln("<info>Initial vectors encrypted successfully!</info>");
        $output->writeln("");
    }

}