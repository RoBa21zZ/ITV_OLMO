<?php
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET["id_vehiculo"])) {
    header("Location: ../public/home.php");
    exit();
}

require_once "VehiculoController.php";

$id_vehiculo = $_GET["id_vehiculo"];
$db = new DatabaseConnection();
$conn = $db->conectar();
$vehiculoController = new VehiculoController($conn);

if ($vehiculoController->eliminarVehiculo($id_vehiculo)) {
    $_SESSION["exito_eliminarVehiculo"] = "Vehiculo eliminado con exito";
    header("Location: ../public/home.php");
    exit();
} else {
    $_SESSION["error_eliminarVehiculo"] = "Error al eliminar el vehiculo";
    header("Location: ../public/home.php");
    exit();
}
