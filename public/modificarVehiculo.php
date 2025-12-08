<?php
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET["id_vehiculo"])) {
    die("ID de cita no proporcionado");
}

require_once '../src/VehiculoController.php';

$id_vehiculo = $_GET["id_vehiculo"];
$id_usuario = $_SESSION["usuario_id"];

$db = new DatabaseConnection();
$conn = $db->conectar();

?>

<?php include __DIR__ . "/components/header.php"?>

<div class="add_vehiculo_contenedor">
    <h2>Modificar Vehiculo</h2>
    <p><?php if (isset($_SESSION["error_actaulizarVehiculo"])) {
            echo $_SESSION["error_actaulizarVehiculo"];
        } ?></p>
    <form action="../src/actualizar_vehiculo.php" method="post" class="add_vehiculo_form">
        <input type="hidden" name="id_vehiculo" value="<?php echo htmlspecialchars($id_vehiculo); ?>">
        <label for="matricula">Matricula:</label>
        <input type="text" name="matricula" id="matricula" minlength="5" maxlength="12" placeholder="Ej: 1234-ABC" required>
        <label for="marca">Marca:</label>
        <select id="marca" name="marca" required>
            <option value="">Seleccione una marca</option>
        </select>

        <label for="modelo">Modelo:</label>
        <select id="modelo" name="modelo" required>
            <option value="">Seleccione una marca primero</option>
        </select> <label for="tipo_vehiculo">Seleccione el tipo de vehiculo</label>
        <select name="tipo_vehiculo" id="tipo_vehiculo">
            <option value="" disabled selected>Porfavor escoge una opción</option>
            <option value="menos_3500kg">Vehiculo con menos de 3500Kg de MMA</option>
            <option value="mas_3500kg">Vehiculo con mas de 3500Kg de MMA</option>
            <option value="agricola">Vehiculo agricola</option>
        </select>
        <label for="anno_matriculacion">Año de matriculación</label>
        <input type="number" name="anno_matriculacion" id="anno_matriculacion" min="1900" max=<?php echo date("Y"); ?> required>
        <button type="submit">Guardar cambios</button>
    </form>
</div>
<script src="../public/js/MarcasModelos.js"></script>

<?php include __DIR__ . "/components/footer.php"  ?>