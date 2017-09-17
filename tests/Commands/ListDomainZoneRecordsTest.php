<?php

namespace Mmo\OVHClientTest\Commands;

use Mmo\OVHClient\Commands\ListDomainZoneRecords;
use Symfony\Component\Console\Tester\CommandTester;

class ListDomainZoneRecordsTest extends \PHPUnit_Framework_TestCase
{
    public function testExecution()
    {
        $zone = 'test.example';

        $builder = $this->createMock('\Ovh\Api');
        $builder->expects($this->once())
            ->method('get')
            ->with('/domain/zone/' . $zone . '/record')
            ->willReturn(['11111', '22222', '33333']);


        $command = new ListDomainZoneRecords();
        $command->setApi($builder);

        $commandTester = new CommandTester($command);
        $commandTester->execute(['zone' => $zone]);
        $this->assertRegExp("/11111\n/", $commandTester->getDisplay());
        $this->assertRegExp("/22222\n/", $commandTester->getDisplay());
        $this->assertRegExp("/33333\n/", $commandTester->getDisplay());
    }

    public function testExecutionWithSubDomain()
    {
        $zone = 'test.example';
        $subDomain = 'host1';

        $builder = $this->createMock('\Ovh\Api');
        $builder->expects($this->once())
            ->method('get')
            ->with('/domain/zone/' . $zone . '/record', ['subDomain' => $subDomain])
            ->willReturn(['11111', '22222']);


        $command = new ListDomainZoneRecords();
        $command->setApi($builder);

        $commandTester = new CommandTester($command);
        $commandTester->execute(['zone' => $zone, '--subDomain' => $subDomain]);
        $this->assertRegExp("/11111\n/", $commandTester->getDisplay());
        $this->assertRegExp("/22222\n/", $commandTester->getDisplay());
    }
}
