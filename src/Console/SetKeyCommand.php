<?php

/**
 * @author  BlackPlatinum Developers
 * @license MIT
 * Date: 12/Nov/2019 23:14 PM
 **/

namespace BlackPlatinum\Encryption\Console;

use Redis;
use BlackPlatinum\Encryption\Core\Exception\KeyException;
use Symfony\Component\Console\Exception\InvalidOptionException;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use PHPScanner\Scanner\Scanner;

class SetKeyCommand extends Command
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
        $this->setName('key:set')
            ->setDescription('Set a key for BlackPlatinum encryption system')
            ->setHelp("<comment>\nSet a key for BlackPlatinum encryption system. It passes a complex progress to save in Redis database as key => value or in file.\n</comment>")
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
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $scanner = new Scanner();

        if ($input->getOption('storage') === 'redis') {
            $output->writeln('');
            $output->writeln("<comment>>>> Warning: You can have one key for all of your data!</comment>");
            $output->writeln("<comment>>>> Keep your key safe!</comment>");
            $output->writeln('');
            $output->writeln("<question>>>> Please enter your key:</question>");
            $output->writeln('');
            $this->writeKeyOnRedis($scanner);
            $output->writeln('');
            $output->writeln("<info>>>> The key saved in the memory successfully!\n</info>");
            return 0;
        }

        if ($input->getOption('storage') === 'file') {
            $output->writeln('');
            $output->writeln("<comment>>>> Warning: You can have one key for all of your data!</comment>");
            $output->writeln("<comment>>>> Keep your key safe!</comment>");
            $output->writeln('');
            $output->writeln("<question>>>> Please enter your key:</question>");
            $output->writeln('');
            $this->writeKey($scanner->nextString());
            $output->writeln('');
            $output->writeln("<info>>>> The key saved in the memory successfully!\n</info>");
            return 0;
        }

        throw new InvalidOptionException("Invalid option: {$input->getOption('storage')}\n\nSupported options are: file, redis");
    }

    /**
     * Insert generated key in redis database.
     *
     * @param Scanner $scanner
     * @return void
     */
    private function writeKeyOnRedis(Scanner $scanner)
    {
        $redis = new Redis();
        $redis->connect('127.0.0.1');

        $key = $scanner->nextString();
        if (!$key) {
            throw new KeyException("[RuntimeException]:\n\nFailed to set the key!\n");
        }

        $isInserted = $redis->set(self::makeHash(['This', 'Is', 'Redis', 'Key', '!'], self::$defaultSalt), $key);
        if (!$isInserted) {
            $redis->close();
            throw new RuntimeException('The key processed successfully, but we can not insert it in memory heap!');
        }

        $redis->close();
    }
}
