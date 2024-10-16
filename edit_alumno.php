<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $anio_ingreso = $_POST['anio_ingreso'];
    $carrera = $_POST['carrera'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];

    $sql = "UPDATE T_Alumnos SET nombre = :nombre, apellido = :apellido, anio_ingreso = :anio_ingreso, carrera = :carrera, fecha_nacimiento = :fecha_nacimiento WHERE ID = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'nombre' => $nombre,
        'apellido' => $apellido,
        'anio_ingreso' => $anio_ingreso,
        'carrera' => $carrera,
        'fecha_nacimiento' => $fecha_nacimiento,
        'id' => $id,
    ]);

    header('Location: admin.php');
    exit;
}
