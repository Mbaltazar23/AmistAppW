<?php
headerAdmin($data);
getModal('modalProductos', $data);
?>

<div class="content-wrapper" id="app-product">
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
                    <!-- Default box -->
                    <div class="card">
                        <div class="card-header">
                            <div class="input-group mb-15">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                        <?= $data['page_title'] ?>
                                    </button>
                                    <div class="dropdown-menu" role="menu">
                                        <a class="dropdown-item" @click.onclick="openModal">Nuevo</a>
                                        <a class="dropdown-item" >Generar Reporte</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="tableProductos" class="table table-responsive-lg" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Precio</th>
                                        <th>Stock</th>
                                        <th>Categoria</th>
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

<?php
footerAdmin($data)
?>