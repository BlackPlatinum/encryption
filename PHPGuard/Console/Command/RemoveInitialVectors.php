<?php


namespace PHPGuard\Console\Command;


use PHPGuard\Console\Commands;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RemoveInitialVectors extends Commands
{
    protected static $defaultName = "remove:iv";

    public function __construct(string $name = null)
    {
        parent::__construct($name);
    }


    protected function configure()
    {
        $this->setDescription("Removes initial vector files in related directories")
                ->setHelp("<comment>\nThis command allows you to remove initial vector files\nYou can generate new initial vector files with: php guard generate:iv\n</comment>");
        parent::configure();
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("");
        $ans = parent::removeIVs();
        if (!$ans) {
            throw new RuntimeException("[RuntimeException]:\n\nOperation not permitted! You maybe need sudo access, try: sudo php guard remove:iv\nor maybe you need root permission, try: sudo -s then try php guard remove:iv");
        }
        $output->writeln("<info>Initial vectors removed successfully!</info>");
        $output->writeln("");
    }
}