<?php

namespace Mmo\OVHClientTest\Commands;

use Mmo\OVHClient\Commands\DomainCredential;
use Symfony\Component\Console\Tester\CommandTester;

class DomainCredentialTest extends \PHPUnit_Framework_TestCase
{

    public function testExecution()
    {
        $permissions = [
            'accessRules' => [
                ["method" => "GET","path" => "/domain/zone/*/record/*"],
                ["method" => "GET","path" => "/domain/zone"],
                ["method" => "PUT","path" => "/domain/zone/*/record/*"],
                ["method" => "GET","path" => "/domain/zone/*/record"],
                ["method" => "POST","path" => "/domain/zone/*/refresh"],
            ]
        ];

        $response = [
            'validationUrl' => 'https://eu.api.ovh.com/auth/?credentialToken=qweqweqwe',
            'consumerKey' => 'consumerKeyconsumerKeyconsumerKeyconsumerKeyconsumerKey',
            'state' => 'pendingValidation',
        ];

        $builder = $this->createMock('\Ovh\Api');
        $builder->expects($this->once())
            ->method('post')
            ->with(
                '/auth/credential',
                $permissions
            )
            ->willReturn($response);

        $command = new DomainCredential();
        $command->setApi($builder);

        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $keys = ['validationUrl', 'consumerKey', 'state'];
        foreach ($keys as $key) {
            $value = $response[$key];
            $pattern = "${key}: ${value}\n";
            $pattern = preg_quote($pattern, '/');
            $pattern = "/${pattern}/";
            $this->assertRegExp($pattern, $commandTester->getDisplay());
        }
    }
}
