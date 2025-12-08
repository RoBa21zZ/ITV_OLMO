<?php
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

require_once '../src/UsuarioController.php';

?>

<?php include __DIR__ . "/components/header.php"  ?>
<div class="register_contenedor">
    <h2>Actualizar Usuario</h2>
    <?php
    if (!empty($_SESSION["error_modificarUsuario"])) {
        echo "<p class='error_modificarUsuario'>" . htmlspecialchars($_SESSION["error_modificarUsuario"]) . "</p>";
        unset($_SESSION["error_modificarUsuario"]);
    }
    ?>
    <form method="POST" action="../src/actualizar_usuario.php" class="registro">
        <label for="nombreUsuario">Nombre:</label>
        <input type="text" id="nombreUsuario" name="nombreUsuario" pattern="{[A-Za-z]}" min="2" max="30" required placeholder="Introduzca su nombre">
        <br><br>
        <label for="apellidosUsuario">Apellidos:</label>
        <input type="text" id="apellidosUsuario" name="apellidosUsuario" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ' -]{2,50}$" min="3" max="30" placeholder="Introduzca su apellido" required title="Debe introducir una o mas palabras con la primera letra mayúsucla">
        <br><br>
        <label for="dni">DNI:</label>
        <input type="text" id="dniUsuario" name="dniUsuario" pattern="[0-9]{8}[A-Za-z ]{1}" placeholder="Introduzca su DNI" minlength="9" maxlength="9" title="Debe introducir 8 números y 1 una letra" required>
        <br><br>
        <label for="tel">Teléfono:</label>
        <input type="text" id="telUsuario" name="telUsuario" pattern="[0-9]{9}" placeholder="Introduzca su teléfono" minlength="9" maxlength="9" title="Debe introducir 9 números" required>
        <br><br>
        <label for="email">E-mail</label>
        <input type="email" id="emailUsuario" name="emailUsuario" placeholder="Introduzca su E-mail" pattern="^[^\s@]+@[^\s@]+\.[^\s@]+$" required>
        <br><br>
        <input type="submit" value="Modificar usuario">
    </form>
    <button><a href="home.php">Inicio</a></button>
</div>
<?php include __DIR__ . "/components/footer.php"  ?>