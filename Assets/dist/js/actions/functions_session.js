function cerrarSesion() {
    swal({
        title: "Cerrar Sesion",
        text: "¿Realmente salir de su sesion?",
        icon: "info",
        buttons: true,
        dangerMode: false
    }).then((isClosed) => {
        if (isClosed) {
            $.ajax({
                type: "POST",
                url: base_url + "/logout",
                success: function (data) {
                    if (data) {
                        swal({
                            title: "Exito !",
                            text: "Sesion Finalizada !!",
                            icon: "success"
                        }).then(function () {
                            window.location = base_url;
                        });
                    }
                }
            });
        }
    });
}
