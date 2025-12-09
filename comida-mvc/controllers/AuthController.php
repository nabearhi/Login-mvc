<?php
namespace controllers;

use models\User;

class AuthController {
    public function login(): void {
        require __DIR__ . '/../views/login.php';
    }

    public function authenticate(): void {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($email === '' || $password === '') {
            $error = "Completa todos los campos.";
            require __DIR__ . '/../views/login.php';
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Correo inválido.";
            require __DIR__ . '/../views/login.php';
            return;
        }

        $user = User::findByEmail($email);
        
        if (!$user || !$user->verifyPassword($password) || !$user->is_active) {
            $error = "Credenciales inválidas.";
            require __DIR__ . '/../views/login.php';
            return;
        }

        $_SESSION['user'] = [
            'id'    => $user->id,
            'email' => $user->email,
            'role'  => $user->role
        ];

        header('Location: /');
        exit;
    }

    public function logout(): void {
        $_SESSION = [];
        session_destroy();
        header('Location: /login');
        exit;
    }
    public function register(): void {
        require __DIR__ . '/../views/register.php';
    }

    public function store(): void {
        $email    = trim($_POST['email'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $password = $_POST['password'] ?? '';
        $role     = 'user';
        if ($email === '' || $telefono === '' || $password === '') {
            $error = "Completa todos los campos.";
            require __DIR__ . '/../views/register.php';
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Correo inválido.";
            require __DIR__ . '/../views/register.php';
            return;
        }

        if (!preg_match("/^[0-9]{10}$/", $telefono)) {
            $error = "El teléfono debe tener exactamente 10 dígitos.";
            require __DIR__ . '/../views/register.php';
            return;
        }

        if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&]).{6,}$/", $password)) {
            $error = "La contraseña debe incluir letras, números y símbolos, mínimo 6 caracteres.";
            require __DIR__ . '/../views/register.php';
            return;
        }

        if (User::findByEmail($email)) {
            $error = "El correo ya está registrado.";
            require __DIR__ . '/../views/register.php';
            return;
        }
        $hash = password_hash($password, PASSWORD_DEFAULT);
        User::create($email, $telefono, $hash, $role);

        header('Location: /login');
        exit;
    }
}
