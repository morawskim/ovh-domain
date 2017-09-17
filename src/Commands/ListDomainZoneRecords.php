<?php

namespace Mmo\OVHClient\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ListDomainZoneRecords extends BaseCommand
{
    protected function configure()
    {
        $this
            ->setName('ovh:list-zone-records')
            ->setDescription('List available records for zone')
            ->addArgument('zone', InputArgument::REQUIRED, 'The internal name of your zone')
            ->addOption('subDomain', null, InputOption::VALUE_OPTIONAL,'Filter the value of subDomain property')
            ->setHelp('');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $ovh = $this->getApi();

        $params = [];
        if ($input->hasOption('subDomain')) {
            $params['subDomain'] = $input->getOption('subDomain');
        }

        /** @var string[] $result */
        $result = $ovh->get('/domain/zone/' . $input->getArgument('zone') . '/record', $params);
        foreach ($result as $item) {
            $output->writeln($item);
        }
    }
}
