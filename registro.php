<?php
require 'conexion.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $rol = $_POST['rol'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);


    $sql = "INSERT INTO T_Usuarios (usuario, password, rol) VALUES (:nombre, :password, :rol)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['nombre' => $nombre, 'password' => $password, 'rol' => $rol]);


    if ($rol === 'alumno') {
        $sql = "INSERT INTO T_Alumnos (nombre) VALUES (:nombre)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['nombre' => $nombre]);
    }

    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Registro</title>
</head>
<body class="container mt-5">
    <h2>Registro</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label>Nombre:</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Contraseña:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Rol:</label>
            <select name="rol" class="form-control" required>
                <option value="alumno">Alumno</option>
                <option value="administrador">Administrador</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Registrar</button>
        <a href="login.php" class="btn btn-secondary">Iniciar Sesión</a>
    </form>
</body>
</html>
