<?php


namespace PHPGuard\Console\Command;


use PHPGuard\Console\Commands;
use RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RemoveInitialVectors extends Commands
{
    protected static $defaultName = "rm:iv";

    public function __construct(string $name = null)
    {
        parent::__construct($name);
    }


    protected function configure()
    {
        $this->setDescription("Removes initial vector files in related directories.")
            ->setHelp("<comment>\nThis command allows you to remove initial vector files.\nYou can generate new initial vectors with: php guard gen:iv\nYou maybe need to change to user root if you got permission denied error.\n</comment>");
        parent::configure();
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("");
        $ans = parent::removeIVs();
        if (!$ans)
            throw new RuntimeException("Permission denied!");
        $output->writeln("<info>Initial vectors removed successfully</info>");
        $output->writeln("");
    }
}