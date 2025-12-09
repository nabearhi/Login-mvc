<?php
namespace controllers;

use models\Product;

class HomeController {
    public function index(): void {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
        $user = $_SESSION['user'];

        if ($user['role'] === 'admin') {
            require __DIR__ . '/../views/admin.php';
        } else {
            $productModel = new Product();
            $productos = $productModel->getAll();
            require __DIR__ . '/../views/inicio.php';
        }
    }
}
