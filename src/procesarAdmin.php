<?php
session_start();
if (!isset($_SESSION["usuario_rol"]) || $_SESSION["usuario_rol"] !== "admin") {
    header("Location: ../login.php");
    exit();
}

require_once 'UsuarioController.php';
require_once 'VehiculoController.php';
require_once 'CitaController.php';

$db = new DatabaseConnection();
$conn = $db->conectar();
$usuarioController = new UsuarioController($conn);
$vehiculosController = new VehiculoController($conn);
$citaController = new CitaController($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST["accion"])) {
    header("Location: ../public/admin/indexAdmin.php");
    exit();
}

$accion = $_POST["accion"];

switch ($accion) {
    case "cambiar_rol":
        $usuarioController->modificarUsuarioAdmin($_POST["id_usuario"]);
        break;
    case "eliminar_usuario":
        $usuarioController->eliminarUsuario($_POST["id_usuario"]);
        break;
    case "eliminar_vehiculo":
        $vehiculosController->eliminarVehiculo($_POST["id_vehiculo"]);
        break;
    case "eliminar_cita":
        $citaController->eliminarCita($_POST["id_cita"]);
        break;
}

header("Location:../public/admin/indexAdmin.php");
exit();