<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 12/Dec/2019 20:25 PM
 *
 * FreshCommand class let you to fresh whole Redis database
 **/

namespace PHPGuard\Console;


use Redis;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class FreshCommand extends Command
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
        $this->setName("fresh")
                ->setDescription("Freshens Redis database")
                ->setHelp("<comment>\nDrops all data in all databases. Be careful when using this command!\n</comment>");
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
        $redis->flushAll();
        $output->writeln("");
        $output->writeln("<info>>>> Redis database cleaned up!</info>");
        $output->writeln("");
    }
}