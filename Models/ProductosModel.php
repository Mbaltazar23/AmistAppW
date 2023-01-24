<?php

class ProductosModel extends Mysql {

    private $intIdProducto;
    private $strNombre;
    private $strImage;
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
        $sql = "SELECT pro.id, pro.nombre, pro.precio,pro.stock,pro.imagen, ct.nombre as categoria, pro.status FROM productos pro
                INNER JOIN categorias ct ON pro.categoria_id = ct.id $validateStatus";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectProducto(int $idproducto) {
        $this->intIdProducto = $idproducto;
        $sql = "SELECT pro.id, pro.nombre, DATE_FORMAT(pro.created_at, '%d/%m/%Y') as fecha, 
               DATE_FORMAT(pro.created_at, '%H:%i:%s') as hora, pro.categoria_id, pro.precio, pro.status, 
               pro.stock,pro.imagen,ct.nombre as categoria FROM productos pro
                INNER JOIN categorias ct ON pro.categoria_id = ct.id WHERE pro.id = $this->intIdProducto";
        $request = $this->select($sql);
        return $request;
    }

    public function insertProducto(string $nombre, int $categoria_id, int $precio, int $stock, string $imagen) {
        $this->strNombre = $nombre;
        $this->intCategoriaId = $categoria_id;
        $this->decPrecio = $precio;
        $this->intStock = $stock;
        $this->strImage = $imagen;
        $return = 0;
        $sql = "SELECT * FROM productos WHERE nombre = '{$this->strNombre}'";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_insert = "INSERT INTO productos(nombre,categoria_id,precio,stock,imagen) VALUES (?,?,?,?,?)";
            $arrData = array($this->strNombre,
                $this->intCategoriaId,
                $this->decPrecio,
                $this->intStock,
                $this->strImage);
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    public function updateProducto(int $id, string $nombre, int $categoria_id, int $precio, int $stock, string $imagen) {
        $this->intIdProducto = $id;
        $this->strNombre = $nombre;
        $this->intCategoriaId = $categoria_id;
        $this->decPrecio = $precio;
        $this->intStock = $stock;
        $this->strImage = $imagen;
        $return = 0;
        $sql = "SELECT * FROM productos WHERE nombre = '{$this->strNombre}' AND id != $this->intIdProducto";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_update = "UPDATE productos SET nombre = ?, categoria_id = ?, precio = ?, stock = ?, imagen=?  WHERE id = $this->intIdProducto";
            $arrData = array($this->strNombre,
                $this->intCategoriaId,
                $this->decPrecio,
                $this->intStock,
                $this->strImage);
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