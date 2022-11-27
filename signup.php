<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="row m-0 justify-content-center">
        <div class="col-md-5">
            <div class="card mt-5">
                <div class="card-header">
                    Signup form
                </div>
                <div class="card-body">
                    <?php

                    use Finder\Ohdb\Ohdb;

                    include "vendor/autoload.php";

                    $ohdb = new Ohdb;
                    $cols = [
                        'id' => [
                            'type' => "int",
                            'primary_key' => true,
                            'length' => 11
                        ],
                        'email' => [
                            'type' => 'text',
                            'length' => 255
                        ],
                        'name' => [
                            'type' => 'text',
                            'length' => 255
                        ],
                        'password' => [
                            'type' => 'text',
                            'length' => 255,
                        ],
                        'create_at' => [
                            'type' => 'text',
                            'length' => 'auto'
                        ]
                    ];
                    $ohdb->table->createTable('usr', $cols);

                    if (isset($_POST['signup'])) {
                        $email = $_POST['email'];
                        $name = $_POST['name'];
                        $password = $_POST['password'];
                        $hash = password_hash($password, PASSWORD_BCRYPT);
                        $insertData = [
                            'email' => $email,
                            'name' => $name,
                            'password' => $hash,
                            'create_at' => date("d-F-Y H:i")
                        ];
                        $existData = [
                            'email' => $email
                        ];
                        if ($ohdb->data->rows('usr', $existData) == 0) {
                            $ohdb->table->saveData($insertData);
                        } else {
                            print "Email exist";
                        }
                    }


                    ?>
                    <form action="" method="post">
                        <input type="email" name="email" placeholder="Email" class="form-control my-2">
                        <input type="text" name="name" placeholder="Fullname" class="form-control my-2">
                        <input type="password" name="password" placeholder="Password" class="form-control my-2">
                        <button type="submit" name="signup" class="btn btn-success">Signup</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>