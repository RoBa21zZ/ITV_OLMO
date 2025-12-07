<?php
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

require_once 'CitaController.php';

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: ../public/modificarCita.php");
    exit();
}

$id_usuario = $_SESSION["usuario_id"];
$id_cita = $_POST["id_cita"];
$fecha_cita = $_POST["fecha_cita"];
$hora_cita = $_POST["hora_cita"];

$db = new DatabaseConnection();
$conn = $db->conectar();

$citaController = new CitaController($conn);

if ($citaController->modificarCita($id_cita, $hora_cita, $fecha_cita)) {
    $_SESSION["exito_modificar_cita"] = "Cita modificada con exito para el $fecha_cita a las $hora_cita";
    header("Location: ../public/citasInfo.php");
    exit();
} else {
    $_SESSION["error_modificar_cita"] = "Error al modificar la cita";
    header("Location: ../public/citasInfo.php");
    exit();
}

?>