<?php

namespace Finder\Ohdb;

class Config
{
    public $config = [];

    public function __construct()
    {
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
}
