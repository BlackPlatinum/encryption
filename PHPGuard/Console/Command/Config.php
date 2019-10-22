<?php


namespace PHPGuard\Console\Command;


use PHPGuard\Console\Commands;
use RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Config extends Commands
{
    protected static $defaultName = "conf:pconf";

    public function __construct(string $name = null)
    {
        parent::__construct($name);
    }


    protected function configure()
    {
        $this->setDescription("Configures keys and initial vectors manually by user.")
            ->addArgument("mode", InputArgument::REQUIRED, "file's mode")
            ->addArgument("owner", InputArgument::REQUIRED, "file's owner")
            ->setHelp("<comment>\nThis command allows you to configure key and iv files manually.\nThis is recommended if you want change mode and owner of key and iv files arbitrary.\nYou maybe need to change to user root if you got permission denied error.\n</comment>");
        parent::configure();
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("");
        $ans = parent::config($input->getArgument("mode"), $input->getArgument("owner"));
        if (!$ans)
            throw new RuntimeException("Permission denied!");
        $output->writeln("<info>Keys and initial vectors configured successfully</info>");
        $output->writeln("");
    }
}