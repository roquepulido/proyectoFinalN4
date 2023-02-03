<?php session_start();
if (isset($_SESSION["rol"])) {
    header("Location:./dashboard.php");
}

if (!empty($_POST)) {
    include "../controllers/dbconn.php";
    $email = $_POST["email"];
    $pass = $_POST["pass"];
    $query = "SELECT u.id_user, u.pass, u.id_rol_fk, r.name_rol FROM users as u INNER JOIN roles as r ON u.id_rol_fk = r.id_roles WHERE email = '$email'";
    $dataSQL = mysqli_query($db, $query) or die(mysqli_error($db));
    if ($dataSQL->num_rows > 0) {
        $user = $dataSQL->fetch_assoc();
        if (password_verify($pass, $user['pass'])) {
            $_SESSION["rol"] = $user["id_rol_fk"];
            $_SESSION["id_user"] = $user["id_user"];

            switch ($_SESSION["rol"]) {
                case 1:
                    $_SESSION["user"]["name"] = "Administrador";
                    $_SESSION["user"]["rol"] = $user["name_rol"];
                    break;
                case 2:
                    $query = "SELECT first_name, last_name , id_class_fk FROM teachers WHERE id_user_fk = '" . $user["id_user"] . "'";
                    $dataSQL = mysqli_query($db, $query) or die(mysqli_error($db));
                    $_SESSION["user"] = $dataSQL->fetch_assoc();
                    $_SESSION["user"]["name"] = $_SESSION["user"]["first_name"] . " " . $_SESSION["user"]["last_name"];
                    $_SESSION["user"]["rol"] = "Maestro";
                    break;
                case 3:
                    $query = "SELECT first_name, last_name , id_student FROM students WHERE id_user_fk = '" . $user["id_user"] . "'";
                    $dataSQL = mysqli_query($db, $query) or die(mysqli_error($db));
                    $_SESSION["user"] = $dataSQL->fetch_assoc();
                    $_SESSION["user"]["name"] = $_SESSION["user"]["first_name"] . " " . $_SESSION["user"]["last_name"];
                    $_SESSION["user"]["rol"] = "Alumno";
                    break;
            }

            header("Location:./dashboard.php");
        }
    }
    $error = "Los datos no estan correctos, trata de nuevo.";
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>University</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="../assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../assets/dist/css/adminlte.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <img style="height: 200px;" class="text-center" src="../assets/img/logoClose.jpg" alt="Logo">
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Bienvenido Ingresa con tu cuenta</p>
                <?php if (isset($error)) { ?>
                <h4 class="d-flex flex-column text-center"><i
                        class="fas fa-exclamation-triangle text-danger"></i><?= $error ?></h4>


                <?php } ?>

                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" name="email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password" name="pass">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <!-- /.col -->
                        <div class="col-8"></div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->
    <div class="pass">
        <h5>Admin</h5>
        <p>ocrocroft0@dailymail.co.uk - P3ege6crJ</p>

        <h5>Maestros</h5>
        <p>ipundy2@virginia.edu - tKXLiZlkHH</p>

        <h5>Alumno</h5>
        <p>osprowle9@eventbrite.com - fttuI4DddH0C</p>

    </div>
    <!-- jQuery -->
    <script src="../assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../assets/dist/js/adminlte.min.js"></script>
</body>

</html>