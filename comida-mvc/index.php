<?php
declare(strict_types=1);

session_start();

spl_autoload_register(function ($class) {
    $path = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($path)) require $path;
});

use controllers\HomeController;
use controllers\AuthController;
use controllers\AdminController;
use controllers\CartController;

$uri = strtok($_SERVER['REQUEST_URI'], '?');
$method = $_SERVER['REQUEST_METHOD'];

if ($uri === '/login' && $method === 'GET') {
    (new AuthController())->login();
} elseif ($uri === '/login' && $method === 'POST') {
    (new AuthController())->authenticate();
} elseif ($uri === '/register' && $method === 'GET') {
    (new AuthController())->register();
} elseif ($uri === '/register' && $method === 'POST') {
    (new AuthController())->store();
} elseif ($uri === '/' && $method === 'GET') {
    (new HomeController())->index();
} elseif ($uri === '/logout' && $method === 'POST') {
    (new AuthController())->logout();

} elseif ($uri === '/admin' && $method === 'GET') {
    (new AdminController())->index();
} elseif ($uri === '/admin/changeRole' && $method === 'POST') {
    (new AdminController())->changeRole();
} elseif ($uri === '/admin/deleteUser' && $method === 'POST') {
    (new AdminController())->deleteUser();
} elseif ($uri === '/admin/addProduct' && $method === 'POST') {
    (new AdminController())->addProduct();
} elseif ($uri === '/admin/deleteProduct' && $method === 'POST') {
    (new AdminController())->deleteProduct();

} elseif ($uri === '/cart/add' && $method === 'POST') {
    (new CartController())->add();
} elseif ($uri === '/cart/clear' && $method === 'POST') {
    (new CartController())->clear();
} elseif ($uri === '/cart/remove' && $method === 'POST') {
    (new CartController())->remove();
} elseif ($uri === '/carrito' && $method === 'GET') {
    (new CartController())->view();
} elseif ($uri === '/inicio' && $method === 'GET') {
    (new HomeController())->index();
} else {
    http_response_code(404);
    echo "no encontrado";
}

