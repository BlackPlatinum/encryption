<?php

/**
 * @author  BlackPlatinum Developers
 * @license MIT
 * Date: 18/Jul/2020 01:55 AM
 **/

namespace BlackPlatinum\Encryption\Console;


use Redis;
use BlackPlatinum\Encryption\Core\Hashing\Hash;
use BlackPlatinum\Encryption\Crypto\Crypto;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RandomKeyCommand extends Command
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
        $this->setName("generate:key")
            ->setDescription("Generates a key for BlackPlatinum encryption system")
            ->setHelp(
                "<comment>\nGenerates a key for BlackPlatinum encryption system. It passes a complex progress to save It in Redis database as key => value.\n</comment>"
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
        $redis = new Redis();
        $redis->connect("127.0.0.1");
        $redisKey = Hash::makeHash(["This", "Is", "Redis", "Key", "!"], Hash::DEFAULT_SALT);
        if ($redis->exists($redisKey)) {
            $redis->del($redisKey);
        }
        $isInserted = $redis->set($redisKey, Crypto::generateKey());
        if (!$isInserted) {
            $redis->close();
            throw new RuntimeException("The key generated successfully, but we can not insert it in memory heap!");
        }
        $output->writeln("");
        $output->writeln("<info>>>> The key generated successfully!\n</info>");
        $redis->close();
        return 0;
    }
}
