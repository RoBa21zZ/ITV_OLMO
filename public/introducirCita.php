<?php
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}
require_once "../src/VehiculoController.php";
$id_usuario = $_SESSION["usuario_id"];
$db = new DatabaseConnection();
$conn = $db->conectar();

$vehiculoController = new VehiculoController($conn);
$vehiculos = $vehiculoController->obtenerVehiculosPorUsuario($id_usuario);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedir cita</title>
</head>
<body> 
    <?php if(isset($_SESSION["errorCita"])){echo $_SESSION["errorCita"];}?> 
    <?php
    if (count($vehiculos) === 0) {
        echo "<p>No tienes vehiculos registrados. <a href='introducirVehiculo.php'>Añade uno ahora</a></p>";
    } else {
    ?>
    <form action="../src/procesarCita.php" method="POST">
        <label for="fecha_cita">Fecha:</label>
        <input type="date" name="fecha_cita" id="fecha_cita" required>

        <label for="hora_cita">Hora:</label>
        <select name="hora_cita" id="hora_cita" required>

        </select>

        <label for="vehiculo_usuario">Tus Vehiculos:</label>
        <select name="vehiculo_usuario" id="vehiculo_usuario" required>
        <!--Geneara qui con el php todos los vehiculos del menda que el texto sea 
            la matricula y el nombre del coche despues que el value se a la id del vehiculo.
            
            hacer lo de los vehiculos a parte.
        -->
            <?php
                $vehiculoController->mostrarVehiculosPorUsuarioPorCita($id_usuario);
            ?>
        </select>
        <button type="submit">Reservar cita</button>
    </form>
    <?php } ?>
    <button><a href="home.php">Volver al inicio</a></button>
    <script src="js/citas.js"></script>
</body>
</html>
