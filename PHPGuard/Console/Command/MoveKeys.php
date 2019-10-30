<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 28/Oct/2019 01:31 AM
 *
 * Moves key files to other directories
 **/

namespace PHPGuard\Console\Command;


use PHPGuard\Console\Commands;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MoveKeys extends Commands
{
    protected static $defaultName = "move:key";

    public function __construct(string $name = null)
    {
        parent::__construct($name);
    }


    protected function configure()
    {
        $this->setDescription("Move key files to new directory")
                ->addArgument("new directory for AES 128 key file", InputArgument::REQUIRED,
                        "new directory to move AES 128 key file")
                ->addArgument("new directory for AES 256 key file", InputArgument::REQUIRED,
                        "new directory to move AES 256 key file")
                ->setHelp("<comment>\nThis command allows you to move key files to a new directory\n</comment>");
        parent::configure();
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("");
        $ans = parent::moveKeys($input->getArgument("new directory for AES 128 key file"),
                $input->getArgument("new directory for AES 256 key file"));
        if (!$ans) {
            throw new RuntimeException("[RuntimeException]:\n\nOperation not permitted! You maybe need sudo access or maybe you entered wrong path, try: sudo php guard move:key\nor maybe you need root permission, try: sudo -s then try php guard move:key");
        }
        $output->writeln("<info>Key files moved to new directory successfully!</info>");
        $output->writeln("");
    }
}