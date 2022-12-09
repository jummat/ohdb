<?php

namespace Finder\Ohdb;

class Edit
{
    public function __construct()
    {
        $license = new License;
        if ($license->license() == true && $license->licenseValidation() == true) {
            $this->config = new Config;
            $this->dbDir = $this->config->returnConfig()['rootDir'];
            $this->tableConfig = new TableConfig;
        }
    }

    public function editData(int $id, string $tableName, array $updateDate)
    {
        $index = 0;
        $this->tableConfig->getConfig($tableName);
        $primaryKey = $this->tableConfig->getPrimaryKey();
        $primaryFile = $this->dbDir . $tableName . "/" . $primaryKey . ".oh";
        if (is_file($primaryFile)) {
            $open = fopen($primaryFile, "r");
            $data = fread($open, filesize($primaryFile));
            fclose($open);
            $exp = explode(";", $data);
            foreach ($exp as $key => $value) {
                $val = json_decode($value, true);
                if ($val == $id) {
                    $result[$primaryKey] = $val;
                    $index = $key;
                }
            }
        }
        $configFile = $this->dbDir . $tableName . "/config.ohx";
        $openConfig = fopen($configFile, "r");
        $data = fread($openConfig, filesize($configFile));
        fclose($openConfig);
        $data = json_decode($data, true);
        foreach ($data as $key => $value) {
            if ($key != $this->tableConfig->getPrimaryKey()) {
                $colPath = $this->dbDir . $tableName . "/" . $key . ".oh";
                if (is_file($colPath)) {
                    $open = fopen($colPath, "r");
                    $data = fread($open, filesize($colPath));
                    fclose($open);
                    $exp = explode(";", $data);
                    foreach ($updateDate as $k => $v) {
                        if ($k == $key) {
                            $exp[$index] = json_encode([$v]);
                        }
                    }
                    $revString = implode(";", $exp);
                    $open = fopen($colPath, "w");
                    fwrite($open, $revString);
                    fclose($open);
                }
            }
        }
    }

    public function delete(int $id, string $tableName)
    {
        $index = 0;
        $this->tableConfig->getConfig($tableName);
        $primaryKey = $this->tableConfig->getPrimaryKey();
        $primaryFile = $this->dbDir . $tableName . "/" . $primaryKey . ".oh";
        if (is_file($primaryFile)) {
            $open = fopen($primaryFile, "r");
            $data = fread($open, filesize($primaryFile));
            fclose($open);
            $exp = explode(";", $data);
            foreach ($exp as $key => $value) {
                $val = json_decode($value, true);
                if ($val == $id) {
                    $result[$primaryKey] = $val;
                    $index = $key;
                }
            }
            unset($exp[$index]);
            $rString = implode(";", $exp);
            $open = fopen($primaryFile, "w");
            fwrite($open, $rString);
            fclose($open);
        }
        $configFile = $this->dbDir . $tableName . "/config.ohx";
        $openConfig = fopen($configFile, "r");
        $data = fread($openConfig, filesize($configFile));
        fclose($openConfig);
        $data = json_decode($data, true);
        foreach ($data as $key => $value) {
            if ($key != $this->tableConfig->getPrimaryKey()) {
                $colPath = $this->dbDir . $tableName . "/" . $key . ".oh";
                if (is_file($colPath)) {
                    $open = fopen($colPath, "r");
                    $data = fread($open, filesize($colPath));
                    fclose($open);
                    $exp = explode(";", $data);
                    unset($exp[$index]);
                    $revString = implode(";", $exp);
                    $open = fopen($colPath, "w");
                    fwrite($open, $revString);
                    fclose($open);
                }
            }
        }
    }
}
