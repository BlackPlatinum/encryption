<?php


namespace PHPGuard\Console\Command;


use RuntimeException;
use PHPGuard\Console\Commands;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ChangeOwner extends Commands
{

    protected static $defaultName = "alter:owner";

    public function __construct(string $name = null)
    {
        parent::__construct($name);
    }


    protected function configure()
    {
        $this->setDescription("Sets owner of 'k' and 'iv' files to user root")
            ->addArgument("username", InputArgument::REQUIRED, "name of file")
            ->setHelp("<comment>\nThis command allows you to set 'k' and 'iv' files owners's to user root or default user of system.\nThis might be necessary due to security matter to alter owner of keys and ivs to root user in some special situations.\nYou maybe need to change to user root if you got permission denied error.\n</comment>");
        parent::configure();
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("");
        $ans = parent::changeOwner($input->getArgument("username"));
        if (!$ans)
            throw new RuntimeException("Permission denied!");
        $output->writeln("<info>'k' and 'iv' files owner's changed successfully!</info>");
        $output->writeln("");
    }
}