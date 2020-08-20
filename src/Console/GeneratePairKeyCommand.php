<?php

/**
 * @author  BlackPlatinum Developers
 * @license MIT
 * Date: 18/Jul/2020 18:21
 **/

namespace BlackPlatinum\Encryption\Console;

use BlackPlatinum\Encryption\Core\Exception\KeyException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GeneratePairKeyCommand extends Command
{
    /**
     * Create an instance of this command.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Configure requirements for this command.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('key:rsa-keys')
            ->setDescription('Generates a RSA pair public and private key for BlackPlatinum encryption system')
            ->setHelp("<comment>\nGenerates a RSA pair public and private key for BlackPlatinum encryption system.\n</comment>")
            ->addOption('bits', null, InputOption::VALUE_OPTIONAL, 'Number of bits in private key');
    }

    /**
     * Execute this command.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     *
     * @throws KeyException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->writeRSAPairKeys(
            $this->generateRSAPairKeys(
                $this->getRSAConfig(
                    $input->getOption('bits')
                )
            )
        );

        $output->writeln('');
        $output->writeln("<info>>>> The pair public and private keys generated successfully!\n</info>");
        return 0;
    }
}
