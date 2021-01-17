<?php

namespace App\Helpers;

class Config
{
    private static $configPath = __DIR__ . '/../../config/';

    private static function resolveConfigName(string $name): array
    {
        $configNames = explode('.', $name);
        if(count($configNames) < 2){
            throw new \InvalidArgumentException("Set config name, exemple: app.url");
        }

        return $configNames;
    }


    public static function get(string $name)
    {
        $configNames = self::resolveConfigName($name);

        $filePath = self::$configPath . $configNames[0] . ".php";
        if(!file_exists($filePath)){
            throw new \Exception("config file {$configNames[0]} not found in {$filePath}");
        }
        //remove file name config
        array_shift($configNames);

        //get config array from file
        $configsFromFile = require($filePath);

        foreach ($configNames as $config) {
            $result = self::getConfig($configsFromFile, $config);
            $configsFromFile = $result;
        }

        return $configsFromFile;
    }

    public static function getConfig(array $configs, string $needle)
    {
        if (!isset($configs[$needle])) {
            throw new \InvalidArgumentException("config {$needle} not found");
        }

        return $configs[$needle];
    }
}
