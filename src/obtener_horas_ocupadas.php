<?php
require_once "CitaController.php";
//En caso de que la peticion get venga vacia devolvemos un json vacio
if(!isset($_GET["fecha"])){
    echo json_encode([]);
    exit;
}

$cita_fecha  = $_GET["fecha"];

$db = new DatabaseConnection();
$citaController = new CitaController($db->conectar());

echo $citaController->obtenerHorasPorFecha($cita_fecha);
?>