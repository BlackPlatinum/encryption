<?php


namespace PHPGuard\Console\Command;


use PHPGuard\Console\Commands;
use RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RemoveKeys extends Commands
{
    protected static $defaultName = "rm:key";

    public function __construct(string $name = null)
    {
        parent::__construct($name);
    }


    protected function configure()
    {
        $this->setDescription("Removes key files in related directories.")
            ->setHelp("<comment>\nThis command allows you to remove key files.\nYou can generate new keys with: php guard gen:key\nYou maybe need to change to user root if you got permission denied error.\n</comment>");
        parent::configure();
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("");
        $ans = parent::removeKeys();
        if (!$ans)
            throw new RuntimeException("Permission denied!");
        $output->writeln("<info>Keys removed successfully</info>");
        $output->writeln("");
    }
}