let tableAdmins;
let rowTable = "";
document.addEventListener('DOMContentLoaded', function () {
    validadorRut('txtDni');
    tableAdmins = $('#tableAdmins').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " " + base_url + "/AdminColegio/getAdminsColegio",
            "dataSrc": ""
        },
        "columns": [
            {"data": "dni"},
            {"data": "nombre"},
            {"data": "email"},
            {"data": "telefono"},
            {"data": "status"},
            {"data": "options"}
        ],
        responsive: true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "asc"]]
    });
    //NUEVO ADMIN
    let formAdmin = document.querySelector("#formAdmin");
    formAdmin.onsubmit = function (e) {
        e.preventDefault();
        let txtRut = document.querySelector('#txtDni').value;
        let strNombre = document.querySelector('#txtNombre').value;
        let txtCorreo = $('#txtEmail').val();
        let txtTelefono = $('#txtTelefono').val();
        var regexCoreo = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
        //var regexClave = new RegExp("^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$");
        var regulTele = /^(\+?56)?(\s?)(0?9)(\s?)[9876543]\d{7}$/;
        if (strNombre == '' || txtRut == '' || txtCorreo == '' || txtTelefono == '')
        {
            swal("Atención", "Debe ingresar datos para crear al Admin", "error");
            return false;
        } else if (!regexCoreo.test(txtCorreo.trim()) || !regulTele.test(txtTelefono.trim())) {
            swal("Por favor", "Ingrese un Telefono o Correo Valido para registrarse...", "error");
            $("#txtTelefono").val("+569");
            return false;
        } else {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/AdminColegio/setAdmin';
            let formData = new FormData(formAdmin);
            request.open("POST", ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {

                    let objData = JSON.parse(request.responseText);
                    if (objData.status)
                    {
                        tableAdmins.api().ajax.reload();
                        $('#modalFormAdmins').modal("hide");
                        formAdmin.reset();
                        swal("Exito !!", objData.msg, "success");
                    } else {
                        swal("Error", objData.msg, "error");
                    }
                }
                return false;
            };
        }
    };

    let formColegioA = document.querySelector("#formColegioA");
    formColegioA.onsubmit = function (e) {
        e.preventDefault();
        let listColegios = document.querySelector("#listColegios").value;
        if (listColegios == '') {
         swal("Atención", "Debe ingresar datos para crear al Admin", "error");
            return false;
        }else {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/AdminColegio/setDetailColegio';
            let formData = new FormData(formColegioA);
            request.open("POST", ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {

                    let objData = JSON.parse(request.responseText);
                    if (objData.status)
                    {
                        tableAdmins.api().ajax.reload();
                        $('#modalFormColegiosAd').modal("hide");
                        formColegioA.reset();
                        swal("Exito !!", objData.msg, "success");
                    } else {
                        swal("Error", objData.msg, "error");
                    }
                }
                return false;
            };
        }
    };

    fntColegios();
}, false);

function fntViewInfo(idAdmin) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/AdminColegio/getAdminColegio/' + idAdmin;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status)
            {
                let estado = objData.data.status == 1 ?
                        '<span class="badge badge-success">Activo</span>' :
                        '<span class="badge badge-dark">Vinculado</span>';
                document.querySelector("#celRut").innerHTML = objData.data.dni;
                document.querySelector("#celNombre").innerHTML = objData.data.nombre;
                document.querySelector("#celEmail").innerHTML = objData.data.email;
                document.querySelector("#celTelefono").innerHTML = objData.data.telefono;
                document.querySelector("#celDireccion").innerHTML = objData.data.direccion != "" ? objData.data.direccion : "No se tiene una direccion registrada";
                document.querySelector("#celFecha").innerHTML = objData.data.fecha;
                document.querySelector("#celHora").innerHTML = objData.data.hora;
                document.querySelector("#celStatus").innerHTML = estado;

                $('#modalViewAdmin').modal('show');
            } else {
                swal("Error", objData.msg, "error");
            }
        }
    };
}

function fntEditInfo(element, idAdmin) {
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML = "Actualizar Adminitrador de Colegio";
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/AdminColegio/getAdminColegio/' + idAdmin;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status)
            {
                document.querySelector("#idAdmin").value = objData.data.id;
                document.querySelector("#txtDni").value = objData.data.dni;
                document.querySelector("#txtNombre").value = objData.data.nombre.toString().toLowerCase();
                document.querySelector("#txtEmail").value = objData.data.email.toString().toLowerCase();
                document.querySelector("#txtTelefono").value = objData.data.telefono;
                document.querySelector("#txtDireccion").value = objData.data.direccion.toString().toLowerCase();

                $('#modalFormAdmins').modal('show');

            } else {
                swal("Error", objData.msg, "error");
            }
        }
    };
}


function fntDelInfo(idadmin) {
    swal({
        title: "Inhabilitar Administrador",
        text: "¿Realmente quiere inhabilitar a este administrador?",
        icon: "warning",
        dangerMode: true,
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/AdminColegio/setStatusAdmin';
            let strData = "idAdmin=" + idadmin + "&status=0";
            request.open("POST", ajaxUrl, true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status)
                    {
                        swal("Inhabilitado !!", objData.msg, "success");
                        tableAdmins.api().ajax.reload();
                    } else {
                        swal("Atención!", objData.msg, "error");
                    }
                }
            };
        }
    });

}

function fntActivateInfo(idadmin) {
    swal({
        title: "Habilitar Administrador",
        text: "¿Realmente quiere habilitar a este administrador?",
        icon: "info",
        dangerMode: true,
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/AdminColegio/setStatusAdmin';
            let strData = "idAdmin=" + idadmin + "&status=1";
            request.open("POST", ajaxUrl, true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status)
                    {
                        swal("Activada !!", objData.msg, "success");
                        tableAdmins.api().ajax.reload();
                    } else {
                        swal("Atención!", objData.msg, "error");
                    }
                }
            };
        }
    });

}

function openModal() {
    document.querySelector('#idAdmin').value = "";
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Adminitrador de Colegio";
    document.querySelector("#formAdmin").reset();
    $('#modalFormAdmins').modal('show');
}


/*Funciones para el añadir/actualizar colegio por parte del Admin*/

function fntSchoolA(idAdmin) {
    document.querySelector('#titleModalA').innerHTML = "Agregar Colegio al Admin";
    document.querySelector('#btnActionFormA').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnTextA').innerHTML = "Guardar";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/AdminColegio/getAdminColegio/' + idAdmin;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status)
            {
                document.querySelector("#idAdminC").value = objData.data.id;
                document.querySelector("#idVinCol").value = "";
                document.querySelector("#txtDniA").value = objData.data.dni;
                document.querySelector("#txtNombreA").value = objData.data.nombre;
                document.querySelector("#listColegios").value = "0";
                $("#modalFormColegiosAd").modal('show');
            }
        }
    };
}
function fntSchoolU(idAdmin) {
    document.querySelector('#titleModalA').innerHTML = "Actualizar Colegio al Admin";
    document.querySelector('#btnActionFormA').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnTextA').innerHTML = "Actualizar";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/AdminColegio/getAdminColegio/' + idAdmin;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status)
            {
                document.querySelector("#idAdminC").value = objData.data.id;
                document.querySelector("#idVinCol").value = objData.data.school.idVin;
                document.querySelector("#txtDniA").value = objData.data.dni;
                document.querySelector("#txtNombreA").value = objData.data.nombre;
                document.querySelector("#listColegios").value = objData.data.school.id;
                $("#modalFormColegiosAd").modal('show');
            }
        }
    };
}

function fntDelSchool(idadmin) {
    swal({
        title: "Remover Colegio",
        text: "¿Realmente quiere quitar este colegio?",
        icon: "warning",
        dangerMode: true,
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/AdminColegio/removeSchoolAdmin';
            let strData = "idAdmin=" + idadmin;
            request.open("POST", ajaxUrl, true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status)
                    {
                        swal("Exito !!", objData.msg, "success");
                        tableAdmins.api().ajax.reload();
                    } else {
                        swal("Atención!", objData.msg, "error");
                    }
                }
            };
        }
    });

}

function fntColegios() {
    if (document.querySelector('#listColegios')) {
        $.ajax({
            type: "POST",
            url: base_url + '/Colegios/getSelectColegios',
            success: function (data) {
                $('.selectColegios select').html(data).fadeIn();
            }
        });
    }
}