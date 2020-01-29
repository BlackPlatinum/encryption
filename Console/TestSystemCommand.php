<?php

/**
 * @author  BlackPlatinum Developers
 * @license MIT
 * Date: 12/Dec/2019 00:01 AM
 *
 * TestSystemCommand class lets you test Guard cryptography system
 **/

namespace BlackPlatinum\Encryption\Console;


use BlackPlatinum\Encryption\Core\Key;
use BlackPlatinum\Encryption\Crypto\Crypto;
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
                ->setDescription("Tests BlackPlatinum encryption system")
                ->addArgument("inputData", InputArgument::REQUIRED, "input data to test system")
                ->setHelp("<comment>\nTests BlackPlatinum encryption system. You have to set a admin key to test the system.\nIf you have more than one word to test use ''. For example: 'Hello Guard !'.\n</comment>");
    }


    /**
     * Executes this command
     *
     * @param  InputInterface   $input
     * @param  OutputInterface  $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $crypt = new Crypto();
        $crypt->setKey(Key::getKey());
        $encrypted = $crypt->encryptString($input->getArgument("inputData"));
        $output->writeln("");
        $output->writeln("Encrypted: ".$encrypted);
        $output->writeln("\n");
        $output->writeln("Decrypted: ".$crypt->decryptString($encrypted));
        $output->writeln("");
        return 0;
    }
}