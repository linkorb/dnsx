<?php

namespace DnsX\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

use RuntimeException;

class DomainShowCommand extends BaseCommand
{
    protected function configure()
    {
        $this
            ->setName('domain:show')
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

        $output->writeLn("Domain: $domainName");
        $records = $this->getAdapter()->getDnsRecords($domainName);
        foreach ($records as $record) {
            $output->writeLn("<info>" . $record->getName() . "</info> " . $record->getType() . " <comment>" . $record->getValue() . "</comment> TTL: " . $record->getTtl());
        }

    }
}
