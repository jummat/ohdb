<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="row m-0 justify-content-center">
        <div class="col-md-5">
            <div class="mt-5 card">
                <div class="card-header">
                    Login
                </div>
                <div class="card-body">
                    <?php

                    use Finder\Ohdb\Ohdb;

                    include "vendor/autoload.php";

                    $ohdb = new Ohdb;

                    if (isset($_POST['login'])) {
                        $email = $_POST['email'];
                        $password = $_POST['password'];
                        $data = [
                            'email' => $email
                        ];
                        if ($ohdb->data->rows("usr", $data) > 0) {
                            $selectData = $ohdb->data->grabByColumn("usr", $data);
                            $hash = $selectData['password'];
                            if (password_verify($password, $hash)) {
                                print "Login Success __ " . $selectData['name'];
                                // print_r($selectData);
                            } else {
                                print "Password is incorrect";
                            }
                            // print_r($selectData);
                        } else {
                            print "Email not registered";
                        }
                    }

                    ?>
                    <form action="" method="post">
                        <input type="text" name="email" placeholder="Email" class="form-control my-2">
                        <input type="password" name="password" placeholder="Password" class="form-control my-2">
                        <button type="submit" name="login" class="btn btn-success">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>