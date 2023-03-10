let tableCategorias;
let rowTable = "";
document.addEventListener('DOMContentLoaded', function () {
    tableCategorias = $('#tableCategorias').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " " + base_url + "/Categorias/getCategorias",
            "dataSrc": ""
        },
        "columns": [
            {"data": "nro"},
            {"data": "nombre"},
            {"data": "fecha"},
            {"data": "hora"},
            {"data": "status"},
            {"data": "options"}
        ],
        "paging": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "asc"]]
    });

    //NUEVA CATEGORIA
    let formCategoria = document.querySelector("#formCategoria");
    formCategoria.onsubmit = function (e) {
        e.preventDefault();
        let strNombre = document.querySelector('#txtNombre').value;
        if (strNombre == '')
        {
            swal("Atención", "Debe ingresar un nombre..", "error");
            return false;
        } else {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/Categorias/setCategoria';
            let formData = new FormData(formCategoria);
            request.open("POST", ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {

                    let objData = JSON.parse(request.responseText);
                    if (objData.status)
                    {
                        tableCategorias.api().ajax.reload();
                        $('#modalFormCategorias').modal("hide");
                        formCategoria.reset();
                        swal("Exito !!", objData.msg, "success");
                    } else {
                        swal("Error", objData.msg, "error");
                    }
                }
                return false;
            };
        }
    };

}, false);

function fntViewInfo(nro, idcategoria) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Categorias/getCategoria/' + idcategoria;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status)
            {
                let estado = objData.data.status == 1 ?
                        '<span class="badge badge-success">Activo</span>' :
                        '<span class="badge badge-danger">Inactivo</span>';
                document.querySelector("#celNro").innerHTML = nro;
                document.querySelector("#celNombre").innerHTML = objData.data.nombre;
                document.querySelector("#celEstado").innerHTML = estado;
                document.querySelector("#celFecha").innerHTML = objData.data.fecha;
                document.querySelector("#celHora").innerHTML = objData.data.hora;
                $('#modalViewCategoria').modal('show');
            } else {
                swal("Error", objData.msg, "error");
            }
        }
    };
}

function fntEditInfo(element, idcategoria) {
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML = "Actualizar Categoría";
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Categorias/getCategoria/' + idcategoria;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status)
            {
                document.querySelector("#idCategoria").value = objData.data.id;
                document.querySelector("#txtNombre").value = String(objData.data.nombre).toLowerCase();

                $('#modalFormCategorias').modal('show');

            } else {
                swal("Error", objData.msg, "error");
            }
        }
    };
}

function fntDelInfo(idcategoria) {
    swal({
        title: "Inhabilitar Categoría",
        text: "¿Realmente quiere inhabilitar al categoría?",
        icon: "warning",
        dangerMode: true,
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/Categorias/setStatusCategoria';
            let strData = "idCategoria=" + idcategoria + "&status=0";
            request.open("POST", ajaxUrl, true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status)
                    {
                        swal("Inhabilitada!", objData.msg, "success");
                        tableCategorias.api().ajax.reload();
                    } else {
                        swal("Atención!", objData.msg, "error");
                    }
                }
            };
        }
    });

}

function fntActivateInfo(idcategoria) {
    swal({
        title: "Habilitar Categoría",
        text: "¿Realmente quiere habilitar esta categoría?",
        icon: "info",
        dangerMode: true,
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/Categorias/setStatusCategoria';
            let strData = "idCategoria=" + idcategoria + "&status=1";
            request.open("POST", ajaxUrl, true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status)
                    {
                        swal("Activada!", objData.msg, "success");
                        tableCategorias.api().ajax.reload();
                    } else {
                        swal("Atención!", objData.msg, "error");
                    }
                }
            };
        }
    });

}

function openModal() {
    document.querySelector('#idCategoria').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nueva Categoría";
    document.querySelector("#formCategoria").reset();
    $('#modalFormCategorias').modal('show');
}



function generarReporte() {
    $.post(base_url + "/Categorias/getCategoriasReport",
            function (response) {
                var fecha = new Date();
                let categorias = JSON.parse(response);
                //console.log(notificaciones);
                //console.log(tecnicos);
                let estado = "";
                var pdf = new jsPDF();
                var columns = ["NRO", "NOMBRE", "FECHA", "HORA", "ESTADO"];
                var data = [];


                for (let i = 0; i < categorias.length; i++) {
                    if (categorias[i].status == 1) {
                        estado = "ACTIVO";
                    } else {
                        estado = "INACTIVO";
                    }
                    data[i] = [(i + 1), categorias[i].nombre, categorias[i].fecha, categorias[i].hora, estado];

                }


                pdf.text(20, 20, "Reportes de las Categorias Registradas");

                pdf.autoTable(columns, data, {
                    startY: 40,
                    styles: {
                        cellPadding: 10,
                        fontSize: 8,
                        font: 'helvetica',
                        textColor: [0, 0, 0],
                        fillColor: [255, 255, 255],
                        lineWidth: 0.1,
                        halign: 'center',
                        valign: 'middle'
                    }
                });



                pdf.text(20, pdf.autoTable.previous.finalY + 20, "Fecha de Creacion : " + fecha.getDate() + "/" + (fecha.getMonth() + 1) + "/" + fecha.getFullYear());
                pdf.save('ReporteCategorias.pdf');
                swal('Exito', "Reporte Imprimido Exitosamente..", 'success');

            }
    );
}