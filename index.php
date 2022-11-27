<?php

use Finder\Ohdb\Ohdb;

include "vendor/autoload.php";

$ohdb = new Ohdb;

$ohdb->config->__install();

print "<pre>";

print_r($ohdb->data->grabAll("FruitData"));