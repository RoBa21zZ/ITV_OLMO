<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        *{
            font-family: Arial, Helvetica, sans-serif;

        }
    </style>
</head>
<body>
    <h2>LOGIN</h2>
    
    <?php
        session_start();
        
        if(isset($_SESSION["usuario_id"])){
            header("Location: home.php");
            exit();
        }
        
        if(isset($_SESSION["error_login"])){
            echo "" . $_SESSION["error_login"];
            unset($_SESSION["error_login"]);
        }
        
    ?>
    <form action="../src/procesarLogin.php" method="POST">
        <label for="emailUsuario">Introduzca su email</label>
        <input type="email" name="emailUsuario" id="emailUsuario" placeholder="Introduzca su E-mail" pattern="^[^\s@]+@[^\s@]+\.[^\s@]+$" required>
        <br><br>
        <label for="contraUsuario">Introduzca su contraseña</label>
        <!-- <input type="password" id="contraUsuario" name="contraUsuario" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$" title="Debe contener al menos una mayúscula un número y careacter especial. Mínimo 8 caracteres" minlength="8" maxlength="100" placeholder="Introduzca una contraseña" required> -->
        <input type="password" id="contraUsuario" name="contraUsuario"  title="Debe contener al menos una mayúscula un número y careacter especial. Mínimo 8 caracteres" minlength="8" maxlength="100" placeholder="Introduzca una contraseña" required>
        
        <br><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>