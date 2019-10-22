<?php


namespace PHPGuard\Console\Command;


use PHPGuard\Console\Commands;
use RuntimeException;
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
        $this->setDescription("Sets mode of 'k' and 'iv' files to read only")
            ->setHelp("<comment>\nThis command allows you to set 'k' and 'iv' files mode's to read only. This is necessary due to security issues.\nYou maybe need to change to user root if you got permission denied error.\n</comment>");
        parent::configure();
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("");
        $ans = parent::changeMode();
        if (!$ans)
            throw new RuntimeException("Permission denied!");
        $output->writeln("<info>'k' and 'iv' files mode's changed successfully!</info>");
        $output->writeln("");
    }
}