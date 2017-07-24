<?php

namespace DnsX\Command;

use Symfony\Component\Console\Command\Command;
use DnsX\Adapter\TransIPAdapter;

abstract class BaseCommand extends Command
{
    protected function getAdapter()
    {
        $username = getenv('TRANSIP_USERNAME');
        $key = getenv('TRANSIP_KEY');
        if (!$username || !$key) {
            throw new RuntimeException("Missing environment variables to instantiate adapter");
        }
        $adapter = new TransIPAdapter($username, $key);
        return $adapter;
    }
}
