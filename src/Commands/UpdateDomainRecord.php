<?php

namespace Mmo\OVHClient\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateDomainRecord extends BaseCommand
{
    protected function configure()
    {
        $this
            ->setName('ovh:update-domain-record')
            ->setDescription('Alter domain record properties')
            ->addArgument('zone', InputArgument::REQUIRED)
            ->addArgument('id', InputArgument::REQUIRED)
            ->addOption('subDomain', null, InputOption::VALUE_OPTIONAL, 'Resource record subdomain')
            ->addOption('target', null, InputOption::VALUE_OPTIONAL, 'Resource record target')
            ->addOption('ttl', null, InputOption::VALUE_OPTIONAL, 'Resource record ttl')
            ->setHelp('');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $ovh = $this->getApi();

        $record = [];
        $target = $input->getOption('target');
        if (!empty($target)) {
            $record['target'] = $target;
        }

        $ttl = $input->getOption('ttl');
        if (!empty($ttl)) {
            $record['ttl'] = $ttl;
        }

        $subDomain = $input->getOption('subDomain');
        if (!empty($subDomain)) {
            $record['subDomain'] = $subDomain;
        }

        if (empty($record)) {
            throw new \LogicException('One of target, ttl or subDomain must be set');
        }

        $ovh->put('/domain/zone/' . $input->getArgument('zone') .'/record/' . $input->getArgument('id'), $record);
    }
}
