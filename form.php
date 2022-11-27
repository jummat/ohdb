<?php

use Finder\Ohdb\Ohdb;

include "vendor/autoload.php";

$ohdb = new Ohdb;
$ohdb->config->__install();

$cols = [
    'id' => [
        'type' => 'int',
        'length' => 11,
        'primary_key' => true
    ],
    'name' => [
        'type' => 'text',
        'length' => 255
    ],
    'price' => [
        'type' => 'text',
        'length' => 25
    ]
];

$ohdb->table->createTable("FruitData", $cols);

if (isset($_POST['store'])) {
    $name = $_POST['fruit'];
    $price = $_POST['price'];
    $data = [
        'name' => $name,
        'price' => $price
    ];
    $ohdb->table->saveData($data);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nosql Form Data</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="mt-5"></div>
            <form action="" method="post">
                <input type="text" name="fruit" placeholder="Fruit" class="form-control my-2">
                <input type="number" name="price" placeholder="Price" class="form-control my-2">
                <input type="submit" value="Save" name="store" class="btn btn-success">
            </form>
            <?php

            $total = $ohdb->data->grabAll("FruitData", "desc");

            ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Fruit</th>
                        <th scope="col">Price (BDT)</th>
                        <th scope="col">Option</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($total as $key => $data) : ?>
                        <tr>
                            <th scope="row">
                                <?= $data['id'] ?>
                            </th>
                            <td>
                                <?= $data['name'] ?>
                            </td>
                            <td>
                                <?= $data['price'] ?>
                            </td>
                            <td>
                                <a href="update.php?id=<?= $data['id'] ?>" class="btn btn-primary">Edit</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>