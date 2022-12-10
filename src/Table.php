<?php

namespace Finder\Ohdb;

class Table
{

    public function __construct()
    {
        $license = new License;
        if ($license->license() == true && $license->licenseValidation() == true) {
            $this->config = new Config;
            $this->dbDir = $this->config->returnConfig()['rootDir'];
            $this->tableCong = new TableConfig;
            $this->stat = new Stat;
            $this->errorHandler = new Errorhandler;
        }
    }

    public function createTable(string $stableName, array $column)
    {
        $this->tableName = $stableName;
        array_push(Clear::$tables, $stableName);
        $path = $this->dbDir . $stableName . "/";
        $this->tablePath = $path;
        if (!is_dir($path)) {
            mkdir($path);
            $this->stat->clientStat("Table created [$stableName]");
        }
        $configFile = $path . "config.ohx";
        if (!is_file($configFile)) {
            $fopen = fopen($configFile, "w");
            fwrite($fopen, json_encode($column));
            fclose($fopen);
        }
        foreach ($column as $key => $value) {
            $dbFile = $path . $key . ".oh";
            if (!is_file($dbFile)) {
                touch($dbFile);
            }
        }
    }

    private function storeLastPrimary(int $key = 1)
    {
        $this->tableCong->getConfig($this->tableName);
        $primary = $this->tableCong->getPrimaryKey();
        $file = $this->tablePath . $primary . ".ohx";
        $open = fopen($file, "w");
        fwrite($open, $key);
        fclose($open);
    }

    private function getCurrentPrimaryValue()
    {
        $primary = $this->tableCong->getPrimaryKey();
        $file = $this->tablePath . $primary . ".ohx";
        if (is_file($file)) {
            $open = fopen($file, "r");
            $data = fread($open, filesize($file));
            fclose($open);
            return $data;
        } else {
            return false;
        }
    }

    public function saveData(array $data)
    {
        $this->tableCong->getConfig($this->tableName);
        $primary = $this->tableCong->getPrimaryKey();
        $errors = 0;
        foreach ($data as $key => $value) {
            $dataType = $this->tableCong->dataType($key);
            if ($key != $primary) {
                if ($dataType == "text") {
                    if (!is_string($value)) {
                        $errors .= 1;
                        $this->errorHandler->setErrorLog("column [$key], set data-type [text/string], inserted value is not [string]");
                    }
                } else if ($dataType == "int") {
                    if (!is_int($value)) {
                        $errors .= "type error $key";
                        $this->errorHandler->setErrorLog("column [$key], set data-type [int], inserted value is not [int]");
                    }
                }
            }
        }
        if ($errors == 0) {
            $toSaveData = [];
            foreach ($data as $key => $value) {
                $toSaveData = [$value];
                $colPath = $this->tablePath . $key . ".oh";
                $unique = $this->tableCong->__unique($key);
                if ($unique == true) {
                    $q = $this->tableCong->checkUnique($colPath, $value);
                    if ($q == true) {
                        if ($this->tableCong->colValueLength($key) >= strlen($value)) {
                            $finalData = json_encode($toSaveData) . ";";
                            $open = fopen($colPath, "a");
                            fwrite($open, "NULL");
                            fclose($open);
                            $this->errorHandler->setErrorLog("column [$key], set unique [true], value already exist");
                        } else {
                            $errors .= 1;
                        }
                    } else {
                        if ($this->tableCong->colValueLength($key) >= strlen($value)) {
                            $finalData = json_encode($toSaveData) . ";";
                            $open = fopen($colPath, "a");
                            fwrite($open, $finalData);
                            fclose($open);
                        } else {
                            $errors .= 1;
                        }
                    }
                } else {
                    if (is_file($colPath)) {
                        if ($this->tableCong->colValueLength($key) >= strlen($value)) {
                            $finalData = json_encode($toSaveData) . ";";
                            $open = fopen($colPath, "a");
                            fwrite($open, $finalData);
                            fclose($open);
                        } else {
                            $errors .= 1;
                        }
                    }
                }
            }
            $this->stat->clientStat("Data inserted to [$this->tableName]");
            $primaryKey = $this->tableCong->getPrimaryKey();
            $primaryKeyPath = $this->tablePath . $primaryKey . ".oh";
            $finalData = json_encode($this->autoIncrement($this->tableName)) . ";";
            $open = fopen($primaryKeyPath, "a");
            fwrite($open, $finalData);
            fclose($open);
        } else {
            print $errors;
        }
    }

    public function autoIncrement(string $stableName)
    {
        $this->tableCong->getConfig($stableName);
        $primary = $this->getCurrentPrimaryValue();
        if ($primary == "") {
            $this->storeLastPrimary(1);
        } else {
            $newValue = $this->getCurrentPrimaryValue() + 1;
            $this->storeLastPrimary($newValue);
        }
        return $this->getCurrentPrimaryValue();
    }
}
