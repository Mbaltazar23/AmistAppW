<!-- Modal FormNotifiaciones para el insert/update para las notificacion (mayormente de tipo Video/Mensaje-->
<div class="modal fade" id="modalFormNotificaciones">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleModal"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formNotificaciones" name="formNotificaciones" class="form-horizontal">
                    <input type="hidden" id="idNotificacion" name="idNotificacion" value="">
                    <input type="hidden" id="idQuestion" name="idQuestion" value="">
                    <div class="form-group">
                        <label for="listTipoNotificacion">Tipo</label>
                        <select class="form-control" id="listTipoNotificacion" name="listTipoNotificacion" onchange="cambiarDisplay(this.value);">
                            <option value="">Seleccione el tipo de notificacion</option>
                            <option value="Pregunta">Pregunta</option>
                            <option value="Video/Mensaje">Video/Mensaje</option>
                        </select>
                    </div>
                    <div id="notificacionesPreguntas" style="display:none">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for>Titulo</label>
                                <input type="text" class="form-control" id="titleQuestion" name="titleQuestion" />
                            </div>
                            <div class="form-group col-md-6">
                                <label for="question">Pregunta:</label>
                                <input type="text" class="form-control" id="question" name="question">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="answer1">Alternativa 1:</label>
                                <input type="hidden" id="idanswer1" name="idanswer1" />
                                <input type="text" id="answer1" class="form-control" name="answer1">
                                <label for="advice1">Consejo 1:</label>
                                <textarea id="advice1" name="advice1" class="form-control"></textarea>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="answer2">Alternativa 2:</label>
                                <input type="hidden" id="idanswer2" name="idanswer2" />

                                <input type="text" id="answer2" class="form-control" name="answer2">
                                <label for="advice2">Consejo 2:</label>
                                <textarea id="advice2" class="form-control" name="advice2"></textarea>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="answer3">Alternativa 3:</label>
                                <input type="hidden" id="idanswer3" name="idanswer3" />
                                <input type="text" id="answer3" class="form-control" name="answer3">
                                <label for="advice3">Consejo 3:</label>
                                <textarea id="advice3" class="form-control" name="advice3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div id="notificacionesMessage" style="display:none">
                        <div class="form-group">
                            <label for>Titulo</label>
                            <input type="text" class="form-control" id="titleMessage" name="titleMessage" />
                        </div>
                        <div class="form-group">
                            <label for="message">Mensaje:</label>
                            <textarea id="message" class="form-control" name="message"></textarea>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="response">Respuesta:</label>
                                <textarea id="response" class="form-control" name="response"></textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="advice">Consejo:</label>
                                <textarea id="advice" class="form-control" name="advice"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Cerrar</button>
                        <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-check-circle"></i>&nbsp;&nbsp;<span id="btnText">Guardar</span></button>&nbsp;&nbsp;
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modalQuestionList">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleModalL"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <button type="button" class="btn btn-success" id="btnAddQuestion" >
                        Nueva pregunta
                    </button>
                </div>
                <div class="card-body">
                    <table id="tableQuestions" class="table table-hover table-striped table-responsive-lg" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Nro</th>
                                <th>Pregunta</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<!--Modal para añadir/actualizar las preguntas relacionadas a la notificacion seleccionada-->
<div class="modal fade" id="modalFormNotificacionesQ">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleModalQ"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formQuestions" name="formQuestions" class="form-horizontal">
                    <input type="hidden" id="idNotificacionQ" name="idNotificacionQ" value="">
                    <div id="bodyQuestion">
                        
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-times-circle"></i>&nbsp;Cerrar</button>
                        <button id="btnActionFormQ" class="btn btn-primary" type="submit"><i class="fa fa-check-circle"></i>&nbsp;<span id="btnTextQ">Guardar</span></button>&nbsp;&nbsp;
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>