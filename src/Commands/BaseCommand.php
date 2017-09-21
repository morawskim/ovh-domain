<?php

namespace Mmo\OVHClient\Commands;

use Mmo\OVHClient\Service\Configuration;
use Mmo\OVHClient\Service\OvhApi;
use Ovh\Api;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class BaseCommand extends Command
{
    /** @var Api */
    protected $api = null;

    public function __construct($name = null)
    {
        parent::__construct($name);
        $option = new InputOption(
            'config',
            'c',
            InputOption::VALUE_OPTIONAL,
            'Path to config file'
        );
        $this->getDefinition()->addOption($option);
    }

    /**
     * @return Api
     */
    public function getApi()
    {
        return $this->api;
    }

    /**
     * @param Api $api
     */
    public function setApi(Api $api)
    {
        $this->api = $api;
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        if (!empty($this->api)) {
            return;
        }

        $configFile = $input->getOption('config');
        if (empty($configFile)) {
            $configFile = Configuration::getDefaultConfigFile();
            if (empty($configFile)) {
                $msg = 'Config file not found. Use --config option to pass path to config file.';
                throw new \RuntimeException($msg);
            }
        }
        $config = Configuration::parseIniFile($configFile);
        $this->setApi(OvhApi::factoryFromConfig($config));
    }
}