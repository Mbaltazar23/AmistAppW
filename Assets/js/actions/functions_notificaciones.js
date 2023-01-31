let tableNotificaciones;
$(document).on('focusin', function (e) {
    if ($(e.target).closest(".tox-dialog").length) {
        e.stopImmediatePropagation();
    }
});


document.addEventListener('DOMContentLoaded', function () {

    tableNotificaciones = $('#tableNotificaciones').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " " + base_url + "/Notificaciones/getNotificaciones",
            "dataSrc": ""
        },
        "columns": [
            {"data": "nro"},
            {"data": "tipo"},
            {"data": "fecha"},
            {"data": "status"},
            {"data": "options"}
        ],
        responsive: true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "asc"]]
    });

    if (document.querySelector("#formNotificaciones")) {
        let formNotificaciones = document.querySelector("#formNotificaciones");
        formNotificaciones.onsubmit = function (e) {
            e.preventDefault();
            let listTipoNotificacion = document.querySelector("#listTipoNotificacion").value;
            let questionAndAnswers = [];
            if (listTipoNotificacion == '') {
                swal("Error !!", "No selecciono el tipo de Notificacion a registrar !!", "error");
                return false;
            } else {
                if (listTipoNotificacion == "Pregunta") {
                    var question = document.getElementById("question").value;
                    var answer1 = document.getElementById("answer1").value;
                    var advice1 = document.getElementById("advice1").value;
                    var answer2 = document.getElementById("answer2").value;
                    var advice2 = document.getElementById("advice2").value;
                    var answer3 = document.getElementById("answer3").value;
                    var advice3 = document.getElementById("advice3").value;

                    var answers = [
                        {answer: answer1, advice: advice1},
                        {answer: answer2, advice: advice2},
                        {answer: answer3, advice: advice3}
                    ];

                    questionAndAnswers = {answers: answers};
                    console.log("preguntas:" + question + "  " + questionAndAnswers);
                } else {

                }

            }
        };
    }
}, false);


function openModal() {
    document.querySelector('#idNotificacion').value = "";
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nueva Notificacion";
    document.querySelector("#formNotificaciones").reset();
    document.querySelector("#notificacionesPreguntas").style.display = "none";
    document.querySelector("#notificacionesMessage").style.display = "none";
    document.querySelector(".modal-dialog").classList.remove("modal-lg");
    $('#modalFormNotificaciones').modal('show');
}
$("#listTipoNotificacion").change(function () {
    if ($(this).val() == "Pregunta") {
        document.querySelector("#notificacionesPreguntas").style.display = "block";
        document.querySelector(".modal-dialog").classList.add("modal-lg");
        document.querySelector("#notificacionesMessage").style.display = "none";
    } else if ($(this).val() == "Video/Mensaje") {
        document.querySelector("#notificacionesPreguntas").style.display = "none";
        document.querySelector(".modal-dialog").classList.remove("modal-lg");
        document.querySelector("#notificacionesMessage").style.display = "block";
    } else {
        document.querySelector("#notificacionesPreguntas").style.display = "none";
        document.querySelector("#notificacionesMessage").style.display = "none";
        document.querySelector(".modal-dialog").classList.remove("modal-lg");
    }
});





