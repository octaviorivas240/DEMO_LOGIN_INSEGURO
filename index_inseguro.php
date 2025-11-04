<?php
session_start();

// Ruta absoluta del archivo JSON
$usersFile = __DIR__ . '/users_inseguro.json';
$usuarios = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (isset($usuarios[$username])) {
        if ($usuarios[$username]['password'] === $password) {
            $_SESSION['user'] = $username;
            $usuarios[$username]['historial'][] = date('Y-m-d H:i:s') . ": Acceso exitoso";
            file_put_contents($usersFile, json_encode($usuarios, JSON_PRETTY_PRINT));
            header('Location: dashboard.php');
            exit;
        } else {
            $mensaje = "Login failed";  // ← PARA HYDRA
        }
    } else {
        $mensaje = "Login failed";      // ← PARA HYDRA
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Inseguro - Vulnerable a Brute Force</title>
    <style>
        body { font-family: Arial, sans-serif; background: linear-gradient(to bottom, #f0f2f5, #d4e3f0); padding: 50px; text-align: center; }
        .container { max-width: 400px; margin: auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 20px rgba(0,0,0,0.1); animation: fadeIn 1s; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        input { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ccc; border-radius: 8px; font-size: 16px; }
        button { background: #007bff; color: white; padding: 12px; border: none; border-radius: 8px; cursor: pointer; font-size: 16px; transition: background 0.3s; }
        button:hover { background: #0056b3; }
        .error { color: red; font-weight: bold; margin-top: 10px; animation: shake 0.5s; }
        @keyframes shake { 0%, 100% { transform: translateX(0); } 25% { transform: translateX(-5px); } 75% { transform: translateX(5px); } }
        h2 { color: #007bff; font-size: 24px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Portal Inseguro de SecureCorp</h2>
        <p>Bienvenido al sistema vulnerable. ¡Cuidado con los ataques!</p>
        <form method="POST">
            <input type="text" name="username" placeholder="Usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Iniciar Sesión</button>
        </form>
        <?php if ($mensaje): ?>
            <p class="error"><?= htmlspecialchars($mensaje) ?></p>
        <?php endif; ?>
        <p style="margin-top: 20px; font-size: 14px; color: #666;">
            Detalles: Sin límites de intentos, ideal para demo de brute force con Hydra.
        </p>
        <p><a href="register_inseguro.php">Registrar nuevo usuario</a></p>
    </div>
</body>
</html>
