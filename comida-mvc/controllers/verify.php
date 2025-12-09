<?php
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $user = $userModel->findByToken($token);

    if ($user) {
        $userModel->verifyUser($user['id']);
        echo "¡Cuenta verificada con éxito!";
    } else {
        echo "Token inválido o expirado.";
    }
}
?>