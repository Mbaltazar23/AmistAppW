<div class="wrapper">
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="<?= media(); ?>/dist/img/AmistAppIcon.png" alt="AmistAppLogo" height="90" width="90"/>
    </div>
    <!--Navbar responsive-->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <?php getModal('modalNotificaciones', $data) ?>
                </div>
            </li>
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                    <img src="<?= media(); ?>/dist/img/<?= $_SESSION['userData']["imgPerfil"] ?>" class="user-image img-circle elevation-2" alt="User Image">
                    <span class="d-none d-md-inline"><?= $_SESSION['userData']["nombre"] ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <!-- User image -->
                    <li class="user-header bg-primary">
                        <img src="<?= media(); ?>/dist/img/<?= $_SESSION['userData']["imgPerfil"] ?>" class="img-circle elevation-2" alt="User Image">
                        <p>
                            <?= $_SESSION['userData']["nombre"] ?> - <?= $_SESSION['userData']["nombreRol"] ?>
                            <small>Registrado desde <?= darFormatoFecha($_SESSION["userData"]["created_at"]) ?></small>
                        </p>
                    </li>

                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <a class="btn btn-default btn-flat" href="<?= base_url(); ?>/dashboard/profile">Perfil</a>
                        <span class="btn btn-default btn-flat float-right" onclick="cerrarSesion();">Salir</span>
                    </li>
                </ul>           
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="<?= base_url() ?>/dashboard" class="brand-link">
            <img src="<?= media(); ?>/dist/img/AmistAppIcon.png"  alt="AmistAppLogo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">AmistApp</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="<?= media(); ?>/dist/img/<?= $_SESSION['userData']["imgPerfil"]; ?>" class="img-circle elevation-2" alt="<?= $data["imgPerfil"] ?>">
                </div>
                <div class="info">
                    <a href="<?= base_url(); ?>/dashboard/profile" class="d-block"><?= $_SESSION['userData']["nombre"] ?></a>
                </div>
            </div>
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="<?= base_url() ?>/dashboard" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                    <?php foreach ($navDashboardAdmin as $modulo => $submodulos) { ?>
                        <li class="nav-item">
                            <a class="nav-link">
                                <i class="nav-icon <?= $submodulos['icon']; ?>"></i>
                                <p>
                                    <?= $modulo; ?>
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <?php foreach ($submodulos['submodulos'] as $submodulo => $data) { ?>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?= base_url() ?>/<?= $data['pagina']; ?>" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p><?= $submodulo; ?></p>
                                        </a>
                                    </li>
                                </ul>
                            <?php } ?>
                        </li>
                    <?php } ?>
                </ul>
            </nav>
        </div>
        <!-- /.sidebar -->
    </aside>