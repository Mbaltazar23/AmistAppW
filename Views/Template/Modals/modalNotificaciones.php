<!-- Modal FormNotifiaciones-->
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
                    <div class="form-group">
                        <label for="listTipoNotificacion">Tipo</label>
                        <select class="form-control" id="listTipoNotificacion" name="listTipoNotificacion">
                            <option value="">Seleccione el tipo de notificacion</option>
                            <option value="Pregunta">Pregunta</option>
                            <option value="Video/Mensaje">Video/Mensaje</option>
                        </select>
                    </div>
                    <div id="notificacionesPreguntas" style="display:none">
                        <div class="form-group">
                            <label for="question">Pregunta:</label>
                            <input type="text" class="form-control" id="question" name="question">
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="answer1">Alternativa 1:</label>
                                <input type="text" id="answer1" class="form-control" name="answer1">
                                <label for="advice1">Consejo 1:</label>
                                <textarea id="advice1" name="advice1" class="form-control"></textarea>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="answer2">Alternativa 2:</label>
                                <input type="text" id="answer2" class="form-control" name="answer2">
                                <label for="advice2">Consejo 2:</label>
                                <textarea id="advice2" class="form-control" name="advice2"></textarea>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="answer3">Alternativa 3:</label>
                                <input type="text" id="answer3" class="form-control" name="answer3">
                                <label for="advice3">Consejo 3:</label>
                                <textarea id="advice3" class="form-control" name="advice3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div id="notificacionesMessage" style="display:none">
                        <div class="form-group">
                            <label for="message">Mensaje:</label>
                            <textarea id="message" class="form-control" name="message"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="response">Respuesta:</label>
                            <textarea id="response" class="form-control" name="response"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="advice">Consejo:</label>
                            <textarea id="advice" class="form-control" name="advice"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-times-circle"></i>&nbsp;Cerrar</button>
                        <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-check-circle"></i>&nbsp;<span id="btnText">Guardar</span></button>&nbsp;&nbsp;
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>