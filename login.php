<?php
require 'conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM T_Usuarios WHERE usuario = :nombre";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['nombre' => $nombre]);
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($password, $usuario['password'])) {
        $_SESSION['nombre'] = $usuario['usuario'];
        $_SESSION['rol'] = $usuario['rol'];

        if ($usuario['rol'] === 'administrador') {
            header('Location: admin.php');
        } else {
            header('Location: alumno.php');
        }
        exit;
    } else {
        $error = "Nombre de usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Iniciar Sesión</title>
</head>
<body class="container mt-5">
    <h2>Iniciar Sesión</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="form-group">
            <label>Nombre:</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Contraseña:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
        <a href="registro.php" class="btn btn-info">No tienes cuenta, regístrate</a>
    </form>
</body>
</html>
