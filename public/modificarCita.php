<?php
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET["id_cita"])) {
    die("ID de cita no proporcionado");
}

require_once '../src/CitaController.php';

$id_cita = $_GET["id_cita"];
$id_usuario = $_SESSION["usuario_id"];

$db = new DatabaseConnection();
$conn = $db->conectar();

?>
<?php include __DIR__ . "/components/header.php"  ?>
<div class="cita_contenedor">
    <h2>Modificar Cita</h2>
    <form action="../src/actualizar_cita.php" method="POST" class="cita_form">
        <input type="hidden" name="id_cita" value="<?php echo htmlspecialchars($id_cita); ?>">
        <label for="fecha_cita">Nueva Fecha:</label>
        <input type="date" name="fecha_cita" id="fecha_cita" required>

        <label for="hora_cita">Nueva Hora:</label>
        <select name="hora_cita" id="hora_cita" required>

        </select>


        <button type="submit">Modificar cita</button>

    </form>
    <div class="cita_volver">
        <a href="home.php">Volver al inicio</a>
    </div>
    <script src="../public/js/citas.js"></script>
</div>
<?php include __DIR__ . "/components/footer.php"  ?>