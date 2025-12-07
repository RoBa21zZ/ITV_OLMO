<?php
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

require_once 'DatabaseConnection.php';
require_once 'Usuario.php';
require_once 'VehiculoController.php';

try {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        header("Location: ../public/introducirVehiculo.php");
        exit();
    }

    $id_usuario = $_SESSION["usuario_id"];
    $matricula = trim($_POST["matricula"]);
    $marca = trim($_POST["marca"]);
    $modelo = trim($_POST["modelo"]);
    $tipo_vehiculo = $_POST["tipo_vehiculo"];
    $anno_matriculacion = $_POST["anno_matriculacion"];

    $db = new DatabaseConnection();
    $conn = $db->conectar();

    $vehiculoController = new VehiculoController($conn);

    if (!$vehiculoController->validarMatricula($matricula)) {
        $_SESSION['error'] = "La matricula no es válida.";
        header("Location: ../public/introducirVehiculo.php");
        exit();
    }

    $matriculaNormalizada = $vehiculoController->normalizarMatricula($matricula);

    if ($vehiculoController->vehiculoExisteMatricula($matriculaNormalizada)) {
        $_SESSION['error'] = "Este vehiculo ya existe.";
        header("Location: ../public/introducirVehiculo.php");
        exit();
    }

    $vehiculo = new Vehiculo();
    $vehiculo->setId_usuario($id_usuario);
    $vehiculo->setMatricula($matriculaNormalizada);
    $vehiculo->setMarca($marca);
    $vehiculo->setModelo($modelo);
    $vehiculo->setTipo($tipo_vehiculo);
    $vehiculo->setAnno_matriculacion($anno_matriculacion);

    if ($vehiculoController->introducirVehiculo($vehiculo)) {
        header("Location: ../public/home.php");
        exit();
    } else {
        $_SESSION['error'] = "Error al registrar el vehiculo.";
        header("Location: ../public/home.php");
        exit();
    }
} catch (Throwable $th) {
    $_SESSION['error'] = "Error al conectar con la base de datos: " . $th->getMessage();
    header("Location: ../public/introducirVehiculo.php");
    exit();
}
