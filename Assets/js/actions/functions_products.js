let tableProductos;
$(document).on('focusin', function (e) {
    if ($(e.target).closest(".tox-dialog").length) {
        e.stopImmediatePropagation();
    }
});


window.addEventListener('load', function () {
    tableProductos = $('#tableProductos').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " " + base_url + "/Productos/getProductos",
            "dataSrc": ""
        },
        "columns": [
            {"data": "nombreP"},
            {"data": "precioP"},
            {"data": "stock"},
            {"data": "categoria"},
            {"data": "status"},
            {"data": "options"}
        ],
        responsive: true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "desc"]]
    });

    if (document.querySelector("#formProductos")) {
        let formProductos = document.querySelector("#formProductos");
        formProductos.onsubmit = function (e) {
            e.preventDefault();
            let strNombre = document.querySelector('#txtNombre').value;
            let strPrecio = document.querySelector('#txtPrecio').value;
            let intStock = document.querySelector('#txtStock').value;
            if (strNombre == '' || strPrecio == '' || intStock == '')
            {
                swal("Atención", "Todos los campos son obligatorios.", "error");
                return false;
            }
            let request = (window.XMLHttpRequest) ?
                    new XMLHttpRequest() :
                    new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/Productos/setProducto';
            let formData = new FormData(formProductos);
            request.open("POST", ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status)
                    {
                        tableProductos.api().ajax.reload();
                        swal("Exito !!", objData.msg, "success");
                        $('#modalFormProductos').modal('hide');
                    } else {
                        swal("Error", objData.msg, "error");
                    }
                }
            };
        };
    }

    if (document.querySelector("#foto")) {
        let foto = document.querySelector("#foto");
        foto.onchange = function (e) {
            let uploadFoto = document.querySelector("#foto").value;
            let fileimg = document.querySelector("#foto").files;
            let nav = window.URL || window.webkitURL;
            let contactAlert = document.querySelector('#form_alert');
            if (uploadFoto != '') {
                let type = fileimg[0].type;
                let name = fileimg[0].name;
                if (type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png') {
                    contactAlert.innerHTML = '<p class="errorArchivo">El archivo no es válido.</p>';
                    if (document.querySelector('#img')) {
                        document.querySelector('#img').remove();
                    }
                    document.querySelector('.delPhoto').classList.add("notBlock");
                    foto.value = "";
                    return false;
                } else {
                    contactAlert.innerHTML = '';
                    if (document.querySelector('#img')) {
                        document.querySelector('#img').remove();
                    }
                    document.querySelector('.delPhoto').classList.remove("notBlock");
                    let objeto_url = nav.createObjectURL(this.files[0]);
                    document.querySelector('.prevPhoto div').innerHTML = "<img id='img' src=" + objeto_url + ">";
                }
            } else {
                swal("Error !!", "No selecciono una foto", "error");
                if (document.querySelector('#img')) {
                    document.querySelector('#img').remove();
                }
            }
        }
    }

    if (document.querySelector(".delPhoto")) {
        let delPhoto = document.querySelector(".delPhoto");
        delPhoto.onclick = function (e) {
            e.preventDefault();
            swal({
                title: "Borrar Imagen",
                text: "¿Realmente quiere borrar esta imagen de este producto?",
                icon: "warning",
                dangerMode: true,
                buttons: true
            }).then((isClosed) => {
                if (isClosed) {
                    document.querySelector("#foto_remove").value = 1;
                    removePhoto();
                }
            });
        };
    }

    fntCategorias();
}, false);

function removePhoto() {
    document.querySelector('#foto').value = "";
    document.querySelector('.delPhoto').classList.add("notBlock");
    if (document.querySelector('#img')) {
        document.querySelector('#img').remove();
    }
}

function fntViewInfo(idProducto) {
    let request = (window.XMLHttpRequest) ?
            new XMLHttpRequest() :
            new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Productos/getProducto/' + idProducto;
    request.open("POST", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status)
            {
                let objProducto = objData.data;
                let estadoProducto = objProducto.status == 1 ?
                        '<span class="badge badge-success">Activo</span>' :
                        '<span class="badge badge-danger">Inactivo</span>';

                document.querySelector("#celNombre").innerHTML = objProducto.nombre;
                document.querySelector("#celPrecio").innerHTML = objProducto.precioP;
                document.querySelector("#celStock").innerHTML = objProducto.stock;
                document.querySelector("#celCategoria").innerHTML = objProducto.categoria;
                document.querySelector("#celFecha").innerHTML = objProducto.fecha;
                document.querySelector("#celHora").innerHTML = objProducto.hora;
                document.querySelector("#celStatus").innerHTML = estadoProducto;


                document.querySelector("#celFoto").innerHTML = '<img src="' + objProducto.url_productImg + '" width="120" height="100"/>';
                $('#modalViewProducto').modal('show');

            } else {
                swal("Error", objData.msg, "error");
            }
        }
    };
}

function fntEditInfo(element, idProducto) {
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML = "Actualizar Producto";
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";
    let request = (window.XMLHttpRequest) ?
            new XMLHttpRequest() :
            new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Productos/getProducto/' + idProducto;
    let formData = new FormData();
    request.open("POST", ajaxUrl, true);
    request.send(formData);
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status)
            {
                let objProducto = objData.data;
                document.querySelector("#idProducto").value = objProducto.id;
                document.querySelector("#txtNombre").value = objProducto.nombre.toString().toLowerCase();
                document.querySelector("#txtPrecio").value = Math.round(objProducto.precio);
                document.querySelector("#txtStock").value = objProducto.stock;
                document.querySelector("#listCategoria").value = objProducto.categoria_id;

                document.querySelector('#foto_actual').value = objData.data.imagen;
                document.querySelector("#foto_remove").value = 0;

                if (document.querySelector('#img')) {
                    document.querySelector('#img').src = objProducto.url_productImg;
                } else {
                    document.querySelector('.prevPhoto div').innerHTML = "<img id='img' src=" + objProducto.url_productImg + "/>";
                }

                if (objData.data.imagen == 'product.png') {
                    document.querySelector('.delPhoto').classList.add("notBlock");
                } else {
                    document.querySelector('.delPhoto').classList.remove("notBlock");
                }

                $('#modalFormProductos').modal('show');
            } else {
                swal("Error", objData.msg, "error");
            }
        }
    };
}

function fntDelInfo(idProducto) {
    swal({
        title: "Inhabilitar Producto",
        text: "¿Realmente quiere inhabilitar el producto?",
        icon: "warning",
        dangerMode: true,
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            {
                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxUrl = base_url + '/Productos/setStatusProducto';
                let status = 0;
                let formData = new FormData();
                formData.append("idProducto", idProducto);
                formData.append("status", status);
                request.open("POST", ajaxUrl, true);
                request.send(formData);
                request.onreadystatechange = function () {
                    if (request.readyState == 4 && request.status == 200) {
                        let objData = JSON.parse(request.responseText);
                        if (objData.status)
                        {
                            swal("Inhabilitado!", objData.msg, "success");
                            tableProductos.api().ajax.reload();
                        } else {
                            swal("Atención!", objData.msg, "error");
                        }
                    }
                };
            }
        }
    });

}

function fntActiveInfo(idProducto) {
    swal({
        title: "Activar Producto",
        text: "¿Realmente quiere dejar activo el producto?",
        icon: "info",
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            {
                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxUrl = base_url + '/Productos/setStatusProducto';
                let status = 1;
                let formData = new FormData();
                formData.append("idProducto", idProducto);
                formData.append("status", status);
                request.open("POST", ajaxUrl, true);
                request.send(formData);
                request.onreadystatechange = function () {
                    if (request.readyState == 4 && request.status == 200) {
                        let objData = JSON.parse(request.responseText);
                        if (objData.status)
                        {
                            swal("Activado!", objData.msg, "success");
                            tableProductos.api().ajax.reload();
                        } else {
                            swal("Atención!", objData.msg, "error");
                        }
                    }
                };
            }
        }
    });
}

function fntCategorias() {
    if (document.querySelector('#listCategoria')) {
        $.ajax({
            type: "POST",
            url: base_url + '/Categorias/getSelectCategorias',
            success: function (data) {
                $('.selectCategoria select').html(data).fadeIn();
            }
        });
    }
}

function openModal() {
    rowTable = "";
    document.querySelector('#idProducto').value = "";
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Producto";
    document.querySelector("#formProductos").reset();
    $('#modalFormProductos').modal('show');
}

