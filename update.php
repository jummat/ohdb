<?php

use Finder\Ohdb\Data;
use Finder\Ohdb\Edit;

include "vendor/autoload.php";

$data = new Data;

$edit = new Edit;

$id = $_GET['id'];

if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $updateData = [
        'name' => $name,
        'price' => $price
    ];
    // print_r($updateData);
    $edit->editData($id, "FruitData", $updateData);
}

$result = ($data->grabSingle("FruitData", $id));

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Data</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="mt-5">
                <form action="" method="post">
                    <input type="text" name="name" placeholder="Fruits" class="form-control my-2" value="<?= $result['name'] ?>">
                    <input type="number" name="price" placeholder="Price" class="form-control my-2" value="<?= $result['price'] ?>">
                    <input type="submit" value="Update" class="btn btn-primary" name="save">
                    <a href="delete.php?id=<?= $id ?>" class="btn btn-danger">Delete</a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>