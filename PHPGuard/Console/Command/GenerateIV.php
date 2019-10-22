<?php


namespace PHPGuard\Console\Command;


use PHPGuard\Console\Commands;
use RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateIV extends Commands
{
    protected static $defaultName = "gen:iv";

    public function __construct(string $name = null)
    {
        parent::__construct($name);
    }


    protected function configure()
    {
        $this->setDescription("Generates new iv files in related directories.")
            ->setHelp("<comment>\nThis command allows you to generate iv files['iv'] for your project.\nYou maybe need to change to user root if you got permission denied error.\n</comment>");
        parent::configure();
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("");
        $ans = parent::generateIv();
        if (!$ans)
            throw new RuntimeException("Permission denied!");
        $output->writeln("<info>Initial vectors generated successfully!</info>");
        $output->writeln("");
    }
}