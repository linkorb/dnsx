<?php

namespace DnsX\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

use RuntimeException;

class DomainExportCommand extends BaseCommand
{
    protected function configure()
    {
        $this
            ->setName('domain:export')
            ->setDescription('Shows current domain configuration')
            ->addArgument(
                'domainName',
                InputArgument::REQUIRED,
                'The domainname'
            )
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $domainName = $input->getArgument('domainName');

        $records = $this->getAdapter()->getDnsRecords($domainName);
        foreach ($records as $record) {
            echo $record->getName() . " " . $record->getType() . " " . $record->getValue() . " " . $record->getTtl() . "\n";
        }

    }
}
