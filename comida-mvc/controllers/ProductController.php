<?php

class ProductController {
    private $productModel;
    public function __construct($productModel) {
        $this->productModel = $productModel;
    }
    public function index() {
        $productos = $this->productModel->getAll();
        include 'views/inicio.php';
    }
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];
            $imagen = $_POST['imagen'];
            $this->productModel->add($nombre, $descripcion, $precio, $imagen);
            header("Location: /productos");
        } else {
            include 'views/add.php';
        }
    }
    public function delete($id) {
        $this->productModel->delete($id);
        header("Location: /productos");
    }
}
?>