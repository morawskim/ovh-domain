<?php

namespace Mmo\OVHClientTest\Commands;

use Mmo\OVHClient\Commands\CurrentCredential;
use Symfony\Component\Console\Tester\CommandTester;

class CurrentCredentialTest extends \PHPUnit_Framework_TestCase
{
    public function testExecution()
    {
        $currentCredential = [
            'ovhSupport' => '',
            'status' => 'validated',
            'applicationId' => 99999,
            'credentialId' => 852852852,
            'rules' => [
                [
                    'method' => 'GET',
                    'path' => '/domain/zone/*/record/*',
                ],
            ],
            'expiration' => '',
            'lastUse' => '2017-09-21T12:20:23+02:00',
            'creation' => '2017-09-21T12:14:56+02:00',
        ];

        $builder = $this->createMock('\Ovh\Api');
        $builder->expects($this->once())
            ->method('get')
            ->with('/auth/currentCredential')
            ->willReturn($currentCredential);


        $command = new CurrentCredential();
        $command->setApi($builder);

        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $keys = ['ovhSupport', 'status', 'applicationId', 'credentialId', 'expiration', 'lastUse', 'creation'];
        foreach ($keys as $key) {
            $value = $currentCredential[$key];
            $pattern = "${key}: ${value}\n";
            $pattern = preg_quote($pattern, '/');
            $pattern = "/${pattern}/";
            $this->assertRegExp($pattern, $commandTester->getDisplay());
        }

        foreach ($currentCredential['rules'] as $rule) {
            $method = preg_quote($rule['method'], '#');
            $path = preg_quote($rule['path'], '#');
            $pattern = '#' . $method . '\s+' . $path . '#' . "\n";
            $this->assertRegExp($pattern, $commandTester->getDisplay());
        }
    }
}
