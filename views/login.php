<?php session_start();
if (isset($_SESSION["rol"])) {
    header("Location:./dashboard.php");
}

if (!empty($_POST)) {
    include "../controllers/dbconn.php";
    $email = $_POST["email"];
    $pass = $_POST["pass"];
    $query = "SELECT id_user, pass, id_rol_fk FROM users WHERE email = '$email'";
    $dataSQL = mysqli_query($db, $query) or die(mysqli_error($db));
    if ($dataSQL->num_rows > 0) {
        $user = $dataSQL->fetch_assoc();
        if (password_verify($pass, $user['pass'])) {
            $_SESSION["rol"] = $user["id_rol_fk"];
            $_SESSION["id_user"] = $user["id_user"];
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

    <!-- jQuery -->
    <script src="../assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../assets/dist/js/adminlte.min.js"></script>
</body>

</html>