<?php

namespace Finder\Ohdb;

class License
{
    public $assetDir = "";

    public function __construct()
    {
        $targetDir = dirname(__DIR__) . "/asset/";
        $this->assetDir = $targetDir;
        $this->extract = new Extract;
    }

    public function license()
    {
        $docRoot = dirname(__DIR__);
        $keyDir = $docRoot . "/asset/";
        if (!is_dir($keyDir)) {
            mkdir($keyDir);
        }
        $authDir = $keyDir . "auth/";
        if (!is_dir($authDir)) {
            mkdir($authDir);
        }
        $keyDir .= "key/";
        if (!is_dir($keyDir)) {
            mkdir($keyDir);
        }
        $keyFile = $keyDir . "license.txt";
        if (is_file($keyFile)) {
            return true;
        } else {
            return false;
        }
    }

    public function message()
    {
        return "Liscence not found. generate new lisence vising https://org-home.com/ohdb/liscence";
    }

    public function setLicense(string $filePath)
    {
        if (is_file($filePath)) {
            $targetDir = dirname(__DIR__) . "/asset/";
            $this->assetDir = $targetDir;
            $lsDir = $targetDir . "key/";
            if (is_dir($lsDir)) {
                $readOpen = fopen($filePath, "r");
                $text = fread($readOpen, filesize($filePath));
                fclose($readOpen);
                $lsPath = $lsDir . "license.txt";
                if (!is_file($lsPath)) {
                    $writeOpen = fopen($lsPath, "w");
                    fwrite($writeOpen, $text);
                    fclose($writeOpen);
                }
            }
        } else {
            $lsFile = $this->assetDir . "key/license.txt";
            if (!is_file($lsFile)) {
                exit("License file not found");
            }
        }
    }

    public function setAuth(string $filePath)
    {
        if (is_file($filePath)) {
            $targetDir = dirname(__DIR__) . "/asset/";
            $this->assetDir = $targetDir;
            $lsDir = $targetDir . "auth/";
            if (is_dir($lsDir)) {
                $readOpen = fopen($filePath, "r");
                $text = fread($readOpen, filesize($filePath));
                fclose($readOpen);
                $lsPath = $lsDir . "auth.ohx";
                if (!is_file($lsPath)) {
                    $writeOpen = fopen($lsPath, "w");
                    fwrite($writeOpen, $text);
                    fclose($writeOpen);
                }
            }
        } else {
            $authFile = $this->assetDir . "auth/auth.ohx";
            if(!is_file($authFile)) {
                exit("Auth file not fount");
            }
        }
    }

    public function licenseValidation()
    {
        $lsFile = $this->assetDir . "key/license.txt";
        $authFile = $this->assetDir . "auth/auth.ohx";
        if (!is_file($lsFile)) {
            print("License file not found");
        } else if (!is_file($authFile)) {
            print("Auth file not found");
        } else {
            $auth = $this->extract->auth();
            $licenseAuth = $this->extract->licenseAuth();
            if ($auth == $licenseAuth) {
                return $this->extract->checkExpiry();
            } else {
                print("License is ivalid");
            }
        }
    }

    public function clearAdditionalLicenseDir($path)
    {
        if (is_dir($path)) {
            $scan = scandir($path);
            foreach ($scan as $item) {
                $filePath = $path . $item;
                if (is_file($filePath)) {
                    unlink($filePath);
                }
            }
            rmdir($path);
        }
    }
}
