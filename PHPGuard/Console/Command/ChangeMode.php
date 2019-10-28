<?php


namespace PHPGuard\Console\Command;


use PHPGuard\Console\Commands;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ChangeMode extends Commands
{
    protected static $defaultName = "alter:mode";

    public function __construct(string $name = null)
    {
        parent::__construct($name);
    }


    protected function configure()
    {
        $this->setDescription("Sets mode of key and initial vectors files to read only")
                ->setHelp("<comment>\nThis command allows you to set key and initial vectors files mode's to read only\nThis is necessary due to security issues\n</comment>");
        parent::configure();
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("");
        $ans = parent::changeMode();
        if (!$ans) {
            throw new RuntimeException("[RuntimeException]:\n\nOperation not permitted! You maybe need sudo access, try: sudo php guard alter:mode\nor maybe you need root permission, try: sudo -s then try php guard alter:mode");
        }
        $output->writeln("<info>Key and iv files mode's changed successfully!</info>");
        $output->writeln("");
    }
}