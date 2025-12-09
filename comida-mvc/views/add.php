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
            $nombre = trim($_POST['nombre']);
            $descripcion = trim($_POST['descripcion']);
            $precio = (float)$_POST['precio'];
            $imagen = null;

            if (!empty($_FILES['imagen']['name'])) {
                $uploadDir = __DIR__ . '/../public/img/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $imagen = basename($_FILES['imagen']['name']);
                move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadDir . $imagen);
            }

            $this->productModel->add($nombre, $descripcion, $precio, $imagen);

            header("Location: /productos");
            exit;
        } else {
            include 'views/add.php';
        }
    }

    public function delete($id) {
        $this->productModel->delete($id);
        header("Location: /productos");
        exit;
    }
}
?>
