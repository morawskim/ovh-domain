<?php

namespace Mmo\OVHClient\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DomainCredential extends BaseCommand
{
    protected function configure()
    {
        $this
            ->setName('ovh:domain-credential')
            ->setDescription('Request a new credential for application')
            ->setHelp('');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $ovh = $this->getApi();
        $result = $ovh->post('/auth/credential', [
            'accessRules' => [
                ["method" => "GET","path" => "/domain/zone/*/record/*"],
                ["method" => "GET","path" => "/domain/zone"],
                ["method" => "PUT","path" => "/domain/zone/*/record/*"],
                ["method" => "GET","path" => "/domain/zone/*/record"],
                ["method" => "POST","path" => "/domain/zone/*/refresh"],
            ]
        ]);

        $output->writeln('You must first open validationUrl and fill form, before you can use consumerKey');
        $output->writeln('validationUrl: ' . $result['validationUrl']);
        $output->writeln('consumerKey: ' . $result['consumerKey']);
        $output->writeln('state: ' . $result['state']);
    }
}