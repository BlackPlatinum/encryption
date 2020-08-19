<?php

/**
 * @author  BlackPlatinum Developers
 * @license MIT
 * Date: 12/Dec/2019 20:25 PM
 **/

namespace BlackPlatinum\Encryption\Console;

use Redis;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FreshCommand extends Command
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
        $this->setName('fresh')
            ->setDescription('Freshens Redis database')
            ->setHelp("<comment>\nDrops all data in all databases. Be careful when using this command!\n</comment>");
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
        $redis = new Redis();
        $redis->connect('127.0.0.1');
        $redis->flushAll();
        $output->writeln('');
        $output->writeln("<info>>>> Redis database freshened up!</info>");
        $output->writeln('');
        $redis->close();
        return 0;
    }
}
