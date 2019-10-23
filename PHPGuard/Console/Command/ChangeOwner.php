<?php


namespace PHPGuard\Console\Command;


use PHPGuard\Console\Commands;
use Symfony\Component\Console\Exception\RuntimeException;
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
        $this->setDescription("Sets owner of key and initial vectors files to user root")
            ->addArgument("owner", InputArgument::REQUIRED, "owner name of file")
            ->setHelp("<comment>\nThis command allows you to set key and initial vectors files owners's to user root or default user of system\nThis might be necessary due to security matter to alter owner of keys and ivs to root user in some special situations\n</comment>");
        parent::configure();
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("");
        $ans = parent::changeOwner($input->getArgument("owner"));
        if (!$ans)
            throw new RuntimeException("[RuntimeException]:\n\nOperation not permitted! You maybe need sudo access, try: sudo php guard alter:owner\nor maybe you need root permission, try: sudo -s then try php guard alter:owner");
        $output->writeln("<info>'k' and 'iv' files owner's changed successfully!</info>");
        $output->writeln("");
    }
}