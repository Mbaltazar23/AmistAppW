new Vue({
    el: '#app-product',
    data: {
        productos: [],
        productoDetalle: {},
        formData: {
            idProducto: '',
            nombre: '',
            precio: '',
            stock: '',
            foto_actual: '',
            foto_remove: 0
        },
        tableProductos: '', // Variable para mantener el DataTable
        foto: null,
        fotoUrl: '',
        url: 'http://localhost/AmistAppWeb'
    },
    methods: {
        // ... (otros métodos existentes)
        onFotoChange(event) {
            const fileInput = event.target;
            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];
                if (file.type !== 'image/jpeg' && file.type !== 'image/jpg' && file.type !== 'image/png') {
                    swal("Error", "El archivo no es válido.", "error");
                    fileInput.value = '';
                    return;
                }
                this.foto = file;
                this.fotoUrl = URL.createObjectURL(file);
            }
        },
        removePhoto() {
            this.foto = null;
            this.fotoUrl = '';
            this.formData.foto_remove = 1;
        },
        submitForm() {
            let strNombre = this.formData.nombre;
            let strPrecio = this.formData.precio;
            let intStock = this.formData.stock;
            if (strNombre === '' || strPrecio === '' || intStock === '') {
                swal("Atención", "Todos los campos son obligatorios.", "error");
                return;
            }

            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = this.url + '/Productos/setProducto';
            let formProductos = document.querySelector("#formProductos");
            let formData = new FormData(formProductos);

            // ... (agregar otros campos si es necesario)
            request.open("POST", ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = () => {
                if (request.readyState === 4 && request.status === 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        this.tableProductos.api().ajax.reload();
                        swal("Éxito !!", objData.msg, "success");
                        $('#modalFormProductos').modal('hide');
                    } else {
                        swal("Error", objData.msg, "error");
                    }
                }
            };
        },
        fntViewInfo(idProducto) {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = this.url + '/Productos/getProducto/' + idProducto;
            request.open("POST", ajaxUrl, true);
            request.send();
            request.onreadystatechange = () => {
                if (request.readyState === 4 && request.status === 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        let objProducto = objData.data;
                        let estadoProducto = objProducto.status == 1 ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>';

                        this.productoDetalle = {
                            nombre: objProducto.nombre,
                            precio: objProducto.precioP,
                            stock: objProducto.stock,
                            categoria: objProducto.categoria,
                            fecha: objProducto.fecha,
                            hora: objProducto.hora,
                            status: estadoProducto,
                            foto: '<img src="' + objProducto.url_productImg + '" width="120" height="100"/>'
                        };

                $('#modalViewProducto').modal('show');
                    } else {
                        swal("Error", objData.msg, "error");
                    }
                }
            };
        },
        fntEditInfo(element, idProducto) {
            rowTable = element.parentNode.parentNode.parentNode;
            this.formData.idProducto = idProducto;
            this.formData.foto_remove = 0;

            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = this.url + '/Productos/getProducto/' + idProducto;
            let formData = new FormData();
            request.open("POST", ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = () => {
                if (request.readyState === 4 && request.status === 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        let objProducto = objData.data;
                        this.formData.nombre = objProducto.nombre.toString().toLowerCase();
                        this.formData.precio = Math.round(objProducto.precio);
                        this.formData.stock = objProducto.stock;
                        this.formData.categoria = objProducto.categoria_id;
                        this.formData.foto_actual = objData.data.imagen;

                        if (objData.data.imagen == 'product.png') {
                            this.formData.foto_remove = 1;
                        }

                        $('#modalFormProductos').modal('show');
                    } else {
                        swal("Error", objData.msg, "error");
                    }
                }
            };
        },
        fntDelInfo(idProducto) {
            swal({
                title: "Inhabilitar Producto",
                text: "¿Realmente quiere inhabilitar el producto?",
                icon: "warning",
                dangerMode: true,
                buttons: true
            }).then((isClosed) => {
                if (isClosed) {
                    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    let ajaxUrl = this.url + '/Productos/setStatusProducto';
                    let status = 0;
                    let formData = new FormData();
                    formData.append("idProducto", idProducto);
                    formData.append("status", status);
                    request.open("POST", ajaxUrl, true);
                    request.send(formData);
                    request.onreadystatechange = () => {
                        if (request.readyState === 4 && request.status === 200) {
                            let objData = JSON.parse(request.responseText);
                            if (objData.status) {
                                swal("Inhabilitado!", objData.msg, "success");
                                this.tableProductos.api().ajax.reload();
                            } else {
                                swal("Atención!", objData.msg, "error");
                            }
                        }
                    };
                }
            });
        },
        fntActiveInfo(idProducto) {
            swal({title: "Activar Producto", text: "¿Realmente quiere dejar activo el producto?", icon: "info", buttons: true}).then((isClosed) => {
                if (isClosed) {
                    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    let ajaxUrl = this.url + '/Productos/setStatusProducto';
                    let status = 1;
                    let formData = new FormData();
                    formData.append("idProducto", idProducto);
                    formData.append("status", status);
                    request.open("POST", ajaxUrl, true);
                    request.send(formData);
                    request.onreadystatechange = () => {
                        if (request.readyState === 4 && request.status === 200) {
                            let objData = JSON.parse(request.responseText);
                            if (objData.status) {
                                swal("Activado!", objData.msg, "success");
                                this.tableProductos.api().ajax.reload();
                            } else {
                                swal("Atención!", objData.msg, "error");
                            }
                        }
                    };
                }
            });
        },
        fntCategorias() {
            if (document.querySelector('#listCategoria')) {
                $.ajax({
                    type: "POST",
                    url: this.url + '/Categorias/getSelectCategorias',
                    success: function (data) {
                        $('.selectCategoria select').html(data).fadeIn();
                    }
                });
            }
        },
        openModal() {
            this.formData.idProducto = '';
            this.formData.foto_actual = '';
            this.formData.foto_remove = 0;
            this.formData.nombre = '';
            this.formData.precio = '';
            this.formData.stock = '';
            this.formData.categoria = '';

            this.foto = null;
            this.fotoUrl = '';

            $('#modalFormProductos').modal('show');

            this.$nextTick(() => {
                document.querySelector('#btnActionForm').classList.replace('btn-info', 'btn-primary');
                document.querySelector('#btnText').innerHTML = 'Guardar';
                document.querySelector('#titleModal').innerHTML = 'Nuevo Producto';
            });
        },
        loadDatatable() {
            this.tableProductos = $('#tableProductos').dataTable({
                "aProcessing": true,
                "aServerSide": true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                },
                "ajax": {
                    "url": " " + this.url + "/Productos/getProductos",
                    "dataSrc": ""
                },
                "columns": [
                    {
                        "data": "nombreP"
                    },
                    {
                        "data": "precioP"
                    },
                    {
                        "data": "stock"
                    },
                    {
                        "data": "categoria"
                    }, {
                        "data": "status"
                    }, {
                        "data": "options"
                    }
                ],
                responsive: true,
                "bDestroy": true,
                "iDisplayLength": 10,
                "order": [
                    [0, "desc"]
                ]
            });
        }

    },
    mounted() { // Inicializar DataTable
        this.loadDatatable(),
        this.fntCategorias() // Cargar las categorías al cargar la página
    }
});
