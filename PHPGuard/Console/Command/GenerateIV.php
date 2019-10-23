<?php


namespace PHPGuard\Console\Command;


use PHPGuard\Console\Commands;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateIV extends Commands
{
    protected static $defaultName = "generate:iv";

    public function __construct(string $name = null)
    {
        parent::__construct($name);
    }


    protected function configure()
    {
        $this->setDescription("Generates new iv files in related directories")
            ->setHelp("<comment>\nThis command allows you to generate initial vectors for your cryptography system\n</comment>");
        parent::configure();
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("");
        $ans = parent::generateIv();
        if (!$ans)
            throw new RuntimeException("[RuntimeException]:\n\nOperation not permitted! You maybe need sudo access, try: sudo php guard generate:iv\nor maybe you need root permission, try: sudo -s then try php guard generate:iv");
        $output->writeln("<info>Initial vectors generated successfully!</info>");
        $output->writeln("");
    }
}