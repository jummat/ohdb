<?php

namespace Finder\Ohdb;

class Extract
{
    public $assetDir = "";
    private $licenseText = "";

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
            $this->licenseText = $text;
            $exp = explode('@', $text);
            $username = $exp[3];
            return base64_decode($username);
        } else {
            print "File not found";
        }
    }

    public function checkExpiry()
    {
        $lstxt = $this->licenseText;
        $exp = explode('@', $lstxt);
        $xpry = $exp[2];
        $xpString = base64_decode($xpry);
        $xpArray = explode("-", $xpString);
        $timestamp = $xpArray[1];
        $currentTimeStamp = time();
        $diff = $timestamp - $currentTimeStamp;
        if ($diff > 0) {
            return true;
        } else {
            return false;
        }
    }
}
