<?php
require 'conexion.php';
session_start();
if ($_SESSION['rol'] !== 'alumno') {
    header('Location: login.php');
    exit;
}

$nombre = $_SESSION['nombre'];
$sql = "SELECT * FROM T_Alumnos WHERE nombre = :nombre";
$stmt = $pdo->prepare($sql);
$stmt->execute(['nombre' => $nombre]);
$alumno = $stmt->fetch();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Datos del Alumno</title>
</head>
<body class="container mt-5">
    <h2>Datos del Alumno</h2>

    <?php if (!$alumno['apellido'] || !$alumno['anio_ingreso'] || !$alumno['carrera'] || !$alumno['fecha_nacimiento']): ?>
        <div class="alert alert-warning" role="alert">
            Tus datos están incompletos. Acude con tu profesor para terminar de llenar tus datos personales.
        </div>
    <?php else: ?>
        <p>Nombre: <?= $alumno['nombre'] ?></p>
        <p>Apellido: <?= $alumno['apellido'] ?></p>
        <p>Año de Ingreso: <?= $alumno['anio_ingreso'] ?></p>
        <p>Carrera: <?= $alumno['carrera'] ?></p>
        <p>Fecha de Nacimiento: <?= $alumno['fecha_nacimiento'] ?></p>
    <?php endif; ?>
    
    <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
</body>
</html>
