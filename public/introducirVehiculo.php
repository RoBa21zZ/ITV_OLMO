<?php
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
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
    <h2>Introduce un nuevo vehiculo </h2>
    <p><?php if(isset($_SESSION["error"])){echo $_SESSION["error"];} ?></p>
    <form action="../src/procesarIntroducirVehiculo.php" method="post">
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
        <button type="submit">Añadir vehiculo</button>
    </form>
    <script src="../public/js/MarcasModelos.js"></script>
</body>

</html>