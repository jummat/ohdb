<?php

namespace Finder\Ohdb;

class Data
{
    public function __construct()
    {
        $this->config = new Config;
        $this->dbDir = $this->config->returnConfig()['rootDir'];
        $this->tableConfig = new TableConfig;
    }

    private function purifyData(array $allData)
    {

        $result = [];
        $totalInOneArray = 0;
        foreach ($allData as $key => $value) {
            $result[$key] = [];
            foreach ($value as $k => $v) {
                if ($v != NULL) {
                    $vl = json_decode($v, true);
                    if (is_array($vl)) {
                        array_push($result[$key], $vl[0]);
                    } else {
                        array_push($result[$key], $vl);
                    }
                    $totalInOneArray += 1;
                }
            }
        }
        $finalResult = [];
        for ($i = 0; $i < $totalInOneArray / count($result); $i++) {
            $arrayName = "arr_" . $i;
            $arrayName = [];
            foreach ($result as $key => $value) {
                $arrayName[$key] = $value[$i];
            }
            array_push($finalResult, $arrayName);
        }
        return $finalResult;
    }

    public function grabAll(string $tableName, $orderBy = "asc")
    {
        $this->tableConfig->getConfig($tableName);
        $tableDir = $this->dbDir . $tableName . "/";
        $configFile = $tableDir . "config.ohx";
        $openConfig = fopen($configFile, "r");
        $data = fread($openConfig, filesize($configFile));
        fclose($openConfig);
        $data = json_decode($data, true);
        $allData = [];
        foreach ($data as $key => $value) {
            $dataDir = $tableDir . $key . ".oh";
            if (is_file($dataDir)) {
                $fileSize = filesize($dataDir);
                $openData = fopen($dataDir, "r");
                $dt = fread($openData, $fileSize);
                fclose($openData);
                $exp = explode(";", $dt);
                $allData[$key] = $exp;
            }
        }
        $data = ($this->purifyData($allData));
        if ($orderBy == "asc") {
            return $data;
        } else if ($orderBy == "desc") {
            $data = array_reverse($data);
            return $data;
        }
    }

    public function grabSingle(string $tableName, int $id)
    {
        $result = [];
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
                    $data = $exp[$index];
                    $data = json_decode($data, true);
                    $result[$key] = $data[0];
                }
            }
        }
        return $result;
    }

    public function rows(string $tableName, array $data)
    {
        if (count($data) == 1) {
            foreach ($data as $k => $v) {
                $path = $this->dbDir . $tableName . "/" . $k . ".oh";
                if (is_file($path)) {
                    $open = fopen($path, "r");
                    $text = fread($open, filesize($path));
                    fclose($open);
                    return substr_count($text, $v);
                }
            }
        }
    }

    public function grabByColumn(string $table, array $data)
    {
        if (count($data) == 1) {
            $index = 0;
            $result = [];
            $this->tableConfig->getConfig($table);
            $tableDir = $this->dbDir . $table . "/";
            foreach ($data as $key => $value) {
                $fileDir = $tableDir . $key . ".oh";
                if (is_file($fileDir)) {
                    $file = fopen($fileDir, "r");
                    $text = fread($file, filesize($fileDir));
                    fclose($file);
                    $exp = explode(";", $text);
                    foreach ($exp as $k => $v) {
                        $vl = json_decode($v, true);
                        $vlu = is_array($vl) ? $vl[0] : $vl;
                        if ($vlu == $value) {
                            $index = $k;
                        }
                    }
                }
            }
            $configFile = $this->dbDir . $table . "/config.ohx";
            $openConfig = fopen($configFile, "r");
            $data = fread($openConfig, filesize($configFile));
            fclose($openConfig);
            $data = json_decode($data, true);
            foreach ($data as $key => $value) {
                if ($key != $this->tableConfig->getPrimaryKey()) {
                    $colPath = $this->dbDir . $table . "/" . $key . ".oh";
                    if (is_file($colPath)) {
                        $open = fopen($colPath, "r");
                        $data = fread($open, filesize($colPath));
                        fclose($open);
                        $exp = explode(";", $data);
                        $data = $exp[$index];
                        $data = json_decode($data, true);
                        $result[$key] = $data[0];
                    }
                }
            }
            return $result;
        }
    }
}
