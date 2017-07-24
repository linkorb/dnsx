<?php

namespace DnsX\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use DnsX\Model\DnsRecord;

use RuntimeException;

class DomainSetCommand extends BaseCommand
{
    protected function configure()
    {
        $this
            ->setName('domain:set')
            ->setDescription('Sets a dns record')
            ->addArgument(
                'domainName',
                InputArgument::REQUIRED,
                'The domainname'
            )
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'Record name'
            )
            ->addArgument(
                'type',
                InputArgument::REQUIRED,
                'Record type'
            )
            ->addArgument(
                'value',
                InputArgument::REQUIRED,
                'Record type'
            )
            ->addArgument(
                'ttl',
                InputArgument::REQUIRED,
                'Record ttl'
            )
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $domainName = $input->getArgument('domainName');

        $output->writeLn("Domain: $domainName");

        $record = new DnsRecord();
        $record->setName($input->getArgument('name'));
        $record->setType(strtoupper($input->getArgument('type')));
        $record->setValue($input->getArgument('value'));
        $record->setTtl($input->getArgument('ttl'));

        $this->getAdapter()->setDnsRecord($domainName, $record);


    }
}
