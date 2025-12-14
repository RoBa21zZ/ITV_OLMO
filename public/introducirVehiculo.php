<?php
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}


?>

<?php include __DIR__ . "/components/header.php"  ?>
<div class="add_vehiculo_contenedor">
    <h2>Introduce un nuevo vehículo</h2>
    <p><?php if(isset($_SESSION["error"])){echo $_SESSION["error"]; unset($_SESSION["error"]);} ?></p>
    <form action="../src/procesarIntroducirVehiculo.php" method="post" class="add_vehiculo_form">
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
        <select name="tipo_vehiculo" id="tipo_vehiculo" required>
            <option value="" disabled selected>Porfavor escoge una opción</option>
            <option value="menos_3500kg">Vehiculo con menos de 3500Kg de MMA</option>
            <option value="mas_3500kg">Vehiculo con mas de 3500Kg de MMA</option>
            <option value="agricola">Vehiculo agricola</option>
        </select>
        <label for="anno_matriculacion">Año de matriculación</label>
        <input type="number" name="anno_matriculacion" id="anno_matriculacion" min="1900" max=<?php echo date("Y"); ?> placeholder="Año mínimo 1900" required>
        <button type="submit">Añadir vehiculo</button>
    </form>
</div>
<script src="../public/js/MarcasModelos.js"></script>

<?php include __DIR__ . "/components/footer.php"  ?>