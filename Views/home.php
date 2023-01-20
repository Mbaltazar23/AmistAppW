<?php
headerLogin($data);
if (isset($_SESSION["login"])) {
    header('Location: ' . base_url() . '/dashboard');
}
?>
<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="<?= base_url(); ?>" class="h1"><b>Amist</b>APP</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Ingrese sus credenciales para Inicia sesión</p>

                <form id="formLogin" method="post">
                    <div class="input-group mb-3">
                        <input type="text" name="txtRut" id="txtRut" class="form-control" placeholder="Rut...">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-duotone fa-passport"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" id="txtPassword" name="txtPassword"class="form-control" placeholder="Password..">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <label for="remember">

                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
<!--                <p class="mb-1">
                    <a href="forgot-password.html">I forgot my password</a>
                </p>-->
                <p class="mb-0">
                    <a href="<?= base_url() ?>/home/register" class="text-center">Registrese como alumno nuevo</a>
                </p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <?php
    footerLogin($data);
    ?>