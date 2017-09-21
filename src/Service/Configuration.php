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

    public static function getDefaultConfigFile()
    {
        $paths = [];
        $userDir = self::getUserDir();

        $paths[] = getcwd() . DIRECTORY_SEPARATOR . 'ovh-domain.ini';

        if (self::useXdg()) {
            $xdgConfig = getenv('XDG_CONFIG_HOME') ?: $userDir . '/.config';
            $paths[] = $xdgConfig . DIRECTORY_SEPARATOR . 'ovh-domain' . DIRECTORY_SEPARATOR . 'config.ini';
        } else {
            $paths[] = $userDir . DIRECTORY_SEPARATOR . '.ovh-domain' . DIRECTORY_SEPARATOR . 'config.ini';
        }

        if (stripos(PHP_OS, 'linux') === 0) {
            $paths[] = '/etc/ovh-domain/config.ini';
        }

        foreach ($paths as $path) {
            if (file_exists($path) && is_readable($path)) {
                return $path;
            }
        }

        return null;
    }

    /**
     * @return bool
     */
    private static function useXdg()
    {
        foreach (array_keys($_SERVER) as $key) {
            if (substr($key, 0, 4) === 'XDG_') {
                return true;
            }
        }
        return false;
    }

    /**
     * @throws \RuntimeException
     * @return string
     */
    private static function getUserDir()
    {
        $home = getenv('HOME');
        if (!$home) {
            throw new \RuntimeException('The HOME environment variable must be set');
        }
        return rtrim(strtr($home, '\\', '/'), '/');
    }
}
