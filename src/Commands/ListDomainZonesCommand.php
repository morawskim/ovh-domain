<?php

namespace Mmo\OVHClient\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListDomainZonesCommand extends BaseCommand
{
    protected function configure()
    {
        $this
            ->setName('ovh:list-zones')
            ->setDescription('List available zones for account')
            ->setHelp('');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $ovh = $this->getApi();

        $result = $ovh->get('/domain/zone');
        foreach ($result as $zone) {
            $output->writeln($zone);
        }
    }
}
