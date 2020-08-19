<?php

/**
 * @author  BlackPlatinum Developers
 * @license MIT
 * Date: 12/Nov/2019 23:14 PM
 **/

namespace BlackPlatinum\Encryption\Console;

use Redis;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
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
            ->setHelp(
                "<comment>\nSet a key for BlackPlatinum encryption system. It passes a complex progress to save It in Redis database as key => value.\n</comment>"
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
        $scn = new Scanner();
        $redis = new Redis();

        $output->writeln('');
        $output->writeln("<comment>>>> Warning: You can have one key for all of your data!</comment>");
        $output->writeln("<comment>>>> Keep your key safe!</comment>");
        $output->writeln('');
        $output->writeln("<question>>>> Please enter your key:</question>");
        $output->writeln('');

        $redis->connect('127.0.0.1');
        $key = $scn->nextString();
        if (!$key) {
            throw new RuntimeException("[RuntimeException]:\n\nFailed to set the key!\n");
        }
        $isInserted = $redis->set(self::makeHash(['This', 'Is', 'Redis', 'Key', '!'], self::$defaultSalt), $key);
        if (!$isInserted) {
            $redis->close();
            throw new RuntimeException('The key processed successfully, but we can not insert it in memory heap!');
        }

        $output->writeln('');
        $output->writeln("<info>>>> The key saved in the memory successfully!\n</info>");
        $redis->close();
        return 0;
    }
}
