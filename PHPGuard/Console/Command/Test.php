<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 24/Oct/2019 02:25 AM
 *
 * Tests Guard cryptography system
 **/

namespace PHPGuard\Console\Command;


use PHPGuard\Console\Commands;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Test extends Commands
{
    protected static $defaultName = "test";

    public function __construct(string $name = null)
    {
        parent::__construct($name);
    }


    protected function configure()
    {
        $this->setDescription("Tests guard cryptography system")
                ->addArgument("value", InputArgument::REQUIRED, "value that will be encrypted")
                ->addArgument("algorithm", InputArgument::OPTIONAL, "cryptography algorithm", "AES128")
                ->setHelp("<comment>\nThis command allows you to test PHPGuard cryptography system to make you sure this is fully operational\n</comment>");
        parent::configure();
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ((strtolower($input->getArgument("algorithm")) !== "aes128") && (strtolower($input->getArgument("algorithm")) !== "aes256")) {
            throw new RuntimeException("[RuntimeException]:\n\nWrong algorithm name!\nDefined algorithms is: aes128, aes256, AES128 and AES256");
        }
        if (strtolower($input->getArgument("algorithm")) === "aes128") {
            $ans = parent::test128($input->getArgument("value"));
            $output->writeln("");
            $output->writeln("Cipher text: ".$ans[0]);
            $output->writeln("Plain text: ".$ans[1]);
            $output->writeln("");
        } else {
            $ans = parent::test256($input->getArgument("value"));
            $output->writeln("");
            $output->writeln("Cipher text: ".$ans[0]);
            $output->writeln("Plain text: ".$ans[1]);
            $output->writeln("");
        }
    }
}