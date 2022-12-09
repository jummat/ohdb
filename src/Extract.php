<?php

namespace Finder\Ohdb;

class Extract
{
    public $assetDir = "";

    public function __construct()
    {
        $targetDir = dirname(__DIR__) . "/asset/";
        $this->assetDir = $targetDir;
    }

    public function auth()
    {
        $authFilePath = $this->assetDir . "auth/auth.ohx";
        if (is_file($authFilePath)) {
            $stram = fopen($authFilePath, "r");
            $text = fread($stram, filesize($authFilePath));
            fclose($stram);
            $json = base64_decode($text);
            $array = json_decode($json, true);
            $username = $array['username'];
            return $username;
        } else {
            print "File not found";
        }
    }

    public function licenseAuth()
    {
        $authFilePath = $this->assetDir . "key/license.txt";
        if (is_file($authFilePath)) {
            $stram = fopen($authFilePath, "r");
            $text = fread($stram, filesize($authFilePath));
            fclose($stram);
            $text = base64_decode($text);
            $exp = explode(":", $text);
            $text = $exp[1];
            $exp = explode('@', $text);
            $username = $exp[3];
            return base64_decode($username);
        } else {
            print "File not found";
        }
    }
}
