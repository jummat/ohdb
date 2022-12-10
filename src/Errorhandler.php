<?php

namespace Finder\Ohdb;

class Errorhandler
{
    public $errors = [];

    public function setErrorLog(string $log)
    {
        $logFile = $_SERVER['DOCUMENT_ROOT'] . "/ohdberror.log";
        if (!empty($log)) {
            $time = date("d-m-Y H:i");
            $longTime = date("d-F-Y h:i:s:m:a");
            $timeStamp = time();
            if (!is_file($logFile)) {
                $open = fopen($logFile, "w");
                $fwrite = fwrite($open, $log . "; time-$time;longTime-$longTime;timeStamp-$timeStamp \n");
                fclose($open);
            } else {
                $open = fopen($logFile, "a");
                $fwrite = fwrite($open, $log . "; time-$time;longTime-$longTime;timeStamp-$timeStamp \n");
                fclose($open);
            }
        }
    }
}
