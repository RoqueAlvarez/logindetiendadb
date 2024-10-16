<?php
require 'conexion.php';
session_start();
if ($_SESSION['rol'] !== 'administrador') {
    header('Location: login.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre'])) {
    $sql = "INSERT INTO T_Alumnos (nombre, apellido, anio_ingreso, carrera, fecha_nacimiento)
            VALUES (:nombre, :apellido, :anio_ingreso, :carrera, :fecha_nacimiento)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'nombre' => $_POST['nombre'],
        'apellido' => $_POST['apellido'],
        'anio_ingreso' => $_POST['anio_ingreso'],
        'carrera' => $_POST['carrera'],
        'fecha_nacimiento' => $_POST['fecha_nacimiento']
    ]);
}


if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $sql = "DELETE FROM T_Alumnos WHERE ID = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    header('Location: admin.php');
    exit;
}


$alumnos = $pdo->query("SELECT * FROM T_Alumnos")->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Panel de Administrador</title>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body class="container mt-5">
    <h2>Bienvenido, Administrador</h2>

    
    <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>

    <h3>Registrar Nuevo Alumno</h3>
    <form method="POST" action="">
        <div class="form-group">
            <label>Nombre:</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Apellido:</label>
            <input type="text" name="apellido" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Año de Ingreso:</label>
            <input type="number" name="anio_ingreso" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Carrera:</label>
            <input type="text" name="carrera" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Fecha de Nacimiento:</label>
            <input type="date" name="fecha_nacimiento" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrar</button>
    </form>

    <h3>Lista de Alumnos</h3>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Año de Ingreso</th>
                <th>Carrera</th>
                <th>Fecha de Nacimiento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($alumnos as $alumno): ?>
                <tr>
                    <td><?= $alumno['ID'] ?></td>
                    <td><?= $alumno['nombre'] ?></td>
                    <td><?= $alumno['apellido'] ?></td>
                    <td><?= $alumno['anio_ingreso'] ?></td>
                    <td><?= $alumno['carrera'] ?></td>
                    <td><?= $alumno['fecha_nacimiento'] ?></td>
                    <td>
                        
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editModal<?= $alumno['ID'] ?>">Editar</button>
                        
                        <div class="modal fade" id="editModal<?= $alumno['ID'] ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel">Editar Alumno</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="POST" action="edit_alumno.php">
                                        <div class="modal-body">
                                            <input type="hidden" name="id" value="<?= $alumno['ID'] ?>">
                                            <div class="form-group">
                                                <label>Nombre:</label>
                                                <input type="text" name="nombre" class="form-control" value="<?= $alumno['nombre'] ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Apellido:</label>
                                                <input type="text" name="apellido" class="form-control" value="<?= $alumno['apellido'] ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Año de Ingreso:</label>
                                                <input type="number" name="anio_ingreso" class="form-control" value="<?= $alumno['anio_ingreso'] ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Carrera:</label>
                                                <input type="text" name="carrera" class="form-control" value="<?= $alumno['carrera'] ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Fecha de Nacimiento:</label>
                                                <input type="date" name="fecha_nacimiento" class="form-control" value="<?= $alumno['fecha_nacimiento'] ?>" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <a href="?eliminar=<?= $alumno['ID'] ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar este alumno?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
