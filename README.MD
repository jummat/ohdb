# ohdb

ohdb is a light weight no sql database.It's fully writen with php
no framework or dependency is used to develope. It has developed with pure php

## Installation

initializing

```php
$ohdb = new Ohdb;
```

### install 
```php
$ohdb->config->__install();
```

required for only ** very first ** time of installation

## Basic usage

### Inserting 

create a new table

```php
 $cols = [
    'id' => [
        'type' => 'int',
        'length' => 11,
        'primary_key' => true
    ],
    'first_col' => [
        'type' => 'text',
        'length' => 255
    ],
    'second_col' => [
        'type' => 'text',
        'length' => 25
    ]
 ];
```

```php
 $ohdb->table->createTable("FruitData", $cols);
```