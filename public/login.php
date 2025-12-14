<?php
        session_start();
        
        if(isset($_SESSION["usuario_id"])){
            header("Location: home.php");
            exit();
        }  
    ?>
<?php include __DIR__ . "/components/header.php"  ?>
<div class="login_contenedor">
    <h2>Login</h2>
    
    <?php
        if(!empty($_SESSION["error_login"])){
            echo "<p class='login_error'>" . htmlspecialchars($_SESSION["error_login"]) . "</p>";
            unset($_SESSION["error_login"]);
        }
    
    ?>
    
    <form action="../src/procesarLogin.php" method="POST">
        <label for="emailUsuario">Introduzca su email</label>
        <input type="email" name="emailUsuario" id="emailUsuario" placeholder="Introduzca su E-mail" pattern="^[^\s@]+@[^\s@]+\.[^\s@]+$" required>
        <br><br>
        <label for="contraUsuario">Introduzca su contraseña</label>
        <input type="password" id="contraUsuario" name="contraUsuario" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$" title="Debe contener al menos una mayúscula un número y careacter especial. Mínimo 8 caracteres" minlength="8" maxlength="100" placeholder="Introduzca una contraseña" required>
        <br><br>
        <input type="submit" value="Login">
    </form>
    <p>¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>
</div>
<script src="js/confirmEliminar.js"></script>
<?php include __DIR__ . "/components/footer.php"  ?>
