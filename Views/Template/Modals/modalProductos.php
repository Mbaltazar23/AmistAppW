<!-- Modal -->
<div class="modal fade" id="modalFormProductos">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleModal">Nueva Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <form @submit.prevent="submitForm" id="formProductos" name="formProductos" class="form-horizontal">
                    <input type="hidden" v-model="formData.idProducto" id="idProducto" name="idProducto" value="">
                    <input type="hidden" v-model="formData.foto_actual" id="foto_actual" name="foto_actual" value="">
                    <input type="hidden" v-model="formData.foto_remove" id="foto_remove" name="foto_remove" value="0">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="control-label">Nombre</label>
                            <input class="form-control" v-model="formData.nombre" id="txtNombre" name="txtNombre" type="text">
                        </div>
                        <div class="form-group col-md-6 selectCategoria">
                            <label for="listCategoria">Categoría</label>
                            <select class="form-control" id="listCategoria" name="listCategoria" v-model="formData.categoria">
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="control-label">Precio</label>
                            <input class="form-control" v-model="formData.precio" id="txtPrecio" name="txtPrecio" type="text">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Stock <span class="required">*</span></label>
                            <input class="form-control" v-model="formData.stock" id="txtStock" name="txtStock" type="text">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="photo">
                            <label for="foto">Agregar Portada</label>
                            <div class="prevPhoto">
                            <span class="delPhoto notBlock" @click="removePhoto">X</span>
                                <label for="foto"></label>
                                <div>
                                <img id="img" :src="fotoUrl ? fotoUrl : '<?=media();?>/img/products/product.png'">
                                </div>
                            </div>
                            <div class="upimg">
                            <input type="file" name="foto" id="foto" @change="onFotoChange">
                            </div>
                            <div id="form_alert"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-check-circle"></i>&nbsp;&nbsp;<span id="btnText">Guardar</span></button>
                        <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalViewProducto" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleModal">Datos del Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <td>Nombre:</td>
                        <td>{{ productoDetalle.nombre }}</td>
                    </tr>
                    <tr>
                        <td>Precio:</td>
                        <td>{{ productoDetalle.precio }}</td>
                    </tr>
                    <tr>
                        <td>Categoría:</td>
                        <td>{{ productoDetalle.categoria }}</td>
                    </tr>
                    <tr>
                        <td>Stock:</td>
                        <td>{{ productoDetalle.stock }}</td>
                    </tr>
                    <tr>
                        <td>Fecha:</td>
                        <td>{{ productoDetalle.fecha }}</td>
                    </tr>
                    <tr>
                        <td>Hora:</td>
                        <td>{{ productoDetalle.hora }}</td>
                    </tr>
                    <tr>
                        <td>Status:</td>
                        <td v-html="productoDetalle.status"></td>
                    </tr>
                    <tr>
                        <td>Foto:</td>
                        <td v-html="productoDetalle.foto"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

