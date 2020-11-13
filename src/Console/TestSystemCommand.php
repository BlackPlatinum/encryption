<?php

/**
 * @author  BlackPlatinum Developers
 * @license MIT
 * Date: 12/Dec/2019 00:01 AM
 **/

namespace BlackPlatinum\Encryption\Console;

use BlackPlatinum\Encryption\Crypto\Symmetric\Crypto;
use BlackPlatinum\Encryption\KeyManager\KeyManager;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestSystemCommand extends Command
{
    /**
     * Create an instance of this command.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Configure requirements for this command.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('test')
            ->setDescription('Tests BlackPlatinum encryption system (symmetric algorithms only)')
            ->setHelp("<comment>\nTests BlackPlatinum encryption system.\nIf you have more than one word to test use ''. For example: 'Hello Guard !'.\n</comment>")
            ->addArgument('inputData', InputArgument::REQUIRED, 'Input data to test system');
    }

    /**
     * Execute this command.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $key = KeyManager::getKey();
        $crypto = (new Crypto())->setKey(!is_null($key) ? $key : KeyManager::getRedisKey());

        $cipher = $crypto->encryptString($input->getArgument('inputData'));
        $output->writeln('');
        $output->writeln('Encrypted: ' . $cipher);
        $output->writeln("\n");

        $output->writeln('Decrypted: ' . $crypto->decryptString($cipher));
        $output->writeln('');

        return 0;
    }
}
