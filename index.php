<?php

use Finder\Ohdb\Ohdb;

include "vendor/autoload.php";

$ohdb = new Ohdb;

$ohdb->config->__install();

$data = $ohdb->data->grabAll("FruitData");

$config = [
    'secureString' => false,
    'dblowercase' => false
];
