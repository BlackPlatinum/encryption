<?php

/**
 * @author  BlackPlatinum Developers
 * @license MIT
 * Date: 12/Dec/2019 20:25 PM
 **/

namespace BlackPlatinum\Encryption\Console;

use Redis;
use BlackPlatinum\Encryption\Core\Exception\KeyException;
use Symfony\Component\Console\Exception\InvalidOptionException;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
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
            ->setHelp("<comment>\nDrops registered key.\n</comment>")
            ->addOption('storage', null, InputOption::VALUE_REQUIRED, 'Specify the storage of the key to delete', 'file');
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
        if ($input->getOption('storage') === 'redis') {
            $this->deleteKeyFromRedis();
            $output->writeln('');
            $output->writeln("<info>>>> The key dropped successfully!\n</info>");
            return 0;
        }

        if ($input->getOption('storage') === 'file') {
            $this->deleteKey();
            $output->writeln('');
            $output->writeln("<info>>>> The key dropped successfully!\n</info>");
            return 0;
        }

        throw new InvalidOptionException("Invalid option: {$input->getOption('storage')}\n\nSupported options are: file, redis");
    }

    /**
     * Delete generated key in redis database.
     *
     * @return void
     */
    private function deleteKeyFromRedis()
    {
        $redis = new Redis();
        $redis->connect('127.0.0.1');

        $redisKey = self::makeHash(['This', 'Is', 'Redis', 'Key', '!'], self::$defaultSalt);
        if (!$redis->exists($redisKey)) {
            $redis->close();
            throw new KeyException("[KeyException]:\n\n>>> There is no key to drop!\n");
        }

        $redis->del($redisKey);
        $redis->close();
    }
}
