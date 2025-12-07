<?php
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

if(!isset($_GET["id_cita"])){
    header("Location: ../public/citasInfo.php");
    exit();
}

require_once "CitaController.php";

$id_cita = $_GET["id_cita"]; 

$db = new DatabaseConnection();
$conn = $db->conectar();
$citaController = new CitaController($conn);

if($citaController->eliminarCita($id_cita)){
    $_SESSION["exito_eliminarCita"] = "Cita eliminada correctamente.";
    header("Location: ../public/citasInfo.php");
    exit();
}else{
    $_SESSION["error_eliminarCita"] = "Error al eliminar la cita";
    header("Location: ../public/citasInfo.php");
    exit();
}

?>