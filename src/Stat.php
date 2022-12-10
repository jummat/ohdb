<?php

namespace Finder\Ohdb;

class Stat
{
    public function clientStat(string $log)
    {
        $dir = dirname(__DIR__) . "/asset/log/";
        if (is_dir($dir)) {
            $clientLogFile = $dir . "client.log";
            if (!empty($log)) {
                if (!is_file($clientLogFile)) {
                    $open = fopen($clientLogFile, "w");
                    fwrite($open, $log . ";\n");
                    fclose($open);
                } else {
                    $open = fopen($clientLogFile, "a");
                    fwrite($open, $log . ";\n");
                    fclose($open);
                }
            }
        }
    }
}
