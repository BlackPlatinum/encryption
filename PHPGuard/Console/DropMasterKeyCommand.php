<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 12/Dec/2019 20:25 PM
 *
 * DropMasterKeyCommand class let you to drop registered master key
 **/

namespace PHPGuard\Console;


use Redis;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use PHPGuard\Core\Hashing\Hash;


class DropMasterKeyCommand extends Command
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
     */
    protected function configure(): void
    {
        $this->setName("drop:key")
                ->setDescription("Drops admin key")
                ->setHelp("<comment>\nDrops admin key. You can generate a new one with 'php guard set:key'\n</comment>");
        parent::configure();
    }


    /**
     * Executes this command
     *
     * @param  InputInterface   $input
     * @param  OutputInterface  $output
     *
     * @throws RuntimeException Throws runtime exception if it fails to set master key
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $redis = new Redis();
        $redis->connect("127.0.0.1");
        $key = Hash::makeHash(["This", "Is", "?", "!"]);
        if ($redis->exists($key)) {
            $redis->del($key);
            $output->writeln("");
            $output->writeln("<info>>>> Master key dropped successfully!\n</info>");
            return;
        }
        $output->writeln("");
        $output->writeln("<error>>>> Master key doesn't exist!</error>");
        $output->writeln("");
    }
}