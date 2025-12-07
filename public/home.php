<?php
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

require_once '../src/VehiculoController.php';
require_once '../src/CitaController.php';
$conn = (new DatabaseConnection())->conectar();

$vehiculoController = new VehiculoController($conn);

$citaController = new CitaController($conn);    
$citaController->actualizarEstadosAutomaticamente();

$usuarioCotroller = new UsuarioController($conn);

$id_usuario = $_SESSION["usuario_id"];

$vehiculos = $vehiculoController->obtenerVehiculosPorUsuario($id_usuario);

$usuario = $usuarioCotroller->obtenerUsuarioPorId($id_usuario);

$rol = $usuario->getRol();

$_SESSION["usuario_rol"] = $rol;

if(isset($_SESSION["usuario_rol"]) && $_SESSION["usuario_rol"] == "admin"){
    header("Location: admin/indexAdmin.php");
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h2>Bienvenido <a href="userInfo.php" title="Más información"><?php echo $_SESSION["usuario_nombre"]?></a></h2>
    
    
    <?php
    
    if (count($vehiculos) === 0) {
        echo "<p>No tienes vehiculos registrados. <a href='introducirVehiculo.php'>Añade uno ahora</a></p>";
    } else {

        echo "<ul>";
        foreach ($vehiculos as $vehiculo) {
            echo "<li>" . htmlspecialchars($vehiculo->getMatricula()) . " - " . htmlspecialchars($vehiculo->getMarca()) . " " . htmlspecialchars($vehiculo->getModelo()) . " (" . htmlspecialchars($vehiculo->getTipo()) . ", " . htmlspecialchars($vehiculo->getAnno_matriculacion()) . ") " . 
            "<button class='btn_eliminar' data-type='vehiculo'>" .
            
            "<a href='../src/eliminar_vehiculo.php?id_vehiculo=" . htmlspecialchars($vehiculo->getId_vehiculo()) . "'>Eliminar Vehiculo</a></button> 
            <button><a href='modificarVehiculo.php?id_vehiculo=" . htmlspecialchars($vehiculo->getId_vehiculo()) . "'>Modificar</a></button>
            " 

            . "</li>";
            
        }
        echo "</ul>";
        echo "<p><a href='introducirVehiculo.php'>Añadir otro vehiculo</a></p>";
    
    }
    ?>
    <button><a href="introducirCita.php">Nueva Cita</a></button>
    <button><a href="citasInfo.php">Ver mis Citas</a></button>
    <button><a href="../src/logOut.php">Log Out</a></button>

    <script src="js/confirmEliminar.js"></script>
</body>

</html>