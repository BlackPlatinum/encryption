<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 12/Nov/2019 23:14 PM
 *
 * SetMasterKeyCommand class provides a system to generate master key
 **/

namespace PHPGuard\Console;


use Redis;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use PHPScanner\Scanner\Scanner;
use PHPGuard\Core\Hashing\Hash;


class SetMasterKeyCommand extends Command
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
        $this->setName("set:key")
                ->setDescription("Set admin key for using Guard cryptography system")
                ->setHelp("<comment>\nSet admin key for using Guard cryptography system. It uses admin key to generate master key due to protect your data.\n</comment>");
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
        $scn = new Scanner();
        $redis = new Redis();
        $output->writeln("");
        $output->writeln("<comment>>>> Warning: You can have one admin key for each project!</comment>");
        $output->writeln("<comment>Keep your admin key safe!</comment>");
        $output->writeln("");
        $output->writeln("<question>>>> Please enter your admin key:</question>");
        $output->writeln("");
        $redis->connect("127.0.0.1");
        $adminKey = $scn->nextString();
        $master = Hash::makeHash($adminKey);
        if (is_null($master)) {
            throw new RuntimeException("[RuntimeException]:\n\nFailed to set master key!\n");
        }
        $isInserted = $redis->set(Hash::makeHash(["This", "Is", "?", "!"]), $master);
        if (!$isInserted) {
            throw new RuntimeException("Master key generated successfully, but we can not insert it in memory heap!");
        }
        $output->writeln("");
        $output->writeln("<info>>>> Master key generated successfully!\n</info>");
    }
}