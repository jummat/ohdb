<?php

use Finder\Ohdb\Ohdb;

include "vendor/autoload.php";

$ohdb = new Ohdb;

$ohdb->license->setLicense("C:\Users\Monwar Shanto\Downloads\license.txt");
$ohdb->license->setAuth("C:\Users\Monwar Shanto\Downloads\auth.ohx");

$cols = [
    'name' => [
        'type' => "text",
        "length" => 255
    ],
    'age' => [
        'type' => 'int',
        'length' => 255
    ],
    'id' => [
        'type' => 'int',
        'length' => 11,
        'primary_key' => 'true'
    ]
];

$ohdb->table->createTable("test", $cols);

$saveData  = [
    'name' => "Test user",
    'age' => 21
];

// $ohdb->table->saveData($saveData);

$cols = [
    'id' => [
        'primary_key' => true,
        'length' => 11,
        'type' => 'int'
    ],
    'data' => [
        'type' => 'text',
        'length' => 255
    ]
];

$ohdb->table->createTable("data", $cols);

$datas = [
    'data' => "Sample string"
];

// $ohdb->table->saveData($datas);


print "<pre>";

$datas = $ohdb->data->grabSingle('test', 1);
print_r($datas);
