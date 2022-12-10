<?php

namespace Finder\Ohdb;

class Stat
{
    public function clientStat(string $log)
    {
        $dir = dirname(__DIR__) . "/asset/log/";
        $time = date("d-m-Y H:i");
        $longTime = date("d-F-Y h:i:s:m:a");
        $timeStamp = time();
        if (is_dir($dir)) {
            $clientLogFile = $dir . "client.log";
            if (!empty($log)) {
                if (!is_file($clientLogFile)) {
                    $open = fopen($clientLogFile, "w");
                    fwrite($open, $log . "; time-$time;longTime-$longTime;timeStamp-$timeStamp \n");
                    fclose($open);
                } else {
                    $open = fopen($clientLogFile, "a");
                    fwrite($open, $log . "; time-$time;longTime-$longTime;timeStamp-$timeStamp \n");
                    fclose($open);
                }
            }
        }
    }
}
