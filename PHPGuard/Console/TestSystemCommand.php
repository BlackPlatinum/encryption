<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 12/Dec/2019 00:01 AM
 *
 * TestSystemCommand class lets you test Guard cryptography system
 **/

namespace PHPGuard\Console;


use PHPGuard\Core\Key;
use PHPGuard\Crypto\Crypto;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class TestSystemCommand extends Command
{

    /**
     * @param  string|null  $name  The name of the command. The default name is null, it means it must be set in configure()
     */
    public function __construct(string $name = null)
    {
        parent::__construct($name);
    }


    /**
     * Configures requirements for this command
     */
    protected function configure(): void
    {
        $this->setName("test")
                ->setDescription("Tests Guard cryptography system")
                ->addArgument("inputData", InputArgument::REQUIRED, "input data to test system")
                ->setHelp("<comment>\nTests Guard cryptography system. You have to set a admin key to test our system.\nIf you have more than one word to test use ''. For example: 'Hello Guard !'.\n</comment>");
    }


    /**
     * Executes this command
     *
     * @param  InputInterface   $input
     * @param  OutputInterface  $output
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $crypt = new Crypto();
        $crypt->setKey(Key::getKey());
        $encrypted = $crypt->encryptString($input->getArgument("inputData"));
        $output->writeln("");
        $output->writeln("Encrypted: ".$encrypted);
        $output->writeln("\n");
        $output->writeln("Decrypted: ".$crypt->decryptString($encrypted));
        $output->writeln("");
    }
}