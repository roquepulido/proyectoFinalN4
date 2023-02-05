<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="./dashboard.php" class="brand-link">
        <img src="../assets/img/logoEscudo.jpg" alt="Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Universidad</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <h5 style="color: #c2c7d0;"><?= $_SESSION["user"]["rol"] ?></h5>
                <a href="#" class="d-block"><?= $_SESSION["user"]["name"] ?></a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <!-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <?php if ($_SESSION['rol'] == 1) {
                ?>

                <li class="nav-header text-center text-uppercase"> menu Administración</li>
                <li class="nav-item">
                    <a href="./admin_admin.php"
                        class="nav-link <?= $_SERVER['PHP_SELF'] == '/proyectoFinalN4/views/admin_admin.php' ? "active" : "" ?>">
                        <i class="bi bi-person-fill-gear nav-icon"></i>
                        <p class="ml-2">Permisos</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./admin_maestros.php"
                        class="nav-link <?= $_SERVER['PHP_SELF'] == '/proyectoFinalN4/views/admin_maestros.php' ? "active" : "" ?>">
                        <i class="bi bi-person-workspace nav-icon"></i>
                        <p class="ml-2">Maestros</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./admin_alumnos.php"
                        class="nav-link <?= $_SERVER['PHP_SELF'] == '/proyectoFinalN4/views/admin_alumnos.php' ? "active" : "" ?>">
                        <i class="bi bi-mortarboard-fill nav-icon"></i>
                        <p class="ml-2">Alumnos</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./admin_clases.php"
                        class="nav-link <?= $_SERVER['PHP_SELF'] == '/proyectoFinalN4/views/admin_clases.php' ? "active" : "" ?>">
                        <i class="bi bi-easel2 nav-icon"></i>
                        <p class="ml-2">Clases</p>
                    </a>
                </li>
                <?php } ?>
                <?php if ($_SESSION['rol'] == 2) {
                ?>

                <li class="nav-header text-center text-uppercase"> menu Maestros</li>
                <li class="nav-item">
                    <a href="./maestro_alumnos.php" class="nav-link ">
                        <i class="bi bi-mortarboard-fill nav-icon"></i>
                        <p class="ml-2">Alumnos</p>
                    </a>
                </li>
                <?php } ?>
                <?php if ($_SESSION['rol'] == 3) {
                ?>
                <li class="nav-header text-center text-uppercase">menu Alumnos</li>
                <li class="nav-item">
                    <a href="./calificaciones.php" class="nav-link">
                        <i class="bi bi-file-earmark-check nav-icon"></i>
                        <p class="ml-2">Calificaciones</p>
                    </a>
                </li>
                <?php } ?>



                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Simple Link
                            <span class="right badge badge-danger">New</span>
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>