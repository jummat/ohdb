<?php

use Finder\Ohdb\Edit;

include "vendor/autoload.php";

$edit = new Edit;
$id = $_GET['id'];

$edit->delete($id, "FruitData");

header("location: /form.php");