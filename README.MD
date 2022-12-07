# ohdb

ohdb is a light weight no sql database.It's fully writen with php
no framework or dependency is used to develope. It has developed with pure php

## Installation

initializing

```php
use Finder\Ohdb\Ohdb;

$ohdb = new Ohdb;
```

### install 
```php
$ohdb->config->__install();
```

required for only __very first__ time of installation

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

### Save data

```php
$ohdb->table->saveData($data)
```

> NB: To store data into a new table call the create table function first and than call save method
> saveData mehod will automatically detect the table name from creaetTable method

### Edit data into table 

```php
$ohdb->edit->editData($id, $tableName, $dataToBeUpdate);
```

### Delete data

```php
$ohdb->delete($id, $tableName);
```

> last update 12/07/2022 10:37

**For full documentation**
Visit [https://org-home.com/ohdb]