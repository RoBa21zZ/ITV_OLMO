<?php
session_start();
?>
<?php include __DIR__ . "/components/header.php"  ?>

<div class="register_contenedor">

<h2>Register</h2>

<?php

if (!empty($_SESSION["errorRegistro"])) {
    echo "<p class='errorRegistro'>" . htmlspecialchars($_SESSION["errorRegistro"]) . "</p>";
    unset($_SESSION["errorRegistro"]);
}

?>

    <form method="POST" action="../src/procesarRegistro.php" class="registro">
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
        <label for="contra">Contraseña:</label>
        <!-- <input type="password" id="contraUsuario" name="contraUsuario" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$" title="Debe contener al menos una mayúscula un número y careacter especial. Mínimo 8 caracteres" minlength="8" maxlength="100" placeholder="Introduzca una contraseña" required> -->
        <input type="password" id="contraUsuario" name="contraUsuario" title="Debe contener al menos una mayúscula un número y careacter especial. Mínimo 8 caracteres" minlength="8" maxlength="100" placeholder="Introduzca una contraseña" required>
        <br><br>
        <input type="submit" value="Register">
    </form>
<button><a href="login.php">Log In</a></button>
<div class="register_contenedor">
<?php include __DIR__ . "/components/footer.php"  ?>