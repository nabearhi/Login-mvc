<?php
namespace controllers;

use models\Product;

class CartController {

    private function ensureSession(): void {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public function add(): void {
        $this->ensureSession();

        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) {
            $_SESSION['error'] = 'ID inválido';
            header('Location: /inicio');
            exit;
        }

        $productoModel = new Product();
        $producto = null;
        foreach ($productoModel->getAll() as $p) {
            if ((int)$p['id'] === $id) {
                $producto = $p;
                break;
            }
        }

        if ($producto) {
            if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            $_SESSION['cart'][] = $producto;
        }

        $_SESSION['open_cart_modal'] = true; // bandera para abrir modal
        header('Location: /inicio');
        exit;
    }

    public function clear(): void {
        $this->ensureSession();
        $_SESSION['cart'] = [];
        $_SESSION['open_cart_modal'] = true;
        header('Location: /inicio');
        exit;
    }

    public function view(): void {
        $this->ensureSession();
        $cart = $_SESSION['cart'] ?? [];
        require __DIR__ . '/../views/cart.php';
    }

    public function remove(): void {
        $this->ensureSession();
        $id = (int)($_POST['id'] ?? 0);
        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $index => $item) {
                if ((int)$item['id'] === $id) {
                    unset($_SESSION['cart'][$index]);
                    break;
                }
            }
            $_SESSION['cart'] = array_values($_SESSION['cart']);
        }
        $_SESSION['open_cart_modal'] = true;
        header('Location: /inicio');
        exit;
    }
}
