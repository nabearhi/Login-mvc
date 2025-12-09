<?php
namespace controllers;

use models\User;
use models\Product;
use database\Database; 

class AdminController {

    public function index(): void {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        header('Location: /login');
        exit;
    }
    

    \database\Database::getConnection();


    $users = User::getAll();
    $productoModel = new Product();
    $productos = $productoModel->getAll();
    $user = $_SESSION['user'];

    require __DIR__ . '/../views/admin.php';
}


    public function changeRole(): void {
        $id = (int)$_POST['id'];
        $role = $_POST['role'] ?? 'user';
        User::updateRole($id, $role);
        header('Location: /admin');
        exit;
    }

    public function deleteUser(): void {
        $id = (int)$_POST['id'];
        User::delete($id);
        header('Location: /admin');
        exit;
    }

    public function addProduct(): void {
        $nombre      = trim($_POST['nombre'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $precio      = (float)($_POST['precio'] ?? 0);
        $imagen      = null;

        if (!empty($_FILES['imagen']['name'])) {
            $uploadDir = __DIR__ . '/../public/img';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $imagen = basename($_FILES['imagen']['name']);
            move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadDir . $imagen);
        }

        $productoModel = new Product();
        $productoModel->add($nombre, $descripcion, $precio, $imagen);

        header('Location: /admin');
        exit;
    }

    public function deleteProduct(): void {
        $id = (int)$_POST['id'];
        $productoModel = new Product();
        $productoModel->delete($id);
        header('Location: /admin');
        exit;
    }
}
