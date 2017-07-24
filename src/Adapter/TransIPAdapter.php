<?php

namespace DnsX\Adapter;

use DnsX\Model\DnsRecord;

class TransIPAdapter
{
    protected $client;
    protected $domainApi;

    public function __construct($username, $key)
    {
        $this->client = new \TransIP\Client($username, $key);
        $this->domainApi = $this->client->api('domain');
    }

    public function getDnsRecords($domainName)
    {
        $info = $this->domainApi->getInfo($domainName);
        $dnsRecords = [];
        foreach ($info->dnsEntries as $dnsEntry) {
            $dnsRecord = new DnsRecord();
            $dnsRecord->setName($dnsEntry->name);
            $dnsRecord->setTtl($dnsEntry->expire);
            $dnsRecord->setType($dnsEntry->type);
            $dnsRecord->setValue($dnsEntry->content);
            $key = $dnsRecord->getKey();
            $dnsRecords[$key] = $dnsRecord;
        }
        return $dnsRecords;
    }

    public function setDnsRecord($domainName, DnsRecord $dnsRecord)
    {
         $records = $this->getDnsRecords($domainName);
         $records[$dnsRecord->getKey()] = $dnsRecord;

         $this->setDnsRecords($domainName, $records);
    }

    public function setDnsRecords($domainName, $dnsRecords)
    {
        $entries = [];
        foreach ($dnsRecords as $dnsRecord) {
            $type = $dnsRecord->getType(); // TODO: needs mapping?
            $entry = new \TransIP\Model\DnsEntry(
                $dnsRecord->getName(),
                $dnsRecord->getTtl(),
                $type,
                $dnsRecord->getValue()
            );
            $entries[] = $entry;
        }
        $this->domainApi->setDnsEntries($domainName, $entries);
    }

}
