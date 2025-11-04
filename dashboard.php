<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index_inseguro.php');  // Ajusta a _seguro si es la versión segura
    exit;
}

$username = $_SESSION['user'];
// Cargar usuarios (ajusta el archivo JSON según versión)
$usersFile = 'users_inseguro.json';  // Cambia a _seguro para versión segura
$usuarios = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];
$user = $usuarios[$username] ?? [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f8f9fa; padding: 20px; }
        .container { max-width: 800px; margin: auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        h1 { color: #28a745; font-size: 28px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background: #007bff; color: white; }
        ul { list-style-type: none; padding: 0; }
        li { background: #e9ecef; margin: 5px 0; padding: 10px; border-radius: 5px; }
        a { color: #dc3545; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h1>¡Bienvenido, <?= $user['nombre'] ?? 'Usuario' ?>!</h1>
        <p><strong>Rol:</strong> <?= $user['rol'] ?? 'N/A' ?></p>
        <p><strong>Email:</strong> <?= $user['email'] ?? 'N/A' ?></p>
        
        <h3>Historial de Accesos</h3>
        <ul>
            <?php foreach ($user['historial'] ?? [] as $entrada): ?>
                <li><?= $entrada ?></li>
            <?php endforeach; ?>
        </ul>
        
        <h3>Datos Sensibles</h3>
        <table>
            <tr><th>Tipo</th><th>Valor</th></tr>
            <?php foreach ($user['datos_sensibles'] ?? [] as $dato): ?>
                <tr><td><?= $dato['Tipo'] ?></td><td><?= $dato['Valor'] ?></td></tr>
            <?php endforeach; ?>
        </table>
        
        <a href="logout.php">Cerrar Sesión</a>
    </div>
</body>
</html>