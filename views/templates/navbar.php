<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center fw-bold" data-widget="pushmenu" href="#" role="button"><i
                    class="bi bi-list"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="./dashboard.php" class="nav-link">Home</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <?= $_SESSION["user"]["name"] ?><i class="bi bi-chevron-down ml-2"></i></i>
            </a>
            <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                <?php if ($_SESSION["rol"] != 1) : ?>
                <a href="./profile.php" class="dropdown-item">
                    <i class="bi bi-person-circle mr-2"></i> Perfil
                </a>
                <div class="dropdown-divider"></div>
                <? endif ?>
                <a href="./logout.php" class="dropdown-item text-danger"><i class="bi bi-door-open mr-2"></i>
                    Logout</a>
            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->