<?php

namespace Finder\Ohdb;

class Config
{
    public $config = [];

    public function __construct()
    {
        $this->license = new License;
        $this->checkPhpVersion();
        if (count($this->config) == 0) {
            $this->config = [
                'rootDir' => $_SERVER['DOCUMENT_ROOT'] . "/../ohdb/",
                'extendion' => '.oh',
                'format' => 'json'
            ];
        }
    }

    public function __install()
    {
        $path = $this->config['rootDir'];
        if (!is_dir($path)) {
            mkdir($path);
        }
        Clear::purify();
    }

    public function returnConfig()
    {
        $path = dirname(__DIR__) . "/license/";
        $this->license->setLicense($path . "license.txt");
        $this->license->setAuth($path . "auth.ohx");
        $this->license->clearAdditionalLicenseDir($path);
        return $this->config;
    }

    public function checkPhpVersion ()
    {
        if (PHP_VERSION_ID < 80110){
            exit("YOur current php version id is" . PHP_VERSION_ID . "Minimum required 80110");
        }      
    }

}
