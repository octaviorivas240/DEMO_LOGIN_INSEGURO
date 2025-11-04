<?php
$usersFile = 'users_inseguro.json';
$usuarios = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];

$mensaje = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $email = $_POST['email'] ?? '';

    if (isset($usuarios[$username])) {
        $mensaje = "Usuario ya existe.";
    } elseif (empty($username) || empty($password) || empty($email)) {
        $mensaje = "Campos requeridos.";
    } else {
        $usuarios[$username] = [
            "password" => $password, // En texto plano!
            "nombre" => $username,
            "email" => $email,
            "rol" => "Usuario",
            "historial" => [date('Y-m-d H:i') . ": Registro exitoso"],
            "datos_sensibles" => []
        ];
        file_put_contents($usersFile, json_encode($usuarios, JSON_PRETTY_PRINT));
        $mensaje = "Usuario registrado. <a href='index_inseguro.php'>Volver a Login</a>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro Inseguro - Vulnerable</title>
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
        <h2>Registro Inseguro de SecureCorp</h2>
        <p>Crea una cuenta vulnerable (contraseña en texto plano).</p>
        <form method="POST">
            <input type="text" name="username" placeholder="Usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <input type="email" name="email" placeholder="Email" required>
            <button type="submit">Registrar</button>
        </form>
        <?php if ($mensaje): ?>
            <p class="error"><?= $mensaje ?></p>
        <?php endif; ?>
        <p><a href="index_inseguro.php">Volver a Login</a></p>
    </div>
</body>
</html>