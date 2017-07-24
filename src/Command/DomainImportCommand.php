<?php

namespace DnsX\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use DnsX\Model\DnsRecord;
use RuntimeException;

class DomainImportCommand extends BaseCommand
{
    protected function configure()
    {
        $this
            ->setName('domain:import')
            ->setDescription('Imports dns records')
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

        $records = [];
        while ($line = trim(fgets(STDIN))) {
            $record = new DnsRecord();
            $part = explode(" ", $line);
            if (count($part)!=4) {
                throw new RuntimeException("Each line should be 4 parts exactly");
            }
            $record->setName($part[0]);
            $record->setType($part[1]);
            $record->setValue($part[2]);
            $record->setTtl($part[3]);
            $records[$record->getKey()] = $record;
        }
        $this->getAdapter()->setDnsRecords($domainName, $records);
    }
}
