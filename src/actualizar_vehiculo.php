<?php
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

require_once 'VehiculoController.php';
try {



    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        header("Location: ../public/modificarCita.php");
        exit();
    }

    $db = new DatabaseConnection();
    $conn = $db->conectar();

    $vehiculoController = new VehiculoController($conn);
    $id_usuario = $_SESSION["usuario_id"];
    $id_vehiculo = $_POST["id_vehiculo"];
    $matricula = $_POST["matricula"];
    $matriculaNormalizada = $vehiculoController->normalizarMatricula($matricula);
    $marca = $_POST["marca"];
    $modelo = $_POST["modelo"];
    $anno_matriculacion = $_POST["anno_matriculacion"];
    $tipo_vehiculo = $_POST["tipo_vehiculo"];

    if (!$vehiculoController->validarMatricula($matricula)) {
        $_SESSION['error_actaulizarVehiculo'] = "La matricula no es válida.";
        header("Location: ../public/modificarVehiculo.php?id_vehiculo=" . $id_vehiculo);
        exit();
    }

    if ($vehiculoController->vehiculoExisteMatricula($matriculaNormalizada,$id_vehiculo)) {
        $_SESSION['error_actaulizarVehiculo'] = "Este vehiculo ya existe.";
        header("Location: ../public/modificarVehiculo.php?id_vehiculo=" . $id_vehiculo);
        exit();
    }
    
    $vehiculo = new Vehiculo();
    $vehiculo->setId_usuario($id_usuario);
    $vehiculo->setMatricula($matriculaNormalizada);
    $vehiculo->setMarca($marca);
    $vehiculo->setModelo($modelo);
    $vehiculo->setTipo($tipo_vehiculo);
    $vehiculo->setAnno_matriculacion($anno_matriculacion);
    $vehiculo->setId_vehiculo($id_vehiculo);
  
    if ($vehiculoController->modificarVehiculo($vehiculo)) {
        header("Location: ../public/home.php");
        exit();
    } else {
        $_SESSION['error_actaulizarVehiculo'] = "Error al registrar el vehiculo.";
        header("Location: ../public/home.php");
        exit();
    }
} catch (PDOException $th) {
    throw new Exception("Error Processing Request", $th->getMessage());
    
}
