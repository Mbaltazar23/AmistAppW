<?php

class ProductosModel extends Mysql {

    private $intIdProducto;
    private $strNombre;
    private $intCategoriaId;
    private $decPrecio;
    private $intStock;
    private $intStatus;

    public function __construct() {
        parent::__construct();
    }

    public function selectProductos($status = null) {
        $validateStatus = "";
        if ($status != null) {
            $validateStatus = "WHERE pro.status = $status";
        }
        $sql = "SELECT pro.id, pro.nombre, pro.precio,pro.stock, ct.nombre as categoria FROM productos pro
                INNER JOIN categorias ct ON pro.categoria_id = ct.id $validateStatus";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectProducto(int $idproducto) {
        $this->intIdProducto = $idproducto;
        $sql = "SELECT pro.id, pro.nombre, pro.precio,pro.stock, ct.nombre as categoria FROM productos
                INNER JOIN categorias ON pro.categoria_id = ct.id WHERE pro.id = $this->intIdProducto";
        $request = $this->select($sql);
        return $request;
    }

    public function insertProducto(string $nombre, int $categoria_id, int $precio, int $stock) {
        $this->strNombre = $nombre;
        $this->intCategoriaId = $categoria_id;
        $this->decPrecio = $precio;
        $this->intStock = $stock;
        $return = 0;
        $sql = "SELECT * FROM productos WHERE nombre = '{$this->nombre}'";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_insert = "INSERT INTO productos(nombre,categoria_id,precio,stock) VALUES (?,?,?)";
            $arrData = array($this->nombre,
                $this->intCategoriaId,
                $this->status,
                $this->intStock);
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    public function updateProducto(int $id, string $nombre, int $categoria_id, int $precio, int $stock) {
        $this->intIdProducto = $id;
        $this->strNombre = $nombre;
        $this->intCategoriaId = $categoria_id;
        $this->decPrecio = $precio;
        $this->intStock = $stock;
        $return = 0;
        $sql = "SELECT * FROM productos WHERE nombre = '{$this->nombre}'";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_update = "UPDATE productos SET nombre = ?, categoria_id = ?, precio = ?, stock = ?WHERE id = $this->intIdProducto";
             $arrData = array($this->nombre,
                $this->intCategoriaId,
                $this->intStock);
            $request_update = $this->update($query_update, $arrData);
            $return = $request_update;
        } else {
            $return = "exist";
        }
        return $return;
    }

    public function updateStatusProducto(int $idproducto, int $status) {
        $this->intIdProducto = $idproducto;
        $this->intStatus = $status;
        $sql = "SELECT * FROM compras WHERE product_id  = $this->intIdProducto";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $sql = "UPDATE productos SET status = ? WHERE id = $this->intIdProducto";
            $arrData = array($this->intStatus);
            $request = $this->update($sql, $arrData);
            if ($request) {
                $request = 'ok';
            } else {
                $request = 'error';
            }
        } else {
            $request = 'exist';
        }
        return $request;
    }

}

?>