let tableNotificaciones, tableQuestions;
let rowTable = "";
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
            {"data": "mensaje"},
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
            let idNot = document.querySelector("#idNotificacion").value;
            let questionAndAnswers = [];

            if (listTipoNotificacion == '') {
                swal("Error !!", "No selecciono el tipo de Notificacion a registrar !!", "error");
                return false;
            } else {
                if (listTipoNotificacion == "Pregunta") {
                    var title = document.getElementById("titleQuestion").value;
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

                    if (!title || !question || !answer1 || !advice1 || !answer2 || !advice2 || !answer3 || !advice3) {
                        swal("Error !!", "Faltan campos por completar !!", "error");
                        return false;
                    }

                    $.ajax({
                        type: "POST",
                        url: base_url + "/Notificaciones/setNotificacion",
                        data: {idNotificacion: idNot, Question: question, Answers: questionAndAnswers,
                            listTipoNotificacion: listTipoNotificacion, title: title},
                        success: function (data) {
                            let objData = JSON.parse(data);
                            if (objData.status) {
                                tableNotificaciones.api().ajax.reload();
                                $('#modalFormNotificaciones').modal('hide');
                                swal("Exito !!", objData.msg, "success");
                            } else {
                                swal("Error", objData.msg, "error");
                            }
                        }
                    });
                } else {
                    var message = document.getElementById('message').value;
                    var response = document.getElementById('response').value;
                    var advice = document.getElementById('advice').value;
                    var titleMessage = document.getElementById('titleMessage').value;

                    if (!message || !response || !advice || !titleMessage) {
                        swal("Error !!", "Faltan campos por completar !!", "error");
                        return false;
                    }

                    $.ajax({
                        type: "POST",
                        url: base_url + "/Notificaciones/setNotificacion",
                        data: {
                            Message: message,
                            Response: response,
                            Advice: advice,
                            title: titleMessage
                        },
                        success: function (data) {
                            let objData = JSON.parse(data);
                            if (objData.status) {
                                tableNotificaciones.api().ajax.reload();
                                $('#modalFormNotificaciones').modal('hide');
                                swal("Exito !!", objData.msg, "success");
                            } else {
                                swal("Error", objData.msg, "error");
                            }
                        }
                    });

                }
            }
        };
    }

    if (document.querySelector("#formQuestions")) {
        let formQuestions = document.querySelector("#formQuestions");
        formQuestions.onsubmit = function (e) {
            e.preventDefault();

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
    vaciarCampos();
}

function cambiarDisplay(value) {
    if (value == "Pregunta") {
        document.querySelector("#notificacionesPreguntas").style.display = "block";
        document.querySelector(".modal-dialog").classList.add("modal-lg");
        document.querySelector("#notificacionesMessage").style.display = "none";
        vaciarCampos();
    } else if (value == "Video/Mensaje") {
        document.querySelector("#notificacionesPreguntas").style.display = "none";
        document.querySelector(".modal-dialog").classList.remove("modal-lg");
        document.querySelector("#notificacionesMessage").style.display = "block";
        vaciarCampos();
    } else {
        document.querySelector("#notificacionesPreguntas").style.display = "none";
        document.querySelector("#notificacionesMessage").style.display = "none";
        document.querySelector(".modal-dialog").classList.remove("modal-lg");
        vaciarCampos();
    }
}


function vaciarCampos() {
    document.querySelector("#notificacionesPreguntas input[type='text']").value = '';
    document.querySelector("#notificacionesMessage textarea").value = '';
    document.querySelector("#notificacionesPreguntas textarea").value = '';
}

function fntViewInfo(nro, idNotificacion) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Notificaciones/getNotificacion/' + idNotificacion;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status)
            {

            }
        }
    };
}


function fntEditInfo(element, idNotificacion) {
    rowTable = element.parentNode.parentNode.parentNode;
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Notificaciones/getNotificacion/' + idNotificacion;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status)
            {
                if (objData.data.tipo == "Pregunta") {
                    viewListPreguntaNotificacion(objData.data);
                } else {
                    viewFormVideoMessageNotificacion(objData.data);
                }
            }
        }
    };
}

function viewListPreguntaNotificacion(arrNotificacion) {
    document.querySelector('#titleModalL').innerHTML = "Preguntas de la Notificacion - " + arrNotificacion.mensaje;
    loadQuestions(arrNotificacion.id);
    document.querySelector("#btnAddQuestion").addEventListener("click", function () {
        viewFormPreguntaNotificacion(arrNotificacion.id);
    });
    $("#modalQuestionList").modal('show');
}

function loadQuestions(idNotificacion) {
    tableQuestions = $('#tableQuestions').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " " + base_url + "/Notificaciones/getQuestionsNotificacion/" + idNotificacion,
            "dataSrc": ""
        },
        "columns": [
            {"data": "nro"},
            {"data": "pregunta"},
            {"data": "fecha"},
            {"data": "hora"},
            {"data": "options"}
        ],
        responsive: true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "asc"]]
    });
}

function viewFormPreguntaNotificacion(idNotificacion) {
    $('#bodyQuestion').html($('#notificacionesPreguntas').html());
    document.querySelector('#titleModalQ').innerHTML = "Nueva Pregunta a la Notificacion";
    document.querySelector("#idNotificacionQ").value = idNotificacion;
    $("#modalFormNotificacionesQ").modal('show');
}

function fntEditQuestionInfo(element, idQuestion) {
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModalQ').innerHTML = "Actualizar Pregunta de la Notificacion";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Notificaciones/getQuestion/' + idQuestion;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status)
            {
                $('#bodyQuestion').html($('#notificacionesPreguntas').html());
                $("#question").val(objData.data.pregunta);
                let objAnswers = objData.data.answers;
                console.log(objData.data);
                console.log(objData.data.answers);
                document.querySelector("#idNotificacionQ").value = objData.data.idNot;
                for (let i = 0; i < objAnswers.length; i++) {
                    document.getElementById(`idanswer${i + 1}`).value = objAnswers[i].id;
                    document.getElementById(`answer${i + 1}`).value = objAnswers[i].respuesta;
                    document.getElementById(`advice${i + 1}`).value = objAnswers[i].consejo;
                }

                $("#modalFormNotificacionesQ").modal('show');
            }

        }
    };
}

function viewFormVideoMessageNotificacion(arrNotificacion) {
    document.querySelector('#titleModal').innerHTML = "Actualizar Notificacion";
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";
    cambiarDisplay(arrNotificacion.tipo);
}


