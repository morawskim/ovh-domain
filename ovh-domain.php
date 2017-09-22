#!/usr/bin/env php
<?php

require __DIR__ . '/vendor/autoload.php';

$application = new \Symfony\Component\Console\Application('ovh domain');
$application->add(new \Mmo\OVHClient\Commands\ListDomainZonesCommand());
$application->add(new \Mmo\OVHClient\Commands\ListDomainZoneRecords());
$application->add(new \Mmo\OVHClient\Commands\UpdateDomainRecord());
$application->add(new \Mmo\OVHClient\Commands\CurrentCredential());
$application->add(new \Mmo\OVHClient\Commands\DomainCredential());
$application->run();
