<?php

/**
 * @author  BlackPlatinum Developers
 * @license MIT
 * Date: 12/Nov/2019 23:14 PM
 *
 * SetKeyCommand class provides a system to set a encryption key on Redis database
 **/

namespace BlackPlatinum\Encryption\Console;


use Redis;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use PHPScanner\Scanner\Scanner;
use BlackPlatinum\Encryption\Core\Hashing\Hash;


class SetKeyCommand extends Command
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
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName("set:key")
            ->setDescription("Set a key for BlackPlatinum encryption system")
            ->setHelp(
                "<comment>\nSet a key for BlackPlatinum encryption system. It passes a complex progress to save It in Redis database as key => value.\n</comment>"
            );
    }


    /**
     * Executes this command
     *
     * @param  InputInterface  $input
     * @param  OutputInterface  $output
     *
     * @return int
     * @throws RuntimeException Throws runtime exception if it fails to set the key
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $scn = new Scanner();
        $redis = new Redis();
        $output->writeln("");
        $output->writeln("<comment>>>> Warning: You can have one key for all of your data!</comment>");
        $output->writeln("<comment>>>> Keep your key safe!</comment>");
        $output->writeln("");
        $output->writeln("<question>>>> Please enter your key:</question>");
        $output->writeln("");
        $redis->connect("127.0.0.1");
        $key = $scn->nextString();
        if (!$key) {
            throw new RuntimeException("[RuntimeException]:\n\nFailed to set the key!\n");
        }
        $isInserted = $redis->set(Hash::makeHash(["This", "Is", "Redis", "Key", "!"], Hash::DEFAULT_SALT), $key);
        if (!$isInserted) {
            $redis->close();
            throw new RuntimeException("The key processed successfully, but we can not insert it in memory heap!");
        }
        $output->writeln("");
        $output->writeln("<info>>>> The key saved in the memory successfully!\n</info>");
        $redis->close();
        return 0;
    }
}
