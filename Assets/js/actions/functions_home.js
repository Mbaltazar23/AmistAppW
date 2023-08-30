new Vue({
    el: '#app',
    data: {
        strRut: '',
        strPassword: ''
    },
    methods: {
        loginUser() {
            if (!this.strRut) {
                swal("Error !!", "Por favor, ingrese su rut...", "error");
                return;
            } else if (!this.strPassword) {
                swal("Error !!", "Por favor, ingrese su contraseña...", "error");
                return;
            } else if (this.strPassword.length > 20) {
                swal("Error", "La contraseña ingresada no es válida...", "error");
                return;
            }
            // Realizar la llamada AJAX a través de Vue.js
            let formLogin = document.querySelector("#formLogin");
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url + '/Home/loginUser';
            var formData = new FormData(formLogin);
            request.open("POST", ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = function () {
                if (request.readyState != 4) 
                    return;
                
                if (request.status == 200) {
                    var objData = JSON.parse(request.responseText);
                    // console.log(objData.userData.nombreRol);
                    if (objData.status) {
                        swal({
                            title: "Exito !",
                            text: "Bienvenido(a) señor(a) " + objData.userData.nombre,
                            icon: "success"
                        }).then(function () {
                            window.location = base_url + '/dashboard';
                        });
                    } else {
                        swal("Atención", objData.msg, "error");
                        document.querySelector('#txtPassword').value = "";
                    }
                } else {
                    swal("Atención", "Error en el proceso", "error");
                }
                return false;
            };
        },
        formatRut() { // La función de validación del RUT aquí
            let value = this.strRut.replace(/\./g, '').replace('-', '');
            if (value.match(/^(\d{2})(\d{3}){2}(\w{1})$/)) {
                value = value.replace(/^(\d{2})(\d{3})(\d{3})(\w{1})$/, '$1.$2.$3-$4');
            } else if (value.match(/^(\d)(\d{3}){2}(\w{0,1})$/)) {
                value = value.replace(/^(\d)(\d{3})(\d{3})(\w{0,1})$/, '$1.$2.$3-$4');
            } else if (value.match(/^(\d)(\d{3})(\d{0,2})$/)) {
                value = value.replace(/^(\d)(\d{3})(\d{0,2})$/, '$1.$2.$3');
            } else if (value.match(/^(\d)(\d{0,2})$/)) {
                value = value.replace(/^(\d)(\d{0,2})$/, '$1.$2');
            }
            this.strRut = value;
        }
    },
    mounted() {
        this.$nextTick(() => {
            document.getElementById('txtRut').addEventListener('input', this.formatRut);
        });
    },
    beforeDestroy() {
        document.getElementById('txtRut').removeEventListener('input', this.formatRut);
    }
});
