/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


// Detectar cambio en el campo "tipo"
$("#tipo").change(function () {
    // Obtener el valor seleccionado
    var tipo = $(this).val();
    // Mostrar los campos correspondientes
    if (tipo === "pregunta") {
        $("#campos-pregunta").show();
        $("#campos-consejo").hide();
        // Crear inputs para preguntas y respuestas
        $("#cantidad-preguntas").change(function () {
            var cantidad = $(this).val();
            var preguntas = "";
            for (var i = 1; i <= cantidad; i++) {
                preguntas += "<label for='pregunta-" + i + "'>Pregunta " + i + ":</label> <input type='text' id='pregunta-" + i + "' name='pregunta-" + i + "'>";
                for (var j = 1; j <= 3; j++) {
                    preguntas += "<label for='respuesta-" + i + "-" + j + "'>Respuesta " + i + "-" + j + ":</label> <input type='text' id='respuesta-" + i + "-" + j + "' name='respuesta-" + i + "-" + j + "'>";
                    preguntas += "<label for='consejo-" + i + "-" + j + "'>Consejo " + i + "-" + j + ":</label> <input type='text' id='consejo-" + i + "-" + j + "' name='consejo-" + i + "-" + j + "'>";
                }
            }
            $("#preguntas").html(preguntas);
        });
    } else {
        $("#campos-pregunta").hide();
        $("#campos-consejo").show();
    }
});


$("#btnAction").click(function (e) {
    e.preventDefault();
    var cantidad = $("#cantidad").val();

    //Arreglos vacios
    var preguntas = [];
    var respuestas_consejos = [];
    for (var i = 1; i <= cantidad; i++) {
        //Agrega la pregunta al arreglo de preguntas
        preguntas.push($("#pregunta-" + i).val());
        for (var j = 1; j <= 3; j++) {
            //Agrega la respuesta y el consejo al arreglo de respuestas_consejos
            respuestas_consejos.push({
                respuesta: $("#respuesta-" + i + "-" + j).val(),
                consejo: $("#consejo-" + i + "-" + j).val()
            });
        }
    }

})
