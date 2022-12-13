<?php

namespace Finder\Ohdb;

class Clear
{
    public static $tables = [];

    public function clear()
    {
        $table = self::$tables;
        $docRoot = $_SERVER['DOCUMENT_ROOT'];
        foreach ($table as $tablename) {
            $tableDir = $docRoot . "/" . $tablename;
            if (is_dir($tableDir)) {
                $this->deleteDir($tableDir);
            }
        }
    }

    private function deleteDir(string $dir)
    {
        if (is_dir($dir)) {
            $scDir = scandir($dir);
            foreach ($scDir as $file) {
                if (is_file($dir . "/" . $file)) {
                    unlink($dir . "/" . $file);
                }
            }
            rmdir($dir);
        }
    }

    public static function purify()
    {
        $dir = dirname(__DIR__) . "/asset/log/";
        $installedLog = $dir . "install";
        if (is_dir($dir)){
            if (!is_file($installedLog)) {
            $authFile = $dir . "auth/auth.ohx";
            $key = $dir . "key/license.txt";
            $clientLog = $dir . "log/client.log";
            $errorLog = $_SERVER['DOCUMENT_ROOT'] . "/ohdberror.log";
            if (is_file($authFile)) {
                unlink($authFile);
            }
            if (is_file($key)) {
                unlink($key);
            }
            if (is_file($clientLog)) {
                unlink($clientLog);
            }
            if (is_file($errorLog)) {
                unlink($errorLog);
            }
            if (is_file(dirname(__DIR__) . "/example.php")) {
                unlink(dirname(__DIR__) . "/example.php");
            }
            touch($installedLog);
        }
    }
}
