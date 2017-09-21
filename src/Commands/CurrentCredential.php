<?php

namespace Mmo\OVHClient\Commands;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CurrentCredential extends BaseCommand
{
    protected function configure()
    {
        $this
            ->setName('ovh:current-credential')
            ->setDescription('Get the current credential details')
            ->setHelp('');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $ovh = $this->getApi();

        /** @var string[] $result */
        $result = $ovh->get('/auth/currentCredential');

        $output->write('ovhSupport: ');
        $output->write($result['ovhSupport']);
        $output->writeln('');

        $output->write('status: ');
        $output->write($result['status']);
        $output->writeln('');

        $output->write('applicationId: ');
        $output->write($result['applicationId']);
        $output->writeln('');

        $output->write('credentialId: ');
        $output->write($result['credentialId']);
        $output->writeln('');

        $output->write('expiration: ');
        $output->write($result['expiration']);
        $output->writeln('');

        $output->write('lastUse: ');
        $output->write($result['lastUse']);
        $output->writeln('');

        $output->write('creation: ');
        $output->write($result['creation']);
        $output->writeln('');

        $table = new Table($output);
        $table->setHeaders(array('Method', 'Path'));
        $table->setStyle('compact');
        if (is_array($result['rules'])) {
            foreach ($result['rules'] as $rule) {
                $table->addRow([$rule['method'], $rule['path']]);
            }
        }
        $output->writeln('Rules:');
        $table->render();
    }
}