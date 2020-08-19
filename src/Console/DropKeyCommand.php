<?php

/**
 * @author  BlackPlatinum Developers
 * @license MIT
 * Date: 12/Dec/2019 20:25 PM
 **/

namespace BlackPlatinum\Encryption\Console;

use Redis;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DropKeyCommand extends Command
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
        $this->setName('key:drop')
            ->setDescription('Drops registered key')
            ->setHelp(
                "<comment>\nDrops registered key. You can generate a new one with 'php guard set:key'\n</comment>"
            );
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
        $redis = new Redis();
        $redis->connect('127.0.0.1');

        $redisKey = self::makeHash(['This', 'Is', 'Redis', 'Key', '!'], self::$defaultSalt);
        if (!$redis->exists($redisKey)) {
            $redis->close();
            throw new RuntimeException("[RuntimeException]:\n\n>>> There is no key to drop!\n");
        }

        $redis->del($redisKey);
        $output->writeln('');
        $output->writeln("<info>>>> The key dropped successfully!\n</info>");
        $redis->close();
        return 0;
    }
}
