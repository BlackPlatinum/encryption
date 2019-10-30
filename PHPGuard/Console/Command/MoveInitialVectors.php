<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 28/Oct/2019 01:31 AM
 *
 * Moves IV files to other directories
 **/

namespace PHPGuard\Console\Command;


use PHPGuard\Console\Commands;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MoveInitialVectors extends Commands
{
    protected static $defaultName = "move:iv";

    public function __construct(string $name = null)
    {
        parent::__construct($name);
    }


    protected function configure()
    {
        $this->setDescription("Move iv files to new directory")
                ->addArgument("new directory for AES 128 iv file", InputArgument::REQUIRED,
                        "new directory to move AES 128 iv file")
                ->addArgument("new directory for AES 256 iv file", InputArgument::REQUIRED,
                        "new directory to move AES 256 iv file")
                ->setHelp("<comment>\nThis command allows you to move iv files to a new directory\n</comment>");
        parent::configure();
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("");
        $ans = parent::moveIvs($input->getArgument("new directory for AES 128 iv file"),
                $input->getArgument("new directory for AES 256 iv file"));
        if (!$ans) {
            throw new RuntimeException("[RuntimeException]:\n\nOperation not permitted! You maybe need sudo access or maybe you entered wrong path, try: sudo php guard move:iv\nor maybe you need root permission, try: sudo -s then try php guard move:iv");
        }
        $output->writeln("<info>Initial vector files moved to new directory successfully!</info>");
        $output->writeln("");
    }
}