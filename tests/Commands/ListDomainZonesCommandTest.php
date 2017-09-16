<?php

namespace Mmo\OVHClientTest\Commands;

use Mmo\OVHClient\Commands\ListDomainZonesCommand;
use Symfony\Component\Console\Tester\CommandTester;

class ListDomainZonesCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testExecution()
    {
        $builder = $this->createMock('\Ovh\Api');
        $builder->expects($this->once())
            ->method('get')
            ->with('/domain/zone')
            ->willReturn(['test.example']);


        $command = new ListDomainZonesCommand();
        $command->setApi($builder);

        $commandTester = new CommandTester($command);
        $commandTester->execute([]);
        $this->assertRegExp("/test.example\n/", $commandTester->getDisplay());
    }
}
