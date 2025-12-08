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
<?php include __DIR__ . "/components/header.php"  ?>
<div class="cita_contenedor">
    <?php if (isset($_SESSION["errorCita"])) {
        echo "<p>" . $_SESSION["errorCita"] . "</p>";
        unset($_SESSION["errorCita"]);
    } ?>
    <?php
    if (count($vehiculos) === 0) {
        echo "<p>No tienes vehiculos registrados. <a href='introducirVehiculo.php'>Añade uno ahora</a></p>";
    } else {
    ?>
        <form action="../src/procesarCita.php" method="POST" class="cita_form">
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
    <div class="cita_volver">
        <a href="home.php">Volver al inicio</a>
    </div>
    <script src="js/citas.js"></script>
</div>

<?php include __DIR__ . "/components/footer.php"  ?>