<?php
headerAdmin($data);
getModal('modalNotificaciones', $data);
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>&nbsp;<?= $data['page_title'] ?> - <?= TITLE_ADMIN ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Inicio</a></li>
                        <li class="breadcrumb-item active"><?= $data['page_title'] ?></li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><strong><?= $data['page_title'] ?></strong></h3>
                            <div class="card-tools">
                                <input type="button"  value="Nueva Notificacion" onclick="openModal();" class="btn btn-success float-right"/>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="tableNotificaciones" class="table table-hover table-striped table-responsive-lg" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Nro</th>
                                        <th>Tipo</th>
                                        <th>Fecha</th>
                                        <th>Status</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                        </div>
                        <!-- /.card-footer-->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<?php footerAdmin($data); ?>
    