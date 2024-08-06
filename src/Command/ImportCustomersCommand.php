<?php

namespace App\Command;

use App\Service\CustomerImport;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'import:customers',
    description: 'Will Import customers from external API',
)]
class ImportCustomersCommand extends Command
{
    protected static $defaultName = 'import:customers';
    private $customerImporter;

    public function __construct(CustomerImport $customerImporter)
    {
        parent::__construct();
        $this->customerImporter = $customerImporter;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $this->customerImporter->import();
        $io->success('Customers have been successfully imported.');

        return Command::SUCCESS;
    }
}
