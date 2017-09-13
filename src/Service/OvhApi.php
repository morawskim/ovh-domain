<?php

namespace Mmo\OVHClient\Service;

use Mmo\OVHClient\Model\Config;
use Ovh\Api;

class OvhApi
{
    public static function factoryFromConfig(Config $config)
    {
        return new Api($config->getApplicationKey(),
            $config->getApplicationSecret(),
            $config->getApiEndpoint(),
            $config->getConsumerKey()
        );
    }
}
