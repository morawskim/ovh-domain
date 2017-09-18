<?php

namespace Mmo\OVHClientTest\Commands;

use Mmo\OVHClient\Commands\UpdateDomainRecord;
use Symfony\Component\Console\Tester\CommandTester;

class UpdateDomainRecordTest extends \PHPUnit_Framework_TestCase
{

    public function testExecutionWithoutOptions()
    {
        $zone = 'test.example';
        $id = '123456789';

        $builder = $this->createMock('\Ovh\Api');

        $command = new UpdateDomainRecord();
        $command->setApi($builder);

        $this->expectException('\LogicException');
        $this->expectExceptionMessage('One of target, ttl or subDomain must be set');

        $commandTester = new CommandTester($command);
        $commandTester->execute(['zone' => $zone, 'id' => $id]);
    }

    public function testExecutionWithAllOptions()
    {
        $zone = 'test.example';
        $id = '123456789';
        $target = '192.168.1.10';
        $ttl = '60';
        $subDomain = 'host';

        $builder = $this->createMock('\Ovh\Api');
        $builder->expects($this->once())
            ->method('put')
            ->with(
                '/domain/zone/' . $zone . '/record/' . $id,
                ['target' => $target, 'ttl' => $ttl, 'subDomain' => $subDomain]
            )
            ->willReturn(null);

        $command = new UpdateDomainRecord();
        $command->setApi($builder);

        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'zone' => $zone,
            'id' => $id,
            '--target' => $target,
            '--ttl' => $ttl,
            '--subDomain' => $subDomain
        ]);
    }
}
