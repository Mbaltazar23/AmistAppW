<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        $navDashboardAdmin = navDashboardAdmin();
        ?>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $data["page_tag"] ?></title>
        <link rel="icon" href="<?= media(); ?>/img/AmistAppIcon.png" type="image/x-icon">

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?= media(); ?>/js/plugins/fontawesome-free/css/all.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Tempusdominus Bootstrap 4 -->
        <link rel="stylesheet" href="<?= media(); ?>/js/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?= media(); ?>/js/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
        <!-- JQVMap -->
        <link rel="stylesheet" href="<?= media(); ?>/js/plugins/jqvmap/jqvmap.min.css">
        <link rel="stylesheet" href="<?= media(); ?>/js/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="<?= media(); ?>/js/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="<?= media(); ?>/js/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
        <link rel="stylesheet" href="<?= media(); ?>/css/styles.css" type="text/css"/>
        <!-- Theme style -->
        <link rel="stylesheet" href="<?= media(); ?>/css/adminlte.min.css">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="<?= media(); ?>/js/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="<?= media(); ?>/js/plugins/daterangepicker/daterangepicker.css">
        <!-- summernote -->
        <link rel="stylesheet" href="<?= media(); ?>/js/plugins/summernote/summernote-bs4.min.css">
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
        <?php require_once("nav_admin.php"); ?> 