<?php

namespace Mmo\OVHClient\Service;


use Mmo\OVHClient\Model\Config;

class Configuration
{
    public static function parseIniFile($filePath)
    {
        if (!file_exists($filePath)) {
            throw new \InvalidArgumentException(sprintf('File "%s" not exist', $filePath));
        }
        if (!is_readable($filePath)) {
            throw new \InvalidArgumentException(sprintf('File "%s" is not readable', $filePath));
        }
        if (!is_file($filePath)) {
            throw new \InvalidArgumentException(sprintf('File "%s" is not regular file', $filePath));
        }

        $array = parse_ini_file($filePath, true);
        if (false === $array) {
            throw new \RuntimeException(sprintf('Can\'t parse ini file "%s"', $filePath));
        }

        return self::parseArray($array);
    }

    public static function parseArray(array $config)
    {
        $obj = new Config();

        if (!empty($config['ovh']) && is_array($config['ovh'])) {
            $ovh = $config['ovh'];
        } else {
            $ovh = [];
        }

        if (!empty($ovh['application_key'])) {
            $obj->setApplicationKey($ovh['application_key']);
        }

        if (!empty($ovh['application_secret'])) {
            $obj->setApplicationSecret($ovh['application_secret']);
        }

        if (!empty($ovh['api_endpoint'])) {
            $obj->setApiEndpoint($ovh['api_endpoint']);
        }

        if (!empty($ovh['consumer_key'])) {
            $obj->setConsumerKey($ovh['consumer_key']);
        }

        return $obj;
    }
}
