<?php
headerLogin($data);
?>
<body class="hold-transition register-page">
    <div class="register-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="<?= base_url(); ?>" class="h1"><b>Amist</b>APP</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Registrese como nuevo Alumno</p>

                <form id="formRegister" method="post">
                    <div class="input-group mb-3">
                        <input type="text" name="txtRut" id="txtRut" class="form-control" placeholder="Rut">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-duotone fa-passport"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" name="" id="" class="form-control" placeholder="Nombres">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Telefono" value="+569" maxlength="12">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-phone"></span>   
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Direccion">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-solid fa-compass"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Repita password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="agreeTerms" name="terms" value="Acepto" required>
                                <label for="agreeTerms">
                                    Yo acepto los <a href="<?= base_url() ?>">terminos</a>
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Regístrese</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <a href="<?= base_url(); ?>" class="text-center">Ya tengo una cuenta</a>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>


    <?php
    footerLogin($data);
    ?>