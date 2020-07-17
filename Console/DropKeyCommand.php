<?php

/**
 * @author  BlackPlatinum Developers
 * @license MIT
 * Date: 12/Dec/2019 20:25 PM
 *
 * DropKeyCommand class lets you to drop registered key
 **/

namespace BlackPlatinum\Encryption\Console;


use Redis;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use BlackPlatinum\Encryption\Core\Hashing\Hash;


class DropKeyCommand extends Command
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
        $this->setName("drop:key")
            ->setDescription("Drops registered key")
            ->setHelp(
                "<comment>\nDrops registered key. You can generate a new one with 'php guard set:key'\n</comment>"
            );
    }


    /**
     * Executes this command
     *
     * @param  InputInterface  $input
     * @param  OutputInterface  $output
     *
     * @return int
     * @throws RuntimeException Throws runtime exception if it fails to drop the key
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $redis = new Redis();
        $redis->connect("127.0.0.1");
        $redisKey = Hash::makeHash(["This", "Is", "Redis", "Key", "!"], Hash::DEFAULT_SALT);
        if (!$redis->exists($redisKey)) {
            $redis->close();
            throw new RuntimeException("[RuntimeException]:\n\n>>> There is no key to drop!\n");
        }
        $redis->del($redisKey);
        $output->writeln("");
        $output->writeln("<info>>>> The key dropped successfully!\n</info>");
        $redis->close();
        return 0;
    }
}
