<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 31/Oct/2019 00:59 AM
 *
 * Compile assets
 **/

namespace PHPGuard\Console\Command;


use PHPGuard\Console\Commands;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CompileMasters extends Commands
{
    protected static $defaultName = "compile:masters";

    public function __construct(string $name = null)
    {
        parent::__construct($name);
    }


    protected function configure()
    {
        $this->setDescription("Compile master files")
                ->setHelp("<comment>\nThis command allows you to compile master files like keys and initial vectors\n</comment>");
        parent::configure();
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("");
        $ans = parent::compileMasters();
        if (!$ans) {
            throw new RuntimeException("[RuntimeException]:\n\nOperation not permitted! You maybe need sudo access, try: sudo php guard compile:assets\nor maybe you need root permission, try: sudo -s then try php guard compile:assets");
        }
        $output->writeln("<info>Key and initial vector files compiled successfully!</info>");
        $output->writeln("");
    }
}