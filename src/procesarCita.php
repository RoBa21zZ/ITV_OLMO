<?php
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

require_once 'CitaController.php';

try {
    if(!$_SERVER["REQUEST_METHOD"] == "POST"){
        header("Location: ../public/introducirCita.php");
        exit();
    }

    $id_usuario = $_SESSION["usuario_id"];
    $fecha_cita = $_POST["fecha_cita"];
    $hora_cita = $_POST["hora_cita"];
    $id_vehiculo = $_POST["vehiculo_usuario"];

    $db = new DatabaseConnection();
    $conn = $db->conectar();

    $citaController = new CitaController($conn);

    $cita = new Cita();

    $cita->setId_usuario($id_usuario);
    $cita->setId_vehiculo($id_vehiculo);
    $cita->setFecha_cita($fecha_cita);
    $cita->setHora_cita($hora_cita);

    if($citaController->registrarCita($cita)){
        $_SESSION["exito"] = "Cita creada con exito para el $fecha_cita a las $hora_cita";
        echo $_SESSION["exito"];
        header("Location: ../public/citasInfo.php");
        exit();
    }else{
        $_SESSION["errorCita"] = "Error al registrar la cita";
        header("Location: ../public/introducirCita.php");
        exit();
    }


} catch (PDOException $th) {
    
    $_SESSION["error"] = "Error al registrar la cita";
    header("Location: ../public/introducirCita.php");
    exit();
}
?>