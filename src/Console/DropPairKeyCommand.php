<?php

/**
 * @author  BlackPlatinum Developers
 * @license MIT
 * Date: 21/Aug/2019 02:35
 **/

namespace BlackPlatinum\Encryption\Console;

use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DropPairKeyCommand extends Command
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
        $this->setName('key:drop-rsa')
            ->setDescription('Drops RSA pair keys')
            ->setHelp("<comment>\nDrops RSA pair keys\n</comment>");
    }

    /**
     * Execute this command.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     *
     * @throws RuntimeException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->deleteRSAPairKeys();
        $output->writeln('');
        $output->writeln("<info>>>> The RSA keys dropped successfully!\n</info>");
        return 0;
    }
}