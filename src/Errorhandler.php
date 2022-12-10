<?php

namespace Finder\Ohdb;

class Errorhandler
{
    public $errors = [];

    public function setErrorLog(string $log)
    {
        $logFile = $_SERVER['DOCUMENT_ROOT'] . "/ohdberror.log";
        if (!empty($log)) {
            if (!is_file($logFile)) {
                $open = fopen($logFile, "w");
                $fwrite = fwrite($open, $log . ";\n");
                fclose($open);
            } else {
                $open = fopen($logFile, "a");
                $fwrite = fwrite($open, $log . ";\n");
                fclose($open);
            }
        }
    }
}
