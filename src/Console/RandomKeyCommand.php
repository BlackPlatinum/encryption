<?php

/**
 * @author  BlackPlatinum Developers
 * @license MIT
 * Date: 18/Jul/2020 01:55 AM
 **/

namespace BlackPlatinum\Encryption\Console;

use Redis;
use BlackPlatinum\Encryption\Crypto\Symmetric\Crypto;
use Symfony\Component\Console\Exception\InvalidOptionException;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RandomKeyCommand extends Command
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
        $this->setName('key:generate')
            ->setDescription('Generates a key for BlackPlatinum encryption system')
            ->setHelp("<comment>\nGenerates a key for BlackPlatinum encryption system.\n</comment>")
            ->addOption('storage', null, InputOption::VALUE_REQUIRED, 'Specify the storage of key to save', 'file');
    }

    /**
     * Execute this command.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     *
     * @throws RuntimeException
     * @throws InvalidOptionException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption('storage') === 'redis') {
            $this->writeKeyOnRedis();
            $output->writeln('');
            $output->writeln("<info>>>> The key generated successfully!\n</info>");
            return 0;
        }

        if ($input->getOption('storage') === 'file') {
            $this->writeKey(Crypto::generateKey());
            $output->writeln('');
            $output->writeln("<info>>>> The key generated successfully!\n</info>");
            return 0;
        }

        throw new InvalidOptionException("Invalid option: {$input->getOption('storage')}\n\nSupported options are: file, redis");
    }

    /**
     * Insert generated key in redis database.
     *
     * @return void
     */
    private function writeKeyOnRedis()
    {
        $redis = new Redis();
        $redis->connect('127.0.0.1');

        $redisKey = self::makeHash(['This', 'Is', 'Redis', 'Key', '!'], self::$defaultSalt);
        if ($redis->exists($redisKey)) {
            $redis->del($redisKey);
        }
        $isInserted = $redis->set($redisKey, Crypto::generateKey());
        if (!$isInserted) {
            $redis->close();
            throw new RuntimeException('The key generated successfully, but we can not insert it in memory heap!');
        }
        $redis->close();
    }
}
