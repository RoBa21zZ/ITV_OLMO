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
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Cita</title>
</head>

<body>
    <h2>Modificar Cita</h2>
    <form action="../src/actualizar_cita.php" method="POST">
        <input type="hidden" name="id_cita" value="<?php echo htmlspecialchars($id_cita); ?>">
        <label for="fecha_cita">Nueva Fecha:</label>
        <input type="date" name="fecha_cita" id="fecha_cita" required>

        <label for="hora_cita">Nueva Hora:</label>
        <select name="hora_cita" id="hora_cita" required>

        </select>

        
        <button type="submit">Modificar cita</button>
        
    </form>
    <a href="citasInfo.php">Volver</a>
    <script src="../public/js/citas.js"></script>
</body>

</html>