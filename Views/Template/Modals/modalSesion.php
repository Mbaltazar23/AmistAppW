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