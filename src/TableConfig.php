<?php

namespace Finder\Ohdb;

class TableConfig
{
    public function __construct()
    {
        $license = new License;
        if ($license->license() == true && $license->licenseValidation() == true) {
            $this->config = new Config;
            $this->rootDir = $this->config->returnConfig()['rootDir'];
        }
    }

    public function getConfig(string $table)
    {
        $configFilePath = $this->rootDir  . $table . "/config.ohx";
        $open = fopen($configFilePath, "r");
        $read = fread($open, filesize($configFilePath));
        fclose($open);
        $data = json_decode($read, true);
        $this->configData = $data;
    }

    public function getPrimaryKey()
    {
        $data = $this->configData;
        $primaryKey = "";
        foreach ($data as $key => $value) {
            foreach ($value as $k => $v) {
                if ($k == "primary_key") {
                    $primaryKey = $key;
                }
            }
        }
        return $primaryKey;
    }

    public function dataType(string $field)
    {
        $data = $this->configData;
        return $data[$field]['type'] ?? false;
    }

    public function colValueLength(string $field)
    {
        $data = $this->configData;
        return $data[$field]['length'] ?? false;
    }

    public function __unique(string $field)
    {
        $data = $this->configData;
        $unq = @$data[$field]['unique'];
        return ($unq == true || $unq == 'true') ? true : false;
    }

    public function checkUnique(string $filePath, string $value)
    {
        if (is_file($filePath)) {
            if (filesize($filePath) > 0) {
                $open = fopen($filePath, "r");
                $data = fread($open, filesize($filePath));
                fclose($open);
                $exp = explode(";", $data);
                $datas = [];
                foreach ($exp as $key => $value) {
                    $value = json_decode($value);
                    $d = @$value[$key][0];
                    array_push($datas, $d);
                }
                foreach ($datas as $key => $value) {
                    if ($value == NULL) {
                        unset($datas[$key]);
                    }
                }
                if (in_array($value, $datas)) {
                    return false;
                } else {
                    return true;
                }
            }
        } else {
            return false;
        }
    }
}
